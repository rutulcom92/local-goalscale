(function($) {
    var Supervisors = function() {
        $(document).ready(function() {
            supervisor._initialize();
        });
    };
    supervisor = Supervisors.prototype;

    supervisor._initialize = function() {
        supervisor._listingView();
        supervisor._edit();

    };

    supervisor._listingView = function() {
        SupervisorsDt = commonScripts._generateDataTable($('#supervisorsDt'), [
            { data: 'image','searchable': false,'sortable': false,  className:"weth" },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_providers','searchable': false },
            { data: 'num_users','searchable': false },
            { data: 'num_users_goals','searchable': false},
            //{ data: 'organization_id','searchable': false },
            { data: 'organization_name' },
            { data: 'programs' },
            { data: 'last_login','searchable': false},
            { data: 'avg_goal_change','searchable': false},
            { data: 'status'}
        ], [
            [1, "asc"]
        ], '', 'POST');
    };

    // supervisor._edit = function(element) {
    //     $('#supervisorsDt tbody').on('click', 'tr', function () {
    //         var data = table.row( this ).id();
    //         var row = table.row(this);

    //         if (row.child.isShown()) {
    //         }
    //         else{
    //             window.location.href = data;
    //         }
           
    //     } );
    // }

    // supervisor._delete = function() {
    //     $(document).on("click", ".supervisor-delete", function() {
    //         commonScripts._handleDelete($(this).attr('data-url'), SupervisorsDt, 'Are you sure you want to delete?', $(this));
    //     });
    // }
    window.Supervisors = new Supervisors();
})(jQuery);
  