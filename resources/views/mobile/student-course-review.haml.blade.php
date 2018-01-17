@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-course-review.css') }}">
@endsection

@section('content')
.desc-div
  .title-div.mb48
    %span.f16.fb.title 课程评论
    %span.f14.fb.title= '('.$items->total().')'
  .items
    - if(count($items) == 0)
      .undiscover
        %img.undiscover-icon{src: "/icon/undiscover.png"}
    - else
      - foreach($items as $item)
        .item.mb48
          .avatar-div
            %img.avatar{src: "/icon/mobile/avatar.png"}
            .caption-div
              %p.f14.fb.text-color=$item->user->name
              %p.f12.date-color= $item->created_at
          %p.f14.text-color= $item->content

   
@endsection

@section('script')
<script src= ""></script>
@endsection