@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mobile-course-show.css') }}">
@endsection

@section('content')
.desc-div
  .title-div
    %span.f20.fb.title.color1 Buddy动物园
    %span.f14.course-num.color1 (21)
    %p.f14.color1.mt20 机构教学点的很很长的名字
    %img.comment-icon{src: "/icon/mobile/comment.png"}
  .content-div
    .address-div
      .time
        %img.time-icon{src: "/icon/mobile/time.png"}
        %span.f12.color3 2017/12/23~20178/3/15
      .address   
        %img.location-icon{src: "/icon/mobile/location_3.png"}
        %span.f12.color3 构教学点的很很长的名字机构教学点的很很长的名字机构教学点的很很长的名字机构教学点的很很长的名字
    .teacher-div
      %span.f16.fb.color2 授课老师
      %span.f14.fb.color2 (3)
      .teacher-info.clearfix
        %img.teacher-icon{src: "/icon/teacher.png"}
        .desc-div
          %span.f14.fb.color3 老师姓名
          %span.f14.fb.color3 李老师
          %p.f12.color3.teacher-introduction 本科学历，学士学位，国家特级教师，优秀教师，头衔很多，一行写不下
      .teacher-info.clearfix
        %img.teacher-icon{src: "/icon/teacher.png"}
        .desc-div
          %span.f14.fb.color3 老师姓名
          %span.f14.fb.color3 李老师
          %p.f12.color3.teacher-introduction 本科学历，学士学位，国家特级教师，优秀教师，头衔很多，一行写不下
    .course-div
      %span.f16.fb.color2 课程介绍
      .f14.color3.course-info 
        精品课程精精精精精精精精精精精精精品课程品课程品课程品课程品课程品课程品课程品课程品
        课程品课程品课程品课程品课程精精精精精精精精精精精品课程品课程品课程品课程品课程品课程品课程品课程品课程品课程品课程
    .location-div
      %span.f16.fb.color2 详细地址
      .location-map#container
  .footer-div
    .left-div
      %span.f16.fb.color2 ￥2400
      %span.f14.fb.color2 (仅剩15名额)
    .right-div
      %button.btn.click-btn.f14#end_btn{type: "button"} 完成
  .footer-div
    .left-div
      %span.f16.fb.color2 没公开课名额了
    .right-div
      %button.btn.gray-btn.f14#end_btn{type: "button"} 暂无名额
  .footer-div
    .left-div
      %span.f16.fb.color2 交了钱没填资料
    .right-div
      %button.btn.click-btn.f14#end_btn{type: "button"} 填写资料
  .footer-div
    .left-div
      %span.f16.fb.color2 报名截止了
    .right-div
      %button.btn.gray-btn.f14#end_btn{type: "button"} 报名截止
  .footer-div
    .left-div
      %span.f16.fb.color2 已报名
    .right-div
      %button.btn.gray-btn.f14#end_btn{type: "button"} 您已报名



@endsection

@section('script')
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
<script src= "/js/mobile-course-show.js"></script>
@endsection