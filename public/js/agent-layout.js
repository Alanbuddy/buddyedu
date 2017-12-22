$(document).ready(function(){
	$('.title-icon').click(function(){
    history.back();
  });

  var cur_url = window.location.href;
  $(".sidebar ul li a").each(function(){
    var url = $(this).attr("href");
    if(cur_url.indexOf(url) != -1){
      $(this).removeClass('a-item').addClass('active_li');
      var src = $(this).find('img').attr("src").replace(/A/, "B");
      $(this).find("img").attr("src", src);
    }
    if(cur_url.indexOf("point-applications") != -1 || cur_url.indexOf("schedule-applications") != -1){
      $("#process_a").removeClass('a-item').addClass('active_li');
      var src1 = $("#process_a").find('img').attr("src").replace(/A/, "B");
      $("#process_a").find("img").attr("src", src1);
    }
  });

  $(".logout").click(function(){
    console.log(window.logout);
    $.ajax({
      type: 'post',
      url: window.logout,
      data: {_token: window.token},
      success: function(data){
        if(data.success){
          location.href = window.login;
        }
      }
    });
  });
    
});