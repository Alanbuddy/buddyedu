@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-product.css') }}">
@endsection

@section('content')
.desc-div
  %p.f16.fb.title.mb60 李晓明的作品
  .product-list
    .item
      %p.f14.date.mb16 2017/12/21
      .img-div
        %img{src: "/icon/mobile/product.jpg"}
        %img{src: "/icon/mobile/product.jpg"}
    .item
      %p.f14.date.mb16 2017/12/22
      .img-div
        %img{src: "/icon/mobile/product.jpg"}
    .item
      %p.f14.date.mb16 2017/12/23
      .img-div
        %img{src: "/icon/mobile/product.jpg"}
@endsection

@section('script')
<script src= ""></script>
@endsection