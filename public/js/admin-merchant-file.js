$(document).ready(function(){
  $(".delete").click(function(){
    var fid = $(this).attr("data-id");
    console.log(fid);
    _this = $(this);
    var destroy = "DELETE";
    $.ajax({
      url: window.file_delete.replace(/-1/, fid),
      type: 'post',
      data: {
        _method: destroy,
        _token: window.token
      },
      success: function(data){
        console.log(data);
        if(data.success){
          _this.closest('tr').remove();
        }
      }
    });
  });
});