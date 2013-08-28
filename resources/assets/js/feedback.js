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

	// Elements
	var container       = '.container-cp',
		feedback        = '.feedback',
		saveButton 	    = '#save-content',
		feedbackHeight  = 0,
		containerHeight = 0,
		containerOffset = 0,
		buttonOffset    = parseInt($(saveButton).css('top'), 10);

	/**
	 * Checking the page if there is feedback, this sets the feedback height variable
	 * and if there is a save button on the page changes its CSS top element to not loose its positioning.
	 */

	if ( $(feedback).is(':visible')) {

		// Set feedback height value
		feedbackHeight = $(feedback).outerHeight();

		// Set button top CSS 
		buttonOffset = buttonOffset + feedbackHeight;

		$(saveButton).css('top', buttonOffset + 'px');
	}

	/**
	 * This window resize function keeps the container at the correct height, this can basically effect
	 * any child containers which rely on this height value
	 */

	$(window).resize(function(event) {

		containerHeight = $(container).height();

		containerOffset = feedbackHeight + 101;
		
		$('.clear').css({
			height : containerHeight - containerOffset
		});

	});

	/**
	 * Window resize trigger here
	 */

	$(window).trigger('resize');

});
