;$(function() {

	// Check HTML5 History API is available
	if (!History.enabled) {
		$.error('Your browser does not support the HTML5 History API, so the control panel may not function correctly.');
	}

	// Set up elements with the data-confirm attribute set
	$(document).on('click submit', '[data-confirm]', function() {
		return confirm($(this).attr('data-confirm'));
	});

	// Set up live pane
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
		},
		afterReplace: function(pane, responseData) {
			$('ol#main-menu li')
				.removeClass('current')
				.eq(
					$('ol#main-menu li.current', responseData).index()
				)
				.addClass('current');
		}
	});

	// Set sidebar ordered lists to a nested accordian
	$('section.sidebar > ol').nestedAccordian();

	// Set up global success handler for AJAX calls to check for flashes HTML and add to the page
	$(document).ajaxSuccess(function(event, xhr, options) {
		if (xhr.responseJSON.flashes.length > 0) {
			$('[data-flashes]').html($(xhr.responseJSON.flashes).html());
		}
	});
});