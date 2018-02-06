@extends('layout.grow')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/grow-record.css') }}">
@endsection

@section('content')
.content-div
  .back-div
    %img.back{src: '/icon/grow/back.png'}
    %span.f16.fb.color1.vm 统计数据
  .items-div
    .height-div
      %img.height{src: '/icon/grow/height.png'}
      %span.f18.fff 身高
    %img.more{src: '/icon/grow/more.png'}
  .items-div
    .height-div
      %img.height{src: '/icon/grow/weight.png'}
      %span.f18.fff 体重
    %img.more{src: '/icon/grow/more.png'}
  .items-div
    .height-div
      %img.height{src: '/icon/grow/head.png'}
      %span.f18.fff 头围
    %img.more{src: '/icon/grow/more.png'}


@endsection

@section('script')
<script src= ""></script>
@endsection