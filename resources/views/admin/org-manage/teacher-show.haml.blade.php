@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/teacher-show.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title 某一机构名称 >
    %span.f16a.title 授课老师 >
    %span.f16a.title 老师名称 

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 基础信息

  .desc-div
    .name-money
      .name-div.clearfix
        %img.icon{src: "/icon/bird.png"}
        .teacher
          .name.f24b　老师姓名
          .teacher-title.f12a.mt16　小学特级教师
      .money-div
        %span.f24c 13211223344
    .info-div.f14d
      .item-div
        .pdiv
          %span 毕业院校：
          %span xxxxxxx师范大学
        .pdiv
          %span 老师性别：
          %span 男
        .pdiv
          %span 身份证号：
          %span 1111111111111111111
      .item-div
        .pdiv
          %span 老师年龄：
          %span 34岁
        .pdiv
          %span 老师教龄：
          %span 10年
        .pdiv
          %span 资格证号：
          %span 11111111112332334
      .p-div
        %span 老师简介：
        %span 这里有一点不太长的简介，简单介绍下这个产品的功能
      .p-div
        %span.left-span 老师简历：
        %span.right-span 精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材精品课程是具有一流的教师队伍、一流教学内容、一流教学方法、一流教材
  
@endsection

@section('script')


@endsection