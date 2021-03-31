(function($) {
    var ProgramUsers = function() {
        $(document).ready(function() {
            programUser._initialize();
        });
    };
    programUser = ProgramUsers.prototype;

    programUser._initialize = function() {
        programUser._listingView();
    };

    programUser._listingView = function() {
        programUsersDt = commonScripts._generateDataTable($('#programUsersDt'), [
            { data: 'image','searchable': false,'sortable': false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_users_goals','searchable': false },
            { data: 'updated_at'},
            { data: 'providers','searchable': false , className: "weth",'sortable': false },           
            { data: 'avg_goal_change','searchable': false },
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };
    window.ProgramUsers = new ProgramUsers();
})(jQuery);
  