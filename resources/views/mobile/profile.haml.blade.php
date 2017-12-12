@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/profile.css') }}">
@endsection

@section('content')
.desc-div
  %img.close{src: "/icon/mobile/close.png"}
  .input-div
    %p.f20.fb.title 个人资料
    .input-group.no-margin-bottom
      .input-inside-div
        .left-div
          %span.f16.text-blue.mr40 手机号码
          %input.form-box.f16#mobile{placeholder: "请输入您的手机号", type: "text"}
        %span.f12.text-blue.pointer 修改
    %p.notice.f14#mobile_notice 请输入正确的手机号
    .input-group.mb64
      %span.f16.text-blue.mr40 学生姓名
      %input.form-box.f16#name{placeholder: "请输入您的姓名", type: "text"}
    .input-group.mb64
      %span.f16.text-blue.mr40 学生性别
      %select.form-box.f16#gender{placeholder: "请输入您的性别"}
        %option{value: "male"} 男
        %option{value: "female"} 女
    .input-group
      %span.f16.text-blue.mr40 学生生日
      %input.form-box.f16#birthday{type: "date"}
    %button.btn.click-btn.f14#next_btn{type: "button"} 完成
@endsection

@section('script')
<script src= ""></script>
@endsection