@extends('layout.admin')
@section('css')

@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title= $merchant->name.">"
    %span.f16a.title 收入总额
  
  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 收支明细

  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 课程名称
              %th 开课日期
              %th 教学点
              %th 手机号
              %th 学生姓名
              %th 收支金额
          %tbody
            %tr
              %td 动物园
              %td 2017/12/23
              %td 教学点名称
              %td 13211223344
              %td 李小米
              %td.green -￥3200
              // %td.red +￥3200

      .select-page.clearfix
        %span.f14a.fl 导出明细 
        %span.choice-page
          != $items->links()
  
@endsection

@section('script')


@endsection