(function($) {
    var OrganizationAdministrators = function() {
        $(document).ready(function() {
            organizationAdministrator._initialize();
        });
    };
    organizationAdministrator = OrganizationAdministrators.prototype;

    organizationAdministrator._initialize = function() {
        organizationAdministrator._listingView();
    };

    organizationAdministrator._listingView = function() {
        organizationAdminsDt = commonScripts._generateDataTable($('#organizationAdminsDt'), [
            { data: 'image','searchable': false,'sortable': false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_providers','searchable': false },
            { data: 'num_users','searchable': false },
            { data: 'num_users_goals','searchable': false },
            { data: 'updated_at','searchable': false},
            { data: 'avg_goal_change','searchable': false},
            { data: 'status'}
        ], [
            [1, "asc"]
        ], '', 'POST');
    };

    // organizationAdministrator._edit = function(element) {
    //     $('#organizationAdminsDt tbody').on('click', 'tr', function () {
    //         var data = table.row( this ).id();
    //         window.location.href = data;
           
    //     } );
    // }

    window.OrganizationAdministrators = new OrganizationAdministrators();
})(jQuery);
  