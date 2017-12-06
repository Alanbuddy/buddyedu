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

  $("#submit").click(function(){
    var name = $("#name").val();
    var admin = $("#admin").val();
    var phone = $("#phone").val();
    var password = $("#password").val();
    $.ajax({
      type: 'post',
      url: window.merchants_index,
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