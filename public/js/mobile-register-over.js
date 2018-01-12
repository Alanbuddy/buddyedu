$(document).ready(function(){
  $("#next_btn").click(function(){
    var schedule_id = $(this).attr("data-id");
    location.href = window.register_end.replace(/-1/, schedule_id);
  });
});