@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-show.css') }}">
<link rel="stylesheet" href="/css/dateRange.css">
<link rel="stylesheet" href="/css/monthPicker.css">
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/6.png"}
    %span.f24a.title 信息统计
    .ta_date#div_date1.date-box
      %span.date_title#date1
      %a.optsel#input_trigger1
        %i.i_orderd
    #datePicker1
  .items-div
    .item-div
      %p.f16c 所选时段内新增学生
      %p.f24b.mt16=$countOfSelectedRange
    .item-div
      %p.f16c 本日新增学生
      %p.f24b.mt16=$countOfToday
    .item-div
      %p.f16c 本周新增学生
      %p.f24b.mt16=$countOfThisWeek
    .item-div
      %p.f16c 学生总数
      %p.f24b.mt16=$count
  .desc-div
    .kids-nums
      %p.column-title.f14a 所选时段内学生总数变化
      .figure-box
        #nums-statistics
    .pie-box
      .age-pie
        %p.pie-title.f14a 全部学生年龄分布
        .figure-box
          #age-statistics
      .gender-pie
        %p.pie-title.f14a 全部学生性别分布
        .figure-box
          #gender-statistics
      
    
@endsection

@section('script')
<script src="/js/jquery.min.js"></script>
<script src="/js/dateRange.js"></script>
<script src="/js/monthPicker.js"></script>
<script src="/js/dateSelect.js"></script>
<script src="/js/highcharts.js"></script>
<script src="/js/statistics.js"></script>

@endsection