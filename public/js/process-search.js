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

  $(".operation").click(function(){
    var str = $(this).text();
    var merchant_id = $(this).closest('tr').attr("data-id");
    if(str == "通过"){
      $.ajax({
        type: 'get',
        url: window.approve.replace(/-1/, merchant_id),
        success: function(data){
          console.log(data);
          if (data.success){
            location.href = window.process_search;
          }
        }
      });
    }else if(str == "驳回"){
      $.ajax({
        type: 'get',
        url: window.reject.replace(/-1/, merchant_id),
        success: function(data){
          console.log(data);
          if (data.success){
            location.href = window.process_search;
          }
        }
      });
    }
  });


  $(".approve").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').text();
    var course_name = $(this).siblings('.course-name').text();
    $("#approveModal").modal("show");
    $("#approveModal").find(".approve-title").text('通过"' + merchant_name + '"申请添加"' + course_name + '"课程的申请？');
  });
  $(".close-approve").click(function(){
    $("#approveModal").modal("hide");
  });

  $(".reject").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').text();
    var course_name = $(this).siblings('.course-name').text();
    $("#rejectModal").modal("show");
    $("#rejectModal").find(".reject-title").text('驳回"' + merchant_name + '"申请添加"' + course_name + '"课程的申请？');
  });
  $(".close-reject").click(function(){
    $("#rejectModal").modal("hide");
  });

});