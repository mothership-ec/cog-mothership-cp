/* 
/*
/* Text Editor JavaScript 
/*
/* ------------------------------------------ */


/* Jquery to correspond with Medium Text Editor https://github.com/daviferreira/medium-editor */

function wysiwyg(id, value) {
	var markdown = $('#' + id),
		preview = $('#editable_' + id),
		previewLink = $('#preview_link_' + id),
		markdownLink = $('#markdown_link_' + id),
		markdownText = value,
		section = $('#section_' + id),
		previewBox = $('#preview-box_' + id),
		markdownBox = $('#markdown-box_' + id),
		menu = $('#menu_' + id);
		;

	function showWysiwyg() {
		markdown.hide();
		markdownBox.hide();
		preview.show();
		previewBox.show();
		previewLink.attr('data-disabled', 1);
		markdownLink.attr('data-disabled', 0);
	}

	(function () {
		new MediumEditor(preview, {
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
						preview.html(result);
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
			var height = section.innerHeight() - menu.outerHeight(),
				width = section.width();

			previewBox.height(section.innerHeight() - menu.outerHeight()).width(section.width());
			preview.outerHeight(previewBox.innerHeight()).width(previewBox.width());
			markdownBox.height(previewBox.height()).width(previewBox.width());
			markdown.outerHeight(markdownBox.innerHeight()).width(width);
			section.innerHeight(height + menu.outerHeight()).width(width);

			preview.hide();
			previewBox.hide();
			markdown.show();
			markdownBox.show();
			markdownLink.attr('data-disabled', 1);
			previewLink.attr('data-disabled', 0);
		}
	});

	section.resizable({
		resize: function(event, ui) {
			var height = section.innerHeight() - menu.outerHeight(),
				width = section.width();

			previewBox.height(section.innerHeight() - menu.outerHeight()).width(section.width());
			preview.outerHeight(previewBox.innerHeight()).width(previewBox.width());
			markdownBox.height(previewBox.height()).width(previewBox.width());
			markdown.outerHeight(markdownBox.innerHeight()).width(width);
			section.innerHeight(height + menu.outerHeight()).width(width);
		}
	});

}