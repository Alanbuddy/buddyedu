@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-course.css') }}">
:javascript
  window.token = "#{csrf_token()}"
  window.sms_send = "#{route('sms.send')}"
  window.validmobile = "#{route('validate.phone')}"
  window.modify_end = "#{route('user.phone.bind')}"
  window.profile_update = "#{route('profile.update')}"
  window.product_list = "#{route('user.drawings')}"
@endsection

@section('content')
.desc-div
  %img.mine{src: "/icon/mobile/mine.png"}
  %p.f16.fb.title.mb48 李晓明的课程
  .items
    - if(count($items) == 0)
      .undiscover
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      - foreach($items as $item)
        .item.mb48
          %img.course-icon{src: $item->course->icon ? $item->course->icon : "/icon/mobile/product.jpg"}
          .title-div
            %p.f14.text-color.title-margin= $item->course->name
            %p.f14.text-color.point-name= $item->point->name
          %a.click-div
            %span.hidden{"data-id" => $item->schedule_id}
            %span.f12.text-blue 我的作品
            %img.arrow{src: "/icon/mobile/more.png"}
@endsection

@section('modal-div')
#profileModal.modal.fade.bottom{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"}
  .modal-dialog
    .modal-content
      .modal-body
        .profile-div
          %img.close{src: "/icon/mobile/close.png"}
          .input-div
            %p.f20.fb.profile-title 个人资料
            .input-group.mb64
              .input-inside-div
                .left-div
                  %span.f16.text-blue.mr40 手机号码
                  %input.form-box.f16#mobile{placeholder: $user->phone, type: "text"}
                %span.f12.text-blue.pointer#modify-phone 修改
            .input-group.mb64
              %span.f16.text-blue.mr40 学生姓名
              %input.form-box.f16#name{placeholder: $user->name, type: "text"}
            .input-group.mb64
              %span.f16.text-blue.mr40 学生性别
              %select.form-box.f16#gender
                %option= $user->gender
                %option{value: "male"} 男
                %option{value: "female"} 女
            .input-group
              %span.f16.text-blue.mr40 学生生日
              %input.form-box.f16#birthday{type: "date", placeholder: $user->birthday}
            %button.btn.click-btn.f14#next_btn{type: "button"} 完成

#phoneModal.modal.fade.bottom{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"}
  .modal-dialog
    .modal-content
      .modal-body
        .profile-div
          %img.phone-close{src: "/icon/mobile/close.png"}
          .input-div
            %p.f20.fb.profile-title 修改手机号
            .input-group.no-margin-bottom
              %span.input-group-addon.miniphoto
              %input.phone-form-box.f14#modify-mobile{placeholder: "请输入您的手机号", type: "text"}
            %p.notice.f14#mobile_notice 请输入正确的手机号
            .input-group.no-margin-bottom
              %span.input-group-addon.verify-photo
              .input-inside-div
                %input.form-verify-box.f14#mobilecode{placeholder: "请输入验证码", type: "text"}
                %span.verify-code-span.f12.pointer#verifycode 获取验证码
            %button.btn.click-btn.f14#phone_next_btn{type: "button"} 完成修改
@endsection
@section('script')
<script src= "/js/mobile-student-course.js"></script>
@endsection