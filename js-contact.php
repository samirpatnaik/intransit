<!-- jQuery -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <!--  <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.min.js">\x3C/script>')</script> -->

  <!-- FlexSlider -->
  <script defer src="js/jquery.flexslider.js"></script>
  <script>
  $(window).load(function() {
	  $('.flexslider').flexslider({
		animation: "slide",
		controlNav: true,              
    directionNav: false, 
	  });
	   $('.brand').flexslider({
		animation: "slide",
		controlNav: false,              
    directionNav: true,             
    prevText: "",          
    nextText: "",
	  });
	});
  </script>
    <script type="text/javascript">
     $(window).load(function(){
                $('#myModal').modal('show');
            });
</script>