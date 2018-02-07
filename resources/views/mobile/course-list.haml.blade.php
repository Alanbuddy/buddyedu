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
            %img.course-icon{src: $item->course->icon??'/icon/logo.png'}
          .course-div.fr
            .title-div
              .caption-div
                %span.f14.fb.caption= $item->course->name
                - if($item->begin>date('Y-m-d H:i:s') && $item->students_count<$item->quota)
                  %span.status.f12 可报
            .time-div
              %img.icon{src: '/icon/mobile/timemini.png'}
              %span.f12.text-color= date('Y/m/d', strtotime($item->begin)).'~'.date('Y/m/d', strtotime($item->end))
            .merchant-div.mb10
              %img.icon{src: '/icon/mobile/point.png'}
              %span.f12.text-color= $item->merchant->name 
            .address-div
              %img.icon{src: '/icon/mobile/locationmini.png'}
              %span.f12.text-color= $item->point->address

@endsection

@section('script')

@endsection
