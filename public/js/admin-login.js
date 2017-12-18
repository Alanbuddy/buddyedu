$(document).ready(function(){
  $("#to_signup").click(function(){
    $("input").val("");
    location.href = window.register;
  });
    
  $("#to_forget_password").click(function(){
    $("input").val("");
    location.href = window.forget;
  });
   
  $("#signin_btn").attr("disabled", true);

  toggle_signin_tip = function(wrong){
    if (wrong){
      $("#error_notice").css("visibility", "visible");
    }
    else{
      $("#error_notice").css("visibility", "hidden");
    }
  };
   
  check_signin_input = function(){
    if ($("#mobile").val().trim() == "" || $("#password").val().trim() == ""){
      $("#signin_btn").attr("disabled", true);
    }
    else{
      $("#signin_btn").attr("disabled", false);
    }
  };
    
  $("#mobile").keyup(function(event) {
    var code = event.which;
    if (code != 13) {
      toggle_signin_tip(false);
    }
    check_signin_input();
  });
  $("#password").keyup(function(event) {
    var code = event.which;
    if (code != 13) {
      toggle_signin_tip(false);
    }
    check_signin_input();
  });


  function signin(){
    if ($("#signin_btn").attr("disabled") == true) {
      return false;
    }
    var mobile = $("#mobile").val().trim();
    var password = $("#password").val().trim();
    var mobile_retval = $.regex.isMobile(mobile);
    if (mobile_retval == false) {
      $("#error_notice").text("手机号错误").css("visibility", "visible");
      return false;
    }
    $.ajax({
      type: "post",
      url: window.login,
      data: {
        phone: mobile,
        password: password,
        _token: window.token
      },
      async: false,
      success: function(){
        location.href = window.log_index;
      },
      error: function(data){
        console.log(data.status);
        if(data.status == 422){
          $("#error_notice").css("visibility","visible");
        }
      }
    });
  }
  
  $("#signin_btn").click(function(){
    signin();
    return false;
  });
  $("#password").keydown(function(event) {
    var code = event.which;
    if (code == 13) {
      signin();
    }
  });

});