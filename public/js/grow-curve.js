$(document).ready(function(){
  $('#curve').highcharts({
    chart: {
            zoomType: 'x'
        },
        title: {
            text: '2017年环法德法国第八站：Dole站'
        },
        xAxis: {
            labels: {
                format: '{value} km'
            },
            minRange: 5,
            title: {
                text: '距离'
            }
        },
        yAxis: {
            startOnTick: true,
            endOnTick: false,
            maxPadding: 0.35,
            title: {
                text: null
            },
            labels: {
                format: '{value} m'
            }
        },
        tooltip: {
            headerFormat: '距离: {point.x:.1f} km<br>',
            pointFormat: '海拔：{point.y} m ',
            shared: true,
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            data: elevationData,
            lineColor: Highcharts.getOptions().colors[1],
            color: Highcharts.getOptions().colors[2],
            fillOpacity: 0,
            name: '海拔',
            marker: {
                enabled: false
            },
            threshold: null
        }]
  });


});