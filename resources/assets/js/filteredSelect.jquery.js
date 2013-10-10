/**
 * "Filtered Select" jQuery Plugin
 *
 *
 * This is a *private* plugin, and should only be used by Message Digital Design.
 *
 * @author Message Digital Design <dev@message.co.uk>
 * @author Joe Holdcroft <joe@message.co.uk>
 */
(function( $ ){
	var methods = {
		/**
		 * Initialise the plugin.
		 *
		 * @param object options Object of options for this plugin
		 */
		init : function(options) {
			var defaults = {
					monitor : false,
					onChange: false
				},
				settings = $.extend({}, defaults, options);

			return this.each(function() {
				var self  = $(this),
					state = {
						settings: settings,
						monitor : false,
						options : {},
						selected: false,
					};

				// Set the element(s) to monitor from the settings
				if (settings.monitor instanceof jQuery) {
					state.monitor = settings.monitor;
				} else if (typeof settings.monitor === 'function') {
					state.monitor = settings.monitor.call(self);
				}

				// Throw an error if the monitor variable isn't a jQuery instance
				if (!(state.monitor instanceof jQuery)) {
					$.error('jQuery.filteredSelect failed to initialise: monitor must be set to a jQuery instance, or a function that returns a jQuery instance');
				}

				// Set the options
				self.children('optgroup').each(function() {
					var groupName = $(this).attr('label');

					state.options[groupName] = [];

					$(this).children('option').each(function() {
						state.options[groupName].push($(this));
					});
				});

				// Save state on the element for use later
				self.data('filteredSelect', state);

				// Bind the change events
				state.monitor.on('change.filteredSelect', function() {
					methods.filter.call(self);
				});

				// Initial filter
				methods.filter.call(self);
			});
		},

		filter : function() {
			return this.each(function() {
				var self     = $(this),
					state    = self.data('filteredSelect'),
					selected = state.monitor.val();

				self.children('optgroup, option[value!=""]').remove();

				if (typeof state.options[selected] !== 'undefined') {
					self.append(state.options[selected]);
				}

				if (typeof state.settings.onChange === 'function') {
					state.settings.onChange.call(self);
				}
			});
		}
	};

	$.fn.filteredSelect = function(method) {
		// Method calling logic
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.filteredSelect');
		}
	};
})(jQuery);