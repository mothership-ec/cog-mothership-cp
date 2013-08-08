/**
 * Feedback Plugin
 *
 * Show and hide feedbak and height correction for save button and container frame
 *
 * This is a *private* plugin, and should only be used by Message Digital Design.
 *
 * @author Message Digital Design <dev@message.co.uk>
 * @author Richard McCartney <richard@message.co.uk>
 */

$(function() {

	var feedback   = '.feedback',
		height     = 0,
		saveButton = '#save-content';
		// topOffset        = $('#saveButton').offset().top;

	// If the feedback is visible work out offset
	if ( $(feedback).is(':visible')) {

		height = $(feedback).outerHeight();

		topOffset = topOffset + height;

		$(saveButton).css('top', topOffset + 'px');

	} else {

		return false;

	}

});
