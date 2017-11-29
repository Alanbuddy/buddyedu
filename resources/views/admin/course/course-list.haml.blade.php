@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_course.css') }}">

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
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名/老师姓名", value: "", :onfocus=>"this.style.color='#5d6578'"}
      
  
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
                // %td.orange 报名中

      .select-page 
        %span.choice-page

  
@endsection

@section('script')


@endsection