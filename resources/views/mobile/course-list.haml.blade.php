@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mobile-course-list.css') }}">
  
@endsection

@section('content')
.desc-div
  .items-div
    - if(count($items) == 0)
      .undiscover
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      - foreach($items as $item)
        %a.item-div.clearfix{href: route('landing',$item->id)}
          .img-div.fl
            %img.course-icon{src: $item->course->icon??'/icon/bird.png'}
          .course-div.fr
            .title-div.clearfix
              .caption-div.fl
                %span.f14.fb.caption= $item->course->name
                - if($item->begin>date('Y-m-d H:i:s') && $item->students_count<$item->quota && !$item->attended)
                  %span.status.f12 可报
              %p.course-price.fr.f14= '￥'.round($item->price/100,2)
            .time-div
              %img.icon{src: '/icon/mobile/timemini.png'}
              %span.f12.text-color= $item->begin.'~'.$item->end
            .address-div
              %img.icon{src: '/icon/mobile/locationmini.png'}
              %span.f12.text-color= $item->point->address

@endsection

@section('script')

@endsection
