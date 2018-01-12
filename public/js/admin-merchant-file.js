
// var bytesPerPiece = 1024 * 1024 / 2; // 每个文件切片大小定为1MB .
// var totalPieces;
// //发送请求
// function upload() {
//   var blob = document.querySelector("#file").files[0];
//   var start = 0;
//   var end;
//   var index = 0;
//   var filesize = blob.size;
//   var filename = blob.name;

//   //计算文件切片总数
//   totalPieces = Math.ceil(filesize / bytesPerPiece);
  
//   while(start < filesize) {
//     end = start + bytesPerPiece;
//     if(end > filesize) {
//         end = filesize;
//     }

//     var chunk = blob.slice(start,end);
//     var sliceIndex= blob.name + index;
//     var formData = new FormData();
//     formData.append("file", chunk, filename);
//     formData.append("file_id", $(".file-id").text());
//     $.ajax({
//         url: window.file_upload,
//         type: 'post',
//         cache: false,
//         data: formData,
//         processData: false,
//         contentType: false,
//     }).done(function(res){ 
      
//     }).fail(function(res) {

//     });
//     start = end;
//     index++;
//   }
//   if (index == totalPieces){
//     showMsg("文件上传成功", "center");
//     setTimeout(function(){location.href = window.file_list;}, 2000);
//   }else{
//     showMsg("文件上传失败", "center");
//   }
// }



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

  $(".add-file-icon").click(function(){
    $("#addFileModal").modal("show");
  });

  $(".close-file").click(function(){
    $("#addFileModal").modal("hide");
  });

  $("#addFileModal").on('shown.bs.modal', function (){
    uploader.refresh();
  });
  


  var $list = $("#thelist");
  var $btn = $('#ctlBtn');
  var uploader = WebUploader.create({

      // swf文件路径
    swf: '/js/Uploader.swf',

    // 文件接收服务端。
    server: window.file_upload,

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker',

    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
    resize: false,
    auto: false,
    dnd: "#thelist",
    disableGlobalDnd: true,
    percentages: {},
    fileNumLimit: 1,   //限制只能上传一个文件

    chunked: true,     //是否要分片处理大文件上传
    chunkSize: 0.5*1024*1024    //分片上传，每片1M，默认是5M
  });

  uploader.options.formData = {
      _token: window.token
    };

  var name = null;

  uploader.on( 'fileQueued', function( file ) {
    $list.append( '<div id="' + file.id + '" class="item">' +
        '<span class="info f14d">' + file.name + '</span>' +
        '<p class="state f14d">等待上传...</p>' +
        '<button class="delete_btn">删除</button>' +
    '</div>' );
    name = file.name;
  });

  uploader.on( 'uploadProgress', function( file, percentage ) {  
    $('.item').find('p.state').text('上传中 '+Math.round(percentage * 100) + '%');
    var $li = $( '#'+file.id ),
      $percent = $("#thelist").find('.progress .progress-bar');

    // 避免重复创建
    if ( !$percent.length ) {
      $percent = $('<div class="progress progress-striped active">' +
        '<div class="progress-bar" role="progressbar" style="width: 0%">' +
        '</div>' +
      '</div>').appendTo($("#thelist")).find('.progress-bar');
    }
    $percent.css( 'width', percentage * 100 + '%' );
  }); 

  uploader.on( 'uploadSuccess', function( file, percentage ) {
    $( '#'+file.id ).find('p.state').text('已上传' + '100%');
    $(".progress").fadeOut(1000);
    var video_file = uploader.getFiles();
    var video_size = video_file[0].size;
    var chunksize = 0.5*1024*1024;
    var chunks = Math.ceil(video_size / chunksize);
    var file_id = $(".file-id").text();
    console.log(chunks);
    $.ajax({
      type: 'post',
      url: window.merge,
      data: {
        _token: window.token,
        name: name,
        count: chunks,
        file_id: file_id
      },
      success: function(data){
        console.log(data);
        if(data.success){
          // $(".video-id").text(data.data.id);
        }
      }
      });
  });

  uploader.on( 'uploadError', function( file ) {
    $( '#'+file.id ).find('p.state').text('上传失败');
  });

  uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').fadeOut();
  });

  $btn.click(function(){
    $.ajax({
      type: 'get',
      url: window.file_init,
      success: function(data){
        console.log(data);
        if(data.success){
          $(".file-id").text(data.data.user_id);
          uploader.options.formData = {
              file_id: data.data.user_id,
              _token: window.token
            };
          uploader.upload();
        }
      }
    });
  });


  $("#thelist").on("click", ".delete_btn", function(){  
    uploader.removeFile($(this).closest(".item").attr("id"));    //从上传文件列表中删除  
    $(".progress").remove();
    $(this).closest(".item").remove();   //从上传列表dom中删除  
  }); 

});