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
		feedback        = '[data-flashes]',
		saveButton 	    = '#save-content',
		deleteButton    = '#delete',
		height   		= 0,
		fbHeight        = 0,
		offSet 			= 0,
		visible			= false,
		open            = false,
		buttonTop    	= parseInt($(saveButton).css('top'), 10);

	/**
	 * Setting up all height calculations if feedback is visibile
	 */
	function calcHeight() {

		offSet = buttonTop + fbHeight;
		height = $(container).outerHeight();

		// Set savebutton top position
		$(saveButton).css('top', offSet + 'px');

		// Set deletebutton top position
		$(deleteButton).css('top', offSet + 'px');

		/**
		 * Minus container offset off the current height value, this resolves content being hidden when
		 * feedback is visible
		 */
		$('.clear').css({
			height : height - (fbHeight + 101)
		});

	}

	/*
	 * Function for each feedback block to hide and show extra error messages.
	 */
	$(feedback).each(function() {

		// Count how many 'li' children feedback has
		var self   = $(this),
			max    = 4,
			length = self.find('ul').children().length;

		/*
		 * If feedback has so many 'li' children that exceed the max value of 4
		 * we hide the extra and place a toggle to show/hide them.
		 */
		if (length > max) {

			var fbChildren = self.find('li'),
				open     = false;

			// Hide extra 'li'
			fbChildren.slice(max, length).hide().end();

			// Add toggle hide/show link
			self.children('.feedback').append('<span class="show-more">Show more messages</span><span class="less">Hide messages</span>');

			// Click function to show/hide children elements
			self.on('click', 'span', function() {

				if (open === false) {

					open = true;

					// show hidden 'li'
					fbChildren.slice(max, length).show();

					// open/hide span
					self.find('.show-more').hide().next().show();
				} else {

					open = false;

					// hide extra 'li'
					fbChildren.slice(max, length).hide();

					// open/hide span
					self.find('.less').hide().prev().show();
				}

				// Calculate feedback height
				fbHeight = $('.feedback-container').outerHeight();

				// Run calc height function
				calcHeight();

			});
		}

		// Calc feedback height
		fbHeight = $('.feedback-container').outerHeight();

	});

 	/*
 	 * Abaility to remove any feedback block from Mothership. Will also
 	 * calculate the height to fix the container
 	 */
	$(feedback).on('click', '.close', function() {

		var self = $(this).parent();

		// remove feedback
		self.remove();

		// recalulate the overall feedback container
		fbHeight = $('.feedback-container').outerHeight();

		// Run calc height function
		calcHeight();

	});

	/**
	 * This window resize function keeps the container at the correct height, this can basically effect
	 * any child containers which rely on this height value
	 */
	$(window).resize(function(event) {

		calcHeight();

	}).trigger('resize');

});
