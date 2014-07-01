;$(function() {
	var modalHandler = new ModalHandler;

	// Check HTML5 History API is available
	if (!History.enabled) {
		$.error('Your browser does not support the HTML5 History API, so the control panel may not function correctly.');
	}

	// Hide/show loading indicator whenever Ajax is happening
	$(document).ajaxSend(function() {
		$('html').addClass('loading');
	}).ajaxComplete(function() {
		$('html').removeClass('loading');
	});

	// Set up elements with the data-confirm attribute set
	$(document).on('submit', 'form[data-confirm]', function() {
		return confirm($(this).attr('data-confirm'));
	});

	$(document).on('click', 'a[data-confirm]', function() {
		return confirm($(this).attr('data-confirm'));
	});

	if (!$('#save-content').is(':visible')) {
		$('.controls').css('margin-right', -8);
	};

	// Set up live pane
	$('[data-live-pane]').livePane({
		linkSelector: 'a[data-live]',
		beforeSend: function(pane) {
			$('html').addClass('loading');

			// Disable form inputs
			pane.find('input, select, textarea, button').each(function() {
				var self = $(this);

				self.attr('data-disabled', (self.attr('disabled') ? 'orig' : true))
					.attr('disabled', 'disabled');
			});
		},
		afterSend: function(pane) {
			$('html').removeClass('loading');

			// Re-enable form inputs
			pane.find('input, select, textarea, button').filter('[data-disabled]').each(function() {
				var self = $(this);

				if ('orig' === self.attr('data-disabled')) {
					self.removeAttr('disabled');
				}
			});

			// Removes any feedback and clear styling
			if ( $('.feedback').is(':visible')) {
				$('.feedback').slideUp().remove();
				$('.clear').removeAttr('style');
				$('#save-content').removeAttr('style');
			}

			// Toggles all collapsable groups
			$('.group[data-collapse] .title').next('.content').animate({
				height: 'toggle',
			});

			if (!$('#save-content').is(':visible')) {
				$('.controls').css('margin-right', -15);
			};

			$('textarea').each(function(){
				$(this).height($(this)[0].scrollHeight);
			});
		},
		afterReplace: function(pane, responseData) {
			pane.trigger('ms.cp.livePane.change');
		}
	});

	// Set sidebar ordered lists to a nested accordian
	$('section.sidebar > ol').nestedAccordian();

	// Set up global success handler for AJAX calls to check for flashes & redirects
	$(document).ajaxSuccess(function(event, xhr, options) {
		if (typeof xhr.responseJSON !== 'undefined'
		 && typeof xhr.responseJSON.flashes !== 'undefined'
		 && xhr.responseJSON.flashes.length > 0) {
			$('[data-flashes]').html($(xhr.responseJSON.flashes).html());
		}

		if (typeof xhr.responseJSON !== 'undefined'
		 && typeof xhr.responseJSON.redirect !== 'undefined'
		 && xhr.responseJSON.redirect.length > 0) {
			History.pushState(null, null, xhr.responseJSON.redirect);
		}
	});

	// On document load should take the scroll height of each text area and set it as its height
	$(document).ready(function() {
		$('textarea').each(function(){
			$(this).height($(this)[0].scrollHeight);
		});
	});

	// Stub window.console
	if (!window.console) {
		console = {
			log  : function() {},
			warn : function() {},
			error: function() {},
		};
	}
});