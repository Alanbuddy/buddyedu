@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-show.css') }}">
<link rel="stylesheet" href="/css/jquery-ui.min.css">
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/5.png"}
    %span.f24a.title 金额统计
  .items-div
    .item-div
      %p.f16c 本日收入
      %p.f24b.mt16='￥'.round($incomeOfToday/100,2)
    .item-div
      %p.f16c 本周收入
      %p.f24b.mt16='￥'.round($incomeOfThisWeek/100,2)
    .item-div
      %p.f16c 本月收入
      %p.f24b.mt16='￥'.round($incomeOfThisMonth/100,2) 
    .item-div
      %p.total
        %span.f16c.total-amount 收入总额
        %span.cash 提现
      %p.f24b.mt16='￥'.round($income/100,2)
  
  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 收支明细
      %li
        %a.f14c{href: route('orders.stat-group-by-course')} 各课程收入

  .desc-div
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 课程名称
            %th 开课日期
            %th 教学点
            %th 手机号
            %th 学生姓名
            %th 收支金额
        %tbody
        -foreach($items as $item)
          %tr
            %td=$item->schedule->course->name
            %td=$item->created_at
            %td=$item->schedule->point->name
            %td=$item->user->phone
            %td=$item->user->name
            %td.green='+￥'.round($item->amount/100,2)
            // %td.ren -￥3200

    .select-page.clearfix
      %span.fl.f14b.pointer#export 导出明细 
      %span.choice-page
#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body.clearfix
        %p.f24b.add-c 导出明细
        .controls.controls-row.mb24
          %label.input-caption.f14d 开始时间
          %input.form-control.input-width#datepicker1{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 结束时间
          %input.form-control.input-width#datepicker2{:type => "text"}
        %btn.f16d.add-btn-width#submit 导出文件  
#cashModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close-cash{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body.clearfix
        %p.f24b.add-c 余额提现
        .items-div
          .item-modal
            %p
              %span.f16c.money 可提现余额
              %span.f12b (即7日前收入)
            %p.f24b.mt16 ￥4250
          .item-modal
            %p.f16c 总余额
            %p.f24b.mt16 ￥4250
        .div
          %span.f14e.notice 您有一笔提现正在处理中
          %btn.fr.f16d.add-btn-width#applying{disabled: true} 申请提现   
          // %btn.fr.f16d.add-btn-width#apply 申请提现      

@endsection

@section('script')
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/datepicker-zh-TW.js"></script>
<script src="/js/export.js"></script>

@endsection