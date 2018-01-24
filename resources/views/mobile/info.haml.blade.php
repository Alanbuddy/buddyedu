@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/info.css') }}">
:javascript
  window.token = "#{csrf_token()}"
  window.user_next = "#{route('user.phone.bind')}"
  window.landing = "#{route('landing',$schedule??1)}"
  window.sms_send = "#{route('sms.send')}"
  window.validmobile = "#{route('validate.phone')}"
  window.login = "#{route('login')}"
@endsection

@section('content')
.desc-div
  .input-div
    %p.f20.fb.title 登录
    .input-group.no-margin-bottom
      %span.input-group-addon.miniphoto
      %input.form-box.f14#mobile{placeholder: "请输入您的手机号", type: "text"}
    %p.notice.f14#mobile_notice 请输入正确的手机号
    .input-group.no-margin-bottom
      %span.input-group-addon.verify-photo
      .input-inside-div
        %input.form-box.form-verify-box.f14#mobilecode{placeholder: "请输入验证码", type: "text"}
        %span.verify-code-span.f12.pointer#verifycode 获取验证码 
    %button.btn.click-btn.f14#next_btn{type: "button"} 登录
@endsection

@section('script')
<script src= "/js/user-info.js"></script>
@endsection