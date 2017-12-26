@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/merchant-edu-point.css') }}">
:javascript
  window.points_search = "#{route('merchant.points', $merchant->id)}"
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title= $merchant->name.">"
    %span.f16a.title 教学点
  
  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='教学点('.$items->count().')'
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入教学点名称", value: "", :onfocus=>"this.style.color='#5d6578'"}

  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 教学点名称
              %th 面积
              %th 负责人
              %th 联系方式
              %th 所在地
              %th 操作
          %tbody
            - foreach($items as $item)
              %tr
                %td= $item->name
                %td= $item->area.'m²'
                %td= $item->admin
                %td= $item->contact
                %td.tip-parent{"data-geo" => $item->geolocation}
                  %img{src: "/icon/location.png"}
                  .tooltip-div.f14d
                    .triangle
                    %img.close{src: "/icon/smallclose.png"}
                    %p 地址信息:
                    %p= $item->address
                    .container
                // %td.red.cancel-auth 取消授权或者重新授权

      .select-page 
        %span.choice-page
          != $items->links()
@endsection

@section('script')
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script src= "/js/edu-point.js"></script>

@endsection