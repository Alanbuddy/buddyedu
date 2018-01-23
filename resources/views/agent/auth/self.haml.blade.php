@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-index.css') }}">
:javascript
  window.auth_self = "#{route('courses.index')}"
@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/2.png"}
      %span.f24a.title 课程授权
  - else
    .title-div
      %a{href: route('courses.index')."?type=my"}
        %img.back-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('courses.index')}='课程类目('.$count.')'
      %li.f14a.bg16b="我的课程(".$items->total().")"
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名称", value: "", :onfocus=>"this.style.color='#5d6578'"}
  
  .desc-div.clearfix
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      - foreach($items as $item)
        %a.frame-div{href: route('courses.show',$item->id)}
          %img.course-icon{src: "icon/bird.png"}
          %p.course-name.f16b=$item->name
          %p.f12b=$item->merchants_count.'机构已添加'
          %p.mt24.f12b=$item->description??'没有简介'
          .add-div
            %span.f14e 已添加


@endsection

@section('script')
<script src= "/js/agent-auth-self.js"></script>

@endsection