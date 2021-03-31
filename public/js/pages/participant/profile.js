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
                            return $('.participant_id').val();
                        }
                    }
                }
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
              
                if (element.hasClass('element_select')) {
                    error.insertAfter(element.next('span'));
                } 
                else if (element.hasClass('multi_select_element')) {
                    error.insertAfter(element.next('span'));
                } 

                else if(element.attr("name") == "userDetail[gender]") {
                    error.insertAfter('#gendor_error');
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
                    $(form)[0].reset();
                    var backUrl = $('#closed').attr('href');
                    setTimeout(function(){ 
                        window.location.href = backUrl;
                    }, 1000);
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
});