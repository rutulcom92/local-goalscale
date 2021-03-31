  Highcharts.chart('goalprogress', {
     chart: {
        type: 'areaspline'
    },
    title: {
        text: ''
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1
    },
    xAxis: {
        categories: [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ]
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' units'
    },
    credits: {
        enabled: false
    },
   plotOptions: {
        areaspline: {
            marker: {
                radius: 6,
                symbol : 'circle'
            },
        }
    },
    series: [{  
        showInLegend: false,      
        name: 'John',
        data: [5, 5, 4, 5, 3, 2, 3,2],
        lineColor: '#FA6400',
        color: '#FA6400',
        lineWidth: 3,
        fillColor: {
            linearGradient: [0, 0, 0, 300],
            stops: [
                [0, '#FA6400'],
                [1, '#FFFFFF']
            ]
        }
    }, {
        showInLegend: false,
        name: 'Jane',
        data: [4, 5, 2, 5, 3, 4, 3,1],
        color: '#2C82BE',
        lineColor: '#2C82BE',
        lineWidth: 3,
        fillColor: {
            linearGradient: [0, 0, 0, 300],
            stops: [
                [0, '#2C82BE'],
                [1, '#FFFFFF']
            ]
        }
    }]
});