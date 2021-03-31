(function($) {
    var ProgramProviders = function() {
        $(document).ready(function() {
            programProvider._initialize();
        });
    };
    programProvider = ProgramProviders.prototype;

    programProvider._initialize = function() {
        programProvider._listingView();
    };                                                                                          

    programProvider._listingView = function() {
        ProgramProvidersDt = commonScripts._generateDataTable($('#programProvidersDt'), [
            { data: 'image','searchable': false,'sortable': false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_users','searchable': false },
            { data: 'num_users_goals','searchable': false }, 
            { data: 'updated_at'},                                                                                                                                                                                          
            { data: 'avg_goal_change','searchable': false },
            { data: 'status' }
        ], [
            [1, "asc"]                                                                                                              
        ], '', 'POST');
    };

    window.ProgramProviders = new ProgramProviders();
})(jQuery);
  