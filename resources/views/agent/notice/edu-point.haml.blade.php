@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/edu-point.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/7.png"}
    %span.f24a.title 通知查看

  .tab-title
    %ul.clearfix
      %li.f14c 添加课程(23)
      %li.f14a.bg16b 添加教学点(15)
      %li.f14c 开课申请(15)
  
  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 教学点名称
            %th 申请时间
            %th 处理时间
            %th 课程状态
        %tbody
          %tr
            %td 这是一门课的名称
            %td 2017.12.23 13:12:23
            %td 2017.12.23 13:12:23
            %td.red 审核驳回
          %tr
            %td 这是一门课的名称
            %td 2017.12.23 13:12:23
            %td ——
            %td.red 审核中
          %tr
            %td 这是一门课的名称
            %td 2017.12.23 13:12:23
            %td 2017.12.23 13:12:23
            %td.f12a 已通过

    .select-page 
      %span.choice-page

  
@endsection

@section('script')

@endsection