(function($) {
    var ProgramGoals = function() {
        $(document).ready(function() {
            programGoal._initialize();
        });
    };
    programGoal = ProgramGoals.prototype;

    programGoal._initialize = function() {
        programGoal._listingView();
    };

    programGoal._listingView = function() {
        programGoalsDt = commonScripts._generateDataTable($('#programGoalsDt'), [
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
    window.ProgramGoals = new ProgramGoals();
})(jQuery);
  