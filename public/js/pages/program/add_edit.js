$(function() {
    commonScripts._mobileInputMaskWithoutCode('.mobile-input-mask');
    commonScripts._zipInputMask('.zip-input-mask');
    $("#programForm").validate({
        ignore: '',
        onkeyup: false,
        rules: {
            'program[name]': {
                required: true,
                remote: {
                    url: base_url + '/program/validate-email',
                    type: "POST",
                    data: {
                        email: function() {
                            return $("#program_name").val();
                        },
                        'id': function() {
                            return $('#program_id').val();
                        }
                    }
                }
            },
            'program[organization_id]': {
                required: true,
            },
            'program[date_added]': {
                required: true,
            },
        },
        messages: {
            'program[name]': {
                required: 'Please provide the program name.',
                remote:'Program already exist with this name.'
            },
            'program[organization_id]': {
                required: 'Please select the organization.',
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
                    //$(form)[0].reset();
                    const urlParams = new URLSearchParams(window.location.search);
                    const myParam = urlParams.get('org_id');

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
              var output = document.getElementById('programImage');
              $('.user_prof_pic span').contents().unwrap();
              $('#profPic').removeClass("forupload_csuser");
              $('#profPic p').hide();
              output.src = reader.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
});