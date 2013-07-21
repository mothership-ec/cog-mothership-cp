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

	var toggleMenu = '[data-toggle=dropdown]';

	// Dropdown toggle animation
	var DropDownToggle = function(parent, dropdown) {

		if (parent.hasClass('open')) {

			dropdown.stop().slideUp();
			parent.removeClass('open');

		} else {

			dropdown.stop().slideDown();
			parent.addClass('open');

		}

	};

	$(toggleMenu).on('click', function() {

		// Set dropdown parent
		var dParent = $(this).parent();

		// Find dropdown menu
		var dropDown = dParent.find('.dropdown-menu');

		// Run dropdown toggle
		DropDownToggle(dParent, dropDown);

	});

});

