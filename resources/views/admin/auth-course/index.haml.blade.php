@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-index.css') }}">

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
    //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
    // - else
    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。
      .add-div
        %img.small-add{src:"/icon/smalladd.png"}
        %span.f14b 添加

    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。
      .add-div
        %span.f14e 已添加
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
          %input.form-control.input-width{:type => "text"}
          %label.input-caption.f14d 课程定价:
          %input.form-control.input-width{:type => "text"}
          %label.input-caption.f14d 机构定价:
          %select.form-control.input-width#auth-price
            %option 请选择类型
            %option 20
            // - foreach ($categories as $category )
            //   %option{value: $category->id}= $category->name      
        .controls.controls-row.mb24
          %label.f14d 课程图标:
          %input.hidden{:type => "file"}
          %btn.upload-btn.f14b{:type => "button"} 上传
          %label.f14d 课程网址:
          %input.form-control.input-web-width.f12b{:type => "text", :placeholder => "非必填", :onfocus=>"this.style.color='#5d6578'}
        .controls.controls-row.mb24
          %label.input-caption.f14d 课程简介:
          %textarea.area-width.form-control
        .controls.controls-row.mb24
          %label.input-caption.f14d 详细介绍:
          %textarea.area-width.form-control.area-height
        %btn.f16d.add-btn-width.fr 确认添加


@endsection

@section('script')
<script src= "/js/admin-course-index.js"></script>

@endsection