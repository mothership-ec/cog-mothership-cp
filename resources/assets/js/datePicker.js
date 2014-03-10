/**
 * Data picker input
 *
 *
 * This is a *private* plugin, and should only be used by Message Digital Design.
 *
 * @author Message Digital Design <dev@message.co.uk>
 * @author Richard McCartney <richard@message.co.uk>
 */

$(function() {

	// Add jQuery UI datepicker to date fields if browser does not support them
	var testDateField, supportsDateField;
	testDateField = document.createElement('input');
	testDateField.setAttribute('type', 'date');
	supportsDateField = 'date' == testDateField.type;

	if (false == supportsDateField) {
		$('input[type="date"]').datepicker();
	}

});
