$(document).ready(function(){
  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });
  $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange : '-20:+10'
      });
  $( "#datepicker" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
  $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});