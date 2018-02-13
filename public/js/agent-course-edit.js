$(document).ready(function(){
  var is_batch = $(".is-batch").text();
  var cid = null;
  $("#modify").click(function(){
    if(is_batch == 1){
      $("#course-price").hide();
      $("#course-num").hide();
      $("#course-time").hide();
      $("#editModal").find(".modal-dialog").css({"margin-top":"-282px","height": "564px"});
    }
    $("#editModal").modal("show");
    cid = $(this).attr("data-id");
  });
  $(".close").click(function(){
    $("#editModal").modal("hide");
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
  var c_begin = $(".begin").text();
  $( "#datepicker1" ).val(c_begin);

  $( "#datepicker2" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange : '-70:+10'
      });
  $( "#datepicker2" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
  $( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  var c_end = $(".end").text();
  $( "#datepicker2" ).val(c_end);

  $("#apply").click(function(){
    var put = "PUT";
    var course = $("#course").attr("data-id");
    var point = $("#point").val();
    var teacher = $("#teacher-select").val();
    var num = $("#num").val().trim();
    var begin = $("#datepicker1").val();
    var end = $("#datepicker2").val();
    var time = $("#time").val().trim();
    var price = $("#price").val().trim() * 100;
    var remark = $("#remark").val().trim();
    var lessons_count = $("#lessons-count").val().trim();
    if(is_batch == 0){
      $.ajax({
        url: window.course_update.replace(/-1/, cid),
        type: 'put',
        data: {
          _method: put,
          _token: window.token,
          course_id: course,
          point_id: point,
          teachers: teacher,
          quota: num,
          begin: begin,
          end: end,
          time: time,
          price: price,
          remark: remark,
          lessons_count: lessons_count
        },
        success: function( data ) {
          if(data.success){
            location.href = window.course_show;
          }
        }
      });
    }else{
      $.ajax({
        url: window.course_update.replace(/-1/, cid),
        type: 'put',
        data: {
          _method: put,
          _token: window.token,
          course_id: course,
          point_id: point,
          teachers: teacher,
          begin: begin,
          end: end,
          remark: remark,
          lessons_count: lessons_count
        },
        success: function( data ) {
          if(data.success){
            location.href = window.course_show;
          }
        }
      });
    }
  });
});