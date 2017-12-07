@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-show.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title 某一机构的名称
  .items-div
    .item-div
      %p.f16c 授权课程
      %p.f24b.mt16 3门
      %img{src: "/icon/more.png"} 
    .item-div
      %p.f16c 教学点
      %p.f24b.mt16 3个
      %img{src: "/icon/more.png"}
    .item-div
      %p.f16c 授权老师
      %p.f24b.mt16 5位
      %img{src: "/icon/more.png"}
    .item-div
      %p.f16c 收入总额
      %p.f24b.mt16 ￥213,000
      %img{src: "/icon/more.png"}
  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 当前开课(5)
      %li.f14c 历史开课(12)
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名/老师名", value: "", :onfocus=>"this.style.color='#5d6578'"}

  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 课程名称
            %th 开课机构
            %th 教学点
            %th 上课老师
            %th 报名人数/班级人数
            %th 课程状态
        %tbody
          %tr
            %td 这是一门课的名称
            %td 某一机构名称
            %td 教学点的名字很长
            %td 老师名字
            %td 12/15
            %td.green 上课中
            // %td.orange 报名中

    .select-page 
      %span.choice-page
    
    

  
@endsection

@section('script')


@endsection