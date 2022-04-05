$(function() {
	$(document).on("submit", '[data-action="submitFormResume"]', function(e) {
		
		var $form = $(this);

		var formData = new FormData($form.get(0));

		var name_file = $('#id-file').attr("name");
		$.each($('#id-file')[0].files, function(i, file) {
			var fileName = $(this).attr('name');
			formData.append(name_file, file, fileName);
		});
				
		$.ajax({
			processData: false,
			contentType: false,
			type: "POST",
			url: $form.attr("action"),
			data: formData,
			success: function(result) {
	            $("#show_modal_succes_resume").trigger("click");
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$("#show_modal_succes_resume").trigger("click");
			}
		});
		
		e.preventDefault();
		return false;
	});
});
