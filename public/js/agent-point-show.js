$(document).ready(function(){
  var maker = null;
  var map = null;
  var geocoder = null;
  var address = null;
  var lat = null;
  var lng = null;
  var geolocation = null;
  var new_location = null;

  var anchor = new qq.maps.Point(6, 6),
      size = new qq.maps.Size(24, 24),
      origin = new qq.maps.Point(0, 0),
      icon = new qq.maps.MarkerImage('/icon/tick.png', size, origin, anchor);

  var geo = $("#map").attr("data-geo");
  geolocation = geo;
  var location = geo.slice(1, geo.length -1).split(",");
  function map_init(container, lat, lng) {
    var center = new qq.maps.LatLng(lat, lng);
    map = new qq.maps.Map(document.getElementById(container),{
      center: center,
      zoom: 12
    });
    marker = new qq.maps.Marker({
      icon: icon,
      map: map,
      position:map.getCenter()
    });
    geocoder = new qq.maps.Geocoder();
  }

  map_init('container', location[0], location[1]);

  $("#point-modify").click(function(){
    $(this).hide();
    $(".edit-input").toggle();
    $(".edit").toggle();
    $(".unedit").toggle();
    $("#confirm").toggle();
  });

  function codeAddress(province, city, county, street){
    address = province + city + county + street;
    geocoder.getLocation(address);
    geocoder.setComplete(function(result){
      map.setCenter(result.detail.location);
      if (marker != null){
        marker.setVisible(false);
      }
      lat = result.detail.location.lat;
      lng = result.detail.location.lng;
      marker = new qq.maps.Marker({
        map: map,
        position: result.detail.location
    });
      marker.setIcon(icon);
    });
      
    geocoder.setError(function(){
      alert('出错了，请输入正确的地址！！！');
    });
    return false;
  }

  $('.get-location').click(function(){
    var province = $("#province").val();
    var city = $("#city").val();
    var county = $("#county").val();
    var street = $("#street").val();
    codeAddress(province, city, county, street);
    new_location = true;
  });

  $("#confirm").click(function(){
    var name = $("#edu-name").text();
    var area = $("#edu-area").val();
    var admin = $("#edu-admin").val();
    var contact = $("#edu-phone").val();
    var province = $("#province").val();
    var city = $("#city").val();
    var county = $("#county").val();
    var street = $("#street").val();
    var location = new_location ? JSON.stringify([lat, lng]) : geolocation;
    var remark = $("#remark").val().trim();
    if(remark == ""){
      showMsg("没有填写申请备注", "center");
      return false;
    }else{
      $.ajax({
        type: 'put',
        url: window.point_update,
        data: {
          name: name,
          admin: admin,
          contact: contact,
          area: area,
          address: street,
          province: province,
          city: city,
          county: county,
          geolocation: location,
          remark: remark,
          _token: window.token
        },
        success: function(data){
          if(data.success){
            $("#confirm").hide();
            $("#area").text(area + "m²");
            $("#admin").text(admin);
            $("#contact").text(contact);
            $("#location").text(province + city + county + street);
            $(".edit-input").toggle();
            $(".edit").toggle();
            $(".unedit").toggle();
            $("#point-modify").toggle();
            new_location = false;
          }
        }
      });
    }
  });
  
});