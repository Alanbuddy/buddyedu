@extends('layout.admin')
@section('css')

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 课程授权 >
    %span.f16a.title= $course->name 

  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('course.show', $course->id)} 课程信息
      %li.f14a.bg16b 授权机构(4)
      %li
        %a.f14c{href: route('course.comment', $course->id)} 评论查看(16)

  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 机构名称
            %th 当前开设本课/历史开设本课
            %th 当前报名人数/历史报名人数
            %th 操作
        %tbody
          -foreach($items as $item)
            %tr
              %td=$item->name
              %td=$item->ongoingSchedulesCount.'/'.$item->schedules_count
              %td=$item->ongoingStudentsCount.'/'.$item->studentsCount
              %td.red 取消授权

    .select-page 
      %span.choice-page
        != $items->links()
  
@endsection

@section('script')


@endsection