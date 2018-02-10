$(document).ready(function(){
  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#name").val("");
    $("#admin").val("");
    $("#phone").val("");
    $(".add-c").text("添加机构");
    $("#merchant-id").text("");
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
    var mid = $("#merchant-id").text();
    var ret = check_input(name, admin, phone, password);
    var put = "PUT";
    if(ret == false){
      return false;
    }
    if(edit){
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
            edit = false;
            $("#name").val("");
            $("#admin").val("");
            $("#phone").val("");
            $(".add-c").text("添加机构");
            $("#merchant-id").text("");
            $("#addModal").modal("hide");
            location.href = window.merchants_index;
          }
        }
      });
    }else{
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
    }
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

  var edit = false;
  $(".edit").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').find('a').text();
    var admin = $(this).siblings('.admin').text();
    var phone = $(this).siblings('.phone').text();
    var mid = $(this).attr("data-id");
    $("#name").val(merchant_name);
    $("#admin").val(admin);
    $("#phone").val(phone);
    $(".add-c").text("修改机构");
    $("#merchant-id").text(mid);
    $("#addModal").modal("show");
    edit = true;
  });
});