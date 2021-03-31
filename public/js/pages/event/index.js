(function($) {
    var Events = function() {
        $(document).ready(function() {
            Event._initialize();
        });
    };
    var Event = Events.prototype;

    Event._initialize = function() {
        Event._listingView();
        Event._initDatePicker();
    };

    
    // setInterval( function () {
    //     scrollPos = $(".dataTables_scrollBody").scrollTop();
    //     table.ajax.reload(function() {
    //         $(".dataTables_scrollBody").scrollTop(scrollPos);
    //     },false);
    // }, 2000 );
    //setInterval(function () {
        //table.ajax.reload();
        //console.log('xxx');
    //}, 2000);

    Event._initDatePicker = function(){
        $('#ostart-date').datepicker({
            format: "mm/dd/yyyy"
        }).on('change', () => {
            $('.datepicker').hide();
            organizationGraph._refreshGraphsData()
        });

        $('#oend-date').datepicker({
            format: "mm/dd/yyyy"
        }).on('change', () => {
            $('.datepicker').hide();
            organizationGraph._refreshGraphsData()
        });
    }

    Event._listingView = function() {
        eventsDt = commonScripts._generateDataTable($('#eventsDt'), [
            { data: 'event_type' },
            { data: 'event_name' },
            { data: 'description'},
            { data: 'related_id' },
            { data: 'email' },
            { data: 'event_user_type' },
            { data: 'event_by' },
            { data: 'created_at' },
            //{ data: 'action' }
        ], [
            [7, "desc"]
        ], '', 'POST');
    };

    window.Events = new Events();

})(jQuery);



