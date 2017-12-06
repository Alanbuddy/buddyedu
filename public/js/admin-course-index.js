function upload(obj){
	var formData = new FormData();
	formData.append('file', $(".hidden")[0].files[0]);
	formData.append('_token', window.token);
	$.ajax({
	  url: window.fileUpload,
	  type: 'post',
	  data: formData,
	  cache: false,
	  processData: false,
	  contentType: false
	  }).done(function(res){
	    if (res.success){
	      $(".course-icon-path").text(res.path);
	      console.log(res.path);
	    }
	  }).fail(function(res){
      showMsg("图片上传失败", "center");
	  });
}
$(document).ready(function(){
  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });
  $(".upload-btn").click(function(){
  	$(".hidden").click();
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

  
});