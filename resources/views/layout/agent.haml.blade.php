!!!
%html
  %head
    %meta{:charset => "utf-8"}
    %meta{:content => "IE=edge", "http-equiv" => "X-UA-Compatible"}
    %meta{:content => "width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0", :name => "viewport"}
    %meta{"content:" => "telephone=no", :name => "format-detection"}
    %meta{"content:" => "email=no", :name => "format-detection"}
    %title
      @yield('title') 管理员
    %link{:href => "/css/bootstrap.min.css", :rel => "stylesheet"}
    %link{:href => "/css/notification.css", :rel => "stylesheet" }
    %link{:href => "/css/admin-layout.css", :rel => "stylesheet"}
    %link{:href => "/css/pagination.css", :rel => "stylesheet"}
    %link{:href => "/css/wangEditor.min.css", :rel => "stylesheet"}

    @yield('css')
    :javascript
      window.token = "#{csrf_token()}"
      window.fileUpload = "#{route('files.store')}"
  %body
    .wrapper
      .layout-left
        %img.logo{src: "/icon/bird.png"}
        .main
          .sidebar
            %ul
              %li
                %a.active_li{href: "#"}
                  %img.mini-icon{src: "/icon/1A.png"}
                  %span.f16c.sidebar-title 开课情况
              %li
                %a.a-item{:href => "#"}
                  %img.mini-icon{src: "/icon/2A.png"}
                  %span.f16c.sidebar-title 课程授权
              %li
                %a.a-item{:href => "#"}
                  %img.mini-icon{src: "/icon/9A.png"}
                  %span.f16c.sidebar-title 教学点
              %li
                %a.a-item{:href => "#"}
                  %img.mini-icon{src: "/icon/10A.png"}
                  %span.f16c.sidebar-title 授课老师
              %li
                %a.a-item{:href => "#"}
                  %img.mini-icon{src: "/icon/4A.png"}
                  %span.f16c.sidebar-title 学生管理
              %li
                %a.a-item{:href => "#"}
                  %img.mini-icon{src: "/icon/5A.png"}
                  %span.f16c.sidebar-title 金额统计
              %li
                %a.a-item{:href => "#"}
                  %img.mini-icon{src: "/icon/6A.png"}
                  %span.f16c.sidebar-title 学生统计
              %li.apply
                %a.a-item{href: "#"}
                  %img.mini-icon{src: "/icon/7A.png"}
                  %span.f16c.sidebar-title 通知查看
              %li.logout
                %a.a-item{:href => "#"}
                  %img.mini-icon{src: "/icon/8A.png"}
                  %span.f16c.sidebar-title 退出登录
          
      .content-area
        @yield('content')
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src = "/js/ajax.js"></script>
    <script src = "/js/regex.js"></script>
    <script src = "/js/mobile-notification.js"></script>
    <script src="/js/jquery.pagination.js"></script>



    @yield('script')