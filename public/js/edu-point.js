$(document).ready(function(){
  $(".tip-parent").each(function(){
    var mapContainer = $(this).find(".tooltip-div").find(".container")[0];
    var location = $(this).attr("data-geo");
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
});