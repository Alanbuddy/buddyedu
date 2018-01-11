@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-product.css') }}">
@endsection

@section('content')
.desc-div
  %p.f16.fb.title.mb60=auth()->user()->name.'的作品'
  .product-list
    -foreach($items as $item)
      .item
        %p.f14.date.mb16 2017/12/21
        .img-div
          %a{href: route('user.drawings.show',$item->id)}
            %img{src: "/icon/mobile/product.jpg"}
@endsection

@section('script')
<script src= ""></script>
@endsection