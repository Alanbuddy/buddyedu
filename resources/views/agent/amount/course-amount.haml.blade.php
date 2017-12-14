@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-show.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/5.png"}
    %span.f24a.title 金额统计
  .items-div
    .item-div
      %p.f16c 本日收入
      %p.f24b.mt16 ￥213,000
    .item-div
      %p.f16c 本周收入
      %p.f24b.mt16 ￥213,000
    .item-div
      %p.f16c 本月收入
      %p.f24b.mt16 ￥213,000
    .item-div
      %p.f16c 收入总额
      %p.f24b.mt16 ￥213,000
  
  .tab-title
    %ul.clearfix
      %li.f14c 收支明细
      %li.f14a.bg16b 各课程收入

  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 课程名称
            %th 当前开课/所有开课
            %th 当前报名/所有报名
            %th 收入总额
        %tbody
          %tr
            %td buddy动物园
            %td 12/15
            %td 100/352
            %td.f12a ￥3200

    .select-page
      %span.choice-page
    
@endsection

@section('script')


@endsection