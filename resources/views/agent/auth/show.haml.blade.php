@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-add.css') }}">

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

  .desc-div
    .name-money
      .name-div
        %img.icon{src: "/icon/bird.png"}
        %span.f24b=$course->name
        %span.add-div
          %img.small-add{src:"/icon/smalladd.png"}
          %span.f14b 添加
      .money-div
        %span.f24c.mr8='￥'.$course->price
        %span.f12a= "(".($course->proportion*100).'%分成)'
    .info-div.f14d
      .p-div
        %span 课程网站：
        %span=$course->url
      .p-div
        %span 课程简介：
        %span=$course->description
      .p-div
        %span.left-span 课程介绍：
        %span.right-span!= $course->detail

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/smallclose.png"}
      .modal-body.clearfix
        %p.f16b.add-c 添加课程
        %p.f14d= '确认申请添加"'.$course->name.'"'？
        .btn-div
          %btn.cancel-btn.f14e 取消
          %btn.conform-btn 添加

@endsection

@section('script')
<script src="/js/agent-course-add.js"></script>

@endsection