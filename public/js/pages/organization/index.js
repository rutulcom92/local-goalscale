(function($) {
    var Organisations = function() {
        $(document).ready(function() {
            Organisation._initialize();
        });
    };
    var Organisation = Organisations.prototype;

    Organisation._initialize = function() {
        Organisation._listingView();
        //Organisation._edit();
    };

    Organisation._listingView = function() {
        organizationsDt = commonScripts._generateDataTable($('#organizationsDt'), [
            { data: 'name' },
            // { data: 'location' },
            { data: 'num_providers' },
            { data: 'num_users' },
            { data: 'programs' },
            { data: 'avg_goal_change' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };

    // Organisation._edit = function() {
    //     $('#organizationsDt tbody').on('click', 'tr', function () {
    //         var data = table.row( this ).id();
    //         var row = table.row(this);

    //         if (row.child.isShown()) {
    //         }
    //         else{
    //             window.location.href = data;
    //         }

    //     } );
    // }
    window.Organisations = new Organisations();
})(jQuery);


function showImportForm() {
    //alert(1111);
    $('.import-users-action').show();
    $('.import-file-box').show();
    $('#import_users_pop').modal('show');
    $('#csv_file_data').addClass('mt-5').html('')
}


$('body').on('click', '.import-users-action', function() {

    if ($('#userImportFile').get(0).files.length > 0) {

        $(".loader").show();

        var file_data = $('#userImportFile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        //alert(form_data);

        $.ajax({
            url: $('#userImportFile').data('import-users-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
        }).done(function(resp) {
            $(".loader").hide();
            if (resp.success != null && resp.success == true) {
                $('#csv_file_data').html(resp.html);
            } else if (resp.error != null) {
                var msg = '<div class="alert alert-danger" role="alert">' + resp.error + '</div>';
                $('#csv_file_data').html(msg);
            }
        });
        //$('#import_users_pop').modal('hide');
    } else {
       // alert("Please select a valid file.");
       // var error = '<label id="userImportFile-error" class="error" for="userImportFile">Please provide valid file.</label>';
        var msg = '<div class="alert alert-danger" role="alert">Please provide a valid file.</div>';
        $('#csv_file_data').html(msg);
    }
});

$(".import-users-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});


$('body').on('click', '.import-continue', function() {

    if ($('#userImportFile').get(0).files.length > 0) {

        $(".loader").show();

        var file_data = $('#userImportFile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        //alert(form_data);

        $.ajax({
            url: $(this).data('import-users-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
        }).done(function(resp) {
            $(".loader").hide();
            console.log(resp);
            var msg = '';

            if (typeof resp.success !== "undefined" && resp.success != "") {
                msg += '<div class="text-left alert alert-success" role="alert">' + resp.success + '</div>';
            }
            if (typeof resp.notice !== "undefined" && resp.notice != "") {
                msg += '<div class="text-left alert alert-warning" role="alert">' + resp.notice + '</div>';
            }
            if (typeof resp.error !== "undefined" && resp.error != "") {
                msg += '<div class="text-left alert alert-danger" role="alert">' + resp.error + '</div>';
            }
            if (typeof resp.errors !== "undefined" && resp.errors != "") {
                msg += '<div class="text-left alert alert-danger" role="alert">' + resp.errors + '</div>';
            }

            $('#csv_file_data').removeClass('mt-5').html(msg);
            $('.import-users-action').hide();
            $('.import-users-file-input').val('');
            $('.import-file-box').hide();
            $(".import-users-file-input").siblings(".custom-file-label").removeClass("selected").html('Choose a CSV or Excel file');
        });
        //$('#import_users_pop').modal('hide');
    } else {
        alert("Please select a valid file.");
        var error = '<label id="userImportFile-error" class="error" for="userImportFile">Please provide valid file.</label>';
    }
});