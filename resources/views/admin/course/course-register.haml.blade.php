@extends('layout.admin')
@section('css')

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 当前开课 >
    %span.f16a.title 

  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('schedules.show',$schedule->id))} 基础信息
      %li.f14a.bg16b 报名情况

  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 手机号
            %th 学院姓名
            %th 学院年龄
            %th 报名时间
            %th 报名状态
        %tbody
          %tr
            %td 13244556633
            %td 某某
            %td 7岁
            %td 2017.12.01 14:13:12
            %td.green 已支付
            // %td.orange 待付款

    .select-page 
      %span.choice-page

@endsection

@section('script')


@endsection