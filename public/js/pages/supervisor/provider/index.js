(function($) {
    var supervisorProviders = function() {
        $(document).ready(function() {
            supervisorprovider._initialize();
        });
    };
    supervisorprovider = supervisorProviders.prototype;

    supervisorprovider._initialize = function() {
        supervisorprovider._listingView();
    };

    supervisorprovider._listingView = function() {
        supervisorProvidersDt = commonScripts._generateDataTable($('#supervisorProvidersDt'), [
            { data: 'image','searchable': false,'sortable':false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_users','searchable': false  },
            { data: 'num_users_goals','searchable': false },
            { data: 'programs' },
            { data: 'updated_at'},
            { data: 'avg_goal_change','searchable': false },
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');

       
    };
    window.supervisorProviders = new supervisorProviders();
})(jQuery);
  