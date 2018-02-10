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

  function map_init() {
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
  map_init();

  function codeAddress(){
    var province = $("#province").val();
    var city = $("#city").val();
    var county = $("#county").val();
    var street = $("#street").val();
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
    codeAddress();
  });

  $("#confirm").click(function(){
    var name = $("#edu-name").val();
    var area = $("#edu-area").val();
    var admin = $("#edu-admin").val();
    var contact = $("#edu-phone").val();
    var province = $("#province").val();
    var city = $("#city").val();
    var county = $("#county").val();
    var street = $("#street").val();
    var location = JSON.stringify([lat, lng]);
    var merchant_id = $("#merchant-id").attr("data-merchant");
    var remark = $("#remark").val().trim();
    if(address == null){
      showMsg("没有填写详细地址", "center");
      return false;
    }else{
      $.ajax({
        type: 'post',
        url: window.points_store,
        data: {
          name: name,
          admin: admin,
          contact: contact,
          area: area,
          address: street,
          province: province,
          city: city,
          county: county,
          merchant_id: merchant_id,
          geolocation: location,
          remark: remark,
          _token: window.token
        },
        success: function(data){
          if(data.success){
            $("#addModal").modal("hide");
            window.location.assign(window.points_index);
          }
        }
      });
    }
  });

  function search(){
    var value = $("#search-input").val();
    location.href = window.points_index + "?key=" + value;
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

  $(".edit").click(function(){
    $("#edu-name").val($(this).siblings('.name').text());
    $("#edu-area").val($(this).siblings('.area').text());
    $("#edu-admin").val($(this).siblings('.admin').text());
    $("#edu-phone").val($(this).siblings('.contact').text());
    $("#province").val($(this).siblings('.province').text());
    $("#city").val($(this).siblings('.city').text());
    $("#county").val($(this).siblings('.county').text());
    $("#street").val($(this).siblings('.tip-parent').find('.address').text());
    $("#addModal").modal("show");
  });
});
