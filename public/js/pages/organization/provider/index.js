(function($) {
    var OrganizationProviders = function() {
        $(document).ready(function() {
            organizationprovider._initialize();
        });
    };
    organizationprovider = OrganizationProviders.prototype;

    organizationprovider._initialize = function() {
        organizationprovider._listingView();
    };                                                                                          

    organizationprovider._listingView = function() {
        OrganizationProvidersDt = commonScripts._generateDataTable($('#organizationprovidersDt'), [
            { data: 'image','searchable': false,'sortable': false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_users','searchable': false },
            { data: 'num_users_goals','searchable': false },                                                                            
            { data: 'programs' },
            { data: 'updated_at'},                                                                                                                                                                                          
            { data: 'avg_goal_change','searchable': false },
            { data: 'status' }
        ], [
            [1, "asc"]                                                                                                              
        ], '', 'POST');
    };

    window.OrganizationProviders = new OrganizationProviders();
})(jQuery);
  