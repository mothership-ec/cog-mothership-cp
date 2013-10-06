/**
 * Button group dropdown
 *
 * Dropdown function for all dropdown elements, will work for standard dropdowns
 * and button groups.
 *
 * @author Message Digital Design <dev@message.co.uk>
 * @author Richard McCartney <richard@message.co.uk>
 */

$(function() {

	var toggleMenu = '.dropdown-toggle',
			 input = $('.dropdown-menu input');

	if (input.val()) {
		$('.button.button-group.small span').addClass('date-set');
	}

	// Dropdown toggle animation
	var DropDownToggle = function(parent, dropdown) {

		if (parent.hasClass('open')) {

			dropdown.slideUp();
			parent.removeClass('open');

		} else {

			dropdown.slideDown();
			parent.addClass('open');

		}

	};

	$(document).on('click', toggleMenu, function() {

		// Set dropdown parent
		var dParent = $(this).parent();

		// Find dropdown menu
		var dropDown = dParent.find('.dropdown-menu');

		// Run dropdown toggle
		DropDownToggle(dParent, dropDown);

		
		if (input.val()) {
			$('.button.button-group.small span').addClass('date-set');
		} else {
			return;
		}

	});

});

