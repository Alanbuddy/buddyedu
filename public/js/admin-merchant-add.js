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
    var name = $("#name").val().trim();
    var admin = $("#admin").val().trim();
    var phone = $("#phone").val().trim();
    var password = $("#password").val().trim();
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
        password: password,
        _token: window.token
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

  function search(){
    var value = $("#search-input").val();
    location.href = window.merchants_index + "?key=" + value;
  }
    
  $("#search-btn").click(function(){
    search();
  });

  $("#search-input").keydown(function(event){
    var code = event.which;
    if (code == 13){
      search();
    }
  });
});