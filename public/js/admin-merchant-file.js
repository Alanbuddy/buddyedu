
var bytesPerPiece = 1024 * 1024 / 2; // 每个文件切片大小定为1MB .
var totalPieces;
//发送请求
function upload() {
  var blob = document.querySelector("#file").files[0];
  var start = 0;
  var end;
  var index = 0;
  var filesize = blob.size;
  var filename = blob.name;

  //计算文件切片总数
  totalPieces = Math.ceil(filesize / bytesPerPiece);
  while(start < filesize) {
    end = start + bytesPerPiece;
    if(end > filesize) {
        end = filesize;
    }

    var chunk = blob.slice(start,end);//切割文件    
    console.log(chunk);
    var sliceIndex= blob.name + index;
    var formData = new FormData();
    formData.append("file", chunk, filename);
    $.ajax({
        url: window.file_upload,
        type: 'post',
        cache: false,
        data: formData,
        processData: false,
        contentType: false,
    }).done(function(res){ 
      
    }).fail(function(res) {

    });
    start = end;
    index++;
  }
  if (index == totalPieces){
    showMsg("文件上传成功", "center");
    setTimeout(function(){location.href = window.file_list;}, 2000);
  }else{
    showMsg("文件上传失败", "center");
  }
}

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
    $(".hidden").click();
  });
});