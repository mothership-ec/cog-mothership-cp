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
		visible			= false,
		buttonOffset    = parseInt($(saveButton).css('top'), 10);

	/**
	 * Checking the page if there is feedback, this sets the feedback height variable
	 * and if there is a save button on the page changes its CSS top element to not loose its positioning.
	 */
	if ( $(feedback).is(':visible')) {

		visible = true;

		$(feedback).find('li').hide().filter(':lt(2)').show();

		$(feedback).find('ul').append('<li><span>more</span><span class="less">less</span></li>')
		    .find('li:last')
		    .click(function(){
		        $(this)
		            .siblings(':gt(1)')
		            .toggle()
		            .end()
		            .find('span')
		            .toggle();
		});

		// Set feedback height value
		feedbackHeight = $(feedback).outerHeight();	

	} else {

		visible = false;

	}

	/**
	 * Setting up all height calculations if feedback is visibile
	 */
	function calcHeight() {
		
		if (visible == true) {

			// Set container height to the current height
			containerHeight = $(container).height();

			// Set container offset value
			containerOffset = feedbackHeight + 101;
		
			// Set button top CSS 
			buttonOffset = buttonOffset + feedbackHeight;

			// Set new save button top CSS value
			$(saveButton).css('top', buttonOffset + 'px');

			/**
			 * Minus container offset off the current height value, this resolves content being hidden when
			 * feedback is visible
			 */
			$('.clear').css({
				height : containerHeight - containerOffset
			});	

		};
	}

	/**
	 * This window resize function keeps the container at the correct height, this can basically effect
	 * any child containers which rely on this height value
	 */
	$(window).resize(function(event) {

		calcHeight();

	});

	/**
	 * Window resize trigger here
	 */
	$(window).trigger('resize');

});
