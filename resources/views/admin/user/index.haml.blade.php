@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-show.css') }}">
:javascript
  window.users_search = "#{route('admins.index')}"
  window.enable = "#{route('admin.user.enable', -1)}"
  window.disable = "#{route('admin.user.disable', -1)}"
@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/10.png"}
      %span.f24a.title 人员处理
  - else
    .title-div
      %a{href: route('admins.index')}
        %img.title-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='工作人员('.$items->total().')'
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入手机号", value: "", :onfocus=>"this.style.color='#5d6578'"}
      
  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 手机号
              %th 申请时间
              %th 账号状态
              %th 操作
          %tbody
            -foreach($items as $item)
              %tr{"data-id" => $item->id}
                %td=$item->phone
                %td=$item->created_at
                -if(empty($item->status)||$item->status=='applying')
                  %td 新申请
                  %td.green.aproved.operation.pointer 开通
                -if($item->status=='disabled')
                  %td 已禁用
                  %td.green.one-span.operation.pointer 开通
                -if($item->status=='enabled')
                  %td 正常使用
                  %td.red.one-span.operation.pointer 禁用

      .select-page
        %span.choice-page
          != $items->links()

@endsection

@section('script')
<script src= "/js/admin-user.js"></script>

@endsection