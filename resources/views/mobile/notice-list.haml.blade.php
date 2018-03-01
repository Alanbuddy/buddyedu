@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mobile-notice-list.css') }}">
  
@endsection

@section('content')
.desc-div
  %p.title.fb.f20 公告信息
  .items-div
    - if(count($items) == 0)
      .undiscover
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      - foreach($items as $item)
        %a.item{href: route('notice.detail',$item->id)}
          %span.caption.fb.f16= $item->title 
          .notice-content!= $item->content

@endsection

@section('script')

@endsection
