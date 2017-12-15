$(document).ready(function(){
  $(".tip-parent").hover(function(){
    $(this).find(".tooltip-div").show();
  },function(){
    $(this).find(".tooltip-div").hide();
  });
  $(".tooltip-div").each(function(){
    _this = $(this);
    $(this).find(".close").click(function(){
      _this.hide();
    });
  });
});