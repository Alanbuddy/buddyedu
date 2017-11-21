@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">

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
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
    // - else
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
          %tr
            %td 这是一门课的名称
            %td 某一机构名称
            %td 机构教学点的长名称
            %td 老师名字
            %td 12/15
            %td.green 上课中
            // %td 已结课

    .select-page 
      %span.choice-page

@endsection

@section('script')


@endsection