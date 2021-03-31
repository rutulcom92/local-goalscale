(function($) {
    var OrganizationSupervisors = function() {
        $(document).ready(function() {
            organizationSupervisor._initialize();
        });
    };
    organizationSupervisor = OrganizationSupervisors.prototype;

    organizationSupervisor._initialize = function() {
        organizationSupervisor._listingView();
    };

    organizationSupervisor._listingView = function() {
        OrganizationSupervisorsDt = commonScripts._generateDataTable($('#organizationSupervisorsDt'), [
            { data: 'image','searchable': false,'sortable': false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_providers','searchable': false },
            { data: 'num_users','searchable': false },
            { data: 'num_users_goals','searchable': false },
            { data: 'programs' },
            { data: 'updated_at','searchable': false},
            { data: 'avg_goal_change','searchable': false},
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };

    window.OrganizationSupervisors = new OrganizationSupervisors();
})(jQuery);
  