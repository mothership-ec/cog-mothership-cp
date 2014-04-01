/**
 * Data picker polyfill for browsers that do not natively support the HTML5
 * "date" input type.
 *
 * @author Message Digital Design <dev@message.co.uk>
 * @author Richard McCartney <richard@message.co.uk>
 */
$(function() {
	var testDateField = document.createElement('input');

	testDateField.setAttribute('type', 'date');

	// If the browser does not support the date input type, init the polyfill
	if ('date' !== testDateField.type) {
		$('input[type="date"]').datepicker({
			dateFormat: "yy-mm-dd"
		});
	}
});
