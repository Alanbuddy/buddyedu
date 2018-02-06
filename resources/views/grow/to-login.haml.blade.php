@extends('layout.grow')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/grow-record.css') }}">
@endsection

@section('content')
.notice-div.f14.color1
  %span 想记录您宝宝的每日成长数据？立即前往
  %a.to-login 登录/注册
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
@endsection
@section('foot-div')
.footer-div
  %button.btn.click-btn.f16#log_btn{type: "button"} 登录/注册
@endsection
@section('script')
<script src= ""></script>
@endsection