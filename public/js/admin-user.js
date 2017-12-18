$(document).ready(function(){
  function search(){
    var value = $("#search-input").val();
    location.href = window.users_search + "?key=" + value;
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

  $(".operation").click(function(){
    var str = $(this).text();
    var data_id = $(this).closest('tr').attr("data-id");
    if(str == "开通"){
      $.ajax({
        type: 'get',
        url: window.enable.replace(/-1/, data_id),
        success: function(data){
          console.log(data);
          if(data.success){
            location.href = window.users_search;
          }
        }
      });
    }else if(str == "禁用"){
      $.ajax({
        type: 'get',
        url: window.disable.replace(/-1/, data_id),
        success: function(data){
          console.log(data);
          if(data.success){
            location.href = window.users_search;
          }
        }
      });
    }
  });
});