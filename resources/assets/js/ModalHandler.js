function ModalHandler() {
	this._modal = null;
	this._ajax  = null;

	this.init();
}

ModalHandler.prototype.init = function() {
	var _this = this;

	$('body').on('click.modal', '[data-modal-open]', function() {
		var self = $(this);
		var uri  = self.attr('data-modal');

		if (typeof uri === 'undefined' && 'a' === self.prop('tagName').toLowerCase()) {
			uri = self.attr('href');
		}

		if (typeof uri === 'undefined') {
			return console.error('Cannot launch modal: Modal URI could not be determined');
		}

		_this.launch(uri);

		return false;
	});

	$('body').on('click.modal', '[data-modal-close]', function() {
		_this.close();
	});
};

ModalHandler.prototype.launch = function(uri) {
	var _this = this;

	// Cancel any running Ajax requests for modals
	if (null !== _this._ajax) {
		_this._ajax.abort();
		_this._ajax = null;
	}

	// Close any open modals
	if (null !== _this._modal) {
		_this.close();
	}

	if (!_this.isIdRef(uri)) {
		this._ajax = $.ajax({
			url     : uri,
			dataType: 'html',
			complete: function() {
				_this._ajax = null;
			},
			success : function(data) {
				_this._modal = $(data).hide().appendTo('body');
				_this._modal.fadeIn(100);
			}
		});
	} else {
		_this._modal = $(uri);
		_this._modal.fadeIn(100);
	}

};

ModalHandler.prototype.close = function() {
	var _this = this;

	if (null === _this._modal) {
		return console.warn('Cannot close modal: there is no modal open');
	}

	_this._modal.fadeOut(200, function() {

		if (_this._ajax !== null) {
			_this._modal.remove();
		} else {
			_this._modal.hide();
		}

		_this._modal = null;
	});

	return true;
};

ModalHandler.prototype.isIdRef = function(uri) {
	if (typeof uri !== 'string') {
		return console.warn('Uri is not a string');
	}

	return uri.charAt(0) === '#';
};

// TODO: overwrite window.console for production
// TODO: loading indicator not shown