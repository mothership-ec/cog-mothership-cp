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

	// Product table JS setup
	$('.table-filter.products').dataTable({
		iDisplayLength: 25,
		"oLanguage": {
			"sLengthMenu": 'Display <select>'+
			'<option value="25">25</option>'+
			'<option value="50">50</option>'+
			'<option value="100">100</option>'+
			'<option value="200">200</option>'+
			'<option value="-1">All</option>'+
			'</select> products',
		"sInfo": "Showing (_START_ to _END_) of _TOTAL_ Products"}
    }).columnFilter({
		aoColumns: [
			{ type: "text" },
			null,
			{ type: "text" },
			{ type: "text" },
			null
		]
	});

	// CMS table JS setup
	$('.table-filter.pages').dataTable({
		iDisplayLength: 25,
		"oLanguage": {
			"sLengthMenu": 'Display <select>'+
			'<option value="25">25</option>'+
			'<option value="50">50</option>'+
			'<option value="100">100</option>'+
			'<option value="200">200</option>'+
			'<option value="-1">All</option>'+
			'</select> pages',
		"sInfo": "Showing (_START_ to _END_) of _TOTAL_ Pages"}
    }).columnFilter({
		aoColumns: [
			{ type: "text" },
			null,
			{ type: "text" },
			{ type: "text" },
			null
		]
	});

	$(document).ready( function() {
		$('.table-filter.products').dataTable();
		$('.table-filter.pages').dataTable();
	});


});