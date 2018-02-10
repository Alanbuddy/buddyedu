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
        if(data.success){
          $("#addModal").modal("hide");
          location.href = window.merchants_index;
        }
      },
      error: function(){
        showMsg("该号码已被占用，请更换号码", "center");
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

  $(".edit").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').find('a').text();
    var admin = $(this).siblings('.admin').text();
    var phone = $(this).siblings('.phone').text();
    var mid = $(this).attr("data-id");
    $("#edit-name").val(merchant_name);
    $("#edit-admin").val(admin);
    $("#edit-phone").val(phone);
    $("#merchant-id").text(mid);
    $("#editModal").modal("show");
  });

  $(".edit-close").click(function(){
    $(".password-con").hide();
    $("#editModal").modal("hide");
  });

  $("#confirm").click(function(){
    var name = $("#edit-name").val().trim();
    var admin = $("#edit-admin").val().trim();
    var phone = $("#edit-phone").val().trim();
    var password = $("#edit-password").val().trim();
    var mid = $("#merchant-id").text();
    var put = "PUT";
    $.ajax({
      type: 'put',
      url: window.merchant_update.replace(/-1/, mid),
      data:{
        name: name,
        adminName: admin,
        phone: phone,
        password: password,
        _token: window.token,
        _method: put
      },
      success: function(data){
        console.log(data);
        if(data.success){
          $("#editModal").modal("hide");
          location.href = window.merchants_index;
        }
      }
    });
  });

  $("#edit-phone").keyup(function(){
    $(".password-con").show();
  });
});