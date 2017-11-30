$(document).ready(function(){
  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  $('#teacher-select').select2({
  	placeholder: "请选择教师名"
  });

  $("#apply").click(function(){
  	var course = $("#course").val();
  	var point = $("#point").val();
  	var teacher = $("#teacher-select").val();
  	var num = $("#num").val();
  	console.log(course);
  	console.log(teacher);
  	console.log(point);
  	$.ajax({
  	  url: window.course_store,
  	  type: 'post',
  	  data: {
  	    _token: window.token,
  	    course_id: course,
  	    point_id: point,
  	    teachers: teacher,
  	    quota: num,
  	    begin: "2017-12-23",
  	    end: "2017-12-24"
  	  },
  	  success: function( data ) {
  	    if(data.success){
          location.href = window.schedule_create;
        }
  	  }
  	});
  });
});