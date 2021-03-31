$(function() {
    commonScripts._mobileInputMaskWithoutCode('.mobile-input-mask');
    commonScripts._zipInputMask('.zip-input-mask');
    $("#participant").validate({
        ignore: '',
        onkeyup: false,
        rules: {
            'users[first_name]': {
                required: true,
            },
            'users[last_name]': {
                required: true,
            },
            'users[email]': {
                required: true,
                email: true,
                remote: {
                    url: base_url + '/participant/validate-email',
                    type: "POST",
                    data: {
                        email: function() {
                            return $("#participantEmail").val();
                        },
                        'id': function() {
                            return $('.participant_id').text();
                        }
                    }
                }
            },
            'users[organization_id]': {
                required: true,
            },
            'user_programs[program_id][]': {
                required: true,
            },
            'participant_provider[provider_id][]': {
                required: true,
            },
            'users[phone]': {
                required: true,
            },
            'userDetail[dob]': {
                required: true,
            },
            'users[address]': {
                required: true,
            },
            'users[city]': {
                required: true,
            },
            'users[state_id]': {
                required: true,
            },
            'users[zip]': {
                required: true,
            },
            'users[record_num]': {
                required: true,
            },
            'userDetail[gender]': {
                required: true,
            },
        },
        messages: {
            'users[first_name]': {
                required: 'Please provide the first name.',
            },
            'users[last_name]': {
                required: 'Please provide the last name.',
            },
            'users[email]': {
                required: 'Please provide the email id.',
                remote: "User already exists with this email.",
            },
            'users[organization_id]': {
                required: "Please select the organization.",
            },
            'user_programs[program_id][]': {
                required: 'Please select the programs.',
            },
            'participant_provider[provider_id][]': {
                required: 'Please select the provider.',
            },
            'users[phone]': {
                required: 'Please provide the phone number.',
            },
            'userDetail[dob]': {
                required: 'Please provide the date of birth.',
            },
            'users[address]': {
                required: 'Please provide the address.',
            },
            'users[city]': {
                required: 'Please provide the city.',
            },
            'users[state_id]': {
                required: 'Please select the state.',
            },
            'users[zip]': {
                required: 'Please provide the zip code.',
            },
            'users[record_num]': {
                required: 'Please provide the record number.',
            },
            'userDetail[gender]': {
                required: 'Please provide the gender.',
            },
        },
        errorPlacement: function(error, element) {
            $('.tab-pane.active').removeClass('active show');
            element.closest('.tab-pane').addClass('active show');
            if(element.attr("name") == "participant_provider[provider_id][]") {
                element.closest('.tab-pane').addClass('active show');
                $('#nav-profile-tab').addClass('active');
                $('#nav-notes-tab').removeClass('active');
            }
            if (element.hasClass('select2-element')) {
                error.insertAfter(element.next('span'));
            }
            else if (element.hasClass('multi_select_element')) {
                $(element).next().find('.select2-selection').css('border', '1px solid #af0000 !important');
                error.insertAfter(element.next('span'));
            }
            // else if (element.hasClass('sel_providers')) {
            //     console.log(121222);
            //     console.log($(element).next().find('.select2-selection').attr('role'));
            //     error.insertAfter($(element).next());                    
            // }
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
            $(".loader").fadeIn();
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
                    commonScripts._toastSuccess(data.response);
                    //$(form)[0].reset();

                    const urlParams = new URLSearchParams(window.location.search);
                    const myParam = urlParams.get('id');

                    if(myParam != null) {
                            setTimeout(function(){
                                window.location.href = $('#back_url').val();
                            }, 1000);
                    }else{
                        var backUrl = data.redirect;
                        setTimeout(function(){
                            window.location.href = backUrl;
                        }, 1000);
                    }

                }
            });
            return false;
        },
    });
    $('#chooseFile').click(function(){
            $('.profilePic').click();

            $('.profilePic').change(function(e){
                var reader = new FileReader();
                reader.onload = function()
                {
                  var output = document.getElementById('participant_image');
                  $('.user_prof_pic span').contents().unwrap();
                  $('#profPic').removeClass("forupload_csuser");
                  $('#profPic p').hide();
                  output.src = reader.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });

    $('body').on('change', '.participant_organization', function() {
        if($('.participant_organization').val() != 0){
            $(".loader").fadeIn();
            $.ajax({
                url: $('.participant_organization').data('get-participant-programs-ajax-url'),
                type: 'POST',
                dataType: 'JSON',
                data: {
                    organizationID: $('.participant_organization').val(),
                    participantID: $('.participant_id').text()
                },
            }).done(function(data) {
                $(".loader").fadeOut();
                $('.sel_programs').html('');
                if (data.status == 'success') {
                    $('.sel_programs').html(data.response);
                }
            });
        }
    });

    $('body').on('change', '.participant_programs', function() {

        $(".loader").fadeIn();
        $.ajax({
            url: $('.participant_programs').data('get-participant-providers-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                programID: $('.participant_programs').val(),
                participantID: $('.participant_id').text()
            },
        }).done(function(data) {
            $(".loader").fadeOut();
            $('.select-providers').html('');
            if (data.status == 'success') {
                $('.select-providers').html(data.response);
                setTimeout(function(){
                    commonScripts._loadSelect2Immediately();
                },500);
            }
        });
         $(".loader").fadeOut();
    });
});

$.validator.prototype.checkForm = function() {
    //overriden in a specific page
    this.prepareForm();
    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
        if (this.findByName(elements[i].name).length !== undefined && this.findByName(elements[i].name).length > 1) {
            for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                this.check(this.findByName(elements[i].name)[cnt]);
            }
        } else {
            this.check(elements[i]);
        }
    }
    return this.valid();
};
