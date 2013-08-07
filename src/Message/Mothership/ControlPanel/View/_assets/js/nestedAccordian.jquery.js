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
					showNumberBadge: true,
					activeClass    : 'active'
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

				// If something is already active, open up the accordian to that place
				var current = self.find('.' + settings.activeClass);
				if (current.length > 0) {
					methods.openAt.call(self, current);
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

		openAt : function(elem) {
			return this.each(function() {
				var list = $(this);

				elem.each(function() {
					methods.open.call(list, elem.add(elem.parents('li')));
				});
			});
		},

		open : function(elem) {
			return this.each(function() {
				var list        = $(this),
					activeClass = list.data('nestedAccordian').settings.activeClass;

				elem.each(function() {
					var self     = $(this)
						children = self.children('ol, ul');

					// If a sibling is open, close it recursively
					methods.close.call(list, self.siblings());

					// Set active class
					list.find('li.' + activeClass).removeClass(activeClass);
					self.addClass(activeClass);

					// Can't open this section if there's no children
					if (children.length === 0) {
						return false;
					}

					// Open up this section
					self.addClass('open');
					children.fadeIn(100);
				});
			});
		},

		close : function(elem) {
			return this.each(function() {
				elem.each(function() {
					var self = $(this);

					self.find('.open').add(self)
						.removeClass('open')
						.children('ol')
							.fadeOut(100);
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