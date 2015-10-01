/**
 * Form functionality for the Mothership Control Panel.
 *
 * @author Joe Holdcroft <joe@message.co.uk>
 */
;$(function() {

	// Set up add links for repeatable groups
	$(document).on('click', 'a[data-group-add]', function() {
		var self = $(this), index, prototype, prototypeName, el, labelPrefix, label;

		index         = self.attr('data-group-index') || 0;
		prototype     = self.attr('data-prototype');
		prototypeName = self.attr('data-prototype-name') || '__name__';
		prototype     = prototype.replace(new RegExp(prototypeName, 'g'), parseInt(index, 10));
		labelPrefix   = self.attr('data-prototype-label-prefix') || 'Group #';

		el = $(prototype);
		el.find('[data-group-label]').html(labelPrefix + (parseInt(index, 10) + 1));

		self.before(el.hide().fadeIn(200));

		self.attr('data-group-index', (parseInt(index, 10) + 1));

		return false;
	});

	// Set up remove links for repeatable groups
	$(document).on('click', 'a[data-group-remove]', function() {
		var self = $(this), group, adder, siblings, labelPrefix;

		group       = self.closest('.group');
		adder       = group.siblings('a[data-group-add]');
		siblings    = group.siblings('.group');
		labelPrefix = adder.attr('data-prototype-label-prefix') || 'Group #';

		group.fadeOut(200, function() {
			group.remove();

			// Re-index siblings
			siblings.each(function(i, el) {
				var self = $(this), field, value;
				field = self.attr('data-identifier-field');
				label = self.find('[data-group-label]');
				value = self.find(':input[name*="[' + field + ']"]').val();
				if (value && value.length) {
					label.html(value);
				}
				else {
					label.html(labelPrefix + (i + 1));
				}
			});

			// Decrement adder index
//			adder.attr('data-group-index', parseInt(adder.attr('data-group-index'), 10) + 1);
		});

		return false;
	});

	$('.group[data-collapse] .title').next('.content').animate({
		height: 'toggle',
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
		self.find('[data-group-label]').html(value);
	});

	// Set up add links for repeatable groups
	$(document).on('click', 'a[data-group-ctrl-up]', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var group = $(this).closest('.group'),
			swap = group.prev('.group'),
			grpSequence = group.find('input[id$=_sequence]'),
			swpSequence = swap.find('input[id$=_sequence]')
		;

		if (!group.size() || !swap.size()) return false;

		if (grpSequence.size()) grpSequence.val(parseInt(grpSequence.val()) - 1);
		if (swpSequence.size()) swpSequence.val(parseInt(grpSequence.val()) + 1);

		group.insertBefore(swap);
	});

	// Set up add links for repeatable groups
	$(document).on('click', 'a[data-group-ctrl-down]', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var group = $(this).closest('.group'),
			swap = group.next('.group'),
			grpSequence = group.find('input[id$=_sequence]'),
			swpSequence = swap.find('input[id$=_sequence]')
		;

		if (!group.size() || !swap.size()) return false;

		if (grpSequence.size()) grpSequence.val(parseInt(grpSequence.val()) + 1);
		if (swpSequence.size()) swpSequence.val(parseInt(grpSequence.val()) - 1);

		swap.insertBefore(group);
	});
});