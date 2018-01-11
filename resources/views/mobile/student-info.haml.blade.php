@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/profile.css') }}">
:javascript
  window.token = "#{csrf_token()}"
  window.user_info = "#{route('profile.update')}"
  window.register_end = "#{route('schedules.enrolled',$schedule)}"
@endsection

@section('content')
.desc-div
  .input-div
    %p.f20.fb.title 学生信息
    .input-group.mb64
      %span.f16.text-blue.mr40 学生姓名
      %input.form-box.f16#name{placeholder: "请输入您的姓名", type: "text"}
    .input-group.mb64
      %span.f16.text-blue.mr40 学生性别
      %span.select-div
        %select.form-box.f16#gender{placeholder: "请选择您的性别"}
          %option{value: "male"} 男
          %option{value: "female"} 女
    .input-group
      %span.f16.text-blue.mr40 学生生日
      %input.birthday-input.f16#birthday{type: "date"}
    %button.btn.click-btn.f14#next_btn{type: "button"} 完成报名
@endsection

@section('script')
<script src= "/js/user-student-info.js"></script>
@endsection