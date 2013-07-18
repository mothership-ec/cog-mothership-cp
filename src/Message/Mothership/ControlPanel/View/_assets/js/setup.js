$(function() {
	$('html').removeClass('no-js').addClass('js');

	if (!History.enabled) {
		$.error('Your browser does not support the HTML5 History API, so the control panel may not function correctly.');
	}

	$(document).on('click submit', '[data-confirm]', function() {
		return confirm($(this).attr('data-confirm'));
	});

	$('[data-live-pane]').livePane({
		linkSelector: 'a[data-live]',
		beforeSend: function(pane) {
			$('html').addClass('loading');

			// Disable form inputs
			pane.find('input, select, textarea, button').each(function() {
				var self = $(this);

				if (self.attr('disabled')) {
					self.attr('data-disabled', true);
				}

				self.attr('disabled', 'disabled');
			});
		},
		afterSend: function(pane) {
			$('html').removeClass('loading');

			// Re-enable form inputs
			pane.find('input, select, textarea, button').each(function() {
				var self = $(this);

				if (!self.attr('data-disabled')) {
					self.removeAttr('disabled');
				}
			});
		}
	});
});