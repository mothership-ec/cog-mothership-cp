/**
 * Navigation functionality
 *
 * This plugin corseponds with the ading to Navigation.
 *
 */

jQuery(document).ready(function($) {

	var container = $('#container'),
		navigation    = $('.nav-offcanvas'),
		link      = $('.nav-open'),
		icon      = $('.nav-open i'),
		close     = $('.close'),
		offSet    = -200,
		open      = false,
		mobile    = false;

	if (window.innerWidth <= 768) {
		mobile = true;
	}

	// Open off canvas
	function openCanvas() {

		open = true;

		var body = $('body');

		// This only counts for navigation off canvas
		if (mobile === true) {
			container.finish(); navigation.finish();

			container.animate({'left': -offSet}, 250);
			navigation.animate({'marginLeft': 0}, 250);
		}

	}

	// Close off canvas
	function closeCanvas() {

		open = false;

		if (mobile === true) {
			container.finish(); navigation.finish();

			container.animate({'left': 0}, 250);
			navigation.animate({'marginLeft': offSet}, 250);
        }
	}

	// Open and close from off canvas link
	link.on('click', function(event) {
		event.preventDefault();
		/* Act on the event */

		var canvasTarget = $(this).data('target'),
			canvasDir    = $(this).data('direction');

		if (open === false) {
			openCanvas(canvasTarget, canvasDir);
			icon.removeClass('fa-bars').addClass('fa-close');
		} else {
			closeCanvas();
			icon.removeClass('fa-close').addClass('fa-bars');
		}

	});


	// close canvas
	close.on('click', function(event) {
		event.preventDefault();

		closeCanvas();
	});


	var checkMobile = function() {

		// Check if the site is below 768px width
		if (window.innerWidth <= 1140) {
			mobile = true;
			navigation.animate({'marginLeft': offSet}, 0);
		} else {
			mobile = false;
			open = false;
			navigation.css('margin-left', 'auto');
			container.css('left', '0');
			icon.removeClass('fa-close').addClass('fa-bars');
		}
	}

	// $(window).on('resize-end', checkMobile);
	if (mobile === false) {
		$(window).on('resize', checkMobile);
	}

});