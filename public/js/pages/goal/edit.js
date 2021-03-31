// $(function () {
        
//     // Initializes and creates emoji set from sprite sheet
//     window.emojiPicker = new EmojiPicker({
//         emojiable_selector: '[data-emojiable=true]',
//         assetsPath: 'public/emoji-icons-lib/img/',
//         popupButtonClasses: 'icon-smile'
//     });

//     window.emojiPicker.discover();
// });

(function($) {
    var goalFormData = new FormData();
    var activityReplayFormData = new FormData();

    var selectedAttachmentsArray = [];
    var attachmentsCount = 0;
    var selectedReplayAttachmentsArray = [];
    var replayAttachmentsCount = 0;
    var appendId;

    var GoalActivityReplay = function() {
        $(document).ready(function() {
            goalActivityReplay._initialize();
        });
    };
    goalActivityReplay = GoalActivityReplay.prototype;

    goalActivityReplay._initialize = function() {
        goalActivityReplay._formValidation();
        goalActivityReplay._registerMethods();
        goalActivityReplay._activityReplay();
        goalActivityReplay._closeGoal();
    };

    goalActivityReplay._closeGoal = function(){
        $(document).on("click", '.close_goal', function(e) {
            e.preventDefault();
            url_ = $(this).data('get-goal-close-url');
            Swal.fire({
                title: '',
                text: 'Discontinuing this goal will stop all activity on this goal for this participant. Are you sure you want to discontinue this goal?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4EB952',//3085d6
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url_,
                        type: 'POST',
                        dataType: 'JSON',
                        data: {},
                    }).done(function(data) {
                        if (data.status == 'success') {
                            commonScripts._toastSuccess(data.response);
                        } else {
                            commonScripts._toastError(data.response);
                        }                        
                    });
                }
            });
        });
    }

    goalActivityReplay._registerMethods = function(){
        goalActivityReplay._loadActivities();
        goalActivityReplay._loadGraphData();
        
          $("#goalActivityForm").validate({
            ignore: '',
            rules: {
                'goal[activity_ranking]': {
                    required: true,
                    number: true,
                },
                'goal[update_text]': {
                    required: true,
                    maxlength: 10000,
                },
            },
            messages: {
                'goal[activity_ranking]': {
                    required: 'Please select activity ranking.',
                },
                'goal[update_text]': {
                    required: 'Please provide update text.',
                },
            },
            errorPlacement: function(error, element) {

                if(element.attr("name") == "goal[activity_ranking]") {
                    error.insertAfter($('#goal-progress'));
                }
                else {
                    error.insertAfter($(element));
                }
            },
            submitHandler: function(form) {
                $(".loader").fadeIn();

                var formInfo = $(form).serializeArray();

                for (var i = 0; i < formInfo.length; i++)
                    goalFormData.append(formInfo[i].name, formInfo[i].value);
                
                var j = 0;
                for (var i = 1; i < selectedAttachmentsArray.length; i++){
                    if(selectedAttachmentsArray[i])
                    {
                        goalFormData.append('activity_files['+j+']',selectedAttachmentsArray[i]);
                        j++;
                    }
                }

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    dataType: 'JSON',
                    cache: false,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData: false,
                    data: goalFormData,
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
                        $('#goal-progress span').removeClass('active');
                        $('.dynamic-comments').html('');
                        $('.last_activity_id').val(data.last_id);
                        var selectedAttachmentsArray = [];
                        var attachmentsCount = 0;
                        $('.textarea_activity_input').text('');
                        $('.activity-attchments-display').html('');
                        setTimeout(function(){
                            goalActivityReplay._loadActivities();
                            goalActivityReplay._loadGraphData();
                        },500);
                    }
                });
                return false;
            },
        });

        $('body').on('click', '.activity-attchment', function() {
            $('.attachments').click();
        });

        $('.textarea_activity_input').keyup(function(e) {
            var areaText = $(".textarea_activity_input").text();
          // console.log(areaText.length);
            if (areaText.length >= 191) {
                    e.preventDefault();
                    Swal.fire({
                    title: '',
                    text: "You've exceeded the character limit.  Please shorten your message.",
                    type: 'warning',
                   // showCancelButton: true,
                   // confirmButtonColor: '#4EB952',//3085d6
                   // cancelButtonColor: '#d33',
                   //confirmButtonText: 'Yes',
                });
                return false;
            }
        });

        $('body').on('change','.attachments',function(){

            var ele = document.getElementById($(this).attr('id'));
            var result = ele.files;
            
            for (var i = 0; i < result.length; ++i) {
                attachmentsCount++;
                var name = result[i].name;
                selectedAttachmentsArray[attachmentsCount] = result[i];
                attachmentsHtml = '<li><a href="javascript:void(0);">' + 
                name + '</a> <img class="mrg-left remove-attachment" data-count-id="' +
                attachmentsCount + '" src="'+$('.remove-file-icon').val()+'"></li>';
                $('.activity-attchments-display').append(attachmentsHtml);
            }
        });

        $(document).on("click", '.remove-attachment', function(e) {
            e.preventDefault();
            delete selectedAttachmentsArray[$(this).data('count-id')];
            attachmentsCount--;
            $(this).closest('li').remove();
        });

        $('body').on('click', '.activity-replay-attchment', function() {
            $('.replay-attachments').click();
        });

        $('body').on('change','.replay-attachments',function(){
            var ele = document.getElementById($(this).attr('id'));
            var result = ele.files;
            
            for (var i = 0; i < result.length; ++i) {
                replayAttachmentsCount++;
                var name = result[i].name;
                selectedReplayAttachmentsArray[replayAttachmentsCount] = result[i];
                attachmentsHtml = '<li><a href="javascript:void(0);">' + 
                name + '</a> <img class="mrg-left remove-replay-attachment" data-count-id="' +
                replayAttachmentsCount + '" src="'+$('.remove-file-icon').val()+'"></li>';
                $('.activity-replay-attchments-display').append(attachmentsHtml);
            }
        });

        $(document).on("click", '.remove-replay-attachment', function(e) {
            e.preventDefault();
            delete selectedReplayAttachmentsArray[$(this).data('count-id')];
            replayAttachmentsCount--;
            $(this).closest('li').remove();
        });

        $('body').on('click', '.load-activities', function() {
            goalActivityReplay._loadActivities();
        });

         $('body').on('click', '#export-to-pdf', function() {
            var graph = $('#goalprogress').wrap().html();
            //$('#goalprogress').unwrap();
            $('#goalGraph').val(graph);
            //console.log(graph);
            $("#goalExportForm").submit();
        });

        $('body').on('click', '#goal-progress span', function() {
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $('.activity_ranking').val('');
            }
            else{
                $('#goal-progress span').removeClass('active');
                $(this).addClass('active');
                $('.activity_ranking').val($(this).attr('id'));
            }   
        });
    }

    goalActivityReplay._loadActivities = function(){
        $(".loader").fadeIn();
        $.ajax({
            url: $('.load-activities').data('get-goal-activities-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                goalID: $('.goal_id').val(),
                lastActivityID: $('.last_activity_id').val()
            },
        }).done(function(data) {
            $(".loader").fadeOut();
            if (data.status == 'success') {
                $('.dynamic-comments').append(data.response);
                if(data.last_id == null){
                    $('.load-activities').hide();
                }
                $('.last_activity_id').val(data.last_id);
            }
        }); 
         $(".loader").fadeOut();  
    }

    goalActivityReplay._loadGraphData =function(){
        $.ajax({
            url: $('.load-graph').data('get-goal-graph-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                goalID: $('.goal_id').val()
            },
        }).done(function(data) {
            $(".loader").fadeOut();
            if (data.status == 'success') {
                goalActivityReplay._CreateChart(data.categories, data.graphData);
            }
        });
    }

    goalActivityReplay._CreateChart = function(categoryData, graphData){

        Highcharts.chart('goalprogress', {
            chart: {
                type: 'areaspline'
            },
            title: {
                text: ''
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                floating: true,
                borderWidth: 1,
            },
            xAxis: {
                categories: categoryData
            },
            yAxis: { 
                min:0,
                max:4,
                align:'top',
                verticalAlign:'top',
                title: {
                    text: ''
                }
            },
            tooltip: {
                useHTML: true,
                className:'hc-tooltip',
                backgroundColor:'#FFFFFF',
                borderWidth: 1,
                borderColor: '#C0C0C0',
                borderRadius: 6,
                formatter: function () {
                    if (this.point.toolInfo != '') {
                        return this.point.toolInfo;
                    }
                    else return false;
                }
            },
            credits: {
                enabled: true
            },
            plotOptions: {
                areaspline: {
                    marker: {
                        radius: 6,
                        symbol : 'circle'
                    },
                },
                series: {
                    pointPlacement: 'on'
                },
            },
            series: [
                {
                showInLegend: false,      
                lineWidth: 3,
                fillColor: {
                    linearGradient: [0, 0, 0, 300],
                    stops: [
                        [0, '#2C82BE'],
                        [1, '#FFFFFF']
                    ]
                },
                data: graphData
            }],
            exporting: {
                enabled: true
              }
        });
    }

    goalActivityReplay._formValidation = function() {
        return {
            ignore: '',
            onkeyup: false,
            rules: {
                'update_text': {
                    required: true,
                    maxlength: 10000
                },
            },
            messages: {
                'update_text': {
                    required: 'Please provide replay text'
                },
            },
            errorPlacement: function(error, element) {
                error.insertAfter($(element).next());
            },
            submitHandler: function(form) {
                var formInfo = $(form).serializeArray();

                for (var i = 0; i < formInfo.length; i++)
                    activityReplayFormData.append(formInfo[i].name, formInfo[i].value);
                
                var j = 0;
                for (var i = 1; i < selectedReplayAttachmentsArray.length; i++){
                    if(selectedReplayAttachmentsArray[i])
                    {
                        activityReplayFormData.append('activity_files['+j+']',selectedReplayAttachmentsArray[i]);
                        j++;
                    }
                }

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    dataType: 'JSON',
                    cache: false,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    processData: false,
                    data: activityReplayFormData,
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
                        $('#goalActivityReplayModal').modal('hide');
                        $(form)[0].reset();
                        $('.dynamic-comments').html('');
                        $('.last_activity_id').val(data.last_id);
                        selectedReplayAttachmentsArray = [];
                        replayAttachmentsCount = 0;
                        activityReplayFormData = new FormData();
                        setTimeout(function(){
                            goalActivityReplay._loadActivities();
                        },500);
                    }
                });
                return false;
            },
        }
    }

    goalActivityReplay._activityReplay = function() {
        // $(document).on("click", '.activity-replay', function(e) {
        //     $(".loader").fadeIn();
        //     $('.activity-replay-'+appendId+' .activity-replay-form').html('');
        //     appendId = $(this).data('id');
        //     $.ajax({
        //         url: $(this).data('get-goal-activity-replay-ajax-url'),
        //         type: 'POST',
        //         dataType: 'JSON',
        //         data: {
        //             goalID: $('.goal_id').val()
        //         },
        //     }).done(function(data) {
        //         $(".loader").fadeOut();
        //         if (data.status == 'success') {
        //             $('.activity-replay-'+appendId).append(data.response);
        //         }
        //     }); 
        //      $(".loader").fadeOut();  
        // });
        $('body').on('click','.open-replay-emoji',function(){
            $('#replay-activity .emoji-menu').toggle('show');
        })
        $(document).on("click", '.activity-replay', function(e) {
            // alert($(this).attr('get-goal-activity-replay-ajax-url'));
            e.preventDefault();
            commonScripts._handleAddEditModal($(this).data('get-goal-activity-replay-ajax-url'), '#goalActivityReplayForm', goalActivityReplay._formValidation(), '#goalActivityReplayModal');
            window.emojiPicker.discover();              
        });
    }
    window.GoalActivityReplay = new GoalActivityReplay();
})(jQuery);
  