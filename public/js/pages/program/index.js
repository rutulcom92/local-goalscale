(function($) {
    var Programs = function() {
        $(document).ready(function() {
            Program._initialize();
        });
    };
    var Program = Programs.prototype;

    Program._initialize = function() {
        Program._listingView();
        Program._edit();
    };

    Program._listingView = function() {
        programsDt = commonScripts._generateDataTable($('#programsDt'), [
            { data: 'name' },
            { data: 'supervisors' },
            { data: 'num_providers' },
            { data: 'num_users' },
            { data: 'num_user_goals' },
            { data: 'updated_at' },
            { data: 'avg_goal_change' }
        ], [
            [1, "asc"]
        ], '', 'POST');       
    };

    // Program._edit = function() {
    //     $('#programsDt tbody').on('click', 'tr', function () {
    //         var data = table.row( this ).id();
    //         window.location.href = data;
    //     } );
    // }
    window.Programs = new Programs();
})(jQuery);
  