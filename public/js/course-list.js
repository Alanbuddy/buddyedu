$(document).ready(function(){
  function search(){
    var value = $("#search-input").val();
    location.href = window.course_search + "?key=" + value;
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
  
  $(".dipslay").click(function(){
    var cid = $(this).attr("data-id");
    // var _this = $(this);
    $.ajax({
      type: 'post',
      url: window.course_display.replace(/-1/, cid),
      data: {

      },
      success: function(data){
        if(data.success){
          $(this).text("隐藏");
        }
      }
    });
  });

});