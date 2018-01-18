@extends('layout.mobile')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/student-product.css') }}">
@endsection

@section('content')
.desc-div
  %p.f16.fb.title.mb40=$drawing->student->name.'的作品'
  %p.f12.date.mb40=$drawing->created_at
  %img.product.mb40{src: $drawing->path }
  -if($video)
    %video.product.mb80{src: $video->path }
  %p.f14.title 我画的小动物“活”了，小玩伴们一起来体验吧!
@endsection

@section('script')
<script src= ""></script>
@endsection