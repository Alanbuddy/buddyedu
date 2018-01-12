@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-index.css') }}">
:javascript
  window.course_list = "#{route('merchants.show', $merchant->id)}}"
  window.course_revoke = "#{route('merchant.course.authorize',[$merchant,-1,'revoke'])}"
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title= $merchant->name.">"
    %span.f16a.title 课程授权

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='课程类目('.$items->count().')'
  
  .desc-div.clearfix
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      - foreach($items as $item)
        .frame-div
          %img.course-icon{src: "icon/bird.png"}
          %p.course-name.f16b{"data-id" => $item->id}= $item->name
          %p.f12b= $item->merchants_count.'机构已添加'
          %p.mt24.f12b= $item->description??'没有简介'
          .add-div
            %span.f14b.cancel-course{style: "cursor: pointer"} 取消

#revokeModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/smallclose.png"}
      .modal-body.clearfix
        %p.f16b.add-c 取消课程
        %p.f14d.ml24 确定取消该课程的授权吗？
        .btn-div
          %btn.conform-btn#submit 确定取消

@endsection

@section('script')
<script src= "/js/admin-course-auth.js"></script>

@endsection