@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mobile-notice-show.css') }}">
  
@endsection

@section('content')
.desc-div
  %p.title.fb.f20 公告详情
  .item
    %span.caption.f16.fb= $notice->title
    .desc.f14!= $notice->content
  

@endsection

@section('script')

@endsection
