$(function() {
    $("#login").validate({
        onkeyup: false,
        rules: {
            'email': {
                required: true,
                email: true
            },
            'password': {
                required: true,
            },
        },
        messages: {
            'email': {
                required: 'The email field is required.',
            },
            'password': {
                required: 'The password field is required.',
            },
        },

        submitHandler: function(form) {
            form.submit();
        },
    });

    $("#reset_password_request").validate({
        onkeyup: false,
        rules: {
            'email': {
                required: true,
                email: true
            }
        },
        messages: {
            'email': {
                required: 'The email field is required.',
            }
        },

        submitHandler: function(form) {
            form.submit();
        },
    });

    // $("#reset_password").validate({
    //     onkeyup: false,
    //     rules: {
    //         'password': {
    //             required: true,
    //         },
    //         'password_confirmation': {
    //             equalTo: "#password"
    //         },
    //     },
    //     messages: {
    //         'password': {
    //             required: 'The password field is required.',
    //         },
    //         'password_confirmation': {
    //             equalTo: 'Please enter the same password as above.',
    //         },
    //     },

    //     submitHandler: function(form) {
    //         form.submit();
    //     },
    // });
});