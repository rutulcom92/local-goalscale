(function($) {
    var ProviderParticipants = function() {
        $(document).ready(function() {
            providerparticipant._initialize();
        });
    };
    providerparticipant = ProviderParticipants.prototype;

    providerparticipant._initialize = function() {
        providerparticipant._listingView();
        // providerparticipant._edit();
    };

    providerparticipant._listingView = function() {
        ParticipantsDt = commonScripts._generateDataTable($('#providerParticipantsDt'), [
            { data: 'image','searchable': false , 'sortable': false},
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_users_goals'},
            { data: 'updated_at'},          
            { data: 'goal_change'},
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };

    // participant._delete = function() {
    //     $(document).on("click", ".participant-delete", function() {
    //         commonScripts._handleDelete($(this).attr('data-url'), participantsDt, 'Are you sure you want to delete?', $(this));
    //     });
    // }
    window.ProviderParticipants = new ProviderParticipants();
})(jQuery);
  