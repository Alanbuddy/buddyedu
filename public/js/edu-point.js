$(document).ready(function(){
  $(".tip-parent").each(function(){
    var mapContainer = $(this).find(".tooltip-div").find(".container")[0];
    var geo = $(this).attr("data-geo");
    var location = geo.slice(1, geo.length -1).split(",");
    function init() {
      var center = new qq.maps.LatLng(location[0], location[1]);
      var map = new qq.maps.Map(mapContainer,{
          center: center,
          zoom: 12
      });

      var anchor = new qq.maps.Point(6, 6),
          size = new qq.maps.Size(24, 24),
          origin = new qq.maps.Point(0, 0),
          icon = new qq.maps.MarkerImage('/icon/tick.png', size, origin, anchor);
      var marker = new qq.maps.Marker({
          icon: icon,
          map: map,
          position:map.getCenter()
        });
    }
    init();
  });

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

  function search(){
    var value = $("#search-input").val();
    location.href = window.points_search + "?key=" + value;
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

  $(document).on('click', ".revoke", function(){
    var point_id = $(this).attr("data-id");
    var _this = $(this);
    $.ajax({
      type: 'get',
      url: window.point_revoke.replace(/-1/, point_id),
      success: function(data){
        if(data.success){
          _this.removeClass('revoke').addClass('approve').text("重新授权");
        }
      }
    });
  });

  $(document).on('click',".approve",function(){
    var point_id = $(this).attr("data-id");
    var _this = $(this);
    $.ajax({
      type: 'get',
      url: window.point_approve.replace(/-1/, point_id),
      success: function(data){
        if(data.success){
          _this.removeClass('approve').addClass('revoke').text("取消授权");
        }
      }
    });
  });
});