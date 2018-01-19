$(document).ready(function(){
  var maker = null;
  var map = null;
  var geocoder = null;
  var address = null;
  var lat = null;
  var lng = null;
  var anchor = new qq.maps.Point(6, 6),
      size = new qq.maps.Size(24, 24),
      origin = new qq.maps.Point(0, 0),
      icon = new qq.maps.MarkerImage('/icon/tick.png', size, origin, anchor);

  function init() {
    // var geo = $(".point-location").text();
    // var location = geo.slice(1, geo.length -1).split(",");
    // var center = new qq.maps.LatLng(location[0], location[1]);
    map = new qq.maps.Map(document.getElementById('container'),{
      // center: center,
      zoom: 12
    });
    marker = new qq.maps.Marker({
      icon: icon,
      map: map,
      // position:map.getCenter()
    });
    geocoder = new qq.maps.Geocoder();
  }
  init();
});