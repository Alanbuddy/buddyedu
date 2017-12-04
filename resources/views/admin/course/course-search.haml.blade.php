@extends('layout.admin')
@section('css')

@endsection

@section('content')

.main-content
  .title-div
    %a{href: route('schedules.index')}
      %img.title-icon{src: "/icon/back.png"}
    // %span.f16a.title= '搜索"'.$key.'"'
    %span.f16a.title 搜索

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 当前开课(5)
      %li
        %a.f14c{href: route('schedule.search')."?type=history"} 历史开课(3)

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
              %th 开课机构
              %th 教学点
              %th 上课老师
              %th 报名人数/班级人数
              %th 课程状态
          %tbody
            - foreach ($items as $item)
              %tr
                %td= $item->course->name
                %td= $item->merchant->name
                %td= $item->point->name
                %td
                  - foreach ($item->teachers as $teacher)
                    %span= $teacher->name
                %td= $item->students_count."/".$item->quota
                %td.green 上课中

      .select-page 
        %span.choice-page
          != $items->links()

@endsection

@section('script')


@endsection