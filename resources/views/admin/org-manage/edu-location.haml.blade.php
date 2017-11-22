@extends('layout.admin')
@section('css')

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title 某一机构的名称 >
    %span.f16a.title 教学点
  
  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 教学点(5)
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入教学点名称", value: "", :onfocus=>"this.style.color='#5d6578'"}

  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 教学点名称
            %th 当前开课/历史开课
            %th 面积
            %th 详细地址
        %tbody
          %tr
            %td 机构点很长的名字
            %td　1/0
            %td xxxxx
            %td.f12a 机构教学点很长的地址信息

    .select-page 
      %span.choice-page
    
    

  
@endsection

@section('script')


@endsection