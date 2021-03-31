(function($) {
    var SupervisorGoals = function() {
        $(document).ready(function() {
            supervisorGoal._initialize();
        });
    };
    supervisorGoal = SupervisorGoals.prototype;

    supervisorGoal._initialize = function() {
        supervisorGoal._listingView();
    };

    supervisorGoal._listingView = function() {
        supervisorGoalsDt = commonScripts._generateDataTable($('#supervisorGoalsDt'), [
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
    window.SupervisorGoals = new SupervisorGoals();
})(jQuery);
  