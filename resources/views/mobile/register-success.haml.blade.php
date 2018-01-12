@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/profile.css') }}">
:javascript
  window.register_end = "#{route('schedules.enrolled',-1)}"
@endsection

@section('content')
.desc-div
  %p.f20.fb.title.mb72 报名成功
  %p.f14.text-color.mb40= '您已成功报名'.$schedule->course->name.'动物园课程!'
  %p.f14.text-color.mb40= '开课前一天我们将发送提醒到您的手机：'.auth()->user()->phone.',届时不要迟到哦！'
  %p.f14.text-color.mb40= '如有任何疑问，请致电客服热线'.$schedule->point->contact
  %button.btn.click-btn.f14#next_btn{type: "button", "data-id" =>$schedule->id} 完成
@endsection

@section('script')
<script src= "/js/mobile-register-over.js"></script>
@endsection