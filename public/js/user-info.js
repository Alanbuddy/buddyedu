$(document).ready(function(){
  $("#next_btn").attr("disabled", true);

  check_signup_input = function(){
    if ($("#mobile").val().trim() == "" ||
        $("#mobilecode").val().trim() == ""){
      $("#next_btn").attr("disabled", true);
    } else {
      $("#next_btn").attr("disabled", false);
    }
  };
  
  $("#mobile").keyup(function(){
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
          if(data.isOccupied == false){
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
            $("#mobile_notice").text("该号码已经注册!").css("visibility", "visible");
            return false;
          }
        }
      });
    }
  });

  $("#next_btn").click(function(){
    var phone = $("#mobile").val().trim();
    var verify_code = $("#mobilecode").val().trim();
    $.ajax({
      type: 'post',
      url: window.register,
      data: {
        phone: phone,
        token: verify_code,
        _token: window.token
      },
      success: function(data){
        alert(data.redirect);
        if (data.success){
          location.href = data.redirect;
        }else{
          $("#mobile_notice").text("验证码错误").css("visibility", "visible");
        }
      }
    }); 
  });
});