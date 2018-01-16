@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-product.css') }}">
@endsection

@section('content')
.desc-div
  %p.f16.fb.title.mb60=auth()->user()->name.'的作品'
  .product-list
    - if(count($items) == 0)
      .undiscover
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      -foreach($items as $item)
        .item
          %p.f14.date.mb16=$item->created_at
          .img-div
            %a{href: route('user.drawings.show',$item->id)}
              %img{src: $item->path}
            
@endsection

@section('script')
<script src= ""></script>
@endsection