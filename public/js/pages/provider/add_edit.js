$(function() {
    commonScripts._mobileInputMaskWithoutCode('.mobile-input-mask');
    commonScripts._zipInputMask('.zip-input-mask');
    $("#provider").validate({
        ignore: '',
        onkeyup: false,
        rules: {
            'users[first_name]': {
                required: true,
            },
            'users[last_name]': {
                required: true,
            },
            'userDetail[provider_type_id]': {
                required: true,
            },
            'users[organization_id]': {
                required: true,
            },
            'users[email]': {
                required: true,
                email: true,
                remote: {
                    url: base_url + '/provider/validate-email',
                    type: "POST",
                    data: {
                        email: function() {
                            return $("#providerEmail").val();
                        },
                        'id': function() {
                            return $('.provider_id').text();
                        }
                    }
                }
            },
            'users[phone]': {
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
            'userDetail[provider_type_id]': {
                required: true,  
            },
            'user_programs[program_id][]': {
                required: true,  
            },
            'provider_supervisor[supervisor_id][]': {
                required: true,  
            }
        },
        messages: {
            'users[first_name]': {
                required: 'Please provide the first name.',
            },
            'users[last_name]': {
                required: 'Please provide the last name.',
            },
            'users[organization_id]': {
                required: 'Please select the organization.',
            },
            'userDetail[provider_type_id]': {
                required: 'Please select the provider type.',
            },
            'users[email]': {
                required: 'Please provide the email id.',
                remote: "User already exists with this email.",
            },
            'users[phone]': {
                required: 'Please provide the phone number.',
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
            'userDetail[provider_type_id]': {
                required: 'Please select the provider type.',  
            },
            'user_programs[program_id][]': {
                required: 'Please select the programs.',  
            },
            'provider_supervisor[supervisor_id][]': {
                required: 'Please select the supervisor.',  
            }
        },
        errorPlacement: function(error, element) {
               
                if (element.hasClass('element_select')) {
                    error.insertAfter(element.next('span'));
                } 
                else if (element.hasClass('multi_select_element')) {
                    $(element).next().find('.select2-selection').css('border', '1px solid #af0000 !important');
                    error.insertAfter(element.next('span'));
                }
                // else if (element.hasClass('sel_supervisor')) {
                //     error.insertAfter($(element).next());                    
                // }
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
                    //$(form)[0].reset();
                    const urlParams = new URLSearchParams(window.location.search);
                    const myParam = urlParams.get('id');

                    if(myParam != null) {
                            setTimeout(function(){ 
                                window.location.href = $('#back_url').val();
                            }, 500); 
                    }else{
                        var backUrl = data.redirect;
                        setTimeout(function(){ 
                            window.location.href = backUrl;
                        }, 500); 
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
                  var output = document.getElementById('provider_image');
                    $('.user_prof_pic span').contents().unwrap();
                    $('#profPic').removeClass("forupload_csuser");
                    $('#profPic p').hide();
                  output.src = reader.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });

    const urlParams = new URLSearchParams(window.location.search);
    const myParam = urlParams.get('id');
    const myParam1 = urlParams.get('pid');
    if(myParam != null || myParam1 != null) {
        $('.provider_programs').prop('disabled', false);
        $('.sel_supervisor').prop('disabled', false);
        $('.provider_type').prop('disabled', false);
    }

    $('body').on('change', '.provider_organization', function() {
        

        if ($.trim($(this).val()) == '' && !$('.provider_id').text()) {
            $('.provider_programs').prop('disabled', true);
            $('.sel_supervisor').prop('disabled', true);
            $('.provider_type').prop('disabled', true);
        } else {
            
            $('.provider_programs').prop('disabled', false);
            $('.sel_supervisor').prop('disabled', false);
            $('.provider_type').prop('disabled', false);
        }

        if ($.trim($(this).val()) == '') {
            $('.sel_programs').html('');
            return false;
        }

         if ($.trim($(this).val()) == '') {
            $('.sel_providerType').html('');
            return false;
        }

       
        //     return false;
        // }

       // $(".loader").fadeIn();
        var org_id;
        if($('#org_id').val() != ''){
            org_id = $('#org_id').val();
        }else{
            org_id = '';
        }
        if($('.provider_organization').val() != 0){
        $(".loader").fadeIn();
            $.ajax({
                url: $('.provider_organization').data('get-provider-programs-ajax-url'),
                type: 'POST',
                dataType: 'JSON',
                data: {
                    organizationID: $('.provider_organization').val(),
                    providerID: $('.provider_id').text(),
                    orgID : org_id
                },
            }).done(function(data) {
                $(".loader").fadeOut();
                $('.sel_programs').html('');
                $('.sel_providerType').html('');
                
                if (data.status == 'success') {
                    $('.sel_programs').html(data.response);
                    $('.sel_providerType').html(data.response1);
                }
            });   
        }     
    });

    // $('body').on('change', '.provider_type', function() {
    //     const urlParams = new URLSearchParams(window.location.search);
    //     const myParam = urlParams.get('id');
    //     if ($.trim($(this).val()) == '' && !$('.provider_id').text()) {
    //         $('.provider_organization').prop('disabled', true);
    //     } else {
    //         if(myParam != null) {
    //             $('.provider_programs').prop('disabled', false);
    //             $('.sel_supervisor').prop('disabled', false);
    //         }
    //         $('.provider_organization').prop('disabled', false);

    //     }

    //     if ($.trim($(this).val()) == '') {
    //         $('.sel_organization').html('');
    //         return false;
    //     }

    //     $(".loader").fadeIn();
    //     var org_id;
    //     if($('#org_id').val() != ''){
    //         org_id = $('#org_id').val();
    //     }else{
    //         org_id = '';
    //     }

    //     $.ajax({
    //         url: $('.provider_type').data('get-provider-organizations-ajax-url'),
    //         type: 'POST',
    //         dataType: 'JSON',
    //         data: {
    //             providerTypeID: $('.provider_type').val(),
    //             providerID: $('.provider_id').text(),
    //             orgID : org_id
    //         },
    //     }).done(function(data) {
    //         $(".loader").fadeOut();
    //        $('.sel_organization').html('');
    //         if (data.status == 'success') {
    //             $('.sel_organization').html(data.response);
    //         }
    //     });        
    // });

    $('body').on('change', '.provider_programs', function() {

        // if ($.trim($(this).val()) == '' && !$('.provider_id').text()) {
        //     $('.sel_supervisor').prop('disabled', true);
        // } else {
        //     $('.sel_supervisor').prop('disabled', false);
        // }

        if ($.trim($(this).val()) == '') {
            $('.select-supervisors').html('');
            return false;
        }
        var pid;
        if($('#pid').val() != ''){
            pid = $('#pid').val();
        }else{
            pid = '';
        }

        $(".loader").fadeIn();
        $.ajax({
            url: $('.provider_programs').data('get-provider-supervisors-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                programID: $('.provider_programs').val(),
                orgID: $('.provider_organization').val(),
                providerID: $('.provider_id').text(),
                pid:pid
            },
        }).done(function(data) {
            $(".loader").fadeOut();
           $('.select-supervisors').html('');
            if (data.status == 'success') {
                console.log(data.response);
                $('.select-supervisors').html(data.response);
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