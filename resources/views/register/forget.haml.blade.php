!!!
%html
  %head
    %meta{:charset => "utf-8"}
    %meta{:content => "IE=edge", "http-equiv" => "X-UA-Compatible"}
    %meta{:content => "width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0", :name => "viewport"}
    %meta{"content:" => "telephone=no", :name => "format-detection"}
    %meta{"content:" => "email=no", :name => "format-detection"}
    %title 云课系统
    %link{:href => "/css/bootstrap.min.css", :rel => "stylesheet"}
    %link{:href => "/css/sign-layout.css", :rel => "stylesheet"}
    
  %body
    .wrapper
      .content-area
        .img-div
          %img.logo{src: "/icon/bird.png"}
          %p.desc-word 这是一些说明文字
        .desc-div
          .input-div
            %p.register-title 忘记密码
            // %p.register-title 修改密码
            .input-group.no-margin-bottom
              %span.input-group-addon.miniphoto
              .input-inside-div
                %input.form-box.form-verify-box.f16#mobile{placeholder: "请输入您的手机号", type: "text"}
                %span.verify-code-span.f16.pointer#verifycode 获取验证码
            %p.notice.f14#mobile_notice 请输入正确的手机号
            .input-group.no-margin-bottom
              %span.input-group-addon.verify-photo
              %input.form-box.f16#mobilecode{placeholder: "请输入验证码", type: "text"}
            %p.notice.f14#code_notice 验证码错误 
            .input-group
              %span.input-group-addon.password-photo
              %input.form-box.f16#password{placeholder: "请设置密码", type: "password"} 
            %button.btn.click-btn.f24.margin-t48#end_btn{type: "button"} 完成
            %p.signup.f16.pointer#to_signin 未忘密码？立即登录
            // %p.signup.f16.pointer#to_signin 不想修改？返回登录
          
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src = "/js/ajax.js"></script>
    <script src = "/js/regex.js"></script>
 