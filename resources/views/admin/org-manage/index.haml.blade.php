@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/org-manage.css') }}">
:javascript
  window.merchants_index = "#{route('merchants.index')}"
  window.merchants_store = "#{route('merchants.store')}"

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/3.png"}
    %span.f24a.title 机构管理

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='合作机构('.$items->total().')'
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入机构名称/负责人", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}  
  
  .desc-div.clearfix
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 机构名称
              %th 当前开课/历史开课
              %th 负责人
              %th 联系方式
              %th 操作
          %tbody
            -foreach($items as $item)
              %tr
                %td
                  %a{href: route('merchants.show', $item->id)}=$item->name
                %td=$item->ongoingSchedules.'/'.$item->schedules_count
                %td=$item->admin->name
                %td=$item->admin->phone
                %td.f12a.edit 编辑
    .select-page 
      %span.choice-page
        != $items->links()

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body
        %p.f24b.add-c 添加机构
        .controls.controls-row.mb24
          %label.input-caption.f14d 机构名称:
          %input.form-control.input-width#name{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 负责人:
          %input.form-control.input-width.manager#admin{:type => "text"}  
        .controls.controls-row.mb24
          %label.input-caption.f14d 手机号码:
          %input.form-control.input-width#phone{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 初始密码:
          %input.form-control.input-width#password{:type => "text"}
        .btn-div     
          %btn.f16d.add-btn-width#submit 立即添加
@endsection

@section('script')
<script src= "/js/admin-merchant-add.js"></script>

@endsection