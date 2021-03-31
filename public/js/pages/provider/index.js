(function($) {
    var Providers = function() {
        $(document).ready(function() {
            provider._initialize();
        });
    };
    provider = Providers.prototype;

    provider._initialize = function() {
        provider._listingView();
        //provider._edit();
    };

    provider._listingView = function() {
        ProvidersDt = commonScripts._generateDataTable($('#providersDt'), [
            { data: 'image','searchable': false,'sortable':false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_users','searchable': false },
            { data: 'num_users_goals','searchable': false },
            { data: 'organization_name'},
            { data: 'programs','searchable': false },
            { data: 'provider_type','searchable': false },
            { data: 'updated_at'},
            { data: 'avg_goal_change','searchable': false },
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };


    // provider._edit = function() {
    //     $('#providersDt tbody').on('click', 'tr', function () {
    //         var data = table.row( this ).id();
    //         var row = table.row(this);

    //         if (row.child.isShown()) {
    //         }
    //         else{
    //             window.location.href = data;
    //         }
    //     } );
    // }

    // provider._delete = function() {
    //     $(document).on("click", ".provider-delete", function() {
    //         commonScripts._handleDelete($(this).attr('data-url'), ProvidersDt, 'Are you sure you want to delete?', $(this));
    //     });
    // }
    window.Providers = new Providers();
})(jQuery);
  