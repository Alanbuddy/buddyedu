@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/teacher-show.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title="$merchant->name >"
    %span.f16a.title 授课老师 >
    %span.f16a.title="$teacher->name"

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 基础信息

  .desc-div
    .name-money
      .name-div.clearfix
        %img.icon{src: "/icon/bird.png"}
        .teacher
          .name.f24b="$teacher->name"
          .teacher-title.f12a.mt16=@$teacher->extra?json_decode($teacher->extra)->title:''
      .money-div
        %span.f24c="$teacher->phone"
    .info-div.f14d
      .item-div
        .pdiv
          %span 毕业院校：
          %span=@$teacher->extra?json_decode($teacher->extra)->school:''
        .pdiv
          %span 老师性别：
          %span=$teacher->gender=='male'?'男':'女'
        .pdiv
          %span 身份证号：
          %span=@$teacher->extra?json_decode($teacher->extra)->id:''
      .item-div
        .pdiv
          %span 老师年龄：
          %span=$teacher->birthday?date('Y')-date('Y',strtotime($teacher->birthday)).'岁':''
        .pdiv
          %span 老师教龄：
          %span 10年
        .pdiv
          %span 资格证号：
          %span=@$teacher->extra?json_decode($teacher->extra)->certificate_id:''
      .p-div
        %span 老师简介：
        %span=@$teacher->extra?json_decode($teacher->extra)->introduction:''
      .p-div
        %span.left-span 老师简历：
        %span.right-span=@$teacher->extra?json_decode($teacher->extra)->cv:''
  
@endsection

@section('script')


@endsection