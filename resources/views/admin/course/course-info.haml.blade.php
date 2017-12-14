@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 当前开课 >
    %span.f16a.title= $item->course->name

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 基础信息
      %li
        %a.f14c{href: route('schedule.student',$item)} 报名情况

  .desc-div
    .name-money
      .name-div
        %p.f24b= $item->course->name 
        %p.f12a.mt16= $item->point->name 
      .money-div
        %span.f24c.mr8= "￥".$item->course->price
        %span.f12a="(".($item->course->proportion * 100)."%分成)"
    .info-div.f14d
      .p-div
        %span 授课老师：
        - foreach ($item->teachers as $teacher)
          %span.teacher= $teacher->name
      .p-div
        %span 报名人数：
        %span= $item->students()->count()."/".$item->quota
        %span.ml80 课程进度：
        %span=$progress.'/'.$item->course->lessons_count
      .p-div
        %span 上课时间：
        %span= $item->begin
      .p-div
        %span 上课地点：
        %span= $item->point->name
      .p-div
        %span.left-span 课程介绍：
        %span.right-span 精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材
    

  
@endsection

@section('script')


@endsection