@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/edu-point.css') }}">
:javascript
  window.points_search = "#{route('merchant.point.application')}"
@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/7.png"}
      %span.f24a.title 申请处理
  - else
    .title-div
      %a{href: route('merchant.point.application')}
        %img.title-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('merchant.course.application')}='添加课程('.$courseApplicationCount.')'
      %li.f14a.bg16b='添加教学点('.$items->total().')'
      %li
        %a.f14c{href: route('merchant.schedule.application')}='开课申请('.$scheduleApplicationCount.')'
      %li
        %a.f14c{href: route('merchant.withdraw.application')} 提现申请()
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
              %th 教学点
              %th 面积
              %th 负责人
              %th 联系方式
              %th 所在地
              %th 备注
              %th{colspan: 2} 操作
          %tbody
          -foreach($items as $item)
            %tr
              %td=$item->merchant_name
              %td=$item->point_name
              %td=$item->area.'m²'
              %td=$item->admin
              %td=$item->contact
              %td 管理的备注(机构的备注)无备注时为——
              %td.tip-parent{"data-geo" => $item->geolocation}
                %img{src: "/icon/location.png"}
                .tooltip-div.f14d
                  .triangle
                  %img.close{src: "/icon/smallclose.png"}
                  %p 地址信息:
                  %p=$item->address
                  .container
              -if(empty($item->status))
                %td#green 通过
                %td.f12e 驳回
              -else
                %td.f12a 已处理
                %td.f12a

      .select-page 
        %span.choice-page
          != $items->links()

  
@endsection

@section('script')
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script src= "/js/process-edu-point.js"></script>
@endsection