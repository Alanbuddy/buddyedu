@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-index.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title= $merchant->name.">"
    %span.f16a.title 课程授权

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='课程类目('.$items->count().')'
  
  .desc-div.clearfix
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      - foreach($items as $item)
        .frame-div
          %img.course-icon{src: "icon/bird.png"}
          %p.course-name.f16b= $item->name
          %p.f12b= $item->merchants_count.'机构已添加'
          %p.mt24.f12b= $item->description??'没有简介'
          .add-div
            %span.f14b 取消

@endsection

@section('script')
<script src= "/js/admin-course-index.js"></script>

@endsection