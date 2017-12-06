@extends('layout.admin')
@section('css')

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title 某一机构的名称 >
    %span.f16a.title 授课老师
  
  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 授课老师(5)
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入老师姓名/手机号", value: "", :onfocus=>"this.style.color='#5d6578'"}

  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 老师姓名
            %th 性别
            %th 年龄
            %th 当前开课/历史开课
            %th 手机号
        %tbody
          %tr
            %td 老师名字
            %td 女
            %td 29
            %td 1/0
            %td.f12a 13211223344

    .select-page 
      %span.choice-page
    
    

  
@endsection

@section('script')


@endsection