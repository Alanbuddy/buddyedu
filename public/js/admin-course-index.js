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
        $(".course-icon-path").text(res.data.path);
	      $(".course-icon-name").text(res.data.name);
        $(".upload-btn").hide();
        $(".icon-name").show();
        showMsg("图片上传成功", "center");
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

  function check_input(name, guide_price, proportion, icon, lessons_count, description){
    if(name == "" || guide_price == "" || proportion == "" || icon == "" || lessons_count == "" || description == ""){
      showMsg("有关键信息没有填写", "center");
      return false;
    }
  }

  $("#submit").click(function(){
    var name = $("#name").val().trim();
    var guide_price = $("#guide-price").val();
    var proportion = parseFloat($("#auth-price").val());
    var icon = $(".course-icon-path").text();
    var lessons_count = $("#length").val().trim();
    var url = $("#web").val().trim();
    var description = $("#profile").val().trim();
    var detail = editor.txt.html();
    var ret = check_input(name,  guide_price, proportion, icon, lessons_count, description);
    if(ret == false) {
      return false;
    }

    var course_info = false;
    $("#edit-area .w-e-text ").last().find('p').each(function(){
      if($(this).text()!=''){
        course_info =  true; 
      }
    });
    if(course_info == false){
      showMsg("详细介绍没有填写", "center");
      return false;
    }

    $.ajax({
      type: 'post',
      url: window.courses_store,
      data: {
        name: name,
        guide_price: guide_price,
        proportion: proportion,
        icon: icon,
        lessons_count: lessons_count,
        url: url,
        description: description,
        detail: detail,
        _token: window.token
      },
      success: function(data){
        if(data.success){
          $("#addModal").modal("hide");
          location.href = window.courses_index;
        }
      }

    });
  });
  
  function search(){
    var value = $("#search-input").val();
    location.href = window.courses_index + "?key=" + value;
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


  $(".icon-name").click(function(){
    $(".upload-btn").click();
  });

  $(".delete-icon").click(function(){
    $(".upload-btn").show();
    $(".icon-name").hide();
  });

  $clamp(document.querySelector('.course-description'), {clamp: 3});
});