(function($) {
    var programSupervisors = function() {
        $(document).ready(function() {
            programSupervisor._initialize();
        });
    };
    programSupervisor = programSupervisors.prototype;

    programSupervisor._initialize = function() {
        programSupervisor._listingView();
    };

    programSupervisor._listingView = function() {
        programSupervisorsDt = commonScripts._generateDataTable($('#programSupervisorsDt'), [
            { data: 'image','searchable': false,'sortable': false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_providers','searchable': false },
            { data: 'num_users','searchable': false },
            { data: 'num_users_goals','searchable': false },
            { data: 'updated_at','searchable': false},
            { data: 'avg_goal_change','searchable': false},
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };

    window.programSupervisors = new programSupervisors();
})(jQuery);
  