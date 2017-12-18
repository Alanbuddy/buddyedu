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
  .title-div
    %img.title-icon{src: "/icon/7.png"}
    %span.f24a.title 申请处理

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='添加课程('.$items->total().')'
      %li
        %a.f14c{href: route('merchant.point.application')} 添加教学点
      %li
        %a.f14c{href: route('merchant.schedule.application')} 开课申请
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
              %th{colspan: 2} 操作
          %tbody
            -foreach($items as $item)
              %tr{"data-id" => $item->merchant_id}
                %td=$item->merchant_name
                %td=$item->course_name
                %td=$item->admin_name
                %td=$item->admin_phone
                -if($item->status=='applying')
                  %td#green.operation 通过
                  %td.f12e.operation 驳回
                -if($item->status=='approved')
                  %td.f12a 已处理
      .select-page
        %span.choice-page
          != $items->links()

  
@endsection

@section('script')
<script src= "/js/process-search.js"></script>

@endsection