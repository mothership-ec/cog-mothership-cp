;$(function() {
	$('html').removeClass('no-js').addClass('js');


$( ".csv-show.valid" ).click(function() {
	if ($('.valid .hide').is(":visible")) {
		$('.valid .hide').hide();
		$( '.csv-show.valid').text("Show all rows");
	} 
	else {
		$('.valid .hide').show();
		$( '.csv-show.valid').text("Hide rows");
	}
});

$( ".csv-show.invalid" ).click(function() {
	if ($('.invalid .hide').is(":visible")) {
		$('.invalid .hide').hide();
		$( '.csv-show.invalid').text("Show all rows");

	} 
	else {
		$('.invalid .hide').show();
		$( '.csv-show.invalid').text("Hide rows");
	}
});

$(window).resize(function(){
	var windowWidth = $(window).width(),
		buttonWidth = $('#save-content').outerWidth()
		offSet = 0;

	$("#test").html(windowWidth);//Just to see in real time what's the window with

	if (windowWidth < 1260) {
		offSet = 1246 - buttonWidth;
    	$('#save-content, .save-content').css('left', offSet);

    	console.log(offSet, topBar, buttonWidth);
  	}
	else {
   		$('#save-content, .save-content').css('right', '14px');
	    $('#save-content, .save-content').css('left', 'auto');
	}

	$('.modules').masonry({
		itemSelector: '.module',
		columnWidth: 330,
		gutter: 20
	});

});

});