@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/point-show.css') }}">

@endsection

@section('content')

.main-content
  .title-div
    %img.back-icon{src: "/icon/back.png"}
    %span.f16a.title 教学点 >
    %span.f16a.title 位置信息

  .tab-title
    %ul.clearfix
      %li.f14a.bg16b 位置信息

  .desc-div
    .name-div
      %p.f24b 教学点的长名称
    .info-div.f14d
      .p-div
        %span.left 占地面积：
        %span.unedit= $point->area.'m²'
        %input.form-control.edit-input
      .p-div
        %span.left 负责人：
        %span.unedit= $point->admin
        %input.form-control.edit-input
      .p-div
        %span.left 联系方式：
        %span.unedit= $point->contact
        %input.form-control.edit-input
      .p-div
        %span.left 地址信息：
        %span.unedit= $point->province.$point->city.$point->county.$point->address
        %span.citys.edit
          %select.form-control#province
          %select.form-control#city
          %select.form-control#county
      .p-div.clearfix
        %span.left#map.fl{"data-geo" => $point->geolocation} 所在地：
        %span.unedit#container
        .new-map.edit
          %p.get-location 获取地址
          #new-container
      .p-div
        %btn.modify-btn-width.fr#modify 修改
      .p-div
        %btn.modify-btn-width.fr#confirm 确定


@endsection

@section('script')
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
<script src="/js/agent-point-show.js"></script>
<script src="/js/city.js"></script>

@endsection