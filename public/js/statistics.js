$(document).ready(function(){
  var age = $("#age-statistics").attr("data-age");
  var gender = $("#gender-statistics").attr("data-gender");
  var num = $("#nums-statistics").attr("data-num");
  console.log(age);
  console.log(gender);
  console.log(num);
  var ageData = [];
  var da = JSON.parse(age);
  $.each(da, function(index, item){
    ageData.push([index-1 + '~' + index + '岁', item]);
  });
  
  $('#gender-statistics').highcharts({
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
    },
    colors:
      ['#75cc7d', '#f58799', '#f6b36c'] ,
    title: {text: null},
    tooltip:{ pointFormat: '{series.name}: <b>{point.y}</b>'},
    plotOptions: { pie:{
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {enabled: false},
      showInLegend: true,
      }
    },
    credits:{
      enabled: false
    },
    legend: {
      itemStyle:{
        color: '#969696'
      }
    },
    series:
      [ {
            type: 'pie',
            name: '人数',
            // data: data.stat.gender.
            data: [
                    ['男生',50],
                    ['女生',40],
                    ['不详',10]
            ]

      } ]
  });
    

  $('#age-statistics').highcharts({
    chart:{
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
    },
    colors: ['#90c5fc', '#7fbaf7', '#67aaef', '#4898e7',
                    '#3388df', '#a1aeff', '#FF9655', '#FFF263', '#6AF9C4'],
    title:{ text: null},
    tooltip:{ pointFormat: '{series.name}: <b>{point.y}</b>'},
    plotOptions: {pie:{
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {enabled: false},
      showInLegend: true
      }
    },
    credits:{
      enabled: false
    },
    legend:{
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      itemStyle:{
          color: '#969696'
        }
    },
    xAxis: {
                categories: [
                    '0-1',
                    '1-2',
                    '2-3',
                    '3-4',
                    '4-5',
                    '5-6',
                    '>6'
                ]
            },
    yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
    series: [ {
      type: 'column',
      name: '人数',
      data: ageData
    } ]
  });
    

  $('#nums-statistics').highcharts({
    title:{
      text: null
    },
    xAxis: {
      title:{
        text: '周数'
      }
    },
    yAxis:{
      title: {text: '数量(k)'}
    },
    tooltip:{ valueSuffix: '千'},
    credits:{
      enabled: false
    },
    legend:{
      enabled: false
    },
    series:
      [
            {
              // data: data.stat.num,
              pointStart: 1,
              data: [
                1.0,
                2.3,
                2.8,
                3.2,
                4.5,
                6.0,
                6.6,
                7.5,
                8.5,
                9.7
              ]
            }
      ]
  });
});