<?php
ob_start();
session_start();
include("../includes/connection.php");   // must provide $connect, db_query(), $sitekey, $secretKey (as before)

/* ------------------------------------------------------------------
 * Helpers
 * ------------------------------------------------------------------ */

/** Redirect and stop. Falls back to JS if output has already started. */
function redirectTo(string $url): void
{
    // Persist any login session before sending the browser to the dashboard.
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }

    // Includes may have emitted whitespace or debug output; discard it so the
    // redirect remains a real HTTP response instead of a blank page.
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    if (!headers_sent()) {
        header('Location: ' . $url, true, 303);
    } else {
        echo '<script>self.location = ' . json_encode($url) . ';</script>';
    }
    exit;
}

function redirectWithMessage(string $msg): void
{
    redirectTo('index.php?strmsg=' . urlencode($msg));
}

/**
 * Verify a reCAPTCHA v3 token with Google using cURL or PHP HTTPS streams.
 * Returns true only when Google accepts the token, the action is "login"
 * and the score is at least 0.5.
 */
function verifyRecaptcha(string $secret, string $token, string $ip = ''): bool
{
    if ($secret === '' || $token === '') {
        error_log('reCAPTCHA: missing secret key or token');
        return false;
    }
    $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $postBody = http_build_query([
        'secret'   => $secret,
        'response' => $token,
        'remoteip' => $ip,
    ]);

    if (function_exists('curl_init')) {
        $ch = curl_init($verifyUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postBody,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 20,
        ]);
        $raw = curl_exec($ch);
        if ($raw === false) {
            error_log('reCAPTCHA cURL error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }
        curl_close($ch);
    } elseif (ini_get('allow_url_fopen')) {
        $context = stream_context_create([
            'http' => [
                'method'        => 'POST',
                'header'        => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    'Content-Length: ' . strlen($postBody) . "\r\n",
                'content'       => $postBody,
                'timeout'       => 20,
                'ignore_errors' => true,
            ],
        ]);
        $raw = @file_get_contents($verifyUrl, false, $context);
        if ($raw === false) {
            error_log('reCAPTCHA HTTPS stream request failed');
            return false;
        }
    } else {
        error_log('reCAPTCHA unavailable: enable cURL or allow_url_fopen');
        return false;
    }

    $data = json_decode($raw);
    if (!$data || empty($data->success)) {
        error_log('reCAPTCHA rejected: ' . json_encode($data->{'error-codes'} ?? []));
        return false;
    }

    return ($data->score ?? 0) >= 0.5 && ($data->action ?? '') === 'login';
}

/** Record a failed login for this IP and return the message to show. */
function registerFailedAttempt(string $ip): string
{
    $rs       = db_query("SELECT * FROM chk_session WHERE ip_addr='$ip'");
    $row      = $rs ? mysqli_fetch_array($rs) : null;
    $attempts = (int)($row['no_of_attempts'] ?? 0);

    if ($attempts >= 5) {
        return 'Please try after 60 mins';
    }

    if (!$row) {
        db_query("INSERT INTO chk_session SET no_of_attempts=1, ip_addr='$ip'");
    } else {
        db_query("UPDATE chk_session SET atime=now(), no_of_attempts=" . ($attempts + 1) . " WHERE ip_addr='$ip'");
    }

    return 'Invalid UserName/Password, ' . max(0, 4 - $attempts) . ' attempt(s) left';
}

/** Create the logged-in session for the given admin_login row. */
function completeLogin(object $res): void
{
    global $connect;

    session_regenerate_id(true);

    $_SESSION['nm']           = $res->uname;
    $_SESSION['admin_type']   = $res->user_type;
    $_SESSION['admin_status'] = $res->admin_status;

    if ($res->user_type == 'super') {
        $_SESSION['admin_id'] = $res->id;
    } else {
        $_SESSION['user_id'] = $res->id;

        $adminName = $connect->real_escape_string(str_replace("'", "&#39;", (string)$res->uname));
        $sessId    = $connect->real_escape_string(session_id());
        $ip        = $connect->real_escape_string($_SERVER['REMOTE_ADDR'] ?? '');

        db_query("insert into mng_subadmin_sessionlogs set
                    id_admin='" . (int)$res->id . "',
                    admin_name='" . $adminName . "',
                    login_time=NOW(),
                    session_id='" . $sessId . "',
                    ip='" . $ip . "'");
    }
}

/* ------------------------------------------------------------------
 * Already logged in -> dashboard
 * ------------------------------------------------------------------ */
if (isset($_SESSION['nm'])) {
    redirectTo('dashboard.php');
}

/* ------------------------------------------------------------------
 * Login submit
 * ------------------------------------------------------------------ */
if (($_GET['act'] ?? '') === '1' && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {

    $rawIp = $_SERVER['REMOTE_ADDR'] ?? '';
    $ip    = $connect->real_escape_string($rawIp);

    // 1. reCAPTCHA v3
    $captcha = trim((string)($_POST['recaptchaResponse'] ?? ''));
    if ($captcha === '') {
        redirectWithMessage('Please check the captcha form.');
    }
    if (!verifyRecaptcha((string)($secretKey ?? ''), $captcha, $rawIp)) {
        redirectWithMessage('Please check the captcha.');
    }

    // 2. Username / password
    $rawUser  = (string)($_POST['uname'] ?? '');
    $rawPass  = trim((string)($_POST['pwd'] ?? ''));
    $username = $connect->real_escape_string($rawUser);
    $password = $connect->real_escape_string($rawPass);

    $rs  = db_query("select * from admin_login where uname='$username' && pwd='$password'");
    $res = $rs ? mysqli_fetch_object($rs) : null;

    if (!$res || (string)$res->uname !== $rawUser || trim((string)$res->pwd) !== $rawPass) {
        redirectWithMessage(registerFailedAttempt($ip));
    }

    // 3. Image captcha
    $vercode     = (string)($_POST['vercode'] ?? '');
    $sessVercode = (string)($_SESSION['vercode'] ?? '');
    if ($sessVercode === '' || $vercode !== $sessVercode) {
        redirectWithMessage('Sorry, Incorrect verification code.');
    }

    // 4. Lock-out check (5 failed attempts -> wait 60 minutes)
    $rs         = db_query("SELECT * FROM chk_session WHERE ip_addr='$ip'");
    $attemptRow = $rs ? mysqli_fetch_array($rs) : null;
    $attempts   = (int)($attemptRow['no_of_attempts'] ?? 0);

    if ($attempts > 4) {
        $entered = strtotime((string)($attemptRow['atime'] ?? ''));
        $minutes = abs(time() - (int)$entered) / 60;
        if ($minutes <= 60) {
            redirectWithMessage('Please try after 60 mins');
        }
    }

    // 5. Success
    db_query("DELETE FROM chk_session WHERE ip_addr='$ip'");
    completeLogin($res);
    redirectTo('dashboard.php');
}

$strmsg = (isset($_GET['strmsg']) && is_string($_GET['strmsg'])) ? $_GET['strmsg'] : '';
?>
<!DOCTYPE HTML>
<!--[if lt IE 9]><html class="lt-ie9"><![endif]-->
<!--[if gt IE 9]><html><![endif]-->
<!--[if !IE]>-->
<html>
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
    <title>Intransit || Admin</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
   <?php include_once('css.php'); ?>
</head>

<body id="body" style="background:#fff !important;">
    <section>
        <div class="container">
            <div style="margin:8% auto 0; max-width:600px; width:100%;">
                <div class="text-center margin-bottom-20"><img src="images/logo.png"></div>
                <div class="text-center"><img src="images/login_bg.png"></div>
                <div class="text-center" style="margin:10px 0 15px 0; font-size:20px; color:#02549f; text-transform:uppercase;">Admin Login</div>
                <div class="login_page">
                    <?php if ($strmsg !== '') { ?>
                        <center><span style="color:red;"><?php echo htmlspecialchars($strmsg, ENT_QUOTES, 'UTF-8'); ?></span></center>
                    <?php } ?>
                    <form action="index.php?act=1" method="post" name="form1" id="loginForm">
                        <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
                        <div class="input-group margin-bottom-20">
                            <input type="text" class="form-control" placeholder="Username" name="uname" required>
                        </div>
                        <div class="input-group margin-bottom-20">
                            <input type="password" class="form-control" placeholder="Password" name="pwd" required>
                        </div>
                        <div class="input-group margin-bottom-20">
                            <img src="captcha.php" style="margin-right:15px;">
                            <input type="text" class="form-control" placeholder="Enter Text" name="vercode" autocomplete="off">
                        </div>
                        <div class="clearfix margin-bottom-20">
                            <div class="btn-group text-center">
                                <button class="btn btn_login" type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </section>

    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo urlencode((string)($sitekey ?? '')); ?>"></script>
    <script>
    // reCAPTCHA v3 tokens expire after 2 minutes, so request a fresh one at submit time.
    (function () {
        var siteKey = <?php echo json_encode((string)($sitekey ?? '')); ?>;
        var form    = document.getElementById('loginForm');
        var submitting = false;

        form.addEventListener('submit', function (e) {
            e.preventDefault();   // runs only after the browser's "required" validation passes
            if (submitting) return;
            submitting = true;

            function send() { form.submit(); }

            grecaptcha.ready(function () {
                grecaptcha.execute(siteKey, {action: 'login'}).then(function (token) {
                    document.getElementById('recaptchaResponse').value = token;
                    send();
                }, send);   // if Google can't be reached, submit anyway; the server shows the captcha message
            });
        });
    })();
    </script>
</body>

</html>
