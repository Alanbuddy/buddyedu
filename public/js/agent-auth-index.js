$(document).ready(function(){
  function search(){
    var value = $("#search-input").val();
    location.href = window.auth_index + "?key=" + value;
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

  $clamp(document.querySelector('.course-description'), {clamp: 3});
});