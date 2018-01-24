<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" , content="telephone=no">
    <meta name="format-detection" , content="email=no">

    <title>
        @yield('title') Buddy云课
    </title>
    <script>
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/mobile-layout.css">
    <link rel="stylesheet" href="/css/mobile-notification.css">

    @yield('css')
    
</head>
<body>
<div>
    @yield('header')
</div>
<div class="wrapper">
@yield('content')

</div>
<div>
    @yield('modal-div')
</div>
<div>
    @yield('foot-div')
</div>

<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/ajax.js"></script>
<script src="/js/regex.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script src="/js/mobile-notification.js"></script>


<script>
    wx.config({
        beta: true,
        debug: false,
        appId: '{{ $signPackage["appId"]}}',
        timestamp: '{{ $signPackage["timestamp"]}}',
        nonceStr: '{{ $signPackage["nonceStr"]}}',
        signature: '{{ $signPackage["signature"]}}',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'onMenuShareTimeline',
            'scanQRCode',
            'hideAllNonBaseMenuItem'
        ]
    });
    wx.ready(function () {
        // 在这里调用 API
        //            wx.hideAllNonBaseMenuItem();
        wx.onMenuShareTimeline({
            title: '', // 分享标题
            link: '', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: '', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
                alert('shared');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
    })

    var appId = "{{config('wechat.mp.app_id')}}";
    var app_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
        + appId
        + "&redirect_uri=http%3a%2f%2f"
        + "cloud.buddyrobots.com/wechat/login&response_type=code&scope=snsapi_userinfo"
        + "&state="+location.href
        + "&connect_redirect=1#wechat_redirect";

    @if(!Auth::check()&&!session()->has('wechat.openid'))
        alert(course_show);
        if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) == 'micromessenger' && !window.course_show) {
            location.href = app_url;
        }
    @endif
</script>

@yield('script')
</body>
</html>
