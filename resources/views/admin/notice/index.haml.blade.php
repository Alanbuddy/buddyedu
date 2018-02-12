@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin-notice-index.css') }}">
:javascript
  window.notice_index = "#{route('notices.index')}"
  window.notice_store = "#{route('notices.store')}"
  window.notice_delete = "#{route('notices.destroy', -1)}"

@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/11.png"}
      %span.f24a.title 公告发布
  - else
    .title-div
      %a{href: route('notices.index')}
        %img.back-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b='所有公告('.$items->total().')'
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入关键字", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}  
  
  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .items-div
        - foreach($items as $item)
          %a.item{href: route('notices.show', $item->id)}
            %p.caption.f20a= $item->title
            %p.date.f12a= $item->created_at
            .content!= $item->content
            %btn.delete-btn#delete{"data-id" => $item->id} 删除
      .select-page 
        %span.choice-page
          != $items->links()

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"}
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body.clearfix
        %p.f24b.add-c 发布公告
        .controls.controls-row.mb24
          %label.input-caption.f14d 公告标题:
          %input.form-control.input-web-width#title{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d.input-top 公告正文:
          %span.area-width.area-height
            #edit-area
        %btn.f16d.add-btn-width.fr#submit 确认发布


@endsection

@section('script')
<script src="/js/wangEditor.min.js"></script>
<script src= "/js/admin-notice-index.js"></script>
@endsection