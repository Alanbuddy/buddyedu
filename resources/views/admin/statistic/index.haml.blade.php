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
      %p.f16c 所选时段内新增学员
      %p.f24b.mt16 3,000
    .item-div
      %p.f16c 本日新增学员
      %p.f24b.mt16 30
    .item-div
      %p.f16c 本周新增学员
      %p.f24b.mt16 300
    .item-div
      %p.f16c 学员总数
      %p.f24b.mt16 13,000
  .desc-div
    .kids-nums
      %p.column-title.f14a 所选时段内学员总数变化
      .figure-box
        #nums-statistics
    .pie-box
      .age-pie
        %p.pie-title.f14a 全部学员年龄分布
        .figure-box
          #age-statistics
      .gender-pie
        %p.pie-title.f14a 全部学员性别分布
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