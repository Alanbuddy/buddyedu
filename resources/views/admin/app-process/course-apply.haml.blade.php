@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/review.css') }}">
:javascript
  window.schedules_search = "#{route('merchant.schedule.application')}"
@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/7.png"}
      %span.f24a.title 申请处理
  - else
    .title-div
      %a{href: route('merchant.schedule.application')}
        %img.title-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('merchant.course.application')}='添加课程('.$courseApplicationCount .')'
      %li
        %a.f14c{href: route('merchant.point.application')}='添加教学点('.$pointApplicationCount.')'
      %li.f14a.bg16b='开课申请('.$items->total().')'
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入机构名", value: "", :onfocus=>"this.style.color='#5d6578'"}
      
  
  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 申请机构
              %th 申请课程
              %th 负责人
              %th 联系方式
              %th 操作
          %tbody
            - foreach($items as $item)
              %tr
                %td=$item->merchant->name
                %td=$item->course->name
                %td=$item->merchant->admin->name
                %td=$item->merchant->admin->phone
                -if(empty($item->status))
                  %td#green 通过
                  %td.f12e 驳回
                -else
                  %td.f12a 已处理
                  %td.f12a
               
      .select-page
        %span.choice-page
          != $items->links()

  
@endsection

@section('script')
<script src= "/js/process-schedule.js"></script>

@endsection