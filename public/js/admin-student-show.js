$(document).ready(function(){
  var request = false;

  var temp = `<div class="box-div">
                <div class="box gray-box">1</div>
              </div>`;


  $(".tip-parent").hover(function(){
    var sid = $(this).attr("data-id");
    console.log(sid);
    if(!request){
      $.ajax({
        type: 'get',
        url: window.sign.replace(/-1/, sid),
        success: function(data){
          console.log(data);
          var len = data.length;
          for(i=0;i<len;i++){

          }
        }
      });




      $(this).find(".tooltip-div").show();

    }
  },function(){
    $(this).find(".tooltip-div").hide();
  });

  $(".close").click(function(){
    $(this).closest('.tooltip-div').hide();
  });

  

});