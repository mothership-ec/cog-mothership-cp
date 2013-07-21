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

	var toggleMenu = '[data-toggle=dropdown]',
		dropdown = $('.dropdown-menu'),
		parent = '.dropdown',
		open = false;

	// If click on HTML hide any dropdown menus
  	$('html').on('click.dropdown', function() {

  		clearMenu();

  	});

  	// Does not hide if you click inside of the dropdown
  	dropdown.on('click', function(e) {

  		e.stopPropagation();

  	});

  	// Show dropdown
	var dropDown = function() {

		open = true;

		dropdown.stop().slideDown();

	};

	// Clear dropdown menu
	var clearMenu = function() {

		if (open == true) {
			dropdown.stop().slideUp();
		}

		open = false;

	};

	// Dropdown menu toggle
	$(document).on('click.dropdown', toggleMenu, dropDown)

});

