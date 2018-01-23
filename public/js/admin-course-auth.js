$(document).ready(function(){
  var cid = null;
  $(".cancel-course").click(function(){
    $("#revokeModal").modal("show");
    cid = $(this).closest('.add-div').siblings(".course-name").attr("data-id");
    console.log(cid);
  });

  $(".close").click(function(){
    $("#revokeModal").modal("hide");
  });

  $("#submit").click(function(){
    $.ajax({
      type: 'get',
      url: window.course_revoke.replace(/-1/, cid),
      success: function(data){
        if(data.success){
          location.href = window.course_list;
        }
      }
    });
  });

  $(".modify").click(function(){
    $("#modifyModal").modal("show");
    var num = $(this).siblings(".quantity").text();
    var course_name = $(this).siblings('.course-name').text();
    var merchant_name = $(".merchant-name").text();
    $("#modifyModal").find(".modify-title").text(merchant_name + "的" + course_name);
    $("#num").val(num);
  });
  $(".close").click(function(){
    $("#modifyModal").modal("hide");
  });

  $("#confirm-btn").click(function(){
    var cid = $(".course-name").attr("data-id");
    var quantity = $("#num").val().trim();
    $.ajax({
      type: 'post',
      url: window.quantity.replace(/-1/, cid),
      data: {
        quantity: quantity
      },
      success: function(data){
        if(data.success){
          $("#modifyModal").modal("hide");
          showMsg("名额修改成功", "center");
        }else{
          showMsg("名额修改失败", "center");
        }
      }
    });
  });
});