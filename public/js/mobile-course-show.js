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
          if (res.err_msg == 'get_brand_wcpay_request:ok') {
              location.href = window.pay_finish;
          } // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。

      });
  }


  $("#edit_btn").click(function(){
    location.href = window.user_phone;
  });

  var storage = window.localStorage;
  storage.schedule_id = $(".schedule-id").text();
});