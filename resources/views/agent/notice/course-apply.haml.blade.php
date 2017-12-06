@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/review.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/7.png"}
    %span.f24a.title 通知查看

  .tab-title
    %ul.clearfix
      %li.f14c 添加课程(23)
      %li.f14c 添加教学点(15)
      %li.f14a.bg16b 开课申请(15)
  
  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 申请课程
            %th 申请时间
            %th 处理时间
            %th 课程状态
        %tbody
          %tr
            %td 某一机构名称
            %td 2017.12.23 14:32:23
            %td 2017.12.23 14:32:23
            %td.green 上课中
            // %td.red 审核中
            // %td.red 审核驳回
            // %td.f12f 报名中
          %tr
            %td 某一机构名称
            %td 2017.12.23 14:32:23
            %td ——
            %td.red 审核中
            // %td.red 审核驳回
            // %td.f12f 报名中

    .select-page 
      %span.choice-page

  
@endsection

@section('script')


@endsection