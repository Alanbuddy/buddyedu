@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/agent-teacher-add.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/10.png"}
    %span.f24a.title 授课老师

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 全部老师(23)
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入老师姓名/手机号", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}
      
  
  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 老师姓名
            %th 性别
            %th 年龄
            %th 当前开课/历史开课
            %th 手机号
        %tbody
          %tr
            %td 老师名字
            %td 女
            %td 29
            %td 1/0
            %td.f12a 13211223344

    .select-page 
      %span.choice-page

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/close.png"}
      .modal-body.clearfix
        %p.f24b.add-c 添加老师
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
          %input.form-control.input-web-width.f12b{:type => "text", :placeholder => "非必填", :onfocus=>"this.style.color='#5d6578'"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 课程简介:
          %textarea.area-width.form-control
        .controls.controls-row.mb24
          %label.input-caption.f14d 详细介绍:
          %textarea.area-width.form-control.area-height
        %btn.f16d.add-btn-width.fr 确认添加
@endsection

@section('script')
<script src= "/js/agent-teacher-add.js"></script>

@endsection