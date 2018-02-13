$(document).ready(function(){
  var is_batch = $(".is-batch").text();
  $("#modify").click(function(){
    if(is_batch == 1){
      $("#course-price").hide();
      $("#course-num").hide();
      $("#course-time").hide();
      $("#editModal").find(".modal-dialog").css({"margin-top":"-282px","height": "564px"});
    }
    $("#editModal").modal("show");
  });
  $(".close").click(function(){
    $("#editModal").modal("hide");
  });

  var teacher = {};
  $("#teacher-select option").each(function(){

  });
  $('#teacher-select').select2({
    placeholder: "请选择教师名"
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


});