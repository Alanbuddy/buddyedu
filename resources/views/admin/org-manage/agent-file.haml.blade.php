@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-show.css') }}">
<link href="/css/webuploader.css" rel="stylesheet" type="text/css">
:javascript
  window.file_delete = "#{route('files.destroy', -1)}"
  window.file_upload = "#{route('files.store')}"
  window.file_list = "#{route('merchant.files', $merchant)}"
  window.file_init = "#{route('file.upload.init')}"
  window.merge = "#{route('files.merge')}"
@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title=$merchant->name
    %span.hidden.merchant-id= $merchant->id
  .items-div
    %a.item-div{href:  route('merchant.courses', $merchant->id)}
      %p.f16c 授权课程
      %p.f24b.mt16=$merchant->courses()->wherePivot('status','approved')->count().'门'
      %img{src: "/icon/more.png"} 
    %a.item-div{href:  route('merchant.points', $merchant->id)}
      %p.f16c 教学点
      %p.f24b.mt16=$merchant->points()->count().'个'
      %img{src: "/icon/more.png"}
    %a.item-div{href:  route('merchant.teachers', $merchant->id)}
      %p.f16c 授权老师
      %p.f24b.mt16=$merchant->teachers()->count().'位'
      %img{src: "/icon/more.png"}
    %a.item-div{href:  route('merchant.orders', $merchant->id)}
      %p.f16c 收入总额
      %p.f24b.mt16='￥'.round($merchant->orders()->sum('amount')/100,2)
      %img{src: "/icon/more.png"}
  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('merchants.show', $merchant)}='当前开课('.$merchant->ongoingSchedules()->count().')'
      %li
        %a.f14c{href: route('merchants.show', $merchant)."?type=finished"}='历史开课('.$merchant->finishedSchedules()->count().')'
      %li.f14a.bg16b= '往来文件('.$items->total().')'
    %img.add-file-icon{src: "/icon/add.png"}
  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 文件名称
              %th 上传时间
              %th 操作
          %tbody
          -foreach($items as $item)
            %tr
              %td=$item->name
              %td=$item->created_at
              %td
                %a.green.mr10.pointer{href: route('file.download', $item->id), download: $item->name} 下载
                %a.red.delete.pointer{"data-id" => $item->id} 删除 

      .select-page 
        %span.choice-page
          != $items->links()

#addFileModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close-file{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body
        %span.hidden.file-id
        .file-div
          %span.f14d 上传文件:
          #uploader.wu-example
            #thelist.uploader-list
            .btns
              #picker 选择文件
              %button#ctlBtn.btn.btn-default.f14d 开始上传
@endsection

@section('script')
<script src="/js/webuploader.js"></script>
<script src= "/js/admin-merchant-file.js"></script>

@endsection