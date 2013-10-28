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

		prototype = prototype.replace(new RegExp(prototypeLabel, 'g'), parseInt(index, 10) + 1);

		self.before($(prototype).hide().fadeIn(200));

		self.attr('data-group-index', (parseInt(index, 10) + 1));

		return false;
	});

	// Set up remove links for repeatable groups
	$(document).on('click', 'a[data-group-remove]', function() {
		var self = $(this), group, adder;
		group = self.parents('.group');
		adder = $('a[data-group-add]');

		group.fadeOut(200, function() {
			group.remove();
		});

		// Decrement adder index
		adder.attr('data-group-index', parseInt(adder.attr('data-group-index'), 10) - 1);
	});

	// Collapse repeatable groups
	$(document).on('click', '.group[data-collapse] .title', function() {
		var self        = $(this),
			content       = self.next('.content');

		// Toggle the height of the group content
		content.animate({
			height: 'toggle',
		});

	});

	// Watch the repeatable group identifier field and push the value to the
	// title element.
	$(document).on('keyup', '.group[data-identifier-field]', function() {
		var self = $(this), field, value;
		field = self.attr('data-identifier-field');
		value = self.find(':input[name*="[' + field + ']"]').val();
		self.find('.title').html(value);
	});
});