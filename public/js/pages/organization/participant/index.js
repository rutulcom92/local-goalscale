(function($) {
    var OrganizationParticipants = function() {
        $(document).ready(function() {
            organizationparticipant._initialize();
        });
    };
    organizationparticipant = OrganizationParticipants.prototype;

    organizationparticipant._initialize = function() {
        organizationparticipant._listingView();
    };

    organizationparticipant._listingView = function() {
        OrgParticipantsDt = commonScripts._generateDataTable($('#OrgParticipantsDt'), [
            { data: 'image','searchable': false,'sortable': false },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'num_users_goals','searchable': false },
            { data: 'updated_at'},
            { data: 'programs'},
            { data: 'provider_id' , className: "weth" },           
            { data: 'avg_goal_change','searchable': false },
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };
    window.OrganizationParticipants = new OrganizationParticipants();
})(jQuery);
  