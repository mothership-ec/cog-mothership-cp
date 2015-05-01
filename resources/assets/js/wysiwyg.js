/* 
/*
/* Text Editor JavaScript 
/*
/* ------------------------------------------ */

/* JQuery UI elements for resizing https://jqueryui.com/resizable */ 

$(function() {
    $( ".textarea" ).resizable();

 });

/* Jquery to correspond with Medium Text Editor https://github.com/daviferreira/medium-editor */

function wysiwyg(id, value) {
	var markdown = $('#' + id),
		wysiwyg = $('#editable_' + id),
		previewLink = $('#preview_link_' + id),
		markdownLink = $('#markdown_link_' + id),
		markdownText = value
		;

	function showWysiwyg() {
		markdown.hide();
		wysiwyg.show();
		previewLink.attr('data-disabled', 1);
		markdownLink.attr('data-disabled', 0);
	}

	(function () {
		new MediumEditor(wysiwyg, {
			extensions: {
				markdown: new MeMarkdown(function (md) {
						markdown.val(md);
						markdownText = md;
					}
				)
			},
			disablePlaceholders: true,
			firstHeader: 'h2',
			secondHeader: 'h3'
		});
	})();

	markdown.hide();

	previewLink.click(function () {
		if (previewLink.data('disabled') == '0') {

			if (markdown.val() !== markdownText) {
				$.ajax({
					url: '/admin/markdown/convert',
					type: 'get',
					data: {'md': markdown.val()},
					success: function (result) {
						wysiwyg.html(result);
						showWysiwyg();
						markdownText = markdown.val();
					}
				});
			} else {
				showWysiwyg();
			}
		}

	});

	markdownLink.click(function () {
		if (markdownLink.data('disabled') == '0') {
			wysiwyg.hide();
			markdown.show();
			markdownLink.attr('data-disabled', 1);
			previewLink.attr('data-disabled', 0);
		}
	});
}


