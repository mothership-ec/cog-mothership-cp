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
	});

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

	$(document).ready( function() {
		$('.table-filter.products').dataTable();
	});

	// initialize the bloodhound suggestion engine
	category.initialize();

	// instantiate the typeahead UI
	$('.example-category').typeahead(null, {
		displayKey: 'num',
		source: category.ttAdapter()
	});


	$(document).ready(function () {
	  $("#colour").select2({
	      tags:["red", "green", "blue", "yellow", "orange", "purple"],
	      tokenSeparators: [",", " "]});
	});

	$(document).ready(function () {
	  $("#size").select2({
	      tags:["xx-small", "x-small", "small", "small-medium", "medium", "medium-large", "large", "x-large", "xx-large", "xxx-large"],
	      tokenSeparators: [",", " "]});
	});

});