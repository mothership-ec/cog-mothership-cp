/**
 * Form functionality for the Mothership Control Panel.
 *
 * @author Joe Holdcroft <joe@message.co.uk>
 */
;$(function() {
	// Set up add links for repeatable groups
	$(document).on('click', 'a[data-group-add]', function() {
		var self           = $(this),
			index          = self.attr('data-group-index') || 0,
			prototypeName  = self.attr('data-prototype-name') || '__name__',
			prototypeLabel = self.attr('data-prototype-label') || '__label__',
			prototype      = self.attr('data-prototype').replace(new RegExp(prototypeName, 'g'), index);

		prototype = prototype.replace(new RegExp(prototypeLabel, 'g'), parseInt(index) + 1);

		self.before($(prototype).hide().fadeIn(200));

		self.attr('data-group-index', (parseInt(index) + 1));

		return false;
	});

	// Set up remove links for repeatable groups
	$(document).on('click', 'a[data-group-remove]', function() {
		$(this).parents('.group').fadeOut(200, function() {
			$(this).remove();
		});
	});

	/**
	 * Repeatable group collapse
	 */
	$(document).on('click', '.group[data-collapse] .title', function() {
		var self        = $(this),
			content       = self.next('.content');

		// Toggle the height of the group content
		content.animate({
			height: 'toggle',
		});

	});
});