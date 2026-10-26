<!-- jQuery -->
<!--  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
<script src="js/jquery.nice-number.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.min.js">\x3C/script>')</script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/ion.rangeSlider.min.js"></script>
<script type="text/javascript">
$(function(){
  $('input[type="number"]').niceNumber();
});
</script>
<script type="text/javascript">
$(document).ready(function() {
$("#demo").ionRangeSlider({
	skin: "round",
	type: "double",
	min: 0,
	max: 200,
	from: 0,
	to: 120,
	grid: false
});
});
</script>
<!-- FlexSlider -->
<script defer src="js/jquery.flexslider.js"></script>
<script>
$(window).load(function() {

    $('.brand').flexslider({
    animation: "slide",
    controlNav: false,              
    directionNav: true,             
    prevText: "",          
    nextText: "",
    });
});
</script>
<script src="js/menu.js"></script>