@extends('layout.admin')
@section('css')

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 搜索
    %span.f16a.title "名称"

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 相关课程

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
                %td 12/15
                - if ($item)
                %td.green 上课中
                // %td 已结课

      .select-page 
        %span.choice-page
          != $items->links()

@endsection

@section('script')


@endsection