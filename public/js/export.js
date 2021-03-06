$(document).ready(function(){
  $("#export").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  $( "#datepicker1" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange : '-70:+10'
      });
  $( "#datepicker1" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
  $( "#datepicker1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

  $( "#datepicker2" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange : '-70:+10'
      });
  $( "#datepicker2" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
  $( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

  $(".cash").click(function(){
    $("#cashModal").modal("show");
  });
  $(".close-cash").click(function(){
    $("#cashModal").modal("hide");
  });

  $("#apply").click(function(){
    var amount = $("#withdraw").val().trim();
    var cash_amount = parseFloat($("#cash-amount").text().slice(1));
    if(amount > 0 && amount <= cash_amount){
      $.ajax({
        url: window.with_draw,
        type: 'post',
        data: {
          amount: amount,
          _token: window.token
        },
        success: function(data){
          if(data.success) {
            $("#cashModal").modal("hide");
            showMsg("提现申请已提交", "center");
          }
        }
      });
    }else{
      showMsg("提现金额必须小于等于可提现余额", "center");
    }
  });

  $("#submit").click(function(){
    var left = $("#datepicker1").val();
    var right = $("#datepicker2").val();
    if(left < right){
      $("#addModal").modal("hide");
      $("#addModal").find("input").val("");
      location.href = window.export_table + "?left=" + left + "&right=" + right;
    }else{
      showMsg("选择时间段错误", "center");
    }
  });
});