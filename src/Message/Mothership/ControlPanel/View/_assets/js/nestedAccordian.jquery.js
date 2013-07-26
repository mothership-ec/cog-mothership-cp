/**
 * "Nested Accordian" jQuery Plugin
 *
 * Provides functionality for an accordian that can work with infinitely nested
 * lists.
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
					showNumberBadge: true
				},
				settings = $.extend({}, defaults, options);

			return this.each(function() {
				var self  = $(this),
					state = {
						settings: settings
					};

				// Save state on the element for use later
				self.data('nestedAccordian', state);

				// Bind the click & form submit events
				methods.bindEvents.call(self);

				if (state.settings.showNumberBadge) {
					methods.initNumberBadges.call(self);
				}
			});
		},

		bindEvents : function() {
			return this.each(function() {
				var self = $(this);

				self.on('click.nestedAccordian', 'li a', function() {

					// ignore if sibling isn't <ol>
					console.log('clicked!');
				});
			});
		},

		initNumberBadges : function() {
			return this.each(function() {
				$(this).find('li').each(function() {
					var self     = $(this),
						children = self.children('ol, ul');

					if (children.length > 0) {
						self.append('<span class="badge">' + children.find('li').length + '</span>');
					}
				});
			});
		}
	};

	$.fn.nestedAccordian = function(method) {
		// Method calling logic
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.nestedAccordian');
		}
	};
})(jQuery);