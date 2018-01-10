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
      %li
        %a.f14c{href: route('merchant.course.application')}='添加课程('.$courseApplicationCount.')'
      %li.f14a.bg16b='添加教学点('.$items->total().')'
      %li
        %a.f14c{href: route('merchant.schedule.application')}='开课申请('.$scheduleApplicationCount.')'

  .desc-div
    - if(count($items) == 0)
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 教学点名称
              %th 申请时间
              %th 处理时间
              %th 管理备注
              %th 申请备注
              %th 课程状态
          %tbody
            -foreach($items as $item)
              %tr
                %td=$item->point_name
                %td=$item->created_at
                %td=$item->updated_at
                %td= $item->advice ? $item->advice : '——'
                %td= $item->remark ? $item->remark : '——'
                -if($item->application_status=='applying')
                  %td.red 审核中
                -if($item->application_status=='approved')
                  %td.f12a 已通过
                -if($item->application_status=='rejected')
                  %td.red 审核驳回
      .select-page
        %span.choice-page
          != $items->links()


@endsection

@section('script')

@endsection