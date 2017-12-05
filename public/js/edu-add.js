$(document).ready(function(){
  $(".add-icon").click(function(){
    $("#addModal").modal("show");
  });
  $(".close").click(function(){
    $("#addModal").modal("hide");
  });
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
    var center = new qq.maps.LatLng(39.87601941962116, 116.43310546875);
    map = new qq.maps.Map(document.getElementById('container'),{
      center: center,
      zoom: 12
    });
    marker = new qq.maps.Marker({
      map: map,
      position:map.getCenter()
    });
    geocoder = new qq.maps.Geocoder();
  }
  init();

  function codeAddress(){
    var province = $("#province").val();
    var city = $("#city").val();
    var county = $("#county").val();
    var street = $("#street").val();
    address = province + city + county + street;
    console.log(address);
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
      
  }
  $('.get-location').click(function(){
    codeAddress();
  });

  $("#submit").click(function(){
    var name = $("#edu-name").val();
    var area = $("#edu-area").val();
    var admin = $("#edu-admin").val();
    var contact = $("#edu-phone").val();
    var province = $("#province").val();
    var city = $("#city").val();
    var county = $("#county").val();
    var street = $("#street").val();
    var merchant_id = "11";
    if(address == null){
      showMsg("没有选择省市区", "center");
    }

    $.ajax({
      type: 'post',
      url: window.points_store,
      data: {
        admin: admin,
        contact: contact,
        area: area,
        address: street,
        province: province,
        city: city,
        county: county,
        merchant_id: merchant_id,
        geolocation: [lat, lng],
        _token: window.token
      },
      success: function(data){
        if(data.success){
          location.href = window.points_index;
        }
      }
    });
  });
});
