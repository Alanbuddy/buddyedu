@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/review.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/7.png"}
    %span.f24a.title 申请处理

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 添加课程(23)
      %li.f14c 添加教学点(15)
      %li.f14c 开课申请(15)
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入机构名", value: "", :onfocus=>"this.style.color='#5d6578'"}
      
  
  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 申请机构
            %th 申请课程
            %th 负责人
            %th 联系方式
            %th{colspan: 2} 操作
        %tbody
          %tr
            %td 某一机构名称
            %td 这是一门课的名称
            %td 负责人名字
            %td 13211122334
            %td#green 通过
            %td.f12e 驳回
          %tr
            %td 某一机构名称
            %td 这是一门课的名称
            %td 负责人名字
            %td 13211122334
            %td.f12a 已处理
            %td 

    .select-page 
      %span.choice-page

  
@endsection

@section('script')


@endsection