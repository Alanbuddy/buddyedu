@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/review.css') }}">
:javascript
  window.process_search = "#{route('merchant.course.application')}"
  window.approve = "#{route('point.approve', [-1, "approve"])}"
  window.reject = "#{route('point.approve', [-1, "reject"])}"
@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/7.png"}
      %span.f24a.title 申请处理
  - else
    .title-div
      %a{href: route('merchant.course.application')}
        %img.title-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='添加课程('.$items->total().')'
      %li
        %a.f14c{href: route('merchant.point.application')}='添加教学点('.$pointApplicationCount.')'
      %li
        %a.f14c{href: route('merchant.schedule.application')} ='开课申请('.$schedulesApplicationCount.')'
      %li
        %a.f14c{href: route('merchant.withdraw.application')}="提现申请($withdrawApplicationCount)"
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入机构名", value: "", :onfocus=>"this.style.color='#5d6578'"}


  .desc-div
    - if(count($items) == 0)
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 申请机构
              %th 申请课程
              %th 负责人
              %th 联系方式
              %th 备注
              %th{colspan: 2} 操作
          %tbody
            -foreach($items as $item)
              %tr{"data-id" => $item->merchant_id}
                %td=$item->merchant->name
                %td=$item->course->name
                %td=$item->merchant->admin->name
                %td=$item->merchant->admin->phone
                %td 管理的备注(机构的备注),无备注时为——
                %td#green.pointer.approve 通过
                %td.f12e.pointer.reject 驳回
                -if($item->status=='applying')
                  %td#green.operation 通过
                  %td.f12e.operation 驳回
                -if($item->status=='approved')
                  %td.f12a 已处理
                  %td.f12a
      .select-page
        %span.choice-page
          != $items->links()

#approveModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close-approve{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body.clearfix
        %p.f24b.add-c 申请处理
        %p.f14d.approve-title 通过"某一机构名称"申请添加"这是一门课程名称"课程的申请？
        .controls.controls-row.mg24
          %label.input-caption.f14d.fn 处理说明
          %input.f14d.form-control.input-width#operation-info{:type => "text", placeholder: "非必填"}
        %btn.f16d.add-btn-width.approve-btn 通过申请
#rejectModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close-reject{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body.clearfix
        %p.f24b.add-c 申请处理
        %p.f14d.reject-title 驳回"某一机构名称"申请添加"这是一门课程名称"课程的申请？
        .controls.controls-row.mg24
          %label.input-caption.f14d.fn 处理说明
          %input.f14d.form-control.input-width#operation-info{:type => "text", placeholder: "非必填"}
        %btn.f16d.add-btn-width.reject-btn 驳回申请
@endsection

@section('script')
<script src= "/js/process-search.js"></script>

@endsection