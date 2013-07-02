$(function() {
	$('html').removeClass('no-js').addClass('js');

	$('[data-confirm]').on('click submit', function() {
		return confirm($(this).attr('data-confirm'));
	});
});