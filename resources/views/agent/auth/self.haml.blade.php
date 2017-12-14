@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-index.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/2.png"}
    %span.f24a.title 课程授权

  .tab-title
    %ul.clearfix
      %li.f14c='课程类目('.$items->total().')'
      %li.f14a.bg16b="我的课程($count)"
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名称", value: "", :onfocus=>"this.style.color='#5d6578'"}
  
  .desc-div.clearfix
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。
      .add-div
        %span.f14e 已添加

    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。
      .add-div
        %span.f14e 已添加
    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。


@endsection

@section('script')
<script src= "/js/admin-course-index.js"></script>

@endsection