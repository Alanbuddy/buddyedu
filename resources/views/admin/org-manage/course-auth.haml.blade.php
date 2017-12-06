@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-index.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title 某一机构的名称 >
    %span.f16a.title 课程授权

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 课程类目(12)
  
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
        %span.f14b 取消

    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。
      .add-div
        %span.f14b 取消
    .frame-div
      %img.course-icon{src: "icon/bird.png"}
      %p.course-name.f16b Buddy动物园
      %p.f12b 5机构已添加
      %p.mt24.f12b 这里有一点不太长的简单介绍一下这个产品的功能，大概只需要二三行字就可以，不可以太长了。


@endsection

@section('script')
<script src= "/js/admin-course-index.js"></script>

@endsection