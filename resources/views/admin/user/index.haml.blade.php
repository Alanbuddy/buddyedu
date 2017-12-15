@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-show.css') }}">
:javascript
  window.users_search = "#{route('admins.index')}"
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/10.png"}
    %span.f24a.title 人员处理

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
              %tr
                %td=$item->phone
                %td=$item->created_at
                -if(empty($item->status)||$item->status=='applying')
                  %td 新申请
                  %td
                    %span.green.aprove 通过
                    %span.red 驳回
                -if($item->status=='rejected')
                  %td 已禁用
                  %td.green.one-span 开通
                -if($item->status=='approved')
                  %td 正常使用
                  %td.red.one-span 禁用

      .select-page
        %span.choice-page
          != $items->links()

@endsection

@section('script')
<script src= "/js/admin-user.js"></script>

@endsection