BX.ready(function () {
    /*BX.bindDelegate(document, 'click', {attribute: {'data-action': 'getCode'}}, function (ev) {
        ev.preventDefault();

        var form = BX.findParent(this, { tag: 'form' });
        var input = BX.findChild(form, {
            attribute: {
                name: 'captcha_sid'
            }
        }, true);
        var image = BX.findChild(form, {tag: 'img'}, true);

        // const responseContainer = BX('response');

        BX.ajax.runAction('mmk:local.api.captcha.getCode', {})
            .then(function (response) {

                BX.adjust(input, {
                    attrs: {
                        'value': response.data.code
                    }
                });

                BX.adjust(image, {
                    attrs: {
                        'src': '/bitrix/tools/captcha.php?captcha_sid=' + response.data.code
                    }
                });

            })
            .catch(function (response) {
                // console.log('catch: ', response);
            });
    });*/
    

    BX.bindDelegate(document, 'submit', {attribute: {'data-action': 'submitForm'}}, function (ev) {
        ev.preventDefault();
		var form = $(this);
        // var container = BX.findChild(document, {
        //     attribute: {'data-container': 'form-feedback'}
        // }, true);

        BX.ajax.post(
            this.getAttribute('action'),
            $(this).serialize(),
            function (response) {
	            $("#show_modal_succes_question").trigger("click");
	            /*var selector = form.closest(".modal").attr("id");
                var jsonResponse = JSON.parse(response);
				$("#"+selector+"-content").html($(jsonResponse.html).find("#"+selector+"-content").html());
				window.dispatchEvent(new CustomEvent('reinit'));	
				window.dispatchEvent(new CustomEvent('modal.init'));	
				window.dispatchEvent(new CustomEvent('init.validate'));	
				window.dispatchEvent(new CustomEvent('init.mask'));	
				
				$(document).on("click", ".modal-close", function() {
					$(".modal-form__success").remove();					
				})*/
            }
        );

    });

});
