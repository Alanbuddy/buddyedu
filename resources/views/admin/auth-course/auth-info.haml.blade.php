@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 课程授权 >
    %span.f16a.title Buddy动物园

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 课程信息
      %li.f14c 授权机构(4)
      %li.f14c 评论查看(16)

  .desc-div
    .name-money
      .name-div
        %img.icon{src: "/icon/bird.png"}
        %span.f24b　Buddy动物园
      .money-div
        %span.f24c.mr8 ￥2400
        %span.f12a 75%分成
    .info-div.f14d
      .p-div
        %span 课程网站：
        %span www.xxxxxxx.com
      .p-div
        %span 课程简介：
        %span 这里有一点不太长的简介，简单介绍下这个产品的功能
      .p-div
        %span.left-span 课程介绍：
        %span.right-span 精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材
  
@endsection

@section('script')


@endsection