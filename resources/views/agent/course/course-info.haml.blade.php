@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="/css/select2.min.css">
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">
<link rel="stylesheet" href="/css/jquery-ui.min.css">

:javascript
  window.course_select = "#{route('courses.index')}"
  window.course_update = "#{route('schedules.update', -1)}"
  window.course_show = "#{route('schedules.show',$schedule->id)}"
@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 当前开课 >
    %span.f16a.title= $schedule->course->name

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 基础信息
      %li
        %a.f14c{href: route('schedule.student',$schedule)} 报名情况

  .desc-div
    .name-money
      .name-div
        %p.f24b= $schedule->course->name
        - if(!$old)
          %p.f12a.mt16= $schedule->point->name
        - else
          %p.f12a.mt16.through= $old->point->name
          %p.f12e.mt16= $schedule->point->name
        %p.is-batch.hidden= $schedule->is_batch
      - if(!$schedule->is_batch)
        .money-div
          - if(!$old)
            %span.f24c.mr8= $schedule->price ? "￥".$schedule->price : "暂无价格"
          - else
            %span.f24c.mr8.through= $old->price ? "￥".$old->price : "暂无价格"
            %span.f24e.mr8= $schedule->price ? "￥".$schedule->price : "暂无价格"
          %span.f12a="(".($schedule->course->proportion * 100)."%分成)"
    .info-div.f14d
      - if(!$old)
        .p-div
          %span 授课老师：
          - foreach ($schedule->teachers as $teacher)
            %span.teacher= $teacher->name
      - else
        .p-div
          %span 授课老师: 
          - foreach ($old->teachers as $teacher)
            %span.teacher.through= $teacher->name
        .p-div
          %span.old-visibility 授课老师: 
          - foreach ($schedule->teachers as $teacher)
            %span.teacher.pink= $teacher->name
      .p-div
        %span 课程进度：
        - if(!$old)
          %span=$progress.'/'.$schedule->lessons_count
        - else
          %span.through=$progress.'/'.$old->lessons_count
          %span.pink=$progress.'/'.$schedule->lessons_count
        - if(!$schedule->is_batch)
          %span.ml80 报名人数：
          - if(!$old)
            %span= $schedule->students()->count()."/".$schedule->quota
          - else
            %span.through= $old->students()->count()."/".$old->quota
            %span.pink= $schedule->students()->count()."/".$schedule->quota
      .p-div
        %span 开课时间：
        - if(!$old)
          %span.begin= date('Y-m-d',strtotime($schedule->begin))
        - else
          %span.through= date('Y-m-d',strtotime($old->begin))
          %span.begin.pink= date('Y-m-d',strtotime($schedule->begin))
      .p-div
        %span 结课时间：
        - if(!$old)
          %span.end= date('Y-m-d', strtotime($schedule->end))
        - else
          %span.through= date('Y-m-d', strtotime($old->end))
          %span.end.pink= date('Y-m-d', strtotime($schedule->end))
      - if(!$schedule->is_batch)
        - if(!$old)
          .p-div
            %span 详细时间：
            %span= $schedule->time
        - else
          .p-div
            %span 详细时间：
            %span.through= $old->time
          .p-div
            %span.old-visibility 详细时间：
            %span.pink= $schedule->time
      - if(!$old)
        .p-div
          %span 上课地点：
          %span= $schedule->point->address
      - else
        .p-div
          %span 上课地点：
          %span.through= $old->point->address
        .p-div
          %span.old-visibility 上课地点：
          %span.pink= $schedule->point->address
      .p-div
        %span.left-span 课程介绍：
        %span.right-span= $schedule->course->description
      .p-div
        %btn.modify-btn-width.fr#modify{"data-id" => $schedule->id} 修改

#editModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body
        %p.f24b.add-c 修改课程
        .controls.controls-row.mb24
          %label.input-caption.f14d 开设课程:
          %span.input-width.f14d#course{"data-id" => $schedule->course->id}= $schedule->course->name
        .controls.controls-row.mb24
          %label.input-caption.f14d 教学点:
          %select.form-control.input-width.manager.f14d#point{:type => "text"} 
            - foreach($schedule->merchant->points()->where('approved',1)->get() as $item)
              %option{value: $item->id}= $item->name
        .controls.controls-row#course-price.mb24
          %label.input-caption.f14d 课程定价:
          %input.form-control.input-width.f14d#price{:type => "text", value: $schedule->price??""}
        .controls.controls-row#desc
          %label.input-caption.f14d.unvisible 故意隐藏:
          %span.hide-notice.mtb#course-desc
        .controls.controls-row.mb24
          %label.input-caption.f14d 课程次数:
          %input.form-control.input-width.f14d#lessons-count{:type => "text", value: $schedule->lessons_count}
        .controls.controls-row.mb24
          %label.input-caption.f14d.teacher 授课老师:
          %select.form-control.input-width#teacher-select.f14d{multiple: "multiple"}
            - foreach($teachers as $item)
              %option{value: $item->id, selected: $item->selected}= $item->name
        .controls.controls-row.mb24#course-num
          %label.input-caption.f14d 班级人数:
          %input.form-control.input-width.f14d#num{:type => "text", value: $schedule->quota??""}
        .controls.controls-row.mb24
          %label.input-caption.f14d 开课时间:
          %input.form-control.input-width#datepicker1{:type => "text", value: $schedule->begin}
        .controls.controls-row.mb24
          %label.input-caption.f14d 结课时间:
          %input.form-control.input-width#datepicker2{:type => "text", value: $schedule->end}
        .controls.controls-row.mb24#course-time
          %label.input-caption.f14d.time 详细时间:
          %textarea.form-control.input-width.f14d#time{:type => "text"}= $schedule->time??""
        .controls.controls-row.mb24
          %label.input-caption.f14d 申请备注:
          %input.form-control.input-width.f14d#remark{:type => "text", placeholder: "非必填"}
        .btn-div     
          %btn.f16d.add-btn-width#apply 确定
@endsection

@section('script')
<script src= "/js/select2.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/datepicker-zh-TW.js"></script>
<script src= "/js/agent-course-edit.js"></script>
@endsection