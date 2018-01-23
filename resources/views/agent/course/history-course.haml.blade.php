@extends('layout.agent')
@section('css')
:javascript
  window.course_search = "#{route('schedules.index')}"
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
      %li
        %a.f14c{href: route('schedules.index')}='当前开课('.$onGoingSchedulesCount.')'
      %li.f14a.bg16b= "历史开课(".$items->total().")"
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
              %th 教学点
              %th 上课老师
              %th 报名人数/班级人数
              %th 课程状态
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
                %td.f12a 已结课   

      .select-page 
        %span.choice-page
          != $items->links()
@endsection

@section('script')
<script src= "/js/history-search.js"></script>

@endsection