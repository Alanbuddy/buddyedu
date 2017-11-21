@extends('layout.admin')
@section('css')

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 课程授权 >
    %span.f16a.title Buddy动物园

  .tab-title
    %ul.clearfix
      %li.f14c 课程信息
      %li.f14a.bg16b 授权机构(4)
      %li.f14c 评论查看(16)

  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 机构名称
            %th 当前开设本课/历史开设本课
            %th 当前报名人数/历史报名人数
            %th 操作
        %tbody
          %tr
            %td 某一机构名称
            %td １/5
            %td 12/75
            %td
              %img{src:"/icon/delete.png"}

    .select-page 
      %span.choice-page

  
@endsection

@section('script')


@endsection