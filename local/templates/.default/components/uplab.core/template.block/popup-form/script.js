$(function() {
	$(document).on("submit", '#callback-form, #callback-form-invite, #callback-form-accept, #ipoteka-form, #booking-form', function(e) {
		var form = $(this).find('form');
		var formData = new FormData(form.get(0));
		$.ajax({
			processData: false,
			contentType: false,
			type: "POST",
            url: '/local/ajax/forms.php',
			data: formData,
			success: function(result) {
                var response = JSON.parse(result);
				// console.log(response);
				if (response.status == 'ok') {
					setTimeout(() => {
						$('.is-close').click();
					}, 200);
					$(form).find('input').val('');
					$(form).find('input[type="checkbox"]').prop('checked', false);
					BX.UI.Notification.Center.notify({
						content: "Ваше обращение принято",
						position: "top-center",
						autoHideDelay: 1500,
						closeButton: false,
						content: BX.create("div", {
							style: {
								fontSize: "18px",
								textAlign: "center",
								width: "100%",
								transform: "translateX(19px)"
							},
							html: "Ваше обращение принято"
						})
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {z
                // console.log(textStatus);
			}
		});
		
		e.preventDefault();
		return false;
	});
});
