$(document).ready(function(){
  var dateRange1 = new pickerDateRange('date1', {
    isTodayValid : true,
    startDate : '2017-11-01',
    endDate : '2017-11-07',
    needCompare : false,
    defaultText : ' 至 ',
    autoSubmit : true,
    inputTrigger : 'input_trigger1',
    theme : 'ta',
    success : function(obj) {
      $("#dCon2").html('开始时间 : ' + obj.startDate + '<br/>结束时间 : ' + obj.endDate);
    }
  });


  function search(){
    var value = $("#search-input").val();
    location.href = window.amount_search + "?key=" + value;
  }
    
  $("#search-btn").click(function(){
    search();
  });

  $("#search-input").keydown(function(event){
    var code = event.which;
    if (code == 13){
      search();
    }
  });
});


