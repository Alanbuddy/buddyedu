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
  });
});