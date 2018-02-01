@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mobile-edu-point.css') }}">
:javascript
  window.point = "#{route('point.nearby')}"
@endsection

@section('content')
.desc-div
  %p.f20.fb.title 附近的教学点
  .location-map.mb60#container
  .item-div.text-color
    .item.clearfix.mb60
      %p.f18.fl.fb 1
      .point-div
        .point-caption.f18.fb 教学点名称教学点名称教学点名称教学点名称教学点名称教学点名称
        .content-span.f14
          %span 联系方式:
          %span 132444444444
        .content-span.f14
          %span 详细地址:
          %span 北京市朝阳区安立路
        %span.distance.f14 2.1km

@endsection

@section('script')
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script src= "/js/mobile-edu-point.js"></script>
@endsection