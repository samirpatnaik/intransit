<?php 

$filename = '../.htaccess';
$accesscontent = "RewriteEngine on 

RewriteBase /

RewriteCond %{HTTPS} off 

RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

## Remove trailing slash
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)/$ http://www.intransittech.com/$1 [L,R=301]

RewriteRule ^admin/.*$ - [PT]

RewriteRule ^design/.*$ - [PT]

RewriteRule ^(css|images|uploadimages|js|includes|fonts|design)$ $1/

RewriteRule ^.+/(cache|css|images|uploadimages|js|includes|fonts|design)/(.+)$ $1/$2

#Top Links

ErrorDocument 404 /index.php
ErrorDocument 500 /index.php

## EXPIRES CACHING ##
<filesMatch '\.(ico|pdf|flv|jpg|jpeg|png|gif|css|js|doc|woff)$'>
Header set Cache-Control 'max-age=29030400, public'
</filesMatch>

# compress text, html, javascript, css, xml:
AddOutputFilterByType DEFLATE text/plain
AddOutputFilterByType DEFLATE text/html
AddOutputFilterByType DEFLATE text/xml
AddOutputFilterByType DEFLATE text/css
AddOutputFilterByType DEFLATE application/xml
AddOutputFilterByType DEFLATE application/xhtml+xml
AddOutputFilterByType DEFLATE application/rss+xml
AddOutputFilterByType DEFLATE application/javascript
AddOutputFilterByType DEFLATE application/x-javascript

ExpiresByType text/css \"access plus 1 month\"
ExpiresByType text/javascript \"access plus 1 month\"
ExpiresByType application/javascript \"access plus 1 month\"

ExpiresByType image/jpeg \"access plus 1 year\"
ExpiresByType image/gif \"access plus 1 year\"
ExpiresByType image/png \"access plus 1 year\"
ExpiresByType image/webp \"access plus 1 year\"
ExpiresByType image/svg+xml \"access plus 1 year\"
ExpiresByType image/x-icon \"access plus 1 year\"

ExpiresByType font/ttf \"access plus 1 year\"
ExpiresByType font/otf \"access plus 1 year\"
ExpiresByType font/woff \"access plus 1 year\"
ExpiresByType font/woff2 \"access plus 1 year\"
ExpiresByType application/font-woff \"access plus 1 year\"


<IfModule mod_deflate.c>
  # Compress HTML, CSS, JavaScript, Text, XML and fonts
  AddOutputFilterByType DEFLATE application/javascript
  AddOutputFilterByType DEFLATE application/rss+xml
  AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
  AddOutputFilterByType DEFLATE application/x-font
  AddOutputFilterByType DEFLATE application/x-font-opentype
  AddOutputFilterByType DEFLATE application/x-font-otf
  AddOutputFilterByType DEFLATE application/x-font-truetype
  AddOutputFilterByType DEFLATE application/x-font-ttf
  AddOutputFilterByType DEFLATE application/x-javascript
  AddOutputFilterByType DEFLATE application/xhtml+xml
  AddOutputFilterByType DEFLATE application/xml
  AddOutputFilterByType DEFLATE font/opentype
  AddOutputFilterByType DEFLATE font/otf
  AddOutputFilterByType DEFLATE font/ttf
  AddOutputFilterByType DEFLATE image/svg+xml
  AddOutputFilterByType DEFLATE image/x-icon
  AddOutputFilterByType DEFLATE text/css
  AddOutputFilterByType DEFLATE text/html
  AddOutputFilterByType DEFLATE text/javascript
  AddOutputFilterByType DEFLATE text/plain
  AddOutputFilterByType DEFLATE text/xml

  # Remove browser bugs (only needed for really old browsers)
  BrowserMatch ^Mozilla/4 gzip-only-text/html
  BrowserMatch ^Mozilla/4\.0[678] no-gzip
  BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
  Header append Vary User-Agent
</IfModule>


## EXPIRES CACHING ##


";
//Site website url manage



$sql = db_query("select page_url from mng_aboutus"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ about.php [QSA]
";

$sql = db_query("select page_url from mng_quality"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ quality.php [QSA]
";

$sql = db_query("select page_url from mng_line_card"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ line-card.php [QSA]
";

$sql = db_query("select page_url from mng_excess_inventory"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ sell-excess-inventary.php [QSA]
";


   $sql = db_query("select page_url from all_seo where cpage = 'news'");
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ news.php [QSA]
";

  $sql = db_query("select page_url from all_seo where cpage = 'parts-search'");
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ parts-search.php [QSA]
";

  $sql = db_query("select page_url from all_seo where cpage = 'product-detail'");
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."_([^/]+)_([^/]+)$ product-detail.php?pr=$1&id=$2 [QSA]
";


$sql = db_query("select page_url from quote_landing"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ request-quote.php [QSA]
";


$sql = db_query("select id,page_url from mng_blog");
while($row = mysqli_fetch_array($sql)){
$url = $row[page_url];
$id = $row[id];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ news-detail.php?id=$id [QSA]
";
}

$sql = db_query("select page_url from service_landing"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ services.php [QSA]
";


$sql = db_query("select id,page_url from service_detail");
while($row = mysqli_fetch_array($sql)){
$url = $row[page_url];
$id = $row[id];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ services-detail.php?id=$id [QSA]
";
}

$sql = db_query("select page_url from industries_landing"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ industries.php [QSA]
";

$sql = db_query("select page_url from privacy_policy"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ privacypolicy.php [QSA]
";

$sql = db_query("select page_url from terms_conditions"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ termsconditions.php [QSA]
";

$sql = db_query("select page_url from contact_us"); 
$row = mysqli_fetch_array($sql);
$url = $row[page_url];
$accesscontent =$accesscontent."RewriteRule ^".chageURL($url)."$ contact-us.php [QSA]
";

$query  = db_query("SELECT * FROM mng_pages order by id desc "); 
while($resuser = mysqli_fetch_array($query)){
	
$accesscontent =$accesscontent."RewriteRule ^".$resuser['page_url']."$ page.php?id=".$resuser['id']." [QSA]
";
	
}

$accesscontent =$accesscontent."RewriteRule ^manufacturer-([^/]+)$ manufacturer.php?m=$1 [QSA]
";



fopen($filename, 'w');

if (is_writable($filename)) 
{
 if (!$handle = fopen($filename, 'w+')) 
 {
        print "Cannot open file ($filename)";
        exit;
    }
   // Write $somecontent to our opened file.
   if (fwrite($handle, $accesscontent) === FALSE) 
   {
       print "Cannot write to file ($filename)";
       exit;
   }
 
   fclose($handle);

} 
else 
{
   print "The file $filename is not writable";
}
 
//**************************************************************************************
?>