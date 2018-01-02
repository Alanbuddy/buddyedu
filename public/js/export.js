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
    $.ajax({
      type: 'post',
      url: window.withdraw,
      data: {
        amount: amount
      },
      success: function(){
        if (data.success){
          $("#cashModal").modal("hide");
          showMsg("提现申请已提交", "center");
        }
      }
    });
  });
});