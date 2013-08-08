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

	var feedback    = '.feedback',
		height      = 0,
		offSet      = 120,
		container   = '.container-content',
		saveButton  = '#save-content';


	// Check if its the filemanager 
	function checkContainer() {

		if ( $(container).hasClass('file-manager') || $(container).hasClass('create-page')) {
	
			offSet = 65;

		} else {

			offSet = 120;

		}

	};


	// If the feedback is visible work out offset
	if ( $(feedback).is(':visible')) {

		// Check the container first
		checkContainer();

		height = $(feedback).outerHeight();

		offSet = offSet + height;

		$(container).css({
			width: 'calc(100% - 200px)',
			width: 'calc(100% - 200px)',
			width: 'calc(100% - 200px)'
		});

	} else {

		console.log('bye');

	}

});
