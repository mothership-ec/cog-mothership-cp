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
						settings: settings,
						open    : []
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
			var list = this;

			return this.each(function() {
				$(this).on('click.nestedAccordian', 'li a', function() {
					methods.open.call(list, $(this).parent('li'));
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
		},

		open : function(elem) {
			return this.each(function() {
				var settings = $(this).data('nestedAccordian');

				elem.each(function() {
					var self     = $(this)
						children = self.children('ol, ul');

					// Close every other one
					if (settings.open.length > 0
					 && settings.open.get(0) !== self.parents('li').get(0)) {
					 	settings.open.find('ol, ul').filter(':visible').hide();
					 	settings.open = null;

						console.log('closed her');
					}
					else {
						console.log('not closing');
						console.log(settings.open);
					}


					// Ignore if this page has no children
					if (children.length === 0) {
						settings.open = null;

						return false;
					}

					console.log('ope her up');
					settings.open = self;

					children.fadeIn(100);
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