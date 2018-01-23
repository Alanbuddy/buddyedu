@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="/css/select2.min.css">
<link rel="stylesheet" href="{{ mix('/css/agent-add.css') }}">
<link rel="stylesheet" href="/css/jquery-ui.min.css">
:javascript
  window.course_store = "#{route('schedules.store')}"
  window.schedule_create = "#{route('schedules.create')}"
  window.course_search = "#{route('schedules.index')}"
  window.course_select = "#{route('courses.index')}"
  window.qr_code = "#{route('qr')}"
@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/1.png"}
      %span.f24a.title 开课情况
  - else
    .title-div
      %a{href: route('schedules.index')}
        %img.back-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b= "当前开课(".$items->total().")"
      %li
        %a.f14c{href: route('schedules.index')."?type=finished"}='历史开课('.$finishedSchedulesCount.')'
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名称", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}
      
  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 课程名称
              %th 教学点
              %th 上课老师
              %th 报名人数/班级人数
              %th 课程状态
              %th 报名链接
          %tbody
            - foreach ($items as $item)
              %tr
                %td
                  %a{href: route('schedules.show',$item->id)}= $item->course->name
                %td= $item->point->name
                %td
                  - foreach ($item->teachers as $teacher)
                    %span= $teacher->name
                %td= $item->students_count."/".$item->quota
                - if ($item->status == "approved" && $item->begin < date('Y-m-d H:i:s'))
                  %td.green 上课中
                - if ($item->status == "applying")
                  %td.red 审核中
                - if ($item->status == "rejected")
                  %td.red 审核驳回
                - if ($item->status == "approved" && $item->begin > date('Y-m-d H:i:s'))
                  %td.orange 报名中
                %td.tip-parent{"data-id" => $item->id, "data-cid" => $item->course->id, "data-request" => "false"}
                  - if ($item->status == "approved" && $item->begin > date('Y-m-d H:i:s'))
                    %img.class-state.register-link{src: "/icon/class2.png"}
                    .tooltip-div
                      .triangle
                      %img.close{src: "/icon/smallclose.png"}
                      %span.f14d 课程链接
                      %span.f12c.copy.ml16 复制
                      .link-div
                        %input.f14d.course-link{type: "text", readonly: "readonly", "data-link" => route('landing',$item->id)}
                      %span.f14d 课程二维码
                      %a.f12c.download.ml16{ href: route('qr')."?size=120&data=".route('landing',$item->id)."&download=1"} 下载
                      .qrcode-box
                        %img.qrcode{src: route('qr')."?size=120&data=".route('landing',$item->id)}
                  - else
                    %img.class-state{src: "/icon/class1.png"}
                    
      .select-page 
        %span.choice-page
          != $items->links()

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body
        %p.f24b.add-c 添加开课
        .controls.controls-row.mb24
          %label.input-caption.f14d 开设课程:
          %select.form-control.input-width.f14d#course
            %option 请选择
        .controls.controls-row.mb24
          %label.input-caption.f14d 教学点:
          %select.form-control.input-width.manager.f14d#point{:type => "text"} 
            - foreach($merchant->points()->where('approved',1)->get() as $item)
              %option{value: $item->id}= $item->name
        .controls.controls-row#course-price.mb24
          %label.input-caption.f14d 课程定价:
          %input.form-control.input-width.f14d#price{:type => "text"}
        .controls.controls-row#desc
          %label.input-caption.f14d.unvisible 故意隐藏:
          %span.hide-notice.mtb#course-desc
        .controls.controls-row.mb24
          %label.input-caption.f14d 课程次数:
          %input.form-control.input-width.f14d#lessons-count{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d.teacher 授课老师:
          %select.form-control.input-width#teacher-select.f14d{multiple: "multiple"}
            - foreach($merchant->teachers as $item)
              %option{value: $item->id}= $item->name
        .controls.controls-row.mb24
          %label.input-caption.f14d 班级人数:
          %input.form-control.input-width.f14d#num{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 开课时间:
          %input.form-control.input-width#datepicker1{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 结课时间:
          %input.form-control.input-width#datepicker2{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d.time 详细时间:
          %textarea.form-control.input-width.f14d#time{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 申请备注:
          %input.form-control.input-width.f14d#remark{:type => "text", placeholder: "非必填"}
        .btn-div     
          %btn.f16d.add-btn-width#apply 提交申请
  
@endsection

@section('script')
<script src= "/js/select2.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/datepicker-zh-TW.js"></script>
<script src= "/js/agent-add.js"></script>

@endsection