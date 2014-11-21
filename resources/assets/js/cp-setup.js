;$(function() {
	/**
	 * ----------------------------------------------------------------------
	 * 
	 * Setup for the ModalHandler
	 *
	 * ----------------------------------------------------------------------
	 */
	var modalHandler = new ModalHandler;

	// Check HTML5 History API is available
	if (!History.enabled) {
		$.error('Your browser does not support the HTML5 History API, so the control panel may not function correctly.');
	}

	/**
	 * ----------------------------------------------------------------------
	 *
	 * The AAX spinner
	 * 
	 * ----------------------------------------------------------------------
	 */
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

	/**
	 * ----------------------------------------------------------------------
	 * 
	 * Live Panes for AJAX loading
	 *
	 * ----------------------------------------------------------------------
	 */
	// Set up live pane
	$('[data-live-pane],[data-live-slide]').livePane({
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

	/**
	 * ----------------------------------------------------------------------
	 * 
	 * The LiveSlide component
	 *
	 * This component allows the swooshy thing to operate.
	 *
	 * ----------------------------------------------------------------------
	 */
	function LiveSlide() {
		_this = this;
		this.loaded = false;
		this.hidden = true;

		$('[data-live-slide][data-slide-loaded]').each(function() {
			var slide = this;
			$(document).on('ready', function() {

			_this.init(slide, 0);
			});
		});

		$('[data-live-slide]').on('ms.cp.livePane.change', function() {
			_this.init(this);
		});

		$('body').on('click.live-slide-toggle', '[data-live-slide-toggle]', function(e) {
			if(!_this.loaded) {
				return console.warn('cannot toggle, no data loaded');
			}

			_this.hidden?_this.show():_this.hide();

			e.stopPropagation();
		});

		$('body').on('click.live-slide', '[data-live-slide]', function(e) {
			if (_this.hidden) {
				_this.show();
			}
		});

		$('body').on('click.live-slide-hide', '[data-live-slide-hide]', function(e) {
			_this.hide();
			e.stopPropagation();
		});

		// show the pane if already loaded
		$('[data-live]').on('click.livePane', function(e) {
			var state = History.getState();
			if (state.url === $(this).attr('href') || state.hash === $(this).attr('href')) {
				_this.show();
			}
		});
	}

	LiveSlide.prototype.init = function(slide, speed) {
		var _this = this;

		this.loaded = true;
		this.slide = $(slide);
		this.slide.append('<span class="button icon caret-right slide-hide" data-live-slide-toggle></span>');
		this.show(speed);

		$(window).unbind('resize.cp-livePane-slide');
		$(window).on('resize.cp-livePane-slide', function() {
			if(_this.hidden) {
				_this.hide(0);
			}
		});
	}
	
	LiveSlide.prototype.show = function(speed) {
		if(this.loaded){
			this.hidden = false;
			this.slide.animate({right: 0}, speed);
			this.slide.trigger('show.cp-livePane-slide');
			$('.slide-hide', this.slide).removeClass('caret-left').addClass('caret-right');
		}
	}

	LiveSlide.prototype.hide = function(speed) {
		if(this.slide){
			this.hidden = true;
			this.slide.animate({right: 30-this.slide.width()}, speed)
			this.slide.trigger('hide.cp-livePane-slide');
			$('.slide-hide', this.slide).removeClass('caret-right').addClass('caret-left');
		}
	}

	LiveSlide.prototype.close = function(speed) {
		if(this.loaded){
			this.hidden = true;
			this.slide.animate({right: -this.slide.width()}, speed);
			this.loaded = false;
			this.slide.trigger('close.cp-livePane-slide');
			$(window).unbind('resize.cp-livePane-slide');
		}
	}

	var LiveSlide = new LiveSlide;

	/**	
	 * ----------------------------------------------------------------------
	 *
	 * Nested accordian setup for the sidebar
	 * 
	 * ----------------------------------------------------------------------
	 */
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