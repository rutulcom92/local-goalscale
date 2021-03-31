$(function() {

    $("#goalForm").validate({
        ignore: '',
        rules: {
            'goal[name]': {
                required: true,
                maxlength: 255,
            },
            'goal[provider_id]': {
                required: true,
                maxlength: 20,
                number: true,
            },
            'goal[participant_id]': {
                required: true,
                maxlength: 20,
                number: true,
            },
        },
        messages: {
            'goal[name]': {
                required: 'Please provide goal name.',
            },
            'goal[provider_id]': {
                required: 'Please select provider.',
            },
            'goal[participant_id]': {
                required: 'Please select participant.',
            },
        },
        errorPlacement: function(error, element) {

            if (element.hasClass('goal-scale-description') && !element.closest('.for_scaling_box_listing').hasClass('goal_scale_error_adjust')) {
                element.closest('.for_scaling_box_listing').addClass('goal_scale_error_adjust');
                error.insertAfter($(element));
            }
            else if(element.hasClass('element_select')) {
                error.insertAfter(element.next('span'));
            }
            else {
                error.insertAfter($(element));
            }
        },
        submitHandler: function(form) {
            $(form).find('[type="submit"]').prop('disabled', true);
            $(form).find('[type="submit"]').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing...')
            form.submit();
            return false;
        },
    });

    $('.goal-scale-description').each(function( index ) {
        $(this).rules('add', {
            required: true,
            maxlength: 10000,
            messages: {
                required: "Please provide description.",
            },
        });
    });

    $('body').on('change', '.goal-provider', function() {

        $('.goal-participant').html('<option value="">Select Participant</option>');

        var provider_id = $(this).val();

        if (provider_id) {

            $(".loader").show();

            $.ajax({
                url: $('.goal-participant').data('participants-ajax-url'),
                type: 'POST',
                dataType: 'JSON',
                data: {
                    provider_id: provider_id
                },
            }).done(function(data) {

                $(".loader").hide();

                if (data.status == 'success') {
                    $.each(data.participants,function(key, value) {
                        $(".goal-participant").append('<option value="' + value.id + '">' + value.first_name + ' ' +value.last_name + '</option>');
                    });
                }
            });
        }
        $('.goal-participant').trigger('change');
    });
    
    // Presenting Challenges
    var markPresentingChallenges = function() {

        // Read the keyword
        var keyword = $(".presenting-challenges-search").val();

        // Determine selected options
        var options = {
            "each": function(element) {
                setTimeout(function() {
                    $(element).addClass("animate");
                }, 50);
            }
        };

        options['className'] = 'highlight-search-term';

        $(".presenting-challenges-checkbox-container").unmark({
            done: function() {
                $(".presenting-challenges-checkbox-container").mark(keyword, options);
            }
        });
    };

    $('body').on('click', '.save-presenting-challenges', function() {

        $('.selected-presenting-challenges').html('');

        $('.presenting-challenges-checkbox:checked').each(function( index ) {
            $('.selected-presenting-challenges').append('<li class="presenting-challenge-li"><span>' + $(this).closest('.presenting-challenges-checkbox-container').find('.custom-control-description').text() + '</span><a href="javascript:void(0);" class="remove-presenting-challenge-from-selection" data-tag-id="' + $(this).val() + '"><i class="far fa-times"></i></a></li>');
        });

        $('#presentingChallengesModal').modal('hide');
    });

    $('body').on('click', '.remove-presenting-challenge-from-selection', function() {
        $('.presenting-challenges-checkbox[value="' + $(this).data('tag-id') + '"]').prop('checked', false);
        $(this).closest('.presenting-challenge-li').remove();
    });

    $('body').on('keyup', '.presenting-challenges-search', function() {
        
        $(".presenting-challenges-checkbox-container").unmark();

        if($(this).val()) {

            $('.presenting-challenges-checkbox-container').each(function( index ) {
            
                if ($(this).find('.custom-control-description').text().toLowerCase().indexOf($('.presenting-challenges-search').val().toLowerCase()) != -1) {
                    $(this).closest('.collapse').collapse("show");
                    $(this).closest('.acc_inner_col').show();
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('.presenting-challenges-primary-container .acc_inner_col').each(function( index ) {
            
                if ($(this).find('.presenting-challenges-checkbox-container:visible').length > 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

        } else {
            $('.presenting-challenges-checkbox-container').each(function( index ) {
                $(this).closest('.acc_inner_col').show();
                $(this).show();
            });
        }
        markPresentingChallenges();
    });

    // Goal Topics
    var markGoalTopics = function() {

        // Read the keyword
        var keyword = $(".goal-topics-search").val();

        // Determine selected options
        var options = {
            "each": function(element) {
                setTimeout(function() {
                    $(element).addClass("animate");
                }, 50);
            }
        };

        options['className'] = 'highlight-search-term';

        $(".goal-topics-checkbox-container").unmark({
            done: function() {
                $(".goal-topics-checkbox-container").mark(keyword, options);
            }
        });
    };

    $('body').on('click', '.save-goal-topics', function() {

        $('.selected-goal-topics').html('');

        $('.goal-topics-checkbox:checked').each(function( index ) {
            $('.selected-goal-topics').append('<li class="goal-topic-li"><span>' + $(this).closest('.goal-topics-checkbox-container').find('.custom-control-description').text() + '</span><a href="javascript:void(0);" class="remove-goal-topic-from-selection" data-tag-id="' + $(this).val() + '"><i class="far fa-times"></i></a></li>');
        });

        $('#goalTopicsModal').modal('hide');
    });

    $('body').on('click', '.remove-goal-topic-from-selection', function() {
        $('.goal-topics-checkbox[value="' + $(this).data('tag-id') + '"]').prop('checked', false);
        $(this).closest('.goal-topic-li').remove();
    });

    $('body').on('keyup', '.goal-topics-search', function() {
        
        $(".goal-topics-checkbox-container").unmark();

        if($(this).val()) {

            $('.goal-topics-checkbox-container').each(function( index ) {
            
                if ($(this).find('.custom-control-description').text().toLowerCase().indexOf($('.goal-topics-search').val().toLowerCase()) != -1) {
                    $(this).closest('.collapse').collapse("show");
                    $(this).closest('.acc_inner_col').show();
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('.goal-topics-primary-container .acc_inner_col').each(function( index ) {
            
                if ($(this).find('.goal-topics-checkbox-container:visible').length > 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

        } else {
            $('.goal-topics-checkbox-container').each(function( index ) {
                $(this).closest('.acc_inner_col').show();
                $(this).show();
            });
        }
        markGoalTopics();
    });

    // Specialized Interventions
    var markSpecializedInterventions = function() {

        // Read the keyword
        var keyword = $(".specialized-interventions-search").val();

        // Determine selected options
        var options = {
            "each": function(element) {
                setTimeout(function() {
                    $(element).addClass("animate");
                }, 50);
            }
        };

        options['className'] = 'highlight-search-term';

        $(".specialized-interventions-checkbox-container").unmark({
            done: function() {
                $(".specialized-interventions-checkbox-container").mark(keyword, options);
            }
        });
    };

    $('body').on('click', '.save-specialized-interventions', function() {

        $('.selected-specialized-interventions').html('');

        $('.specialized-interventions-checkbox:checked').each(function( index ) {
            $('.selected-specialized-interventions').append('<li class="specialized-intervention-li"><span>' + $(this).closest('.specialized-interventions-checkbox-container').find('.custom-control-description').text() + '</span><a href="javascript:void(0);" class="remove-specialized-intervention-from-selection" data-tag-id="' + $(this).val() + '"><i class="far fa-times"></i></a></li>');
        });

        $('#specializedInterventionsModal').modal('hide');
    });

    $('body').on('click', '.remove-specialized-intervention-from-selection', function() {
        $('.specialized-interventions-checkbox[value="' + $(this).data('tag-id') + '"]').prop('checked', false);
        $(this).closest('.specialized-intervention-li').remove();
    });

    $('body').on('keyup', '.specialized-interventions-search', function() {
        
        $(".specialized-interventions-checkbox-container").unmark();

        if($(this).val()) {

            $('.specialized-interventions-checkbox-container').each(function( index ) {
            
                if ($(this).find('.custom-control-description').text().toLowerCase().indexOf($('.specialized-interventions-search').val().toLowerCase()) != -1) {
                    $(this).closest('.collapse').collapse("show");
                    $(this).closest('.acc_inner_col').show();
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('.specialized-interventions-primary-container .acc_inner_col').each(function( index ) {
            
                if ($(this).find('.specialized-interventions-checkbox-container:visible').length > 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

        } else {
            $('.specialized-interventions-checkbox-container').each(function( index ) {
                $(this).closest('.acc_inner_col').show();
                $(this).show();
            });
        }
        markSpecializedInterventions();
    });

    loadParticipants();

});

function loadParticipants() {   

    var provider_id = $('#provider_id').val();
    //$('select[name="goal[provider_id]"]').select2('data', { value:provider_id, text: "Hello!"});
    var participant_id = $('#participant_id').val();
   // console.log('provider_id = '+provider_id);
   // console.log('participant_id = '+participant_id);

    if (provider_id) {

        $(".loader").show();

        $.ajax({
            url: $('.goal-participant').data('participants-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                provider_id: provider_id
            },
        }).done(function(data) {

            $(".loader").hide();

            if (data.status == 'success') {
                $.each(data.participants, function (key, value) {
                    var selected = '';
                    if (value.id == participant_id) selected = 'selected';

                    $(".goal-participant").append('<option value="' + value.id + '" '+selected+'>' + value.first_name + ' ' +value.last_name + '</option>');
                });
            }
        });
    }
    //$('select[name="goal[participant_id]"]').val(participant_id);
    //$('.goal-participant').prepend('<option value="">Select Participant</option>');
    //$('.goal-participant').trigger('change');
}