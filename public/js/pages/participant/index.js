(function($) {
    var Participants = function() {
        $(document).ready(function() {
            participant._initialize();
        });
    };
    participant = Participants.prototype;

    participant._initialize = function() {
        participant._listingView();
        participant._edit();
    };

    participant._listingView = function() {
        ParticipantsDt = commonScripts._generateDataTable($('#participantsDt'), [
            { data: 'image','searchable': false, 'sortable': false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_users_goals','searchable': false },
            { data: 'updated_at'},
            { data: 'organization'},
            { data: 'providers'},           
            { data: 'avg_goal_change','searchable': false},
            { data: 'status'}
        ], [
            [1, "asc"]
        ], '', 'POST');
    };

    // participant._edit = function() {
    //     $('#participantsDt tbody').on('click', 'tr', function () {
    //         var data = table.row( this ).id();
    //         var row = table.row(this);

    //         if (row.child.isShown()) {
    //         }
    //         else{
    //             window.location.href = data;
    //         }
    //     } );
    // }

    // participant._delete = function() {
    //     $(document).on("click", ".participant-delete", function() {
    //         commonScripts._handleDelete($(this).attr('data-url'), participantsDt, 'Are you sure you want to delete?', $(this));
    //     });
    // }
    window.Participants = new Participants();
})(jQuery);
  