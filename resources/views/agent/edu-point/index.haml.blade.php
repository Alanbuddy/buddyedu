@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/agent-edu-add.css') }}">
:javascript
  window.points_store = "#{route('points.store')}"
  window.points_index = "#{route('points.index')}"

@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/9.png"}
      %span.f24a.title#merchant-id{"data-merchant" => auth()->user()->ownMerchant->id} 教学点
  - else
    .title-div
      %a{href: route('points.index')}
        %img.back-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='全部教学点('.$items->total().')'
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入教学点", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}
      
  
  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 教学点
              %th 面积
              %th 负责人
              %th 联系方式
              %th 详细地址
          %tbody
          -foreach($items as $item)
            %tr
              %td
                %a.name{href: route('points.show', $item->id)}=$item->name
              %td.area= $item->area.'m²'
              %td.admin= $item->admin
              %td.contact= $item->contact
              %td.tip-parent{"data-geo" => $item->geolocation}
                %img{src: "/icon/location.png"}
                .tooltip-div
                  .triangle
                  %img.close{src: "/icon/smallclose.png"}
                  %p 地址信息:
                  %p.address= $item->address
                  .container
      .select-page 
        %span.choice-page
          != $items->links()

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/close.png"}
      .modal-body
        %p.f24b.add-c 添加教学点
        .controls.controls-row.mb16
          %label.input-caption.f14d 名称设置
          %input.form-control.input-width#edu-name{:type => "text"}
        .controls.controls-row.mb16
          %label.input-caption.f14d 面积
          %input.form-control.input-width.area#edu-area{:type => "text"}  
        .controls.controls-row.mb16
          %label.input-caption.f14d 负责人
          %input.form-control.input-width.admin#edu-admin{:type => "text"}  
        .controls.controls-row.mb16
          %label.input-caption.f14d 联系方式
          %input.form-control.input-width#edu-phone{:type => "text"}  
        .controls.controls-row.mb16
          %label.input-caption.f14d.city-select 省市区
          %span.citys
            %select.form-control#province
            %select.form-control#city
            %select.form-control#county
        .controls.controls-row.mb16
          %label.input-caption.f14d.vt 详细地址
          %textarea.form-control.textarea-width#street{:type => "text"}
        .controls.controls-row.mb16
          %label.input-caption.f14d 申请备注
          %input.form-control.input-width.f14d#remark{:type => "text", placeholder: "非必填"}
        .controls.controls-row.mb16
          %label.input-caption.f14d 地理位置
          %span.get-location.f14b 获取地址
          #container
        .btn-div     
          %btn.f16d.add-btn-width#submit 确定

@endsection

@section('script')
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
<script src="/js/city.js"></script>
<script src= "/js/edu-add.js"></script>
@endsection