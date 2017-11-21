@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/org-manage.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/3.png"}
    %span.f24a.title 机构管理

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 合作机构(29)
    .search-add
      .user-search-box
        .search#search-btn
        %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名/老师名", value: "", :onfocus=>"this.style.color='#5d6578'"}
      %img.add-icon{src: "/icon/add.png"}  
  
  .desc-div.clearfix
    // - if(count($items) == 0) 
    //   .undiscover.f14
    //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
    // - else
    .table-box
      %table.table.table-hover.table-height
        %thead.f14b.th-bg
          %tr
            %th 机构名称
            %th 当前开课/历史开课
            %th 负责人
            %th 联系方式
            %th 课程状态
        %tbody
          %tr
            %td 某一机构名称
            %td １/5
            %td 负责人名字
            %td 13012345678
            %td.tip-parent
              %img{src:"/icon/attachment1.png"}
              .tooltip-div
                .triangle
                %img.close{src: "/icon/smallclose.png"}
                %btn.upload-btn.f14b 上传附件
                .file-div.f14d.clearfix
                  %span.fl 往来文件
                  %img.fr{src: "/icon/delete.png"}
                .file-div.f14d.clearfix
                  %span.fl 往来文件
                  %img.fr{src: "/icon/delete.png"}
    .select-page 
      %span.choice-page

@endsection

@section('script')
<script src= "/js/admin-course-index.js"></script>

@endsection