@extends('layout.grow')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/grow-record.css') }}">
@endsection

@section('content')
.content-div
  .back-div
    %img.back{src: '/icon/grow/back.png'}
    %span.f16.fb.color1.vm 测量指南
  .item-div
    %p.f16.color3.caption 头围测量小秘诀
    %p.f14.color4 胎儿头围是指绕胎头一周的最大长度，胎儿的头部从前面到后面最长的部分，通常情况下是从“前额的鼻根”到“后脑的枕骨隆突”的距离最长，所以一般头围就是从“前额的鼻根”到“后脑的枕骨隆突”绕一周的长度。
@endsection

@section('script')
<script src= ""></script>
@endsection