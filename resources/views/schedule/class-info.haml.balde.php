@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/class_info.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f24a.title 当前开课>
    %span.f16a 这是一门课的名称

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 基础信息
      %li.f14c.bg16b 报名情况

  .desc-div
    .name-money
      .name-div
        %p.f24b.mt32 这是一门课的名称
        %p.f12a.mt16 某一机构的很长的名字 
      .money-div
        %span.f24c.mr8 ￥2400
        %span.f12a 75%分成
  
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
            %td 教学点的名字很长
            %td 老师名字
            %td 12/15
            %td.classtime 上课中
            // %td.register 报名中

    .select-page 
      %span.choice-page

  
@endsection

@section('script')


@endsection