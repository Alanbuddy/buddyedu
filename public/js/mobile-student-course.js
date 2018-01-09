$(document).ready(function(){
  $(".mine").click(function(){
    $("#profileModal").modal("show");
  });

  $(".close").click(function(){
    $("#profileModal").modal("hide");
  });
  $("#modify-phone").click(function(){
    $("#profileModal").modal("hide");
    $("#phoneModal").modal("show");
  });
  $(".phone-close").click(function(){
    $("#phoneModal").modal("hide");
    $("#profileModal").modal("show");
    var modify_phone = $("#modify-mobile").val().trim();
    if(modify_phone != ""){
      $("#mobile").val(modify_phone);
    }
    $("#mobile_notice").css("visibility", "hidden");
  });


  $("#phone_next_btn").attr("disabled", true);

  check_signup_input = function(){
    if ($("#modify-mobile").val().trim() == "" ||
        $("#mobilecode").val().trim() == ""){
      $("#phone_next_btn").attr("disabled", true);
    } else {
      $("#phone_next_btn").attr("disabled", false);
    }
  };
  
  $("#modify-mobile").keyup(function(){
    check_signup_input();
    $("#mobile_notice").css("visibility", "hidden");
  });
    
  $("#mobilecode").keyup(function(){
    check_signup_input();
    $("#mobile_notice").css("visibility", "hidden");
  });

  var timer = null;
  var wait = 60;
  var time = function(o) {
    $(o).attr("disabled", true);
    if (wait == 0) {
      $(o).attr("disabled", false);
      $(o).text('获取验证码');
      wait = 60;
    } else {
      $(o).text('重发(' + wait + ')');
      wait--;
      timer = setTimeout(function(){
        time(o);
      }, 1000);
    }
    return false;
  };

  $("#verifycode").click(function(){
    var mobile = $("#modify-mobile").val().trim();
    var mobile_retval = $.regex.isMobile(mobile);
    if (mobile_retval == false) {
      $("#mobile_notice").text("请输入正确手机号").css("visibility", "visible");
      return false;
    } else {
      $.ajax({
        type: 'get',
        url: window.validmobile,
        data: {
          phone: mobile
        },
        success: function(data){
          if(data.isOccupied == true){
            $.ajax({
              type: 'get',
              url: window.sms_send,
              data: {
                phone: mobile
              },
              success: function(data){
                if (data.success){
                  $("#mobile_notice").css("visibility", "hidden");
                  if (timer !== null) {
                    clearTimeout(timer);
                  }
                  time("#verifycode");
                } else {
                  $("#mobile_notice").text("请稍后再重新获取").css("visibility", "visible");
                }
              }
            });
          } else {
            $("#mobile_notice").text("该号码还未注册!").css("visibility", "visible");
            return false;
          }
        }
      });
    }
  });

  $("#phone_next_btn").click(function(){
    var phone = $("#modify-mobile").val().trim();
    var verify_code = $("#mobilecode").val().trim();
    $.ajax({
      type: 'post',
      url: window.modify_end,
      data: {
        phone: phone,
        token: verify_code,
        _token: window.token
      },
      success: function(data){
        if (data.success){
          
        }else{
          $("#mobile_notice").text("验证码错误").css("visibility", "visible");
        }
      }
    }); 
  });

  $("#next_btn").click(function(){
    var name = $("#name").val();
    var gender = $("#gender").val();
    var birthday = $("#birthday").val();
    $.ajax({
      type: 'post',
      url: window.phone_update,
      data: {
        name: name,
        gender: gender,
        birthday: birthday,
        _token: window.token
      },
      success: function(data){
        if(data.success){
          $("#profileModal").modal("hide");
        }else{
          showMsg("服务器错误,请稍后再试", "center");
        }
      }
    });
  });
});