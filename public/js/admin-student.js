$(document).ready(function(){
  function search(){
    var value = $("#search-input").val();
    location.href = window.students_search + "?key=" + value;
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


  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange : '-70:+10'
      });
  $( "#datepicker" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
  $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

  $("#phone").keyup(function(){
    $("#mobile-notice").css("visibility", "hidden");
  });

  $("#submit").click(function(){
    var name = $("#name").val().trim();
    var phone = $("#phone").val().trim();
    var gender = $("#gender").val();
    var birthday = $("#datepicker").val();
    var mobile_retval = $.regex.isMobile(phone);
    if (mobile_retval == false) {
      showMsg("手机号错误", "center");
      return false;
    }else{
      $.ajax({
        type: 'post',
        url: window.students_store,
        data: {
          name: name,
          phone: phone,
          gender: gender,
          birthday: birthday
        },
        success: function(data){
          if(!data.success){
            $("#addModal").modal("hide");
            location.href = window.students_search;
          }else{
            $("#mobile-notice").css("visibility", "visible");
            return false;
          }
        }
      });
    }
  });
});