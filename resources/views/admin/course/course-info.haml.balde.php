@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 当前开课 >
    %span.f16a.title 这是一门课的名称

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 基础信息
      %li.f14c 报名情况

  .desc-div
    .name-money
      .name-div
        %p.f24b 这是一门课的名称
        %p.f12a.mt16 某一机构的很长的名字 
      .money-div
        %span.f24c.mr8 ￥2400
        %span.f12a 75%分成
    .info-div.f14d
      .p-div
        %span 授课老师：
        %span 某老师、某某老师
      .p-div
        %span 报名人数：
        %span 10/15
        %span.ml80 课程进度：
        %span 0/36
      .p-div
        %span 上课时间：
        %span 2018-2-21
      .p-div
        %span 上课地点：
        %span 机构给的很长的一个地址信息
      .p-div
        %span.left-span 课程介绍：
        %span.right-span 精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材
    

  
@endsection

@section('script')


@endsection