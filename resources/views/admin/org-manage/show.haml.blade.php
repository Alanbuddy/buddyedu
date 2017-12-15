@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/auth-show.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.title-icon{src: "/icon/back.png"}
    %span.f16a.title 合作机构 >
    %span.f16a.title=$merchant->name
  .items-div
    %a.item-div{href:  route('merchant.courses')}
      %p.f16c 授权课程
      %p.f24b.mt16=$merchant->courses()->wherePivot('status','approved')->count().'门'
      %img{src: "/icon/more.png"} 
    %a.item-div{href:  route('merchant.courses')}
      %p.f16c 教学点
      %p.f24b.mt16=$merchant->points()->count().'个'
      %img{src: "/icon/more.png"}
    %a.item-div{href:  route('merchant.courses')}
      %p.f16c 授权老师
      %p.f24b.mt16=$merchant->teachers()->count().'位'
      %img{src: "/icon/more.png"}
    %a.item-div{href:  route('merchant.courses')}
      %p.f16c 收入总额
      %p.f24b.mt16='￥'.round($merchant->orders()->sum('amount')/100,2)
      %img{src: "/icon/more.png"}
  .tab-title
    -if(!$finished)
      %ul.clearfix
        %li.f14a.bg16b='当前开课('.$merchant->ongoingSchedules()->count().')'
        %li
          %a.f14c{href: route('merchants.show', $merchant)."?type=finished"}='历史开课('.$merchant->finishedSchedules()->count().')'
    -else
      %ul.clearfix
        %li
          %a.f14c{href: route('merchants.show', $merchant)}='当前开课('.$merchant->ongoingSchedules()->count().')'
        %li.f14a.bg16b='历史开课('.$merchant->finishedSchedules()->count().')'
    .user-search-box
      .search#search-btn
      %input.input-style#search-input.f14e{:type => "text", :placeholder => "输入课程名/老师名", value: "", :onfocus=>"this.style.color='#5d6578'"}

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
          %tbody
          -foreach($items as $item)
            %tr
              %td=$item->course->name
              %td 某一机构名称
              %td=$item->point->name
              %td
                -foreach($item->teachers as $teacher)
                  %span=$teacher->name
              %td=$item->students()->count().'/'.$item->quota
              -if($item->begin < date('Y-m-d H:i:s'))
                %td.green 上课中
              -else
                %td.orange 报名中

      .select-page 
        %span.choice-page
          != $items->link()
    
    

  
@endsection

@section('script')

@endsection