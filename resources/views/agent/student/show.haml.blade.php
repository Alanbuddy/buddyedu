@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{mix('/css/student-show.css')}}">
:javascript
  window.sign = "#{route('user.attendances',[$user->id,-1])}"
  window.comment = "#{route('course.comment',-1)."?user_id=".$user->id}"
@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 学生管理 >
    %span.f16a.title=$user->name

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 报名信息

  .desc-div
    - if(count($items) == 0) 
      .undiscover.f14
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      .table-box
        %table.table.table-hover.table-height
          %thead.f14b.th-bg
            %tr
              %th 课程名称
              %th 开课机构
              %th 教学点
              %th 上课老师
              %th 报名人数/班级人数
              %th 课程状态
              %th 上课情况
          %tbody
            -foreach($items as $item)
              %tr
                %td=$item->course->name
                %td=$item->merchant->name
                %td=$item->point->name
                %td 老师名字
                %td=$item->students()->count().'/'.$item->quota
                -if(strtotime($item->end) < time())
                  %td 已结课
                -else if(strtotime($item->begin)>time())
                  %td.orange 报名中
                -else
                  %td.green 上课中

                %td.tip-parent{"data-id" => $item->id, "data-cid" => $item->course->id, "data-request" => "false"}
                  %img.class-state{src: "/icon/class1.png"}
                  .tooltip-div
                    .triangle
                    %img.close{src: "/icon/smallclose.png"}
                    .box-div
                    .span-div
                      %span.f14b 课程评论
                      - if(!$item->valid)
                        %span.f12a (屏蔽)
                    .review.f12a
           
      .select-page 
        %span.choice-page
          != $items->links()

  
@endsection

@section('script')
<script src= "/js/admin-student-show.js"></script>

@endsection