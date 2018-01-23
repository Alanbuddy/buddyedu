@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-add.css') }}">
<link rel="stylesheet" href="/css/jquery-ui.min.css">
:javascript
  window.students_search = "#{route('users.index')}"
  window.students_store = "#{route('users.store')}"

@endsection

@section('content')

.main-content
  - if(!$key)
    .title-div
      %img.title-icon{src: "/icon/4.png"}
      %span.f24a.title 学生管理
  - else
    .title-div
      %a{href: route('users.index')}
        %img.back-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b= "全部学生(".$items->total().")"
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入学生手机号/姓名", value: "", :onfocus=>"this.style.color='#5d6578'"}
      - if($hasBatchCourse)
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
              %th 手机号
              %th 学生姓名
              %th 学生年龄
              %th 报名课程
              %th 缴费总额
          %tbody
            -foreach($items as $item)
              %tr
                %td
                  %a{href: route('users.show', $item->id)}=$item->phone
                %td=$item->name
                %td=$item->birthday??'未知'
                %td=$item->enrolled_shedules_count
                %td.f12a='￥'.($item->total??0)

      .select-page
        %span.choice-page
          != $items->links()

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body
        %p.f24b.add-c 添加学生
        .controls.controls-row.mb24
          %label.input-caption.f14d 学生姓名:
          %input.form-control.input-width#name{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 手机号码:
          %input.form-control.input-width#phone{:type => "text"}
        .controls.controls-row.mb24
          %label.input-caption.f14d 学生性别:
          %select.form-control.input-width#gender
            %option 请选择性别
            %option{value: "male"} 男
            %option{value: "female"} 女
        .controls.controls-row.mb24
          %label.input-caption.f14d 学生生日:
          %input.form-control.input-width#datepicker{:type => "text"}
        .btn-div     
          %btn.f16d.add-btn-width#submit 立即添加
@endsection

@section('script')
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/datepicker-zh-TW.js"></script>
<script src= "/js/admin-student.js"></script>

@endsection