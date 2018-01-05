$(document).ready(function(){
  function search(){
    var value = $("#search-input").val();
    location.href = window.process_search + "?key=" + value;
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

  $(".approve-btn").click(function(){
    var application_id = $(this).siblings('.application-id').text();
    var remark = $("#operation-info").val().trim();
    $.ajax({
      type: 'get',
      url: window.approve.replace(/-1/, application_id),
      data: {
        remark: remark
      },
      success: function(data){
        if (data.success){
          location.href = window.process_search;
        }
      }
    });
  });

  $(".reject-btn").click(function(){
    var application_id = $(this).siblings('.application-id').text();
    var remark = $("#operation-info").val().trim();
    $.ajax({
      type: 'get',
      url: window.reject.replace(/-1/, application_id),
      data: {
        remark: remark
      },
      success: function(data){
        if (data.success){
          location.href = window.process_search;
        }
      }
    });
  });

  $(".approve").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').text();
    var course_name = $(this).siblings('.course-name').text();
    var application_id = $(this).closest('tr').attr("data-id");
    $("#approveModal").modal("show");
    $("#approveModal").find(".approve-title").text('通过"' + merchant_name + '"申请添加"' + course_name + '"课程的申请？');
    $("#approveModal").find(".application-id").text(application_id);
  });
  $(".close-approve").click(function(){
    $("#approveModal").modal("hide");
  });

  $(".reject").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').text();
    var course_name = $(this).siblings('.course-name').text();
    var application_id = $(this).closest('tr').attr("data-id");
    $("#rejectModal").modal("show");
    $("#rejectModal").find(".reject-title").text('驳回"' + merchant_name + '"申请添加"' + course_name + '"课程的申请？');
    $("#rejectModal").find(".application-id").text(application_id);
  });
  $(".close-reject").click(function(){
    $("#rejectModal").modal("hide");
  });

});