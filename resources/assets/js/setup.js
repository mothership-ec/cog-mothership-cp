$(function() {
	$('html').removeClass('no-js').addClass('js');


	$(window).resize(function(){
		var windowWidth = $(window).width(),
			buttonWidth = $('#save-content').outerWidth()
			offSet = 0;

		if (windowWidth < 1260) {
			offSet = 1246 - buttonWidth;
			$('#save-content, .save-content').css('left', offSet);
		} else {
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

	$(document).ready(function () {
		$("#colour").select2({
			tags:[""],
			tokenSeparators: [",", " "]
		});
	});

	$(document).ready(function () {
		$("#size").select2({
			tags:[""],
			tokenSeparators: [",", " "]
		});
	});

	var variantCount = 0,
		variant      = $('.select2-offscreen'),
		variantArray = [];



	// Creating the variants
	variant.change(function() {

		// Get the first input and match

	});

});