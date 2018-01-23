@extends('layout.admin')
@section('css')


@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 当前开课 >
    %span.f16a.title= $schedule->course->name

  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('schedules.show', $schedule)} 基础信息
      %li.f14a.bg16b 报名情况

  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 手机号
              %th 学生姓名
              %th 学生年龄
              %th 报名时间
              %th 报名状态
          %tbody
          -foreach($items as $item)
            %tr
              %td=$item->phone
              %td=$item->name
              %td=$item->birthday?(date('Y')-date('Y',strtotime($item->birthday))).'岁':'未知'
              %td=$item->pivot->created_at
              %td.green 已支付
              // %td.orange 待付款

      .select-page 
        %span.choice-page
          != $items->links()

@endsection

@section('script')


@endsection