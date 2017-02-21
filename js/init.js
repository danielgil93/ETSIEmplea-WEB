(function($){
  $(function(){

    $('.button-collapse').sideNav();
    $('.parallax').parallax();
    $('select').material_select();
    $('.modal-trigger').leanModal();
    
    setTimeout(function() {
    	$(".notify").fadeOut(1500);
    },4000);
	
	$('a').bind('click',function(event){
		var $anchor = $(this);

		$('html, body').stop().animate({
			scrollTop: $($anchor.attr('href')).offset().top
		}, 1500,'easeInOutExpo');

		event.preventDefault();
	});

  }); // end of document ready
})(jQuery); // end of jQuery name space