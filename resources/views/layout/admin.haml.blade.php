!!!
%html
  %head
    %meta{:charset => "utf-8"}
    %meta{:content => "IE=edge", "http-equiv" => "X-UA-Compatible"}
    %meta{:content => "width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0", :name => "viewport"}
    %meta{"content:" => "telephone=no", :name => "format-detection"}
    %meta{"content:" => "email=no", :name => "format-detection"}
    %title
      @yield('title') 管理端
    %link{:href => "/css/bootstrap.min.css", :rel => "stylesheet"}
    %link{:href => "/css/notification.css", :rel => "stylesheet" }
    %link{:href => "/css/admin-layout.css", :rel => "stylesheet"}
    %link{:href => "/css/pagination.css", :rel => "stylesheet"}
    %link{:href => "/css/wangEditor.min.css", :rel => "stylesheet"}

    @yield('css')
    :javascript
      window.token = "#{csrf_token()}"
      window.fileUpload = "#{route('files.store')}"
      window.logout = "#{route('logout')}"
      window.login = "#{route('login')}"
  %body
    .wrapper
      .layout-left
        .logo-div
          %img.logo{src: "/icon/logo.png"}
        .main
          .sidebar
            %ul
              %li
                %a.a-item{href: route('schedules.index')}
                  %img.mini-icon{src: "/icon/1A.png"}
                  %span.fb.sidebar-title 开课情况
              %li
                %a.a-item{:href => route('courses.index')}
                  %img.mini-icon{src: "/icon/2A.png"}
                  %span.fb.sidebar-title 课程授权
              %li
                %a.a-item{:href => route('merchants.index')}
                  %img.mini-icon{src: "/icon/3A.png"}
                  %span.fb.sidebar-title 机构管理
              %li
                %a.a-item{:href => route('notices.index')}
                  %img.mini-icon{src: "/icon/11A.png"}
                  %span.fb.sidebar-title 公告发布
              %li
                %a.a-item{:href => route('users.index')}
                  %img.mini-icon{src: "/icon/4A.png"}
                  %span.fb.sidebar-title 学生管理
              %li
                %a.a-item#amount_a{:href => route('orders.stat-group-by-merchant')}
                  %img.mini-icon{src: "/icon/5A.png"}
                  %span.fb.sidebar-title 金额统计
              %li
                %a.a-item{:href => route('users.statistics')}
                  %img.mini-icon{src: "/icon/6A.png"}
                  %span.fb.sidebar-title 信息统计
              %li.apply
                %a.a-item#process_a{href: route('merchant.course.application')}
                  %img.mini-icon{src: "/icon/7A.png"}
                  %span.fb.sidebar-title 申请处理
              %li.client
                %a.a-item{href: route('admins.index')}
                  %img.mini-icon{src: "/icon/10A.png"}
                  %span.fb.sidebar-title 人员管理
              %li.logout
                %a.a-item#exit{href: "javascript:void(0)"}
                  %img.mini-icon{src: "/icon/8A.png"}
                  %span.fb.sidebar-title 退出登录
          
      .content-area
        @yield('content')
<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src = "/js/ajax.js"></script>
<script src = "/js/regex.js"></script>
<script src = "/js/mobile-notification.js"></script>
<script src="/js/jquery.pagination.js"></script>
<script src="/js/admin-layout.js"></script>

@yield('script')