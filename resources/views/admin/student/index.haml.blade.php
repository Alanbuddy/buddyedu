@extends('layout.admin')
@section('css')
:javascript
  window.students_search = "#{route('users.index')}"

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
        %img.title-icon{src: "/icon/back.png"}
      %span.f16a.title= '搜索"'.$key.'"'

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b= "全部学生(".$items->total().")"
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入学生手机号/姓名", value: "", :onfocus=>"this.style.color='#5d6578'"}

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

@endsection

@section('script')
<script src= "/js/admin-student.js"></script>

@endsection