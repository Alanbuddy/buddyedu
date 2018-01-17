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
    var geo = $(".point-location").text();
    var location = geo.slice(1, geo.length -1).split(",");
    var center = new qq.maps.LatLng(location[0], location[1]);
    map = new qq.maps.Map(document.getElementById('container'),{
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
  init();

  var order = null;
  var signPackage = null;

  $("#end_btn").click(function(){
    $.ajax({
      type: 'post',
      url: window.course_pay,
      data: {
        _token: window.token
      },
      success: function(resp){
        if(resp.success){
          signPackage = resp.data;
          order=resp.data.order;
          jsBrage();
        }else{
          if(resp.message == "已经加入课程"){
            showMsg("您已经加入课程", "center");
            return false;
          }
          if(resp.message == "课程学员已满"){
            showMsg("课程学员已满", "center");
            return false;
          }
        }
      }
    });
  });

  var person_phone = $(".person-phone").text();
  function jsBrage() {
      if (typeof WeixinJSBridge == 'undefined') {
          if (document.addEventListener) {
              document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
          } else if (document.attachEvent) {
              document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
              document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
          }
      } else {
          onBridgeReady();
      }
  }
  function onBridgeReady() {
      // alert('signPackage.timeStamp='+signPackage.timeStamp);
      WeixinJSBridge.invoke('getBrandWCPayRequest', {
          'appId': ''+signPackage.appId,
          'timeStamp': ''+signPackage.timeStamp,
          'nonceStr': ''+signPackage.nonceStr,
          'package': ''+signPackage.package,
          'signType': 'MD5', //微信签名方式：
          'paySign': ''+signPackage.sign,
      }, function (res) {
          if (res.err_msg == 'get_brand_wcpay_request:ok' && person_phone == "未注册") {
            location.href = window.user_phone;
          }else if(res.err_msg == 'get_brand_wcpay_request:ok' && person_phone != "未注册") {
            location.href = window.pay_finish;
          }
      });
  }


  $("#edit_btn").click(function(){
    location.href = window.user_phone;
  });

  $("#review_btn").click(function(){
    $("#reviewModal").modal("show");
  });

  $(".close").click(function(){
    $("#reviewModal").modal("hide");
    $(".review-div").val("");
  });

  $("#submit").click(function(){
    var comment = $(".review-div").val();
    var schedule_id = $(".schedule-id").text();
    $.ajax({
      type: 'post',
      url: window.review,
      data: {
        content: comment,
        schedule_id: schedule_id,
        _token: window.token
      },
      success: function(data){
        if(data.success){
          $("#reviewModal").modal("hide");
          showMsg("成功提交评价", "center");
          setTimeout(function(){
            location.href = window.landing;
          }, 1000);
        }
      }
    });
  });
});