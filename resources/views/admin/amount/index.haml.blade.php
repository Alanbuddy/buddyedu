@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-show.css') }}">
<link rel="stylesheet" href="/css/dateRange.css">
<link rel="stylesheet" href="/css/monthPicker.css">
:javascript
  window.amount_search = "#{route('orders.stat-group-by-merchant')}"
@endsection

@section('content')

.main-content
  .title-div
    - if(!$key)
      %img.title-icon{src: "/icon/5.png"}
      %span.f24a.title 金额统计
    - else
      %a{href: route('orders.stat-group-by-merchant')}
        %img.back-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'
    .ta_date#div_date1.date-box
      %span.date_title#date1
      %a.optsel#input_trigger1
        %i.i_orderd
    #datePicker1
  .items-div
    .item-div
      %p.f16c 所选时段内收入
      %p.f24b.mt16='￥'.round($incomeOfSelectedRange/100,2)
    .item-div
      %p.f16c 本日收入
      %p.f24b.mt16='￥'.round($incomeOfToday/100,2)
    .item-div
      %p.f16c 本周收入
      %p.f24b.mt16='￥'.round($incomeOfThisWeek/100,2)
    .item-div
      %p.f16c 收入总额
      %p.f24b.mt16='￥'.round($income/100,2)
  
  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 各机构收入
      %li
        %a.f14c{href: route('orders.stat-group-by-course')} 各课程收入
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入机构名/课程名", value: "", :onfocus=>"this.style.color='#5d6578'"}

  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 开课机构
              %th 当前开课/所有开课
              %th 当前报名/所有报名
              %th 所选时段内收入
              %th 收入总额
          %tbody
          -foreach($items as $item)
            %tr
              %td=$item->name
              %td=$item->ongoingSchedules_count.'/'.$item->schedules_count
              %td=$item->ongoingStudentCount.'/'.$item->studentCount
              %td='￥'.($item->incomeOfSelectedRange??'0')
              %td.f12a='￥'.($item->income??'0')

      .select-page 
        %span.choice-page
          != $items->links()
    
@endsection

@section('script')
<script src="/js/jquery.min.js"></script>
<script src="/js/dateRange.js"></script>
<script src="/js/monthPicker.js"></script>
<script src="/js/dateSelect.js"></script>
<script src="/js/admin-amount-search.js"></script>

@endsection