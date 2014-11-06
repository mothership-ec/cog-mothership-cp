;$(function() {
	$('html').removeClass('no-js').addClass('js');


	

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

	$(document).ready( function() {
		$('.table-filter').dataTable();
	});

	$('.clear-filters').on('click', function() {
		$('.table-filter').find('input').val('');
		$('.table-filter').find('input').keyup();

	});





});