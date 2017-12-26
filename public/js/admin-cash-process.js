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

  $(".cash-end").click(function(){
    var merchant_name = $(this).siblings('.merchant-name').text();
    var cash_num = $(this).siblings('.cash-num').text();
    var application_id = $(this).closest('tr').attr("data-id");
    $("#addModal").modal("show");
    $("#addModal").find(".cash-title").text('机构"' + merchant_name + '"的"' + cash_num + '"提现申请已处理?');
    $("#addModal").find(".application-id").text(application_id);
  });

  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  $("#cancel").click(function(){
    $("#addModal").modal("hide");
  });
});