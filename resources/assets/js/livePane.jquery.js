/**
 * "Live Pane" jQuery Plugin
 *
 * Provides functionality to load in the contents of a specific area, or "pane"
 * of a page dynamically without a page refresh.
 *
 * This is a *private* plugin, and should only be used by Message Digital Design.
 *
 * @author Message Digital Design <dev@message.co.uk>
 * @author Joe Holdcroft <joe@message.co.uk>
 */
;(function( $ ){
	var methods = {
		/**
		 * Initialise the plugin.
		 *
		 * @param object options Object of options for this plugin
		 */
		init : function(options) {
			var defaults = {
					linkSelector: false, // Selector string for links that should load in the pane
					beforeSend  : false, // Event for before the ajax request is made
					afterSend   : false, // Event for when the ajax response is received
					afterReplace: false  // Event for when the ajax response is received + successful
				},
				settings = $.extend({}, defaults, options),
				selector = this.selector;

			return this.each(function() {
				var self  = $(this),
					state = {
						settings   : settings,
						selector   : selector,
						ajaxRequest: null
					};

				// Save state on the element for use later
				self.data('livePane', state);

				// Bind the click & form submit events
				methods.bindEvents.call(self);
			});
		},

		bindEvents : function() {
			return this.each(function() {
				var self = $(this);

				// Set up history event listener for loading content
				History.Adapter.bind(window, 'statechange.livePane', function() {
					methods.loadUri.call(self, History.getState().url);
				});

				// Set up click event for live links
				if (self.data('livePane').settings.linkSelector != false) {
					$(document).on('click.livePane', self.data('livePane').settings.linkSelector, function(e) {
						History.pushState(null, null, $(this).attr('href'));

						return false;
					});
				}
			});
		},

		loadUri : function(uri) {
			return this.each(function() {
				var self  = $(this),
					state = self.data('livePane');

				// Cancel current Ajax request, if there is one
				if (null !== state.ajaxRequest) {
					state.ajaxRequest.abort();
				}

				// If set, fire the beforeSend event
				if (typeof state.settings.beforeSend === 'function') {
					state.settings.beforeSend(self);
				}

				// Removes any feedback and clear styling
				if ( $('.feedback').is(':visible')) {
					$('.feedback').slideUp().remove();
					$('.clear').removeAttr('style');
				}

				state.ajaxRequest = $.ajax({
					url     : uri,
					dataType: 'html',
					complete: function() {
						// If set, fire the afterSend event
						if (typeof state.settings.afterSend === 'function') {
							state.settings.afterSend(self);
						}
						console.log('complete?');
					},
					success : function(html) {
						// Clear the current Ajax request
						state.ajaxRequest = null;

						// Replace the HTML in the pane
						self.html($(state.selector, html).html());

						// If set, fire the afterSend event
						if (typeof state.settings.afterReplace === 'function') {
							state.settings.afterReplace(self, $(html));
						}
					}
				});
			});
		}
	};

	$.fn.livePane = function(method) {
		// Method calling logic
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.livePane');
		}
	};
})(jQuery);