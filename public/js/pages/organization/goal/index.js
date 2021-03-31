(function($) {
    var OrganizationGoals = function() {
        $(document).ready(function() {
            organizationGoal._initialize();
        });
    };
    organizationGoal = OrganizationGoals.prototype;

    organizationGoal._initialize = function() {
        organizationGoal._listingView();
    };

    organizationGoal._listingView = function() {
        OrgParticipantsDt = commonScripts._generateDataTable($('#OrgGoalsDt'), [
            { data: 'name' },
            { data: 'participant',  className: "weth" },
            { data: 'provider',  className: "weth" },
            { data: 'created_at','searchable': false },
            { data: 'updated_at'},          
            { data: 'tags' },
            { data: 'goal_change','searchable': false },
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };
    window.OrganizationGoals = new OrganizationGoals();
})(jQuery);
  