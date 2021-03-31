$(function() {
    commonScripts._mobileInputMaskWithoutCode('.mobile-input-mask');
    commonScripts._zipInputMask('.zip-input-mask');
    $("#organizationForm").validate({
        ignore: '',
        onkeyup: false,
        rules: {
            'organization[name]': {
                required: true,
                remote: {
                    url: base_url + '/organization/validate-email',
                    type: "POST",
                    data: {
                        email: function() {
                            return $("#orgName").val();
                        },
                        'id': function() {
                            return $('#organization_id').val();
                        }
                    }
                }
            },
            // 'organization[contact_email]': {
            //     required: true,
            //     email: true,
            //     remote: {
            //         url: base_url + '/organization/validate-email',
            //         type: "POST",
            //         data: {
            //             email: function() {
            //                 return $("#organization_email").val();
            //             },
            //             'id': function() {
            //                 return $('#organization_id').val();
            //             }
            //         }
            //     }
            // },
            // 'organization[contact_phone]': {
            //     required: true,
            // },
            // 'organization[address]': {
            //     required: true,
            // },
            // 'organization[city]': {
            //     required: true,
            // },
            // 'organization[state_id]': {
            //     required: true,
            // },
            // 'organization[zip]': {
            //     required: true,
            // },
            // 'organization[record_num]': {
            //     required: true,
            // },
            'organization[date_added]': {
                required: true,
            },
            'organization[program_label]': {
                required: true,
            },
            'organization[supervisor_label]': {
                required: true,
            },
            'organization[provider_label]': {
                required: true,
            },
            'organization[participant_label]': {
                required: true,
            },
            'organization_types[]': {
                required: true,
            }
        },
        messages: {
            'organization[name]': {
                required: 'Please provide the organization name.',
            },
            // 'organization[contact_email]': {
            //     required: 'Please provide the contact email.',
            // },
            // 'organization[contact_phone]': {
            //     required: 'Please provide the contact phone.',
            // },
            // 'organization[address]': {
            //     required: 'Please provide the address.',
            // },
            // 'organization[city]': {
            //     required: 'Please provide the city.',
            // },
            // 'organization[state_id]': {
            //     required: 'Please select the state.',
            // },
            // 'organization[zip]': {
            //     required: 'Please provide the zip code.',
            // },
            // 'organization[record_num]': {
            //     required: 'Please provide the record number.',
            // },
            'organization[date_added]': {
                required: 'Please provide the date added.',
            },
            'organization[program_label]': {
                required: 'Please provide the program label.',
            },
            'organization[supervisor_label]': {
                required: 'Please provide the supervisor label.',
            },
            'organization[provider_label]': {
                required: 'Please provide the provider label.',
            },
            'organization[participant_label]': {
                required: 'Please provide the participant label.',
            },
            'organization_types[]': {
                required: 'Please select an organization type.',
            }

        },
        errorPlacement: function(error, element) {

                if (element.hasClass('element_select')) {
                    error.insertAfter(element.next('span'));
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
                    commonScripts._zipInputMask('.zip-input-mask');
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
                    
                    var backUrl = data.redirect;
                    setTimeout(function(){ 
                        window.location.href = backUrl;
                    }, 500); 
                                     
                }
            });
            return false;
        },
    });

    $('#chooseFile').click(function(){
        $('#organization-logo').click();
    });
    $('#organization-logo').change(function(e){
        // console.log("asdad");
        e.preventDefault();
        var reader = new FileReader();
        reader.onload = function()
        {
          var output = document.getElementById('organization_image');
          $('.user_prof_pic span').contents().unwrap();
          $('#profPic').removeClass("forupload_csuser");
          $('#profPic p').hide();
          output.src = reader.result;
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    // $('#chooseFile').click(function(){
    //     $('#organization-logo').click();
    //     $('#organization-logo').change(function(e){
    //         var reader = new FileReader();
    //         reader.onload = function()
    //         {
    //           var output = document.getElementById('organization_image');
    //           $('.user_prof_pic span').contents().unwrap();
    //           $('#profPic').removeClass("forupload_csuser");
    //           $('#profPic p').hide();
    //          // output.src = reader.result;
    //           // var output = document.getElementById('organization-logo-image');
    //           // $('.upload_logo_UI a span').remove();
    //           // $('.upload_logo_UI a img').css("width",'99%');
    //           // $('.upload_logo_UI a img').css("height",'97%');
    //           // $('.upload_logo_UI a img').css("filter",'none');
    //           output.src = reader.result;
    //         }
    //         reader.readAsDataURL(e.target.files[0]);
    //     });
    // });
});