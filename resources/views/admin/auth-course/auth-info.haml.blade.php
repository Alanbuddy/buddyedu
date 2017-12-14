@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 课程授权 >
    %span.f16a.title=$course->name

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 课程信息
      %li
        %a.f14c{href: route('course.merchant', $course->id)}='授权机构('.$course->merchants()->count().')'
      %li
        %a.f14c{href: route('course.comment', $course->id)}='评论查看('.$course->comments()->count().')'

  .desc-div
    .name-money
      .name-div
        %img.icon{src: "/icon/bird.png"}
        %span.f24b=$course->name
      .money-div
        %span.f24c.mr8='￥'.$course->price
        %span.f12a= "(".($course->proportion*100).'%分成)'
    .info-div.f14d
      .p-div
        %span 课程网站：
        %span=$course->url
      .p-div
        %span 课程简介：
        %span.course-desc=$course->description
      .p-div
        %span.left-span 课程介绍：
        %span.right-span!= $course->detail

@endsection

@section('script')


@endsection