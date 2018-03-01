@extends('layout.agent')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/point-show.css') }}">
:javascript
  window.point_update = "#{route('points.update',$point->id)}"
  window.point_show = "#{route('points.show', $point->id)}"
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
      %p.f24b#edu-name= $point->name
    .info-div.f14d
      .p-div
        %span.left 占地面积：
        %span.unedit#area= $point->area.'m²'
        %input.form-control.edit-input#edu-area{value: $point->area}
      .p-div
        %span.left 负责人：
        %span.unedit#admin= $point->admin
        %input.form-control.edit-input#edu-admin{value: $point->admin}
      .p-div
        %span.left 联系方式：
        %span.unedit#contact= $point->contact
        %input.form-control.edit-input#edu-phone{value: $point->contact}
      .p-div
        %span.left 地址信息：
        %span.unedit#location{"data-pro" => $point->province, "data-ci" => $point->city, "data-co" => $point->county}= $point->province.$point->city.$point->county.$point->address
        %span.citys.edit
          %select.form-control#province
          %select.form-control#city
          %select.form-control#county
      .p-div.edit
        %span.left 详细地址：
        %input.form-control.edit-input#street{value: $point->address}
      .p-div.edit
        %span.left 申请备注：
        %input.form-control.edit-input#remark{:type => "text", placeholder: "必填"}
      .p-div.clearfix
        %span.left#map.fl{"data-geo" => $point->geolocation} 所在地：
        .new-map
          %p.get-location.edit 获取地址
          #container
      .p-div
        %btn.modify-btn-width.fr#point-modify{"data-text" => "true"} 修改
      .p-div
        %btn.modify-btn-width.fr#confirm 确定


@endsection

@section('script')
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
<script src="/js/agent-point-show.js"></script>
<script src="/js/city.js"></script>

@endsection