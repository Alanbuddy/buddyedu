function upload(obj){
  var formData = new FormData();
  formData.append('file', $(".hidden")[0].files[0]);
  formData.append('_token', window.token);
  $.ajax({
    url: window.fileUpload,
    type: 'post',
    data: formData,
    cache: false,
    processData: false,
    contentType: false
    }).done(function(res){
      if (res.success){
        $(".course-icon-path").text(res.data.path);
        showMsg("图片上传成功", "center");
      }
    }).fail(function(res){
      showMsg("图片上传失败", "center");
    });
}

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
  $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange : '-70:+10'
      });
  $( "#datepicker" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
  $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

  function check_input(name, birthday, icon, gender, certificate_id, id, school, desc, profile){
    if(name == "" || birthday == "" || icon == "" || gender == "" || certificate_id == "" || id == "" || school == "" || desc == "" || profile == ""){
      showMsg("有关键信息没有填写", "center");
      return false;
    }
  }

  $("#submit").click(function(){
    var name = $("#name").val().trim();
    var phone = $("#phone").val().trim();
    var merchant_id = $("#merchant-id").attr("data-merchant");
    var title = $("#title").val();
    var icon = $(".course-icon-path").text();
    var birthday = $("#datepicker").val();
    var gender = $("#gender").val();
    var certificate_id = $("#certificate").val().trim();
    var id = $("#id").val().trim();
    var school = $("#school").val().trim();
    var desc = $("#desc").val().trim();
    var profile = $("#profile").val().trim();
    var ret = check_input(name, birthday, icon, gender, certificate_id, id, school, desc, profile);
    if(ret == false){
      return false;
    }
    var mobile_retval = $.regex.isMobile(phone);
    if (mobile_retval == false) {
      showMsg("手机号错误", "center");
      return false;
    }
    $.ajax({
      type: 'post',
      url: window.teachers_store,
      data: {
        name: name,
        phone: phone,
        merchant_id: merchant_id,
        title: title,
        avatar: icon,
        gender: gender,
        birthday: birthday,
        certificate_id: certificate_id,
        id: id,
        school: school,
        introduction: desc,
        cv: profile,
        _token: window.token
      },
      success: function(data){
        if(data.success){
          $("#addModal").modal("hide");
          location.href = window.teachers_index;
        }
      }
    });
  });

  function search(){
    var value = $("#search-input").val();
    location.href = window.teachers_index + "?key=" + value;
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