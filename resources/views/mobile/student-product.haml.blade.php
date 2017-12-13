@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-product.css') }}">
@endsection

@section('content')
.desc-div
  %p.f16.fb.title.mb40 李晓明的作品
  %p.f12.date.mb40 2017/12/21
  %img.product{src: "/icon/mobile/product.jpg"}
  %p.f14.title 一句提示分享的文案
@endsection

@section('script')
<script src= ""></script>
@endsection