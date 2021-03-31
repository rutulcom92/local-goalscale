(function($) {
    var ProviderGoals = function() {
        $(document).ready(function() {
            providerGoal._initialize();
        });
    };
    providerGoal = ProviderGoals.prototype;

    providerGoal._initialize = function() {
        providerGoal._listingView();
       // providerGoal._edit();
    };

    providerGoal._listingView = function() {
        providerGoalsDt = commonScripts._generateDataTable($('#providerGoalsDt'), [
            { data: 'name' },
            { data: 'participant', className: "weth" },
            { data: 'created_at','searchable': false },
            { data: 'updated_at'},          
            { data: 'tags' },
            { data: 'goal_change','searchable': false },
            { data: 'status' }
        ], [
            [1, "asc"]
        ], '', 'POST');
    };

    // providerGoal._edit = function() {
    //     $('#providerGoalsDt tbody').on('click', 'tr', function () {
    //         var data = table.row( this ).id();
    //         window.location.href = data;
    //     } );
    // }

    // participant._delete = function() {
    //     $(document).on("click", ".participant-delete", function() {
    //         commonScripts._handleDelete($(this).attr('data-url'), participantsDt, 'Are you sure you want to delete?', $(this));
    //     });
    // }
    window.ProviderGoals = new ProviderGoals();
})(jQuery);
  