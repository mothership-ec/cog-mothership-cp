/**
 * Title Edit
 *
 * JS to edit the CMS title of a page
 *
 * @author Message Digital Design <dev@message.co.uk>
 * @author Richard McCartney <richard@message.co.uk>
 */

$(function() {

	var title = '[data-title]',
		edit = '[data-title-edit]';


	$(document).on('click', function(e) {
		
		// If the title is the target show the edit input
		if ( $(e.target).is(title) ) {
			
			$(edit).show();

		// stop clicking
		} else if ( $(e.target).is(edit) || $(e.target).is($(edit).children()) ) {

			e.stopPropagation();

		} else {

			$(edit).hide();

		}

	});

});

