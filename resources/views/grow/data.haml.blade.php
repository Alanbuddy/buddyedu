@extends('layout.grow')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/grow-record.css') }}">
:javascript
  window.samples_store = "#{route('samples.store')}"
  window.samples_index = "#{route('samples.index')}"
@endsection

@section('content')
.content-div
  .head-div
    .back-div
      %img.back{src: '/icon/grow/back.png'}
      %span.f16.fb.color1.vm 某宝宝的今日数据
    %span.f14.color5 测量指南
  .input-div
    .input-group.mb48
      %span.f16.color3.mr88 身高
      %input.form-box.f16#height{placeholder: "请输入", type: "text"}
      %span.f16.color3 cm
    .input-group.mb48
      %span.f16.color3.mr88 体重
      %input.form-box.f16#weight{placeholder: "请输入", type: "text"}
      %span.f16.color3 kg
    .input-group.mb48
      %span.f16.color3.mr88 头围
      %input.form-box.f16#head{placeholder: "请输入", type: "text"}
      %span.f16.color3 cm

@endsection
@section('foot-div')
.footer-div
  %button.btn.gray-btn.f16#save_btn{type: "button"} 保存
@endsection
@section('script')
<script src= "/js/data-save.js"></script>
@endsection