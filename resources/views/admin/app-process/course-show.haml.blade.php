@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 开课申请 >
    %span.f16a.title= $item->course->name

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 开课信息

  .desc-div
    .name-money
      .name-div
        %p.f24b= $item->course->name 
        %p.f12a.mt16= $item->point->name 
      .money-div
        %span.f24c.mr8= $item->price ? "￥".round($item->price/100, 2) : "暂无价格"
        %span.f12a="(".($item->course->proportion * 100)."%分成)"
    .info-div.f14d
      .p-div
        %span 授课老师：
        - foreach ($item->teachers as $teacher)
          %span.teacher= $teacher->name
      .p-div
        %span 班级人数：
        %span= $item->quota
        %span.ml80 课程次数：
        %span= $item->course->lessons_count
      .p-div
        %span 上课时间：
        %span= $item->begin
      .p-div
        %span 上课地点：
        %span= $item->point->name
      .p-div
        %span.left-span 课程介绍：
        %span.right-span= $item->course->description
  
@endsection

@section('script')

@endsection