@extends('layout.admin')
@section('css')


@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/4.png"}
    %span.f24a.title 学员管理

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 全部学员(23)
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入学员手机号/姓名", value: "", :onfocus=>"this.style.color='#5d6578'"}
      
  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 手机号
            %th 学员姓名
            %th 学员年龄
            %th 报名课程
            %th 缴费总额
        %tbody
          %tr
            %td 13211223344
            %td 学员姓名
            %td 8岁
            %td 5门
            %td.f12a ￥5,400

    .select-page 
      %span.choice-page

@endsection

@section('script')


@endsection