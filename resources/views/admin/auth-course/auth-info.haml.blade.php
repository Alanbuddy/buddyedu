@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">
:javascript
  window.course_edit = "#{route('courses.update',$course->id)}"
  window.course_show = "#{route('courses.show',$course->id)}"
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
      %li
        %a.f14c{href: route('course.merchant', $course->id)}='授权机构('.$course->merchants()->count().')'
      %li
        %a.f14c{href: route('course.comment', $course->id)}='评论查看('.$course->comments()->count().')'

  .desc-div
    .name-money
      .name-div
        %img.icon{src: $course->icon}
        %span.f24b=$course->name
    .info-div.f14d
      .p-div
        %span 课程定价：
        %span=$course->guide_price."(".($course->proportion*100).'%分成)'
      .p-div
        %span 课程网站：
        %span=$course->url
      .p-div
        %span 课程简介：
        %span.course-desc=$course->description
      .p-div
        %span.left-span 课程介绍：
        %span.right-span!= $course->detail
      .p-div
        %btn.modify-btn-width.fr#modify 修改

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"}
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body.clearfix
        %p.f24b.add-c 添加课程
        .controls.controls-row.mb24
          %label.input-caption.f14d 课程名称:
          %input.form-control.input-width#name{:type => "text", value: $course->name}
          %label.input-caption.f14d 课程节数:
          %input.form-control.input-width#length{:type => "text", value: $course->lessons_count}
          
          %label.input-caption.f14d 机构分成:
          %select.form-control.input-width#auth-price{value: $course->proportion}
            %option{value: $course->proportion}= ($course->proportion * 100).'%'
            %option{value: 0.8} 80%
            %option{value: 0.7} 70%
            %option{value: 0.6} 60%    
        .controls.controls-row.mb24
          %label.f14d 课程图标:
          %input.hidden{:onchange => "upload(this)", :type => "file"}
          %span.course-icon-path.hidden
          %span.icon-name.input-width
            %span.course-icon-name.f14b
            %img.delete-icon{src: "/icon/smallclose.png"}
          %btn.upload-btn.f14b{:type => "button"} 上传
          %label.f14d 课程网址:
          %input.form-control.input-web1-width.f12b#web{:type => "text", :placeholder => "非必填", :onfocus=>"this.style.color='#5d6578'"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 课程定价:
          %input.form-control.input-web-width#guide-price{:type => "text", value: $course->guide_price}
        .controls.controls-row.mb24
          %label.input-caption.f14d.input-top 课程简介:
          %textarea.area-width.form-control#profile= $course->description
        .controls.controls-row.mb24
          %label.input-caption.f14d.input-top 详细介绍:
          %span#desc-html{style: "display:none;"}= $course->detail
          %span.area-width.area-height
            #edit-area
        %btn.f16d.add-btn-width.fr#confirm-btn 确认修改

@endsection

@section('script')
<script src="/js/wangEditor.min.js"></script>
<script src= "/js/admin-course-edit.js"></script>


@endsection