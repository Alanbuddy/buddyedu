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
        @yield('title') 云课客户端
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
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/js/mobile-notification.js"></script>

<script>

</script>

@yield('script')
</body>
</html>
