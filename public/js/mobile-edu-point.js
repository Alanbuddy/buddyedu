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

  function init(lat, lng) {
    var center = new qq.maps.LatLng(lat,lng);
    map = new qq.maps.Map(document.getElementById('container'),{
      center: center,
      zoom: 10
    });
    geocoder = new qq.maps.Geocoder();
  }

  var temp = `
    <div class="item clearfix mb60">
      <p class="f18 fl fb num">1</p>
      <div class="point-div">
        <div class="point-caption f18 fb">教学点名称教学点名称教学点名称教学点名称教学点名称教学点名称</div>
        <div class="content-span f14">
          <span>联系方式:</span>
          <span class='contact'>132444444444</span>
        </div>
        <div class="content-span f14">
          <span>详细地址:</span>
          <span class='address'>北京市朝阳区安立路</span>
        </div>
        <span class="distance f14">2.1km</span>
      </div>
    </div>
  `;
  var template = $(temp);
  function render(index, item){
    template.find('.num').text(index);
    template.find('.point-caption').text(item.name);
    template.find('.contact').text(item.contact);
    template.find('.address').text(item.address);
    template.find('.distance').text((item.distance/1000).toFixed(1) + "km");
    return template.clone(true);
  }
  var node = null;
  $(window).on('location', function(e, l){
    u_latitude = l.latitude;
    u_longitude = l.longitude;
    $.ajax({
      type: 'get',
      url: window.point + "?location=" + [40.001347,116.401764],
      success: function(res){
        init(40.001347,116.401764);
        $.each(res, function(index, value){
          var len = value.geolocation.length;
          var location = value.geolocation.slice(1, len -1).split(",");
          latlngs.push(new qq.maps.LatLng(location[0],location[1]));
          node=render(index +1, value);
          $(".item-div").append(node);
        });
        for(var i = 0;i < latlngs.length; i++) {
          (function(n){
            var marker = new qq.maps.Marker({
              icon: new qq.maps.MarkerImage(icon_arr[n], size, origin, anchor),
              map: map,
              position: latlngs[n]
            });
          })(i);
        }
      }
    });
  });

  
});
