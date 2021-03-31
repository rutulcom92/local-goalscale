(function($) {
    var ParticipantGoals = function() {
        $(document).ready(function() {
            participantGoal._initialize();
        });
    };
    participantGoal = ParticipantGoals.prototype;

    participantGoal._initialize = function() {
        participantGoal._listingView();
       //participantGoal._edit();
    };

    participantGoal._listingView = function() {
        participantGoalsDt = commonScripts._generateDataTable($('#participantGoalsDt'), [
            { data: 'name' },
            { data: 'created_at','searchable': false },
            { data: 'updated_at'},          
            { data: 'tags' },
            { data: 'goal_change','searchable': false },
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };

    // participantGoal._edit = function() {
    //     $('#participantGoalsDt tbody').on('click', 'tr', function () {
    //         var data = table.row( this ).id();
    //         window.location.href = data;
    //     } );
    // }

    // participant._delete = function() {
    //     $(document).on("click", ".participant-delete", function() {
    //         commonScripts._handleDelete($(this).attr('data-url'), participantsDt, 'Are you sure you want to delete?', $(this));
    //     });
    // }
    window.ParticipantGoals = new ParticipantGoals();
})(jQuery);
  