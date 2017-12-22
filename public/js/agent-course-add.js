$(document).ready(function(){
  $(".add-div").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  $("#cancel").click(function(){
    $("#addModal").modal("hide");
  });

  $("#add").click(function(){
    var cid = $(this).attr("data-id");
    var remark = $("#remark").val().trim();
  	$.ajax({
      type: 'post',
      url: window.course_add,
      data: {
        remark: remark
      },
      success: function(data){
        if(data.success){
          $("#addModal").modal("hide");
        }else{
          showMsg("添加课程失败", "center");
        }
      }
    });
  });

});