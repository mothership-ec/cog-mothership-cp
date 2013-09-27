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
		deleteButton    = '#delete',
		max   			= 4,
		height   		= 0,
		fbTrueHeight    = 0,
		fbHeight        = 0,
		offSet 			= 0,
		containerOffset = 0,
		visible			= false,
		open            = false,
		buttonTop    	= parseInt($(saveButton).css('top'), 10);

	/**
	 * Setting up all height calculations if feedback is visibile
	 */
	function calcHeight() {

		if (open == true) {

			offSet = buttonTop + fbTrueHeight;
			height = $(container).height();

			containerOffset = fbTrueHeight + 101;

		} else if (open == false) {

			offSet = buttonTop + fbHeight;
			height = $(container).height();

			containerOffset = fbHeight + 101;

		}

		// Set savebutton top position
		$(saveButton).css('top', offSet + 'px');

		// Set deletebutton top position
		$(deleteButton).css('top', offSet + 'px');

		/**
		 * Minus container offset off the current height value, this resolves content being hidden when
		 * feedback is visible
		 */
		$('.clear').css({
			height : height - containerOffset
		});
	}

	/**
	 * Checking the page if there is feedback, this sets the feedback height variable
	 * and if there is a save button on the page changes its CSS top element to not loose its positioning.
	 */
	if ( $(feedback).is(':visible')) {

		// Set visible to true and get the outer height of feedback
		visible      = true;
		fbTrueHeight = $(feedback).outerHeight();

		// Variables to hide list elements in the feedback
		var length = $('.feedback li').length;

		/**
		 * This if statement will hide errors if there are more than 5, it also contains the function
		 * to hide and show more errors
		 */
		if (length > max) {

			// Hide feedback li's
			$('.feedback li:gt('+max+')').hide().end();

			// Add in show button
			$('.feedback').append('<span class="show-more">Show more messages</span><span class="less">Hide messages</span>');

			// Set new feedback height
			fbHeight = $(feedback).outerHeight();

			/**
			 * On click function when a user clicks the show more span in the feedback
			 */
			$('.feedback span').on('click', function() {

				/**
				 * Show hidden LI errors
				 */
				if (open == false) {

					open = true;

					$('.feedback li:gt('+max+')').show();

					// Set new outer height
					fbTrueHeight = $(feedback).outerHeight();

					// Hide and show button
					$(this).hide();
					$('.less').show();

				} else if (open == true) {

					open = false;

					$('.feedback li:gt('+max+')').hide().end();

					// Hide and show button
					$(this).hide();
					$('.show-more').show();
				}

				// Run calc height function
				calcHeight();

			});

		} else {
			// Set new outer height
			fbHeight = $(feedback).outerHeight();
		}

	};

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
