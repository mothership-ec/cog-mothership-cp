/**
 * Form functionality for the Mothership Control Panel.
 *
 * @author Joe Holdcroft <joe@message.co.uk>
 */
$(function() {
	// Set up add links for repeatable groups
	$('a[data-prototype]').click(function() {
		var self          = $(this),
			index         = self.attr('data-prototype-index') || 0,
			prototypeName = self.attr('data-prototype-name') || '__name__',
			prototype     = self.attr('data-prototype').replace(new RegExp(prototypeName, 'g'), index);

		self.before(prototype);
	});
});