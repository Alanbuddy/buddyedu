!!!
%html{user: !empty($user)?$user->id:''}
  %head
    %meta{:charset => "utf-8"}
    %meta{:content => "IE=edge", "http-equiv" => "X-UA-Compatible"}
    %meta{:content => "width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0", :name => "viewport"}
    %meta{"content:" => "telephone=no", :name => "format-detection"}
    %meta{"content:" => "email=no", :name => "format-detection"}
    %title 云课系统
    %link{:href => "/css/bootstrap.min.css", :rel => "stylesheet"}
    %link{:href => "/css/sign-layout.css", :rel => "stylesheet"}
    :javascript
      window.register = "#{route('register')}"
      window.forget = "#{route('password.request')}"
      window.login = "#{route('login')}"
      window.log_index = "#{route('schedules.index')}"
  %body
    .wrapper
      .content-area
        .img-div
          %img.logo{src: "/icon/bird.png"}
          %p.desc-word 这是一些说明文字
        .desc-div
          .input-div
            %p.log-title 登录
            .input-group
              %span.input-group-addon.miniphoto
              %input.form-box.f16#mobile{placeholder: "请输入您的手机号", type: "text"} 
            %p.notice.f14#error_notice 手机号或密码错误
            - if(!empty($user))
              %p.notice-user.f14#lock-notice 请通知管理员开通您的账号
            .input-group.no-margin-bottom
              %span.input-group-addon.password-photo
              %input.form-box.f16#password{placeholder: "请输入密码", type: "password"} 
            %span.forget.f16.fr.pointer#to_forget_password 忘记密码?
            // %span.forget.f16.fr.pointer#to_forget_password 修改密码?
            %button.btn.click-btn.f24.mt26#signin_btn{type: "button"} 立即登录
            %p.signup.f16.pointer#to_signup 没有账号？立即注册
          
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src = "/js/ajax.js"></script>
    <script src = "/js/regex.js"></script>
    <script src = "/js/admin-login.js"></script>
 