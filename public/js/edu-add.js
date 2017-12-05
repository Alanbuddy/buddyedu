$(document).ready(function(){
  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  function init() {
    var center = new qq.maps.LatLng(39.87601941962116, 116.43310546875);
    var map = new qq.maps.Map(document.getElementById('container'),{
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
