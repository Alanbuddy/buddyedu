$(document).ready(function(){
  var age = $("#age-statistics").attr("data-age");
  var gender = $("#gender-statistics").attr("data-gender");
  var num = $("#nums-statistics").attr("data-num");

  var ageData = [];
  var ageX = [];
  var da = JSON.parse(age);
  $.each(da, function(index, item){
    ageX.push([index-1+ '~' + index + '岁']);
    ageData.push([index-1 + '~' + index + '岁', item]);
  });

  var genderData = [];
  var gender_d = JSON.parse(gender);
  $.each(gender_d, function(index, item){
    if(item.gender == "male"){
      item.gender = "男生";
    }else if(item.gender == "female"){
      item.gender = "女生";
    }else{
      item.gender = "不详";
    }
    genderData.push([item.gender, item.count]);
  });
  
  var numData = [];
  var num_d = JSON.parse(num);
  $.each(num_d, function(index, item){
    numData.push(item);
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
    tooltip:{ pointFormat: '{series.name}: <b>{point.y}人</b>'},
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
            data: genderData
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
    tooltip:{ pointFormat: '{series.name}: <b>{point.y}人</b>'},
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
              categories: ageX
            },
    yAxis: {
                min: 0,
                title: {
                    text: ''
                },
                tickInterval: 1
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
        text: '周数',
      },
      tickInterval: 1
    },
    yAxis:{
      title: {text: '数量'},
      tickInterval: 1
    },
    tooltip:{ valueSuffix: '人'},
    credits:{
      enabled: false
    },
    legend:{
      enabled: false
    },
    series:
      [
            {
              data: numData,
              pointStart: 1
              // data: [
              //   1.0,
              //   2.3,
              //   2.8,
              //   3.2,
              //   4.5,
              //   6.0,
              //   6.6,
              //   7.5,
              //   8.5,
              //   9.7
              // ]
            }
      ]
  });
});