/**
 * "Select All Toggle" jQuery Plugin
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
					inputs      : null, 			// jQuery instance for the all inputs
					selectText  : 'Select all',		// Text for the toggle when not all the inputs are ticked
					deselectText: 'Deselect all',	// Text for the toggle when none or some of the inputs are ticked
				},
				settings = $.extend({}, defaults, options);

			return this.each(function() {
				var self  = $(this),
					state = {
						settings: settings,
						status  : null, // all, some, none
					};

				// Throw error if location setting is not a jQuery instance
				if (!(settings.inputs instanceof jQuery)) {
					$.error('jQuery.selectAllToggle failed to initialise: inputs must be a jQuery instance');
				}

				// Set the state
				self.data('selectAllToggle', state);

				// Set initial state
				methods.setStatus.call(self);

				// Bind click event for toggling
				self.on('click.selectAllToggle', function() {
					methods.toggle.call(self);

					return false;
				});

				// Bind click event to see if the toggle state has changed
				settings.inputs.on('change.selectAllToggle', function() {
					methods.setStatus.call(self);
				});
			});
		},

		setStatus : function() {
			return this.each(function() {
				var self        = $(this),
					state       = self.data('selectAllToggle'),
					numInputs   = state.settings.inputs.length,
					numSelected = state.settings.inputs.filter(':checked').length;

				state.status = (numSelected == 0)
					? 'none'
					: (numSelected == numInputs ? 'all' : 'some');

				self.text(('all' === state.status) ? state.settings.deselectText : state.settings.selectText)
					.removeClass('none all some')
					.addClass(state.status);
			});
		},

		toggle : function() {
			return this.each(function() {
				var self  = $(this),
					state = self.data('selectAllToggle');

				state.settings.inputs.prop('checked', ('all' !== state.status));

				methods.setStatus.call(self);
			});
		}
	};

	$.fn.selectAllToggle = function(method) {
		// Method calling logic
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.selectAllToggle');
		}
	};
})(jQuery);