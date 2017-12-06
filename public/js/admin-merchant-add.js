$(document).ready(function(){
  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });
  $(".upload-btn").click(function(){
    $(".hidden").click();
  });

  function check_input(name, admin, phone, password){
    if(name == "" || admin == "" || phone == "" || password == ""){
      showMsg("有关键信息没有填写", "center");
      return false;
    }
  }

  $("#submit").click(function(){
    var name = $("#name").val();
    var admin = $("#admin").val();
    var phone = $("#phone").val();
    var password = $("#password").val();
    var ret = check_input(name, admin, phone, password);
    if(ret == false){
      return false;
    }
    $.ajax({
      type: 'post',
      url: window.merchants_store,
      data:{
        name: name,
        adminName: admin,
        phone: phone,
        password: password
      },
      success: function(data){
        console.log(data);
        if(data.success){
          $("#addModal").modal("hide");
          location.href = window.merchants_index;
        }
      }
    });
  });
});