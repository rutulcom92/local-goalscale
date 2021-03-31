(function($) {
    var OrganizationPrograms = function() {
        $(document).ready(function() {
            orgranizationProgram._initialize();
        });
    };
    orgranizationProgram = OrganizationPrograms.prototype;

    orgranizationProgram._initialize = function() {
        orgranizationProgram._listingView();
    };

    orgranizationProgram._listingView = function() {
        orgranizationProgramsDt = commonScripts._generateDataTable($('#orgranizationProgramsDt'), [
            { data: 'name' },
            { data: 'supervisors' },
            { data: 'num_providers','searchable': false },
            { data: 'num_users','searchable': false },
            { data: 'num_user_goals','searchable': false },
            { data: 'updated_at'},          
            { data: 'avg_goal_change','searchable': false }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };
    window.OrganizationPrograms = new OrganizationPrograms();
})(jQuery);
  