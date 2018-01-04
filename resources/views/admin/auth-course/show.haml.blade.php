@extends('layout.admin')
@section('css')
:javascript
  window.merchant_revoke = "#{route('merchant.course.authorize',[-1,$course,'revoke'])}"
  window.merchant_approve = "#{route('merchant.course.authorize',[-1,$course,'approve'])}"
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 课程授权 >
    %span.f16a.title= $course->name 

  .tab-title
    %ul.clearfix
      %li
        %a.f14c{href: route('courses.show', $course->id)} 课程信息
      %li.f14a.bg16b='授权机构('.$course->merchants()->count().')'
      %li
        %a.f14c{href: route('course.comment', $course->id)}='评论查看('.$course->comments()->count().')'

  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 机构名称
              %th 当前开设本课/历史开设本课
              %th 当前报名人数/历史报名人数
              %th 操作
          %tbody
            -foreach($items as $item)
              %tr
                %td=$item->name
                %td=$item->ongoingSchedulesCount.'/'.$item->schedules_count
                %td=$item->ongoingStudentsCount.'/'.$item->studentsCount
                - if($item->status == 'revoked')
                  %td.approve{"data-id" => $item->id } 重新授权
                - else
                  %td.revoke{"data-id" => $item->id } 取消授权

      .select-page 
        %span.choice-page
          != $items->links()
  
@endsection

@section('script')
<script src= "/js/course-auth.js"></script>

@endsection