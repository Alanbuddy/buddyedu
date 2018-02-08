@extends('layout.grow')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/grow-record.css') }}">
@endsection

@section('content')
.content-div
  .back-div
    %img.back{src: '/icon/grow/back.png'}
    %span.f16.fb.color1.vm 头围数据
  .ul-div
    %ul.flex-div.f14
      %li.active 0~1岁
      %li 1~3岁
      %li 3~5岁
  .curve-box
    #curve
  


@endsection

@section('script')
<script src="/js/jquery-1.8.3.min.js"></script>
<script src="/js/highcharts.js"></script>
<script src= "/js/grow-curve.js"></script>
@endsection