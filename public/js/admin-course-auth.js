$(document).ready(function(){
  var cid = null;
  $(".cancel-course").click(function(){
    $("#revokeModal").modal("show");
    cid = $(this).closest('.add-div').siblings(".course-name").attr("data-id");
    console.log(cid);
  });

  $(".close").click(function(){
    $("#revokeModal").modal("hide");
  });

  $("#submit").click(function(){
    $.ajax({
      type: 'get',
      url: window.course_revoke.replace(/-1/, cid),
      success: function(data){
        if(data.success){
          location.href = window.course_list;
        }
      }
    });
  });

});