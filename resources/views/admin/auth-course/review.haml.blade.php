@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/review.css') }}">
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 课程授权 >
    %span.f16a.title Buddy动物园

  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('course.show', $course->id)} 课程信息
      %li
        %a.f14c{href: route('course.merchant', $course->id)} 授权机构(4)
      %li.f14a.bg16b 评论查看(16)

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
          %tr
            %td 学生姓名
            %td 某一机构名称
            %td 机构里面的环境很好，上课氛围非常好
            %td#green 展示
            %td.f12e 隐藏
            

    .select-page 
      %span.choice-page
        != $items->links()

  
@endsection

@section('script')


@endsection