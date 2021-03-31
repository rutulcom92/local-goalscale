(function($) {
    var Landing = function() {
        $(document).ready(function() {
            landing._initialize();
        });
    };
    landing = Landing.prototype;

    landing._initialize = function() {
        landing._formValidation();
    };

    landing._formValidation = function() {
        landing._mobileInputMaskWithoutCode('.mobile-input-mask');
        $("#contactus").validate({
            onkeyup: false,
            rules: {
                'contactus[name]': {
                    required: true,
                },
                'contactus[email]': {
                    required: true,
                },
                'contactus[phone]': {
                    required: true,
                },
                'contactus[message]': {
                    required: true,
                },
            },
            messages: {
                'contactus[name]': {
                    required: 'The name field is required.',
                },
                'contactus[email]': {
                    required: 'The email field is required.',
                },
                'contactus[phone]': {
                    required: 'The phone number field is required.',
                },
                'contactus[message]': {
                    required: 'The message field is required.',
                },
            },
            errorPlacement: function(error, element) {
                    $('.tab-pane.active').removeClass('active show');
                    element.closest('.tab-pane').addClass('active show');
                    if (element.hasClass('element_select')) {
                        error.insertAfter(element.next('span'));
                    }
                    else if(element.attr("name") == "userDetail[gender]") {
                        error.insertAfter('#gendor_error');
                    }

                    else if(element.attr("name") == "dealer_photo") {
                        error.insertAfter($(element).parent());
                    }
                    else if(element.hasClass('file-upload')==true){
                        error.insertAfter($(element).parents('.client_image_section'));
                    }

                    else{
                        error.insertAfter($(element));
                    }

                },
            submitHandler: function(form) {
                landing._unmaskInput('.mobile-input-mask');
                var form = $(form)[0];
                var formData = new FormData(form)
                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    dataType: 'JSON',
                    cache: false,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function() {
                        $(form).find('[type="submit"]').prop('disabled', true);
                        $(".loader").fadeIn();
                    },
                    error: function(data) {
                        $(".loader").fadeOut();
                        landing._mobileInputMaskWithoutCode('.mobile-input-mask');
                        $(form).find('[type="submit"]').prop('disabled', false);
                        landing._showFormError(form, data.responseJSON.errors);
                    },
                }).done(function(data) {
                    $(".loader").fadeOut();
                    $(form).find('[type="submit"]').prop('disabled', false);
                    if (data.status == 'success') {
                        landing._toastSuccess(data.response);
                        $(form)[0].reset();

                    }
                });
                return false;
            },
        });
    }

    landing._mobileInputMaskWithoutCode = function(elem) {

		if ($(elem).length > 0) {

			$(elem).inputmask("(999) 999-9999", {
				// "clearIncomplete": true,
				"removeMaskOnSubmit": true
			});
		}
    };

    landing._unmaskInput = function(elem) {

		if ($(elem).length > 0) {
			$(elem).inputmask('remove');
		}
	};

	landing._toastSuccess = function(msg) {

		iziToast.success({
			backgroundColor: '#34920d',
			messageColor: '#fff',
			titleColor: '#fff',
			icon: 'fa fa-check',
			iconColor: '#fff',
			transitionIn: 'bounceInRight',
			title: 'Success!',
			message: "" + msg
		});
	};

	landing._toastError = function(msg) {

		iziToast.error({
			backgroundColor: '#BC5459',
			messageColor: '#fff',
			titleColor: '#fff',
			icon: 'fa fa-ban',
			iconColor: '#fff',
			transitionIn: 'bounceInRight',
			title: 'Error!',
			message: "" + msg
		});
	};

    window.Landing = new Landing();

})(jQuery);

function showContactForm() {
    //alert(1111);
    $('#contact_popup').modal('show');
}
