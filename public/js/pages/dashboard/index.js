(function($) {
    var DashBoard = function() {
        $(document).ready(function() {
            dashboard._initialize();
        });
    };
    dashboard = DashBoard.prototype;

    dashboard._initialize = function() {
        dashboard._formValidation();
        dashboard._addEditWelcomecontent();
        dashboard._addEditAboutcontent();
    };
    dashboard._formValidation = function() {
        commonScripts._mobileInputMaskWithoutCode('.mobile-input-mask');
        $("#contactus").validate({
            onkeyup: false,
            rules: {
                'contactus[message]': {
                    required: true,
                },
            },
            messages: {
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
                commonScripts._unmaskInput('.mobile-input-mask');
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
                        commonScripts._mobileInputMaskWithoutCode('.mobile-input-mask');
                        $(form).find('[type="submit"]').prop('disabled', false);
                        commonScripts._showFormError(form, data.responseJSON.errors);
                    },
                }).done(function(data) {
                    $(".loader").fadeOut();
                    $(form).find('[type="submit"]').prop('disabled', false);
                    if (data.status == 'success') {
                        commonScripts._toastSuccess(data.response);
                        $(form)[0].reset();
                        
                    }
                });
                return false;
            },
        });
    }

    dashboard._welcomecontentFormValidation = function() {
        return {
            ignore: '',
            onkeyup: false,
            rules: {
                'sitecontent[reference_key]':{
                    required: true
                },
                'sitecontent[content]':{
                    required: true
                },
                'welcomeHeading[reference_key]':{
                    required: true
                },
                'welcomeHeading[content]':{
                    required: true
                }
            },
            messages: {
                'sitecontent[reference_key]':{
                    required: 'The reference key field is required.',
                },
                'sitecontent[content]':{
                    required: 'The content field is required.',
                },
                'welcomeHeading[reference_key]':{
                    required: 'The reference key field is required.',
                },
                'welcomeHeading[content]':{
                    required: 'The heading field is required.',
                }
            },
            errorPlacement: function(error, element) {
                error.insertAfter($(element));
            },
            submitHandler: function(form) {
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
                        $(form).find('[type="submit"]').prop('disabled', false);
                        commonScripts._showFormError(form, data.responseJSON.errors);
                    },
                }).done(function(data) {
                    $(".loader").fadeOut();
                    $(form).find('[type="submit"]').prop('disabled', false);
                    if (data.status == 'success') {
                        $('.welcome-content').html($('.welcome-info').val());
                        $('.welcome-heading-content').html($('.welcome-heading-info').val());
                        commonScripts._toastSuccess(data.response);
                        $('#welcomeContentModal').modal('hide');
                    }
                });
                return false;
            },
        }
    }
    dashboard._aboutContentFormValidation = function() {
        return {
            ignore: '',
            onkeyup: false,
            rules: {
                'sitecontent[reference_key]':{
                    required: true
                },
                'sitecontent[content]':{
                    required: true
                },
                'aboutUsHeading[reference_key]':{
                    required: true
                },
                'aboutUsHeading[content]':{
                    required: true
                }
            },
            messages: {
                'sitecontent[reference_key]':{
                    required: 'The reference key field is required.',
                },
                'sitecontent[content]':{
                    required: 'The content field is required.',
                },
                'aboutUsHeading[reference_key]':{
                    required: 'The reference key field is required.',
                },
                'aboutUsHeading[content]':{
                    required: 'The heading field is required.',
                }
            },
            errorPlacement: function(error, element) {
                error.insertAfter($(element));
            },
            submitHandler: function(form) {
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
                        $(form).find('[type="submit"]').prop('disabled', false);
                        commonScripts._showFormError(form, data.responseJSON.errors);
                    },
                }).done(function(data) {
                    $(".loader").fadeOut();
                    $(form).find('[type="submit"]').prop('disabled', false);
                    if (data.status == 'success') {
                        $('.aboutus-heading-content').html($('.about-heading-info').val());
                        $('.aboutus-image-content').html($('.about-image-info').val());
                        $('#mCSB_2_container').html($('.about-info').val());
                        commonScripts._toastSuccess(data.response);
                        $('#aboutContentModal').modal('hide');
                        window.location.reload();
                    }
                });
                return false;
            },
        }
    }

    dashboard._addEditWelcomecontent = function() {
        $(document).on("click", '.add-edit-welcomecontent', function(e) {
            e.preventDefault();
            commonScripts._handleAddEditModal($(this).attr('data-url'), '#welcomeContentForm', dashboard._welcomecontentFormValidation(), '#welcomeContentModal');
        });
    }

    dashboard._addEditAboutcontent = function() {
        $(document).on("click", '.add-edit-aboutcontent', function(e) {
            e.preventDefault();
            commonScripts._handleAddEditModal($(this).attr('data-url'), '#aboutContentForm', dashboard._aboutContentFormValidation(), '#aboutContentModal');
        });
    }
    window.DashBoard = new DashBoard();
})(jQuery);
  