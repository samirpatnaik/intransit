/* 	
             var slider = document.getElementById("myRange");
             var output = document.getElementById("value");

              output.innerHTML = slider.value;

slider.oninput = function(){
	output.innerHTML = this.value;
}

slider.addEventListener("mousemove", function(){
	var x = slider.value;
	var color = 'linear-gradient(90deg, rgb(2, 156, 252)' + x + '%, rgb(214,214,214)' + x + '%)';
    slider.style.background = color;
    
})*/

/*const allRanges = document.querySelectorAll(".slideContainer");
allRanges.forEach(wrap => {
  const range = wrap.querySelector(".range");
  const bubble = wrap.querySelector(".bubble");

  range.addEventListener("input", () => {
    setBubble(range, bubble);
  });
  setBubble(range, bubble);
});

function setBubble(range, bubble) {
  const val = range.value;
  const min = range.min ? range.min : 0;
  const max = range.max ? range.max : 200;
  const newVal = Number(((val - min) * 100) / (max - min));
  bubble.innerHTML = val;

  // Sorta magic numbers based on size of the native UI thumb
  bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
}*/

/*let btnAdd = document.querySelector('#add');
let btnSubtract = document.querySelector('#subtract');

let input = document.querySelector('input');

btnAdd.addEventListener('click', () =>{
  input.value = parseInt(input.value) + 1;
});

btnSubtract.addEventListener('click', () =>{
  input.value = parseInt(input.value) - 1;
});*/
$(function() { // document ready
  if ($('#sticky').length) { // make sure "#sticky" element exists
    var el = $('#sticky');
    var stickyTop = $('#sticky').offset().top; // returns number
    var stickyHeight = $('#sticky').height();

    $(window).scroll(function() { // scroll event
      var limit = $('#footer').offset().top - stickyHeight - 100;

      var windowTop = $(window).scrollTop(); // returns number

      if (stickyTop < windowTop) {
        el.css({
          position: 'fixed',
          top: 0
        });
      } else {
        el.css('position', 'static');
      }

      if (limit < windowTop) {
        var diff = limit - windowTop;
        el.css({
          top: diff
        });
      }
    });
  }
});