@extends('layout.admin')
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
          %tr
            %td buddy动物园
            %td 2017/12/15
            %td 教学点名称
            %td 13211223344
            %td 李华
            %td.green +￥3200
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
@endsection

@section('script')
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/datepicker-zh-TW.js"></script>
<script src="/js/export.js"></script>

@endsection