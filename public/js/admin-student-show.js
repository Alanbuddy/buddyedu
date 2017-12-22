$(document).ready(function(){

  var temp = `<div class="box">1</div>`;
  var template = $(temp);

  function render(item){
    if(item == true){
      template.removeClass().addClass('box green-box');
    }else if(item == false){
      template.removeClass().addClass('box red-box');
    }else{
      template.removeClass().addClass('box gray-box');
    }
    return template.clone(true);
  }

  var request = false;
  $(".tip-parent").hover(function(){
    var _this = $(this);
    var sid = $(this).attr("data-id");
    var cid = $(this).attr("data-cid");
    $(this).find('.class-state').attr('src', "/icon/class2.png");
    if(!request){
      $.ajax({
        type: 'get',
        url: window.sign.replace(/-1/, sid),
        success: function(data){
          for(var i in data){
            var node = render(data[i]);
            node.text(i);
            var box = _this.find('.box-div');
            _this.find('.box-div').append(node);
          }
        }
      });
      $.ajax({
        type: 'get',
        url: window.comment.replace(/-1/, cid),
        success: function(data){
          if(data.success){
            if(data.data){
              _this.find(".review").text(data.data.content);
            }else{
              _this.find(".review").text("暂无评论");
            }
          }
        }
      });
      request = true;
    }
    $(this).find(".tooltip-div").show();
  },function(){
    $(this).find('.class-state').attr('src', "/icon/class1.png");
    $(this).find(".tooltip-div").hide();
  });

  $(".close").click(function(){
    $(this).closest('.tooltip-div').hide();
  });

  

});