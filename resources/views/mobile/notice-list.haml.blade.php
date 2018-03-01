@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mobile-notice-list.css') }}">
  
@endsection

@section('content')
.desc-div
  %p.title.fb.f20 公告信息
  .items-div
    .undiscover
      %img.undiscover-icon{src: "/icon/undiscover.png"}
    %a.item{href:'#'}
      %span.caption.fb.f16 很长很长的标题很很很很很很很长很长的标题长很长的标题长很长的标题长很长的标题长很长的标题长很长的标题长很长的标题
      .notice-content 很很很很很很很很很长很长的标题长很长的标题长很长的标题长很长的标题长很长的标题长很长的标题长很长的标题长很长的标题长很长的标题

@endsection

@section('script')

@endsection
