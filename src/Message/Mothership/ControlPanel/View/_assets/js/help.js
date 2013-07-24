/**
 * Contextual Help Plugin
 *
 * This plugin provides functionality to all contextual help. 
 * Revealing the chosen help section for a field or form element.
 *
 * This is a *private* plugin, and should only be used by Message Digital Design.
 *
 * @author Message Digital Design <dev@message.co.uk>
 * @author Richard McCartney <richard@message.co.uk>
 */

$(function() {

	// Show required contextual help
	$(document).on('click', 'a[data-show]', function() {

		var self     = $(this),
			longHelp = self.attr('href');

		$(longHelp).addClass('open').fadeIn(200);

	});

	// Hide contextual help
	$(document).on('click', '.long.open', function(e) {

		$(this).removeClass('open').fadeOut(200);

	});

});
