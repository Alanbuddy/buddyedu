@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 开课申请 >
    %span.f16a.title= $schedule->course->name

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 开课信息

  .desc-div
    .name-money
      .name-div
        %p.f24b= $schedule->course->name 
        %p.f12a.mt16= $schedule->point->name 
      .money-div
        %span.f24c.mr8= $schedule->price ? "￥".$schedule->price : "暂无价格"
        %span.f12a="(".($schedule->course->proportion * 100)."%分成)"
    .info-div.f14d
      .p-div
        %span 授课老师：
        - foreach ($schedule->teachers as $teacher)
          %span.teacher= $teacher->name
      .p-div
        %span 班级人数：
        %span= $schedule->quota
        %span.ml80 课程次数：
        %span= $schedule->course->lessons_count
      .p-div
        %span 上课时间：
        %span= $schedule->begin
      .p-div
        %span 上课地点：
        %span= $schedule->point->name
      .p-div
        %span.left-span 课程介绍：
        %span.right-span= $schedule->course->description
  
@endsection

@section('script')

@endsection