$(document).ready(function(){
  $("#next_btn").click(function(){
    var name = $("#name").val().trim();
    var gender = $("#gender").val();
    var birthday = $("#birthday").val();
    $.ajax({
      type: 'post',
      url: window.user_info,
      data: {
        name: name,
        gender: gender,
        birthday: birthday,
        _token: window.token
      },
      success: function(data){
        if(data.success){
          location.href = window.register_end;
        }
      }
    });
  });
});