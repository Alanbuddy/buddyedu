@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 当前开课 >
    %span.f16a.title= $item->course->name

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 基础信息
      %li
        %a.f14c{href: route('schedule.student',$item)} 报名情况

  .desc-div
    .name-money
      .name-div
        %p.f24b= $item->course->name
        %p.f12a.mt16= $item->point->name
      - if(!$item->is_batch)
        .money-div
          %span.f24c.mr8= $item->course->price ? "￥".$item->course->price : "暂无价格"
          %span.f12a="(".($item->course->proportion * 100)."%分成)"
    .info-div.f14d
      .p-div
        %span 授课老师：
        - foreach ($item->teachers as $teacher)
          %span.teacher= $teacher->name
      .p-div
        %span 课程进度：
        %span=$progress.'/'.$item->course->lessons_count
        - if(!$item->is_batch)
          %span.ml80 报名人数：
          %span= $item->students()->count()."/".$item->quota
      .p-div
        %span 开课时间：
        %span= $item->begin
      .p-div
        %span 结课时间：
        %span= $item->end
      - if(!$item->is_batch)
        .p-div
          %span 详细时间：
          %span= $item->time
      .p-div
        %span 上课地点：
        %span= $item->point->address
      .p-div
        %span.left-span 课程介绍：
        %span.right-span= $item->course->description

// #editModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
//   .modal-dialog
//     .modal-content
//       .modalheader
//         %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
//       .modal-body
//         %p.f24b.add-c 添加开课
//         .controls.controls-row.mb24
//           %label.input-caption.f14d 开设课程:
//           %select.form-control.input-width.f14d#course
//             %option 请选择
//         .controls.controls-row.mb24
//           %label.input-caption.f14d 教学点:
//           %select.form-control.input-width.manager.f14d#point{:type => "text"} 
//             - foreach($merchant->points()->where('approved',1)->get() as $item)
//               %option{value: $item->id}= $item->name
//         .controls.controls-row#course-price.mb24
//           %label.input-caption.f14d 课程定价:
//           %input.form-control.input-width.f14d#price{:type => "text"}
//         .controls.controls-row#desc
//           %label.input-caption.f14d.unvisible 故意隐藏:
//           %span.hide-notice.mtb#course-desc
//         .controls.controls-row.mb24
//           %label.input-caption.f14d 课程次数:
//           %input.form-control.input-width.f14d#lessons-count{:type => "text"}
//         .controls.controls-row.mb24
//           %label.input-caption.f14d.teacher 授课老师:
//           %select.form-control.input-width#teacher-select.f14d{multiple: "multiple"}
//             - foreach($merchant->teachers as $item)
//               %option{value: $item->id}= $item->name
//         .controls.controls-row.mb24#course-num
//           %label.input-caption.f14d 班级人数:
//           %input.form-control.input-width.f14d#num{:type => "text"}
//         .controls.controls-row.mb24
//           %label.input-caption.f14d 开课时间:
//           %input.form-control.input-width#datepicker1{:type => "text"}
//         .controls.controls-row.mb24
//           %label.input-caption.f14d 结课时间:
//           %input.form-control.input-width#datepicker2{:type => "text"}
//         .controls.controls-row.mb24#course-time
//           %label.input-caption.f14d.time 详细时间:
//           %textarea.form-control.input-width.f14d#time{:type => "text"}
//         .controls.controls-row.mb24
//           %label.input-caption.f14d 申请备注:
//           %input.form-control.input-width.f14d#remark{:type => "text", placeholder: "非必填"}
//         .btn-div     
//           %btn.f16d.add-btn-width#apply 提交申请
@endsection

@section('script')
<script src= "/js/agent-add.js"></script>
@endsection