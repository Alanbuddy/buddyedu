@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mobile-course-list.css') }}">
  
@endsection

@section('content')
.desc-div
  %p.f20.fb.title 北京市北京市
  .items-div
    %a.item-div.clearfix{href: "#"}
      .img-div.fl
        %img.course-icon{src: '/icon/bird.png'}
      .course-div.fr
        .title-div.clearfix
          .caption-div.fl
            %span.f14.fb.caption 动物园
            %span.status.f12 可报
          %p.course-price.fr.f14 ￥1600
        .time-div
          %img.icon{src: '/icon/mobile/timemini.png'}
          %span.f12.text-color 日期格式北京市某一街道的详细地址北京市某一街道的
        .address-div
          %img.icon{src: '/icon/mobile/locationmini.png'}
          %span.f12.text-color 北京市某一街道的详细地址北京市某一街道的详细地址

@endsection

@section('script')

@endsection