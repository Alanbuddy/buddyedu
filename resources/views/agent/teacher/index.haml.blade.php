@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/agent-teacher-add.css') }}">
<link rel="stylesheet" href="/css/jquery-ui.min.css">
:javascript
  window.teachers_index = "#{route('teachers.index')}"
  window.teachers_store = "#{route('users.store')}"

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/10.png"}
    %span.f24a.title#merchant-id{"data-merchant" => auth()->user()->ownMerchant->id} 授课老师

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 全部老师(23)
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入老师姓名/手机号", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}


  .desc-div
    // - if(count($items) == 0)
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "/icon/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 老师姓名
            %th 性别
            %th 年龄
            %th 当前开课/历史开课
            %th 手机号
        %tbody
          -foreach($items as $item)
            %tr
              %td=$item->name
              %td=$item->gender=='female'?'女':'男'
              %td=date('Y')-date('Y',strtotime($item->birthday))
              %td=$item->ongoingSchedules.'/'.$item->coaching_schedules_count
              %td.f12a=$item->phone

    .select-page
      %span.choice-page

#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"}
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/close.png"}
      .modal-body.clearfix
        %p.f24b.add-c 添加老师
        .controls.controls-row.mb24
          %label.input-caption.f14d 老师姓名
          %input.form-control.input-width#name{:type => "text"}
          %label.input-caption.f14d 手机号码
          %input.form-control.input-width#phone{:type => "text"}
          %label.input-caption.f14d 获得职称
          %select.form-control.input-width#title
            %option 请选择类型
            %option{value: "教授"} 教授
            %option{value: "副教授"} 副教授
            %option{value: "特级教师"} 特级教师
            %option{value: "高级教师"} 高级教师
            %option{value: "一级教师"} 一级教师
            %option{value: "二级教师"} 二级教师
            %option{value: "三级教师"} 三级教师

        .controls.controls-row.mb24
          %label.f14d 老师图像
          %input.hidden{:onchange => "upload(this)", :type => "file"}
          %span.course-icon-path{style: "display:none;"}
          %btn.upload-btn.f14b{:type => "button"} 上传
          %label.f14d 出生年份
          %input.form-control.input-width#datepicker{:type => "text"}
          %label.f14d 老师性别
          %select.form-control.input-width#gender{:type => "text"}
            %option 请选择
            %option{value: "male"} 男
            %option{value: "female"} 女
        .controls.controls-row.mb24
          %label.input-caption.f14d 资格证号
          %input.input-width.form-control#certificate
          %label.input-caption.f14d 身份证号
          %input.input-web-width.form-control#id
        .controls.controls-row.mb24
          %label.input-caption.f14d 毕业院校
          %input.input-width.form-control#school
          %label.input-caption.f14d 老师简介
          %input.input-web-width.form-control#desc
        .controls.controls-row.mb24
          %label.input-profile.f14d 老师简历
          %textarea.area-width.form-control.area-height#profile
        %btn.f16d.add-btn-width.fr#submit 确认添加
@endsection

@section('script')
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/datepicker-zh-TW.js"></script>
<script src= "/js/agent-teacher-add.js"></script>

@endsection