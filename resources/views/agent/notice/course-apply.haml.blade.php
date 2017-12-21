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
      %li
        %a.f14c{href: route('merchant.course.application')}='添加课程('.$courseApplicationCount .')'
      %li
        %a.f14c{href: route('merchant.point.application')}='添加教学点('.$pointApplicationCount.')'
      %li.f14a.bg16b='开课申请('.$items->total().')'

  .desc-div
    - if(count($items) == 0)
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 申请课程
              %th 申请时间
              %th 处理时间
              %th 课程状态
          %tbody
            -foreach($items as $item)
              %tr
                %td=$item->course->name
                %td=$item->created_at
                %td=$item->updated_at
                -if($item->status == 'rejected')
                  %td.red 审核驳回
                -elseif($item->status == 'applying')
                  %td.red 审核中
                -if($item->status == 'approved' && ($item->begin < date('Y-m-d H:i:s')))
                  %td.f12f 报名中
                -elseif($item->status == 'approved' && $item->begin > date('Y-m-d H:i:s'))
                  %td.green 上课中
      .select-page
        %span.choice-page
          != $items->links()


@endsection

@section('script')


@endsection
