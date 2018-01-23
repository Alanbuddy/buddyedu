@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-course-index.css') }}">
:javascript
  window.course_list = "#{route('merchants.show', $merchant->id)}}"
  window.course_revoke = "#{route('merchant.course.authorize',[$merchant,-1,'revoke'])}"
  window.quantity = "#{route('merchant.course.quantity.update',[$merchant->id,-1])}"
@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title= $merchant->name.">"
    %span.f16a.title 课程授权
    %span.merchant-name= $merchant->name

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
          - if($item->is_batch)
            %span.f12c 剩余名额:
            %span.f12c.quantity 200
            %span.modify 修改
          - else
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

#modifyModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/smallclose.png"}
      .modal-body.clearfix
        %p.f24b.add-c 名额修改
        %p.f14d.modify-title 某一机构名称的一门课程名称
        .controls.controls-row.mg24
          %label.input-caption.f14d.fn 剩余名额
          %input.f14d.form-control.input-width#num
        %btn.f16d.add-btn-width#confirm-btn 确定 

@endsection

@section('script')
<script src= "/js/admin-course-auth.js"></script>

@endsection