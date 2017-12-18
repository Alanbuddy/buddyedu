@extends('layout.admin')
@section('css')
:javascript
  window.teachers_search = "#{route('merchant.teachers', $merchant->id)}"
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title= $merchant->name.">"
    %span.f16a.title 授课老师
  
  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='授课老师('.$items->count().')'
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入老师姓名/手机号", value: "", :onfocus=>"this.style.color='#5d6578'"}

  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 老师姓名
              %th 性别
              %th 年龄
              %th 当前开课/历史开课
              %th 手机号
          %tbody
            - foreach($items as $item)
              %tr
                %td
                  %a{href: route('merchant.teacher.show',[$merchant,$item])}=$item->name
                %td=$item->gender=='female'?'女':'男'
                %td=date('Y')-date('Y',strtotime($item->birthday))
                %td=$item->ongoingSchedules.'/'.$item->coaching_schedules_count
                %td.f12a=$item->phone

      .select-page 
        %span.choice-page
          != $items->links()
  
@endsection

@section('script')
<script src= "/js/merchant-teacher.js"></script>

@endsection