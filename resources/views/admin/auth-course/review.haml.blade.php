@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/review.css') }}">
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 课程授权 >
    %span.f16a.title=$course->name

  .tab-title
    %ul.clearfix
      %li.f14c 课程信息
      %li.f14c="授权机构(".$items->total().")"
      %li.f14a.bg16b ='评论查看('.$course->comments()->count().')'

  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 学生姓名
            %th 机构名称
            %th 评论内容
            %th{colspan: 2} 操作
        %tbody
        -foreach($items as $item)
          %tr
            %td=$item->user->name
            %td 某一机构名称
            %td=$item->content
            %td#green 展示
            %td.f12e 隐藏
            

    .select-page 
      %span.choice-page

  
@endsection

@section('script')


@endsection