(function($) {
    var SupervisorPrograms = function() {
        $(document).ready(function() {
            supervisorProgram._initialize();
        });
    };
    supervisorProgram = SupervisorPrograms.prototype;

    supervisorProgram._initialize = function() {
        supervisorProgram._listingView();
    };

    supervisorProgram._listingView = function() {
        supervisorProgramsDt = commonScripts._generateDataTable($('#supervisorProgramsDt'), [
            { data: 'name' },
            { data: 'num_providers','searchable': false },
            { data: 'num_users','searchable': false },
            { data: 'num_user_goals','searchable': false },
            { data: 'updated_at'},          
            { data: 'avg_goal_change','searchable': false }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };
    window.SupervisorPrograms = new SupervisorPrograms();
})(jQuery);
  