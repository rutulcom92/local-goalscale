(function($) {
    var goals = function() {
        $(document).ready(function() {
            goal._initialize();
        });
    };
    var goal = goals.prototype;

    goal._initialize = function() {
        goal._listingView();
        //goal._edit();
    };

    goal._listingView = function() {
        goalsDt = commonScripts._generateDataTable(
            $('#goalsDt'),
            [
                { data: 'name' },
                {
                    data: 'participant',
                    class: 'weth',
                },
                {
                    data: 'provider',
                    class: 'weth',
                },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'tags' },
                { data: 'goal_change' },
                { data: 'status' },
                { data: 'action' },
            ],
            [
                [0, "ASC"]
            ],
            '',
            'POST'
        );
    };

    // goal._edit = function() {
    //     $('#goalsDt tbody').on('click', 'tr', function () {
    //         var data = table.row( this ).id();
    //         var row = table.row(this);
    //         if (!$(event.target).is('.dt-view-all-tags'))
    //         {
    //             if (row.child.isShown()) {
    //             }
    //             else{
    //                 window.location.href = data;
    //             }
    //         }
    //     } );
    // }

    window.goals = new goals();

})(jQuery);

function showImportForm() {
    //alert(1111);
    $('.import-goal-action').show();
    $('.import-file-box').show();
    $('#import_goals_pop').modal('show');
    $('#csv_file_data').addClass('mt-5').html('')
}


$('body').on('click', '.import-goal-action', function() {

    if ($('#goalImportFile').get(0).files.length > 0) {

        $(".loader").show();

        var file_data = $('#goalImportFile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        //alert(form_data);

        $.ajax({
            url: $('#goalImportFile').data('import-goal-ajax-url'),
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
        //$('#import_goals_pop').modal('hide');
    } else {
       // alert("Please select a valid file.");
       // var error = '<label id="goalImportFile-error" class="error" for="goalImportFile">Please provide valid file.</label>';
        var msg = '<div class="alert alert-danger" role="alert">Please provide a valid file.</div>';
        $('#csv_file_data').html(msg);
    }
});

$(".import-goal-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});


$('body').on('click', '.import-continue', function() {

    if ($('#goalImportFile').get(0).files.length > 0) {

        $(".loader").show();

        var file_data = $('#goalImportFile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        //alert(form_data);

        $.ajax({
            url: $(this).data('import-goal-ajax-url'),
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
            $('.import-goal-action').hide();
            $('.import-goal-file-input').val('');
            $('.import-file-box').hide();
            $(".import-goal-file-input").siblings(".custom-file-label").removeClass("selected").html('Choose a CSV or Excel file');
        });
        //$('#import_goals_pop').modal('hide');
    } else {
        alert("Please select a valid file.");
        var error = '<label id="goalImportFile-error" class="error" for="goalImportFile">Please provide valid file.</label>';
    }
});
