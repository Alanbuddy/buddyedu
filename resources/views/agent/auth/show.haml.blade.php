@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-add.css') }}">

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

  .desc-div
    .name-money
      .name-div
        %img.icon{src: "/icon/bird.png"}
        %span.f24b　Buddy动物园
        %span.add-div
          %img.small-add{src:"/icon/smalladd.png"}
          %span.f14b 添加
      .money-div
        %span.f24c.mr8 ￥2400
        %span.f12a (75%分成)
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

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/smallclose.png"}
      .modal-body.clearfix
        %p.f16b.add-c 添加课程
        %p.f14d 确认申请添加"Buddy动物园"？
        .btn-div
          %btn.cancel-btn.f14e 取消
          %btn.conform-btn 添加

@endsection

@section('script')
<script src="/js/agent-course-add.js"></script>

@endsection