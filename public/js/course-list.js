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
  
  $(".display").click(function(){
    var cid = $(this).attr("data-id");
    var status = $(this).text();
    var put = "PUT";
    var _this = $(this);
    if(status == "展示"){
      $.ajax({
        type: 'put',
        url: window.course_display.replace(/-1/, cid),
        data: {
          _method: put,
          hidden: 0
        },
        success: function(data){
          if(data.success){
            _this.text("隐藏");
          }
        }
      });
    }else{
      $.ajax({
        type: 'put',
        url: window.course_display.replace(/-1/, cid),
        data: {
          _method: put,
          hidden: 1
        },
        success: function(data){
          if(data.success){
            _this.text("展示");
          }
        }
      });
    }
  });

});