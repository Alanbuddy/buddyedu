@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mobile-edu-point.css') }}">
@endsection

@section('content')
.desc-div
  %p.f20.fb.title 附近的教学点
  .location-map.mb60#container
  .item-div
    .item
      %p.f18.caption-color 1
      .point-div
        .point-caption.caption-color.f18 教学点名称教学点名称教学点名称教学点名称教学点名称教学点名称
@endsection

@section('script')
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script src= "/js/mobile-edu-point.js"></script>
@endsection