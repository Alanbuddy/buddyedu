@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="/css/select2.min.css">
<link rel="stylesheet" href="{{ mix('/css/agent-add.css') }}">
:javascript
  window.course_store = "#{route('schedules.store')}"
  window.schedule_create = "#{route('schedules.create')}"
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/1.png"}
    %span.f24a.title 开课情况

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 当前开课(23)
      %li.f14c 历史开课(15)
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名称", value: "", :onfocus=>"this.style.color='#5d6578'"}
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
            %th 课程名称
            %th 教学点
            %th 上课老师
            %th 报名人数/班级人数
            %th 课程状态
        %tbody
          %tr
            %td 这是一门课的名称
            %td 教学点的名字很长
            %td 老师名字
            %td 12/15
            %td.green 上课中
            // %td.red 审核中
            // %td.red 审核驳回
            // %td.orange 报名中

    .select-page 
      %span.choice-page

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body
        %p.f24b.add-c 添加开课
        .controls.controls-row.mb24
          %label.input-caption.f14d 开设课程:
          %select.form-control.input-width.f14d#course{:type => "text"}
            %option{value: "1"} 课程名
        .controls.controls-row.mb24
          %label.input-caption.f14d 教学点:
          %select.form-control.input-width.manager.f14d#point{:type => "text"}  
            %option{value: "2"} xxx教学点
        .controls.controls-row.mb24
          %label.input-caption.f14d.teacher 授课老师:
          %select.form-control.input-width#teacher-select.f14d{multiple: "multiple"}
            %option{value: "1"} 教师a
            %option{value: "2"} 教师b
        .controls.controls-row.mb24
          %label.input-caption.f14d 班级人数:
          %input.form-control.input-width.f14d#num{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 上课时间:
          %input.form-control.input-width{:type => "text"}
        .btn-div     
          %btn.f16d.add-btn-width#apply 提交申请
  
@endsection

@section('script')
<script src= "/js/select2.min.js"></script>
<script src= "/js/agent-add.js"></script>

@endsection