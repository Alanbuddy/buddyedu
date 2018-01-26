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
    var course_id = $(this).siblings('.course-name').attr("data-id");
    var merchant_name = $(".merchant-name").text();
    $("#modifyModal").find(".modify-title").text(merchant_name + "的" + course_name);
    $("#num").val(num);
    $("#modifyModal").find('.course-id').text(course_id);
  });
  $(".close").click(function(){
    $("#modifyModal").modal("hide");
    $("#num").val("");
  });

  $("#confirm-btn").click(function(){
    var cid = $(".course-id").text();
    var quantity = $("#num").val().trim();
    if($.isNumeric(quantity)){
      $.ajax({
        type: 'post',
        url: window.quantity.replace(/-1/, cid),
        data: {
          quantity: quantity,
          _token: window.token
        },
        success: function(data){
          if(data.success){
            $("#modifyModal").modal("hide");
            location.href = window.course_auth;
          }else{
            showMsg("名额修改失败", "center");
          }
        }
      });
    }else{
      showMsg("名额必须为数字", "center");
      return false;
    }
    
  });

  $clamp(document.querySelector('.course-description'), {clamp: 3});
});