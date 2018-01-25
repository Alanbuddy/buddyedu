@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin-register.css') }}">
:javascript
  window.students_index = "#{route('students.index')}"
@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 当前开课 >
    %span.f16a.title= $schedule->course->name

  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('schedules.show', $schedule)} 基础信息
      %li.f14a.bg16b 报名情况
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入学生手机号/姓名", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}
      // - if($isBatch)
      //   %img.add-icon{src: "/icon/add.png"}

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
              %th 学生姓名
              %th 学生年龄
              %th 操作
          %tbody
            -foreach($items as $item)
              %tr
                %td=$item->phone
                %td=$item->name
                %td=(date('Y')-date('Y',strtotime($item->birthday))).'岁'
                %td
                  %a.delete 删除

      .select-page 
        %span.choice-page
          != $items->links()

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1", style: "z-index: 10006"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body.f14
        .search-div
          %p.f24b 学生选择
          .user-search-box
            .search#modal-search-btn
            %input.input-style#modal-search-input.f14e{:type => "text", :placeholder => "输入学生手机号/姓名", value: "", :onfocus=>"this.style.color='#5d6578'"}
        .checkbox-items
        
        .select-page
          %span.totalitems
          .quotes#Pagination
        .btn-div
          .btn.font-color1#confirm-btn{type: "button"} 确定

@endsection

@section('script')
<script src= "/js/admin-student-register.js"></script>

@endsection