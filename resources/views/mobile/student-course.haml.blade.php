@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-course.css') }}">
@endsection

@section('content')
.desc-div
  %a{href: route('profile')}
    %img.mine{src: "/icon/mobile/mine.png"}
  %p.f16.fb.title.mb48 李晓明的课程
  .items
    // - foreach($items as $item)
    .item.mb48
      %img.course-icon{src: "/icon/mobile/product.jpg"}
      .title-div
        %p.f14.text-color.title-margin Buddy动物园
        %p.f14.text-color.point-name 机构教学点设置的长长的名称
      %a.click-div{href: route('user.drawings', $item->schedule_id)}
        %span.f12.text-blue 我的作品
        %img.arrow{src: "/icon/mobile/more.png"}
    .item.mb48
      %img.course-icon{src: "/icon/mobile/product.jpg"}
      .title-div
        %p.f14.text-color.title-margin Buddy动物园
        %p.f14.text-color 机构教学点设置的长长的名称
      %a.click-div
        %span.f12.text-blue 我的作品
        %img.arrow{src: "/icon/mobile/more.png"}
@endsection

@section('script')
<script src= ""></script>
@endsection