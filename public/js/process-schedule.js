$(document).ready(function(){
  function search(){
    var value = $("#search-input").val();
    location.href = window.search + "?key=" + value;
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


  $(".approve").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').text();
    var course_name = $(this).siblings('.course-name').text();
    $("#approveModal").modal("show");
    $("#approveModal").find(".approve-title").text('通过"' + merchant_name + '"申请开设"' + course_name + '"课程的申请？');
  });
  $(".close-approve").click(function(){
    $("#approveModal").modal("hide");
  });

  $(".reject").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').text();
    var course_name = $(this).siblings('.course-name').text();
    $("#rejectModal").modal("show");
    $("#rejectModal").find(".reject-title").text('驳回"' + merchant_name + '"申请开设"' + course_name + '"课程的申请？');
  });
  $(".close-reject").click(function(){
    $("#rejectModal").modal("hide");
  });
});