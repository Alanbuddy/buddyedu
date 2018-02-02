$(document).ready(function(){
  var u_latitude = null;
  var u_longitude = null;
  var latlngs = [];
  var map = null;
  var geocoder = null;
  var address = null;
  var lat = null;
  var lng = null;
  var icon_arr = ['/icon/mobile/point1.png','/icon/mobile/point2.png','/icon/mobile/point3.png','/icon/mobile/point4.png','/icon/mobile/point5.png',
   '/icon/mobile/point6.png','/icon/mobile/point7.png','/icon/mobile/point8.png','/icon/mobile/point9.png','/icon/mobile/point10.png',];
  var anchor = new qq.maps.Point(6, 6),
      size = new qq.maps.Size(24, 24),
      origin = new qq.maps.Point(0, 0);

  function init() {
    var center = new qq.maps.LatLng(u_latitude,u_longitude);
    map = new qq.maps.Map(document.getElementById('container'),{
      center: center,
      zoom: 10
    });
    geocoder = new qq.maps.Geocoder();
  }
  init();

  $(window).on('location', function(e, l){
    u_latitude = l.latitude;
    u_longitude = l.longitude;
    alert(222);
    alert(u_latitude);
    alert(333);
    alert(u_longitude);
    $.ajax({
      type: 'get',
      url: window.point + "?location=" + [40.001347,116.401764],
      success: function(res){
        $.each(res, function(index, value){
          var len = value.geolocation.length;
          var location = value.geolocation.slice(1, len -1).split(",");
          latlngs.push(new qq.maps.LatLng(location[0],location[1]));
        });
        alert(latlngs);
        for(var i = 0;i < latlngs.length; i++) {
          (function(n){
            var marker = new qq.maps.Marker({
              icon: new qq.maps.MarkerImage('/icon/mobile/point1.png', size, origin, anchor),
              map: map,
              position: latlngs[n]
            });
          })(i);
        }
      }
    });
  });

  
});
