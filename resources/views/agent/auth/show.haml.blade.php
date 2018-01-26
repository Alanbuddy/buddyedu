@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-add.css') }}">
:javascript
  window.course_add = "#{route('course.apply',$course->id)}"
@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 课程授权 >
    %span.f16a.title=$course->name

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 课程信息

  .desc-div
    .name-money
      .name-div
        %img.icon{src: $course->icon??'/icon/bird.png'}
        %span.f24b=$course->name
        - if ($course->added)
          %span.added-div
            %span.f14e 已添加
        - else
          %span.add-div
            %img.small-add{src:"/icon/smalladd.png"}
            %span.f14b 添加
    .info-div.f14d
      .p-div
        %span 课程定价：
        %span=$course->guide_price."(".($course->proportion*100).'%分成)'
      .p-div
        %span 课程网站：
        %span=$course->url??"暂无"
      .p-div
        %span.left-span 课程简介：
        %span.right-span=$course->description
      .p-div
        %span.left-span 课程介绍：
        %span.right-span!= $course->detail

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/smallclose.png"}
      .modal-body.clearfix
        %p.f16b.add-c 添加课程
        .controls.controls-row.mb24
          %label.input-caption.f14d 申请备注:
          %input.form-control.input-width.f14d#remark{:type => "text", :placeholder => "非必填"}
        .btn-div
          %btn.conform-btn#add{"data-id" => $course->id} 提交申请

@endsection

@section('script')
<script src="/js/agent-course-add.js"></script>

@endsection