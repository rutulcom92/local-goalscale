(function($) {
    var g1 = 0, g2 = 0, g3 = 0;
    var OrganizationGraph = function() {
        $(document).ready(function() {
            organizationGraph._initialize();
            organizationGraph._refreshGraphsData();
        });
    };
    organizationGraph = OrganizationGraph.prototype;

    organizationGraph._initialize = function() {
       organizationGraph._registerMethods();
       var dateFormat = 'MM/DD/YYYY';
       var st_date = moment().startOf('year').format(dateFormat);
       var en_date = moment().format(dateFormat);

       $("#ostart-date").val(st_date);
       $("#oend-date").val(en_date);
    };

    $('.select2m').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '160px',
        numberDisplayed: 0,
        selectedTop: true,
        nonSelectedText: "None Selected",
        onDropdownHidden: function(event) {
           organizationGraph._refreshGraphsData();
        }
    }).multiselect('selectAll', false).multiselect('updateButtonText');

    organizationGraph._refreshGraphsData = function (){
        organizationGraph._loadAvgGoalGraphData();
        organizationGraph._loadGraphData();
        organizationGraph._loadProgramProviderGraphData();
    }


    organizationGraph._registerMethods = function(){
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


    organizationGraph._loadAvgGoalGraphData =function(){
        $(".loader").fadeIn();
        $.ajax({
            url: $('.load-avg-goal-graph').data('get-average-goal-change-by-program-graph-details-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                orgId : $('#organizationId').val(),
                pId : $('#programId').val(),
                st_date : $('#ostart-date').val(),
                en_date : $('#oend-date').val()

            },
        }).done(function(data) {
            if (data.status == 'success') {
                g1 = 1;
                if(g1==1 && g2==1 && g3==1){
                    $(".loader").fadeOut();
                }

                
                let dataCount = data.graph_data.length * 80;
                $("#avg_goal").css("height", dataCount);
                
                organizationGraph._CreateAverageGoalChangeByProgramChart(data.categories,data.graph_data);
            }
        });
    }

    organizationGraph._CreateAverageGoalChangeByProgramChart = function(categories, graphData){

if(graphData!=''){

        Highcharts.chart('avg_goal', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                backgroundColor: null,
                type: 'pie'
            },
            title: {
                text: '',
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                 states: {
                     hover: {
                       enabled: false
                     },
                     inactive: {
                         opacity: 1
                     },
                 },
                 size:'100%',
                    center: ["50%", "50%"],
                    animation: false,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                    },
                    showInLegend: true,
                    borderWidth: 0
                },
               series: {
                  marker: {
                      enabled: true,
                  }
                }
            },
            legend: {
             itemHoverStyle: {
                 color: '#121415'
             },
             itemStyle: {
                 fontSize:'13px',
                 color: '#121415',
                 fontWeight: '400'
                 },
                enabled: true,
                align: 'center',
                verticalAlign: 'bottom',
                color: '#121415'
            },
            series: [{
             innerSize: '60%',
                allowPointSelect: true,
                animation: true,
                name: '',
                colorByPoint: true,
                data: graphData,
                marker : {symbol : 'square' }
            }],
            responsive: {
             rules: [{
                 condition: {
                     maxWidth:400
                 },
                 chartOptions: {
                     legend: {
                         align: 'center',
                         verticalAlign: 'bottom',
                         symbolWidth: 8,
                         symbolHeight: 8,
                         symbolRadius: 100,
                         itemStyle: {
                             fontSize:'11px'
                         },
                     }
                 }
             }]
         }
        });

    }
    else
    {
        Highcharts.chart("avg_goal", {
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

    }

    organizationGraph._loadGraphData =function(){
        $(".loader").fadeIn();
        $.ajax({
            url: $('.load-per-goal-graph').data('get-goal-performance-by-program-graph-details-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                orgId : $('#organizationId').val(),
                pId : $('#programId').val(),
                st_date : $('#ostart-date').val(),
                en_date : $('#oend-date').val()

            },
        }).done(function(data) {
            if (data.status == 'success') {
                g2 = 1;
                if(g1==1 && g2==1 && g3==1){
                    $(".loader").fadeOut();
                }

                
                let dataCount = data.graph_data.length * 36;
                $("#per_goal").css("height", dataCount);
                organizationGraph._CreateChart(data.categories, data.graph_data);
            }
        });
    }

    organizationGraph._CreateChart = function(categoryAxis, seriesAxis){
        if(seriesAxis!=''){
        Highcharts.chart('per_goal', {
            chart: {
                type: 'bar',
                backgroundColor: null
            },
            title:{
                text: null
            },
            credits: {
                enabled: false
            },
            xAxis:[{
                categories: categoryAxis,
                labels: {
                    step: 1,
                    style: {
                        color: '#121415',
                        fontSize: '10px',
                        fontWeight: '400'
                    },
                   // rotation: -20,

                }
            }],
            yAxis:{
                min:-4,
                max:4,
                tickInterval: 1,
                labels: {
                    style: {
                        color: '#121415',
                        fontSize: '13px',
                        fontWeight: '400'
                    }
                },
                title: {
                    enabled: false
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
               //  enabled: false
            },
            plotOptions: {
                series: {
                    states: {
                        hover: {
                          enabled: false
                        },
                        inactive: {
                            opacity: 1
                        }
                    },
                    pointWidth: 25,
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        style: {
                            textOutline: false,
                            color: '#121415'
                        }
                        //format: '{point.y:.1f}'
                    }
                }
            },
            series: seriesAxis,
        });
    }
    else
    {
        Highcharts.chart("per_goal", {
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

    }

     organizationGraph._loadProgramProviderGraphData =function(){
        $(".loader").fadeIn();
        $.ajax({
            url: $('.load-pro-goal-graph').data('get-goal-progress-by-program-providertype-graph-details-ajax-url'),
            type: 'POST',
            dataType: 'JSON',
            data: {
                orgId : $('#organizationId').val(),
                pId : $('#programId').val(),
                st_date : $('#ostart-date').val(),
                en_date : $('#oend-date').val()
            },
        }).done(function(data) {
           //$(".loader").fadeIn();
            if (data.status == 'success') {
                g3 = 1;
                if(g1==1 && g2==1 && g3==1){
                    //$('.loader').removeClass('first_time_ldr');
                    $(".loader").fadeOut();
                }

                

                data.graph_data.data = data.graph_data.data.filter(program => program.goals.length > 0);
                
                let dataCount = data.graph_data.data.length * 80;
                $("#pro_goal").css("height", dataCount);
                const formattedData = processProgramProviderGraphData(data.graph_data.data);
                const normalizedData = normalizeProgramProviderGraphData(formattedData);
                organizationGraph._CreateProgramProviderChart(formattedData.map(data => data.name),normalizedData);
            }
        });
    }

    /**
     * Use this to calculate data for the goal progress by program and provider type graph
     * Returns an array of programs that contains goal difference averages for each provider
     * **/
    function processProgramProviderGraphData(graph_data) {
        var programs = [];
        graph_data.forEach(program => {
            var goals = program.goals;
            var goalDifferences = [];
            var currentGoalId = goals[0].id;
            var oldestCurrentGoalUpdate = 0;
            // calculate goal difference for each provider in each program
            for (i = 0; i < goals.length; i++) {
                if (i === (goals.length - 1)) {
                    var goalDifference = goals[i].activity_ranking - goals[oldestCurrentGoalUpdate].activity_ranking;
                    goalDifferences.push({goalDifference, providerId: goals[oldestCurrentGoalUpdate].provider_id});
                }
                if (goals[i].id !== currentGoalId) {
                    var goalDifference = goals[i - 1].activity_ranking - goals[oldestCurrentGoalUpdate].activity_ranking;
                    goalDifferences.push({goalDifference, providerId: goals[oldestCurrentGoalUpdate].provider_id});
                    oldestCurrentGoalUpdate = i;
                    currentGoalId = goals[i].id;
                }
            }
            // calculate average goal differences per provider in each program
            var currentDifferences = [];
            var currentProviderId = goalDifferences[0].providerId;
            var providersData = [];
            for (i = 0; i < goalDifferences.length; i++) {
                if (i === (goalDifferences.length - 1)) {
                    currentDifferences.push(goalDifferences[i].goalDifference);
                    providersData.push({
                        id: currentProviderId,
                        goalsAverageDifference: +(currentDifferences.reduce((a, b) => a + b) / currentDifferences.length).toFixed(2),
                        providerName: goals.find(goal => goal.provider_id === currentProviderId).name
                    });
                }
                if (goalDifferences[i].providerId === currentProviderId) {
                    currentDifferences.push(goalDifferences[i].goalDifference);
                } else {
                    providersData.push({
                        id: currentProviderId,
                        goalsAverageDifference: +(currentDifferences.reduce((a, b) => a + b) / currentDifferences.length).toFixed(2),
                        providerName: goals.find(goal => goal.provider_id === currentProviderId).name
                    });
                    currentProviderId = goalDifferences[i].providerId;
                    currentDifferences = [];
                }
            }
            var currentProgram = {
                name: program.name,
                data: providersData
            }
            programs.push(currentProgram);
        })
        return programs;
    }

    /**
     * Use this to normalize data for the goal progress by program and provider type graph
     * Returns an array with the goal difference average for each provider in each program
     * **/
    function normalizeProgramProviderGraphData(programsData) {
        var providerNames = [];
        programsData.forEach(program => {
            program.data.forEach(provider => {
                providerNames.push(provider.providerName);
            })
        });
        // filter out unique provider names
        var categories = providerNames.filter((v, i, a) => a.indexOf(v) === i);
        var normalizedData = [];
        programsData.forEach(program => {
            var providerAverages = [];
            for (i = 0; i < categories.length; i++) {
                if (program.data.filter(provider => provider.providerName === categories[i]).length > 0) {
                    providerAverages.push((program.data.find(provider => provider.providerName === categories[i])).goalsAverageDifference);
                } else {
                    providerAverages.push("");
                }
            }
            normalizedData.push(providerAverages);
        });
        // restructure arrays to fit graph input
        var graphData = [];
        var currentDataSet = {name: '', data: []};
        for (i = 0; i < categories.length; i++) {
            currentDataSet.name = categories[i];
            normalizedData.forEach(dataSet => {
                currentDataSet.data.push(dataSet[i]);
            })
            graphData.push(currentDataSet);
            currentDataSet = {name: '', data: []};
        }
        return graphData;
    }

    organizationGraph._CreateProgramProviderChart = function(categories, graphData){
        if(graphData!=''){
        Highcharts.chart('pro_goal', {
              chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: categories,
            title: {
                text: null
            }
        },
        yAxis: {
            min: -4,
            max:4,
            tickInterval: 1,
            title: {
                text: '',
                align: ''
            },
            labels: {
                overflow: ''
            }
        },
        tooltip: {
            valueSuffix: ''
        },
        plotOptions: {
            bar: {
             states: {
                 hover: {
                   enabled: false
                 },
                 inactive: {
                     opacity: 1
                 }
             },
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
         x: 20,
            align: 'left',
            verticalAlign: 'bottom'
        },
        credits: {
            enabled: false
        },
        series: graphData
    });
}
else
{
    Highcharts.chart("pro_goal", {
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

    }

    $(document).on('change', '.org-dreport-filter', function() {

          // organizationGraph._loadGraphData();
          // organizationGraph._loadProgramProviderGraphData();
          // organizationGraph._loadAvgGoalGraphData();
   });

    window.OrganizationGraph = new OrganizationGraph();
})(jQuery);
