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


    $('.table-filter.products').dataTable()
		.columnFilter({
			aoColumns: [
				{ type: "text" },
				null,
				{ type: "text" },
				{ type: "text" },
				{ type: "text" },
				{ type: "text" },
				null
			]
		});

	// instantiate the bloodhound suggestion engine
	var category = new Bloodhound({
		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.num); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		local: [
			{ num: 'C-Line' },
			{ num: 'M-Line' },
			{ num: 'Gifting' },
			{ num: 'Straps' },
			{ num: 'Editions' }
		]
	});

	// initialize the bloodhound suggestion engine
	category.initialize();

	$('.sorting').each(function() {
		if ($(this).attr('data-disable')) {
			$(this).removeClass('sorting');
		};
	});

	// instantiate the typeahead UI
	$('.example-category').typeahead(null, {
		displayKey: 'num',
		source: category.ttAdapter()
	});


	$(document).ready(function () {
	  $("#e20").select2({
	      tags:["red", "green", "blue"],
	      tokenSeparators: [",", " "]});
	});

});