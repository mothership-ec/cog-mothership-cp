function ModalHandler() {
	this._modal = null;
	this._ajax  = null;

	this.init();
}

ModalHandler.prototype.init = function() {
	var _this = this;

	$('body').on('click.modal', '[data-modal-open]', function() {
		var self = $(this);
		var ref  = self.attr('data-modal');

		if (typeof ref === 'undefined' && 'a' === self.prop('tagName').toLowerCase()) {
			ref = self.attr('href');
		} else if (typeof ref === 'undefined' && self.attr('form') && self.attr('type') === 'submit') {
			ref = $('#' + self.attr('form'));
		} else if (typeof ref === 'undefined' && self.attr('type') === 'submit') {
			ref = self.closest('form');
		}

		if (typeof ref === 'undefined') {
			return console.error('Cannot launch modal: Modal URI could not be determined');
		}

		_this.launch(ref);

		return false;
	});

	$('body').on('click.modal', '[data-modal-close]', function() {
		_this.close();
	});
};

ModalHandler.prototype.launch = function(ref) {
	var _this = this, 
		data = null, 
		form = _this.getForm(ref),
		uri  = (form === null ? ref : ref.attr('action'));
	;

	// Cancel any running Ajax requests for modals
	if (null !== _this._ajax) {
		_this._ajax.abort();
		_this._ajax = null;
	}

	// Close any open modals
	if (null !== _this._modal) {
		_this.close();
	}


	if (!_this.isIdRef(uri) || form !== null) {
		this._ajax = $.ajax({
			url     : uri,
			dataType: 'html',
			method  : (form === null ? 'get' : form.attr('method')),
			data    : (form === null ? null  : form.serialize()),
			complete: function(data) {
				_this._ajax = null;
				console.log($('[data-flashes]', $(data.responseText)).html());
				$('[data-flashes]').html($('[data-flashes]', $(data.responseText)).html());
			},
			success : function(data) {
				_this._modal = $(data).hide().appendTo('body');
				_this._modal.fadeIn(100);
			}
		});
	} else {
		_this._modal = $(ref);
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

ModalHandler.prototype.getForm = function(ref) {
	try {
		ref = $(ref);
		return ref.is('form') ? ref : null;
	} catch(err) {
		return null;
	}
}

ModalHandler.prototype.isIdRef = function(ref) {
	if (typeof ref !== 'string') {
		return console.warn('Uri is not a string');
	}

	return ref.charAt(0) === '#';
};

// TODO: overwrite window.console for production
// TODO: loading indicator not shown