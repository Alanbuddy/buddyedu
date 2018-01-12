
$(document).ready(function(){
  var timer = null;
  var wait = 120;
  var time = function(o) {
    $(o).attr("disabled", true);
    if (wait == 0) {
      $(o).attr("disabled", false);
      $(o).text('获取验证码');
      wait = 120;
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
    var mobile = $("#mobile").val().trim();
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
          }else {
            $("#mobile_notice").text("该号码未注册!").css("visibility", "visible");
            return false;
          }
        }
      });
    }
  });

  function forget(){
    if ($("#end_btn").attr("disabled") == true) {
      return false;
    }
    var phone = $("#mobile").val().trim();
    var verify_code = $("#mobilecode").val().trim();
    var password = $("#password").val().trim();
    $.ajax({
      type: 'post',
      url: window.forget,
      data: {
        phone: phone,
        password: password,
        token: verify_code,
        _token: window.token
      },
      success: function(data){
        if (data.success) {
          location.href = window.login;
        }else{
          if(data.message == '验证码无效'){
            $("#code_notice").text("验证码无效").css("visibility", "visible");
          }
          if(data.message == '密码错误'){
            $("#password_notice").text("密码错误").css("visibility", "visible");
          }
          if(data.message == '用户不存在'){
            $("#password_notice").text("用户不存在").css("visibility", "visible");
          }
        } 
      }
    });
  }

  $("#end_btn").click(function(){
    forget();
    return false;
  });
  
  $("#to_signin").click(function(){
    $("input").val("");
    location.href = window.login;
  });

  $("#end_btn").attr("disabled", true);

  check_forget_input = function(){
    if ($("#mobile").val().trim() == "" ||
        $("#mobilecode").val().trim() == "" ||
        $("#password").val().trim() == ""){
      $("#end_btn").attr("disabled", true);
    }else{
      $("#end_btn").attr("disabled", false);
    }
  };

  $("#mobile").keyup(function(){
    check_forget_input();
    $("#mobile_notice").css("visibility", "hidden");
  });
    
  $("#mobilecode").keyup(function(){
    check_forget_input();
    $("#code_notice").css("visibility", "hidden");
  });

  $("#password").keyup(function(event){
    var code = event.which;
    if(code == 13){
      forget();
    }else{
      check_forget_input();
      $("#password_notice").css("visibility", "hidden");
    }
  });
 
});