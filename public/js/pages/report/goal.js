(function ($) {
    var gh1 = 0,
        gh2 = 0,
        gh3 = 0;
    var GoalGraph = function () {
        $(document).ready(function () {
            goalGraph._registerMethods();
        });
    };
    goalGraph = GoalGraph.prototype;

    goalGraph._initialize = function () {
        var dateFormat = "MM/DD/YYYY";
        var st_date = moment().startOf("year").format(dateFormat);
        var en_date = moment().format(dateFormat);
        $("#gstart-date").val(st_date);
        $("#gend-date").val(en_date);
    };

    $(".select2g")
    
        .multiselect({
            
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonWidth: "160px",
            numberDisplayed: 0,
            selectedTop: true,
            nonSelectedText: "None Selected",
            onDropdownHidden: function (event) {
                goalGraph._refreshGraphsData();
            },
        })
        .multiselect("selectAll", false)
        .multiselect("updateButtonText");

    goalGraph._registerMethods = function () {
        $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
            goalGraph._initialize();
            goalGraph._refreshGraphsData();
        });

        $("#gstart-date")
            .datepicker({
                format: "mm/dd/yyyy",
            })
            .on("change", () => {
                $(".datepicker").hide();
                goalGraph._refreshGraphsData();
            });

        $("#gend-date")
            .datepicker({
                format: "mm/dd/yyyy",
            })
            .on("change", () => {
                $(".datepicker").hide();
                goalGraph._refreshGraphsData();
            });
    };

    goalGraph._refreshGraphsData = function () {
        goalGraph._loadGraphData();
        goalGraph._loadGraphData1();
        goalGraph._loadGraphData2();
        
    };

    goalGraph._loadGraphData = function () {
        $(".loader").fadeIn();
        $.ajax({
            url: $(".load-pro-goal1-graph").data(
                "get-goal-topic-presenting-challenge-graph-details-ajax-url"
            ),
            type: "POST",
            dataType: "JSON",
            data: {
                gt: $("#goal-topic").val(),
                si: $("#specialized-invention").val(),
                pc: $("#presenting-challenge").val(),
                st_date: $("#gstart-date").val(),
                en_date: $("#gend-date").val(),
            },
        }).done(function (data) {
            // $(".loader").fadeIn();

            if (data.status == "success") {
                gh1 = 1;
                if (gh1 == 1 && gh2 == 1 && gh3 == 1) {
                    $(".loader").fadeOut();
                }
                if (data.graph_data) {
                    let dataCount = data.graph_data.length * 25;
                    $("#pro_goal1").css("height", dataCount);
                goalGraph._CreateChart(data.yaxis, data.graph_data);
                 }
                
            }
        });
    };

    goalGraph._CreateChart = function (yaxis, graphData) {
        // Fourth
        if(graphData!=''){

            Highcharts.chart("pro_goal1", {
            chart: {
                type: "bar",
            },
            title: {
                text: "",
            },
            subtitle: {
                text: "",
            },
            xAxis: {
                categories: yaxis,
                title: {
                    text: null,
                },
            },
            yAxis: {
                min: -4,
                max: 4,
                tickInterval: 1,
                title: {
                    text: "",
                    align: "",
                },
                labels: {
                    overflow: "",
                },
            },
            tooltip: {
                valueSuffix: "",
            },
            plotOptions: {
                bar: {
                    states: {
                        hover: {
                            enabled: false,
                        },
                        inactive: {
                            opacity: 1,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                },
            },
            legend: {
                x: 20,
                align: "left",
                verticalAlign: "bottom",
            },
            credits: {
                enabled: false,
            },
            series: graphData,
         
        });
    }
    else
    {
        Highcharts.chart("pro_goal1", {
            chart: {
              type: "pie",
               plotBackgroundColor: null,
               plotBorderWidth: null,
               plotShadow: false
            },
            title: {
                text: "No data to display",
            },
            subtitle: {
                text: "Select different option",
            }
          
            
        });
        
    }

    };

    goalGraph._loadGraphData1 = function () {
        $(".loader").fadeIn();
        $.ajax({
            url: $(".load-pro-goal2-graph").data(
                "get-goal-topic-specialized-intervention-graph-details-ajax-url"
            ),
            type: "POST",
            dataType: "JSON",
            data: {
                gt: $("#goal-topic").val(),
                si: $("#specialized-invention").val(),
                pc: $("#presenting-challenge").val(),
                st_date: $("#gstart-date").val(),
                en_date: $("#gend-date").val(),
            },
        }).done(function (data) {
            //   $(".loader").fadeIn();
            if (data.status == "success") {
                gh2 = 1;
                if (gh1 == 1 && gh2 == 1 && gh3 == 1) {
                    $(".loader").fadeOut();
                }
                if (data.graph_data) {
                    let dataCount = data.graph_data.length * 22;
                    $("#pro_goal2").css("height", dataCount);                   
                    goalGraph._CreateChart1(data.yaxis, data.graph_data);
                }
                
            }
        });
    };

    goalGraph._CreateChart1 = function (yaxis, graphData) {
        if(graphData!=''){

        Highcharts.chart("pro_goal2", {
            chart: {
                type: "bar",
            },
            title: {
                text: "",
            },
            subtitle: {
                text: "",
            },
            xAxis: {
                categories: yaxis,
                title: {
                    text: null,
                },
            },
            yAxis: {
                min: -4,
                max: 4,
                tickInterval: 1,
                title: {
                    text: "",
                    align: "",
                },
                labels: {
                    overflow: "",
                },
            },
            tooltip: {
                valueSuffix: "",
            },
            plotOptions: {
                bar: {
                    states: {
                        hover: {
                            enabled: false,
                        },
                        inactive: {
                            opacity: 1,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                },
            },
            legend: {
                x: 20,
                align: "left",
                verticalAlign: "bottom",
            },
            credits: {
                enabled: false,
            },
            series: graphData,
        });


    }
    else
    {
        Highcharts.chart("pro_goal2", {
            chart: {
                type: "bar",
               plotBackgroundColor: null,
               plotBorderWidth: null,
               plotShadow: false
            },
            title: {
                text: "No data to display",
            },
            subtitle: {
                text: "Select different option",
            }
        });
        
    }

    };

    goalGraph._loadGraphData2 = function () {
        $(".loader").fadeIn();
        $.ajax({
            url: $(".load-pro-goal3-graph").data(
                "get-goal-presenting-challenge-specialized-intervention-graph-details-ajax-url"
            ),
            type: "POST",
            dataType: "JSON",
            data: {
                gt: $("#goal-topic").val(),
                si: $("#specialized-invention").val(),
                pc: $("#presenting-challenge").val(),
                st_date: $("#gstart-date").val(),
                en_date: $("#gend-date").val(),
            },
        }).done(function (data) {
            // $(".loader").fadeIn();
            if (data.status == "success") {
                gh3 = 1;
                if (gh1 == 1 && gh2 == 1 && gh3 == 1) {
                    $(".loader").fadeOut();
                }
                    let dataCount = data.graph_data.length * 20;
                    $("#pro_goal3").css("height", dataCount);
                    goalGraph._CreateChart2(data.yaxis, data.graph_data);

                
                
            }
        });
    };

    goalGraph._CreateChart2 = function (yaxis, graphData) {
        if(graphData!=''){
        Highcharts.chart("pro_goal3", {
            chart: {
                type: "bar",
            },
            title: {
                text: "",
            },
            subtitle: {
                text: "",
            },
            xAxis: {
                categories: yaxis,
                title: {
                    text: null,
                },
            },
            yAxis: {
                min: -4,
                max: 4,
                tickInterval: 1,
                title: {
                    text: "",
                    align: "",
                },
                labels: {
                    overflow: "",
                },
            },
            tooltip: {
                valueSuffix: "",
            },
            plotOptions: {
                bar: {
                    states: {
                        hover: {
                            enabled: false,
                        },
                        inactive: {
                            opacity: 1,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                },
            },
            legend: {
                x: 20,
                align: "left",
                verticalAlign: "bottom",
            },
            credits: {
                enabled: false,
            },
            series: graphData,
        });
    }
    else
    {
        Highcharts.chart("pro_goal3", {
            chart: {
               type: "bar",
               plotBackgroundColor: null,
               plotBorderWidth: null,
               plotShadow: false
            },
            title: {
                text: "No data to display",
            },
            subtitle: {
                text: "Select different option",
            }
        });
        
    }

    };

    $(document).on("change", ".goal-greport-filter", function () {
        // goalGraph._loadGraphData();
        // goalGraph._loadGraphData1();
        // goalGraph._loadGraphData2();
    });

    window.GoalGraph = new GoalGraph();
})(jQuery);
