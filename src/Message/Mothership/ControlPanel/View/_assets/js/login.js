/**
 * Login hide labels
 *
 * Hide login labels on click or when a value is in its coresponding input
 *
 * This is a *private* plugin, and should only be used by Message Digital Design.
 *
 * @author Message Digital Design <dev@message.co.uk>
 * @author Richard McCartney <richard@message.co.uk>
 */

$(function() {

	var inputArray = $('.login-form input');

	$.each(inputArray, function(index, element){

	    var input = $(element);
	    var label = $('label[for=' + input.attr('id') + ']');

	    // On load hide label if input has a value
    	$(window).on('load', function() {
			if (input.val()) {
				label.hide();
			};
		});

    	// Hide label on focus
	    input.focus(function() {
	        label.fadeOut();
	    });

	    // Show label off focus if input has no value
	    input.blur(function(){
	        if(!input.val()) { label.fadeIn(); }
	    });

	});

});

