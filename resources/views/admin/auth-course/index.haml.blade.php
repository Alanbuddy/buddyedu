@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-index.css') }}">
:javascript
  window.courses_store = "#{route('courses.store')}"
  window.courses_index = "#{route('courses.index')}"
@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/2.png"}
      %span.f24a.title 课程授权
  - else
    .title-div
      %a{href: route('courses.index')}
        %img.title-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='课程类目('.$items->count().')'
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名称", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}  
  
  .desc-div.clearfix
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      -foreach($items as $item)
        %a.frame-div{href: route('courses.show',$item->id)}
          %img.course-icon{src: $item->icon??'icon/bird.png'}
          %p.course-name.f16b=$item->name
          %p.f12b=$item->merchants_count.'机构已添加'
          %p.mt24.f12b=$item->description??'没有简介'

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
          %label.input-caption.f14d 课程节数:
          %input.form-control.input-width#length{:type => "text"}
          
          %label.input-caption.f14d 机构分成:
          %select.form-control.input-width#auth-price
            %option 请选择
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
          %input.form-control.input-web-width#guide-price{:type => "text"}
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