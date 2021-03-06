$(document).ready(function(){
	$('.back-icon').click(function(){
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
    if(cur_url.indexOf("applications/point") != -1 || cur_url.indexOf("applications/schedule") != -1){
      $("#notice-a").removeClass('a-item').addClass('active_li');
      var src1 = $("#notice-a").find('img').attr("src").replace(/A/, "B");
      $("#notice-a").find("img").attr("src", src1);
    }
    if(cur_url.indexOf("group-by-course") != -1 || cur_url.indexOf("withdraw/breakdown") != -1){
      $("#amount-a").removeClass('a-item').addClass('active_li');
      var src2 = $("#amount-a").find('img').attr("src").replace(/A/, "B");
      $("#amount-a").find("img").attr("src", src2);
    }

    if(cur_url.indexOf("teachers") != -1 ){
      $("#teacher-a").removeClass('a-item').addClass('active_li');
      var src3 = $("#teacher-a").find('img').attr("src").replace(/A/, "B");
      $("#teacher-a").find("img").attr("src", src3);
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