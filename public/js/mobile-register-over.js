$(document).ready(function(){
  $("#next_btn").click(function(){
    location.href = window.register_end.replace(/-1/, schedule_id);
  });
});