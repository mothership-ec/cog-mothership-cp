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

	var feedback  = '.feedback',
		height	  = 0,
		container = '.container-content';

	if ( $(feedback).is(':visible')) {

		height = $(feedback).outerHeight();

		console.log(height);

	} else {

		console.log('bye');

	}

});
