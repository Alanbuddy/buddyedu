@extends('layout.grow')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/grow-record.css') }}">
@endsection

@section('content')
.desc-div
  .head-div
    %p.f16.fb.color1 宝宝的成长历程
    %span.f14.color1 统计数据>
  .item-div
    .date-div.clearfix
      %span.f14.color1.fl 10个月1天
      %span.f12.color2.fr 今天
    .data-div.f14.color3
      %span 身高
      %span 体重
      %span 头围
    .data-div.f14.color3
      %span ? cm
      %span ? kg
      %span ? cm
  .item-div
    .date-div.clearfix
      %span.f14.color1.fl 10个月1天
      %span.f12.color2.fr 昨天
    .data-div.f14.color3
      %span 身高
      %span 体重
      %span 头围
    .data-div.f14.color3
      %span ? cm
      %span ? kg
      %span ? cm
  .item-div
    .date-div.clearfix
      %span.f14.color1.fl 10个月1天
      %span.f12.color2.fr 五天前
    .data-div.f14.color3
      %span 身高
      %span 体重
      %span 头围
    .data-div.f14.color3
      %span ? cm
      %span ? kg
      %span ? cm
  .item-div
    .date-div.clearfix
      %span.f14.color1.fl 10个月1天
      %span.f12.color2.fr 七天前
    .data-div.f14.color3
      %span 身高
      %span 体重
      %span 头围
    .data-div.f14.color3
      %span ? cm
      %span ? kg
      %span ? cm
  .item-div
    .date-div.clearfix
      %span.f14.color1.fl 10个月1天
      %span.f12.color2.fr 2017/12/30
    .data-div.f14.color3
      %span 身高
      %span 体重
      %span 头围
    .data-div.f14.color3
      %span ? cm
      %span ? kg
      %span ? cm
  .item-div
    .date-div.clearfix
      %span.f14.color1.fl 10个月1天
      %span.f12.color2.fr 七天前
    .data-div.f14.color3
      %span 身高
      %span 体重
      %span 头围
    .data-div.f14.color3
      %span ? cm
      %span ? kg
      %span ? cm
  .item-div
    .date-div.clearfix
      %span.f14.color1.fl 10个月1天
      %span.f12.color2.fr 2017/12/30
    .data-div.f14.color3
      %span 身高
      %span 体重
      %span 头围
    .data-div.f14.color3
      %span ? cm
      %span ? kg
      %span ? cm
@endsection
@section('foot-div')
.footer-div
  %button.btn.click-btn.f16#record_btn{type: "button"} 立即记录
@endsection
@section('script')
<script src= ""></script>
@endsection