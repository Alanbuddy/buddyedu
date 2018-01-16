@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-product.css') }}">
@endsection

@section('content')
.desc-div
  %p.f16.fb.title.mb40 李晓明的作品
  %p.f12.date.mb40 2017/12/21
  %img.product.mb40{src: "/icon/mobile/product.jpg"}
  %video.product.mb80{src: ""}
  %p.f14.title 我画的小动物“活”了，小玩伴们一起来体验吧!
@endsection

@section('script')
<script src= ""></script>
@endsection