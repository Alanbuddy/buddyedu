@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin-notice-show.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 公告发布 >
    %span.f16a.title 公告详情

  .tab-title
    %ul
      %li.f14a.bg16b 公告详情

  .desc-div
    .content-div
      .name-money
        .name-div
          %p.f24b= $notice->title
          %p.f12a.mt16= $notice->created_at
      .info-div.f14d
        .content!= $notice->content
  
@endsection

@section('script')

@endsection