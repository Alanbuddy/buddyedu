@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-index.css') }}">
:javascript
  window.courses_store = "#{route('courses.store')}"
  window.courses_index = "#{route('courses.index')}"
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/2.png"}
    %span.f24a.title 课程授权

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 课程类目(12)
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名称", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}  
  
  .desc-div.clearfix
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。

    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。
    
    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/close.png"}
      .modal-body.clearfix
        %p.f24b.add-c 添加课程
        .controls.controls-row.mb24
          %label.input-caption.f14d 课程名称:
          %input.form-control.input-width#name{:type => "text"}
          %label.input-caption.f14d 课程定价:
          %input.form-control.input-width#price{:type => "text"}
          %label.input-caption.f14d 机构分成:
          %select.form-control.input-width#auth-price
            %option 请选择
            %option{value: 0.8} 80%
            %option{value: 0.7} 70%
            %option{value: 0.6} 60%    
        .controls.controls-row.mb24
          %label.f14d 课程图标:
          %input.hidden{:onchange => "upload(this)", :type => "file"}
          %span.course-icon-path{style: "display:none;"}
          %btn.upload-btn.f14b{:type => "button"} 上传
          %label.input-caption.f14d 课程节数:
          %input.form-control.input-width#length{:type => "text"}
        .controls.controls-row.mb24
          %label.f14d 课程网址:
          %input.form-control.input-web-width.f12b#web{:type => "text", :placeholder => "非必填", :onfocus=>"this.style.color='#5d6578'"}
        .controls.controls-row.mb24
          %label.input-caption.f14d.input-top 课程简介:
          %textarea.area-width.form-control#profile
        .controls.controls-row.mb24
          %label.input-caption.f14d.input-top 详细介绍:
          %span.area-width.area-height
            #edit-area
        %btn.f16d.add-btn-width.fr#submit 确认添加


@endsection

@section('script')
<script src="/js/wangEditor.min.js"></script>
<script src= "/js/admin-course-index.js"></script>
@endsection