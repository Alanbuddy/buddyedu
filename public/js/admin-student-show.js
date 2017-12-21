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
    console.log(sid);
    if(!request){
      $.ajax({
        type: 'get',
        // url: window.sign.replace(/-1/, sid),
        url: window.sign.replace(/-1/, 1),
        success: function(data){
          console.log(data);
          for(var i in data){
            var node = render(data[i]);
            node.text(i);
            console.log(node);
            var box = _this.find('.box-div');
            _this.find('.box-div').append(node);
            $.ajax({
              type: 'get',
              // url: window.comment.replace(/-1/, cid),
              url: window.comment.replace(/-1/, 1),
              success: function(data){
                if(data.success){
                  console.log(data.data.content);
                  _this.find(".review").text(data.data.content);
                }
              }
            });
          }
        }
      });
      request = true;
    }
    $(this).find(".tooltip-div").show();
  },function(){
    $(this).find(".tooltip-div").hide();
  });

  $(".close").click(function(){
    $(this).closest('.tooltip-div').hide();
  });

  

});