define(['jquery', 'elgg/Ajax'], function ($, Ajax) {

	$(document).on('click', '#change-text-preview-button', function () {
		var $change_text_form = $('.elgg-form-admin-tools-change-text');
		var ajax = new Ajax();
		
		ajax.view('admin_tools/change_text_preview', {
			data: {
				from: $change_text_form.find('input[name="from"]').val(),
				to: $change_text_form.find('input[name="to"]').val()
			}
		}).done(function(data) {
			$('#change-text-preview').html(data);
		});
	});
	
	$(document).on('change', '.elgg-form-admin-tools-change-text .elgg-input-text', function () {
		$('#change-text-preview').html('');
	});
});
