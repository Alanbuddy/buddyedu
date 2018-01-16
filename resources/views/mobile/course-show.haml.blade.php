@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mobile-course-show.css') }}">
:javascript
  window.token = "#{csrf_token()}"
  window.course_pay = "#{route('prepay',$schedule)}"
  window.pay_finish = "#{route('schedules.enrolled',$schedule)}"
  window.user_phone = "#{route('user.phone.bind.form')}"
  window.review = "#{route('comments.store')}"
@endsection

@section('content')
.desc-div
  .title-div
    %span.f20.fb.title.color1= $schedule->course->name
    %span.f14.course-num.color1 (21)
    %p.f14.color1.mt20
      %span.edu-point-name=$schedule->merchant->name
    %a{href: route('comments.index')}
      %img.comment-icon{src: "/icon/mobile/comment.png"}
  .content-div
    .address-div
      .time
        %img.time-icon{src: "/icon/mobile/time.png"}
        %span.f12.color3=$schedule->begin.'~'.$schedule->end
      .address   
        %img.location-icon{src: "/icon/mobile/location_3.png"}
        %span.f12.color3=$schedule->point->name
    .teacher-div
      %span.f16.fb.color2 授课老师
      %span.f14.fb.color2="($schedule->teachers_count)"
      -foreach($schedule->teachers as $item)
        .teacher-info
          %img.teacher-icon{src: $item->avatar ? $item->avatar : "/icon/teacher.png"}
          .teacher-desc-div
            %span.f14.fb.color3 老师姓名
            %span.f14.fb.color3=$item->name
            %p.f12.color3.teacher-introduction=$item->title
    .course-div
      %span.f16.fb.color2 课程介绍
      .f14.color3.course-info=$schedule->course->description
    .location-div
      %span.f16.fb.color2 详细地址
      %span.hidden.point-location= $schedule->point->geolocation
      .location-map#container
    %span.hidden.schedule-id= $schedule->id
  .footer-div
    -if($hasEnrolled)
      -if(empty($user->phone))
        .left-div
          %span.f16.fb.color2 交了钱没填资料
        .right-div
          %button.btn.click-btn.f14#edit_btn{type: "button"} 填写资料
      -else
        -if(strtotime($schedule->end) < time())
          .left-div
            %span.f16.fb.color2 课程已结束
          .right-div
            %button.btn.gray-btn.f14#review_btn{type: "button"} 立即评价
        -else
          .left-div
            %span.f16.fb.color2 已报名
          .right-div
            %button.btn.gray-btn.f14#end_btn{type: "button"} 您已报名
    -else
      -if($available)
        .left-div
          %span.f16.fb.color2="￥".round($schedule->price/100,2)
          %span.f14.fb.color2='(仅剩'.$available.'名额)'
        .right-div
          %button.btn.click-btn.f14#end_btn{type: "button"} 立即报名
      -else
        -if($isFull)
          .left-div
            %span.f16.fb.color2 没公开课名额了
          .right-div
            %button.btn.gray-btn.f14#end_btn{type: "button"} 暂无名额
        -else if($schedule->begin< date('Y-m-d H:i:s'))
          .left-div
            %span.f16.fb.color2 报名截止了
          .right-div
            %button.btn.gray-btn.f14#end_btn{type: "button"} 报名截止



@endsection

@section('modal-div')
#reviewModal.modal.fade.bottom{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"}
  .modal-dialog
    .modal-content
      .modal-body
        .content-div
          %img.close{src: "/icon/mobile/close.png"}
          .input-div
            %p.f18.color2= $schedule->course->name.'评价'
            %textarea.review-div.f14
            %button.btn.click-btn.f14#submit{type: "button"} 提交评价

@endsection
@section('script')
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script src= "/js/mobile-course-show.js"></script>

@endsection
