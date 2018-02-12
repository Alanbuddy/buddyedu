$(document).ready(function(){
  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  var E = window.wangEditor;
  var editor = new E('#edit-area');
  editor.customConfig.uploadImgParams = {
      _token: window.token,
      editor: "1"
  };
  editor.customConfig.uploadFileName = 'file';
  editor.customConfig.uploadImgServer = window.fileUpload;
  editor.customConfig.showLinkImg = false;
  editor.customConfig.menus = [
        'head',
        'image'
     ];
  editor.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  };
  editor.customConfig.uploadImgTimeout = 3600000;
  editor.create();

  function search(){
    var value = $("#search-input").val();
    location.href = window.notice_index + "?key=" + value;
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

  $("#submit").click(function(){
    var title = $("#title").val().trim();
    var content = editor.txt.html();
    console.log(content);
    var content_info = false;
    $("#edit-area .w-e-text ").last().find('p').each(function(){
      if($(this).text()!=''){
        content_info =  true; 
      }
    });
    if(content_info == false && title == ""){
      showMsg("有关键内容没有填写", "center");
      return false;
    }

    $.ajax({
      type: 'post',
      url: window.notice_store,
      data: {
        title: title,
        content: content,
        _token: window.token
      },
      success: function(data){
        if(data.success){
          $("#addModal").modal("hide");
          location.href = window.notice_index;
        }
      }
    });
  });

  $("#delete").click(function(){
    var nid = $(this).attr("data-id");
    var destroy = "DELETE";
    var _this = $(this);
    $.ajax({
      type: 'post',
      url: window.notice_delete.replace(/-1/, nid),
      data: {
        _method: destroy,
        _token: window.token
      },
      success: function(data){
        if(data.success){
          _this.closest('.item').remove();
        }
      }
    });
  });
});