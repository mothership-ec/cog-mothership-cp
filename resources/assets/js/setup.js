;$(function() {
	$('html').removeClass('no-js').addClass('js');


$(window).resize(function(){
	var windowWidth = $(window).width();

	$("#test").html(windowWidth);//Just to see in real time what's the window with

	if (windowWidth < 1260) {
    	$('#save-content, .save-content').css('left', '1093px');
  	}
	else {
   		$('#save-content, .save-content').css('right', '14px');
	    $('#save-content, .save-content').css('left', 'auto');
	  }
});

});