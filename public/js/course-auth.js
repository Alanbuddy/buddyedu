$(document).ready(function(){
  $(document).on('click', ".revoke", function(){
    var merchant_id = $(this).attr("data-id");
    var _this = $(this);
    $.ajax({
      type: 'get',
      url: window.merchant_revoke.replace(/-1/, merchant_id),
      success: function(data){
        if(data.success){
          _this.removeClass('revoke').addClass('approve').text("重新授权");
        }
      }
    });
  });

  $(document).on('click',".approve",function(){
    var merchant_id = $(this).attr("data-id");
    var _this = $(this);
    $.ajax({
      type: 'get',
      url: window.merchant_approve.replace(/-1/, merchant_id),
      success: function(data){
        if(data.success){
          _this.removeClass('approve').addClass('revoke').text("取消授权");
        }
      }
    });
  });
});