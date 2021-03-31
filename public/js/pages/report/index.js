var avg_goal;
var per_goal;
var pro_goal; 
var pro_goal1;
var pro_goal2;
var pro_goal3;
$( document ).ready(function() {
	/*$(document).on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) { // on tab selection event
	    $( "#avg_goal, #per_goal, #pro_goal, #pro_goal1, #pro_goal2, #pro_goal3" ).each(function() {
	        var chart = $(this).Highcharts(); // target the chart itself
	        $timeout(function() {
	        	chart.reflow() // reflow that chart
	        }, 100);	
	    });
	})*/

	// First
	// avg_goal = Highcharts.chart('avg_goal', {
 //        chart: {        	
 //            plotBackgroundColor: null,
 //            plotBorderWidth: null,
 //            plotShadow: false,
 //            backgroundColor: null,
 //            type: 'pie'
 //        }, 
 //        title: {
 //            text: '',
 //        },       
 //        credits: {
 //            enabled: false
 //        },
 //        tooltip: {
 //            // enabled: false
 //        },
 //        plotOptions: {
 //            pie: {
 //            	states: {
 //            		hover: {			          
	// 		          enabled: false
	// 		        },
	// 	            inactive: {
	// 	                opacity: 1
	// 	            }
	// 	        },
 //            	size:'100%',
 //                center: ["50%", "50%"],
 //                animation: false,
 //                allowPointSelect: true,
 //                cursor: 'pointer',
 //                dataLabels: {                
 //                    enabled: false,                    
 //                },
 //                showInLegend: true,
 //                borderWidth: 0
 //            },
 //           series: {
 //              marker: {
 //                  enabled: true,              
 //              }
 //            }
 //        },
 //        legend: {
 //        	itemHoverStyle: {
	// 			color: '#121415'
	// 		},
 //        	itemStyle: {
 //            	fontSize:'13px',                          
 //            	color: '#121415',
 //            	fontWeight: '400'  	
 //          	},
 //            enabled: true,            
 //            align: 'center',
 //            verticalAlign: 'bottom',            
 //            color: '#121415'	
 //        },
 //        series: [{
 //        	innerSize: '60%',
 //            allowPointSelect: true,
 //            animation: true,
 //            name: '',
 //            colorByPoint: true,            
 //            data: [{     
 //                name: 'Program A',           
 //                y: 53,
 //                color: '#DBECF8',                               
 //            },
 //            {
 //                name: 'Program B',                
 //                y: 25,
 //                color: '#2C82BE',                
 //            },
 //            {
 //                name: 'Program C',                
 //                y: 22,
 //                color: '#76DDFB',                
 //            }],
 //            marker : {symbol : 'square' }
 //        }],
 //        responsive: {
	// 		rules: [{
	// 			condition: {
	// 			    maxWidth:400
	// 			},
	// 			chartOptions: {					
	// 				legend: { 												
	// 					align: 'center',
	// 					verticalAlign: 'bottom',
	// 					symbolWidth: 8,
	// 			        symbolHeight: 8,
	// 			        symbolRadius: 100,
	// 					itemStyle: {
	// 		            	fontSize:'11px'
	// 		          	},
	// 				}
	// 			}
	// 		}]
	// 	}        
 //    });	

    // Second
	// var categories = ['Program A', 'Program B', 'Program C', 'Program D'];	
	// per_goal = Highcharts.chart('per_goal', {
	//     chart: {
	//         type: 'bar',
	//         backgroundColor: null
	//     },
	//     title:{
	// 		text: null
	// 	}, 
	//     credits: {
	//         enabled: false
	//     },   
	//     xAxis:[{
	// 		categories: categories,			
	// 		labels: {				
	// 		    step: 1,
	// 		    style: {
	//                 color: '#121415',
	//                 fontSize: '13px',	     
	//                 fontWeight: '400'        
	//             }
	// 		}
	// 	}],
	//     yAxis:{	  	    	
	//     	labels: {	    		
	// 	 		style: {
	//                 color: '#121415',
	//                 fontSize: '13px',	
	//                 fontWeight: '400'                
	//            	}        	
 //            },	    	
	//         title: {
	//         	enabled: false
	//         }	        
	//     },	    
	//     legend: {
	//         enabled: false
	//     },
	//     tooltip: {
 //           //  enabled: false
 //        },
	//     plotOptions: {
	//         series: {
	//         	states: {
 //            		hover: {			          
	// 		          enabled: false
	// 		        },
	// 	            inactive: {
	// 	                opacity: 1
	// 	            }
	// 	        },
	//         	pointWidth: 25,	        	
	//             borderWidth: 0,
	//             dataLabels: {
	//                 enabled: false,	                             
	//                 style: {
	//                 	textOutline: false,
	//                 	color: '#121415'
	//                 }
	//                 //format: '{point.y:.1f}'
	//             }
	//         }
	//     },	    
	//     series: [{	            
	//             "data": [
	//                 {
	//                     "name": "Program A",
	//                     "y": 2.8,	   
	//                     "color": "#76DDFB"
	//                 },
	//                 {
	//                     "name": "Program B",
	//                     "y":1.8,
	//                     "color": "#76DDFB"
	//                 },
	//                 {
	//                     "name": "Program C",
	//                     "y":2,
	//                    	"color": "#76DDFB"
	//                 },
	//                 {
	//                     "name": "Program D",
	//                     "y": 2.2,
	//                     "color": "#76DDFB"
	//                 }
	//             ]
	//         }
	//     ],    
	// });


	// // Third
	// pro_goal = Highcharts.chart('pro_goal', {
	//     chart: {
	//         type: 'bar'
	//     },
	//     title: {
	//         text: ''
	//     },
	//     subtitle: {
	//         text: ''
	//     },
	//     xAxis: {
	//         categories: ['Overall', 'Program A', 'Program B', 'Program C'],
	//         title: {
	//             text: null
	//         }
	//     },
	//     yAxis: {
	//         min: 0,
	//         title: {
	//             text: '',
	//             align: ''
	//         },
	//         labels: {
	//             overflow: ''
	//         }
	//     },
	//     tooltip: {
	//         valueSuffix: ''
	//     },
	//     plotOptions: {
	//         bar: {
	//         	states: {
 //            		hover: {			          
	// 		          enabled: false
	// 		        },
	// 	            inactive: {
	// 	                opacity: 1
	// 	            }
	// 	        },
	//             dataLabels: {
	//                 enabled: true
	//             }
	//         }
	//     },
	//     legend: {
	//     	x: 20,	        
	//         align: 'left',
	//         verticalAlign: 'bottom'
	//     },
	//     credits: {
	//         enabled: false
	//     },
	//     series: [{
	//         name: 'Provider Type A',
	//         color: '#DBECF8',
	//         data: [2.3, 1.9, 1.7, 2.9]
	//     }, {
	//         name: 'Provider Type B',
	//         color: '#2C82BE',
	//         data: [1.7, 2.9, 0.8, 2.4]
	//     }, {
	//         name: 'Provider Type C',
	//         color: '#76DDFB',
	//         data: [1.2, 0.5, 1.3, 0.9]
	//     }]
	// });	
});