<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script>
        //designWidth:设计稿的实际宽度值，需要根据实际设置
        //maxWidth:制作稿的最大宽度值，需要根据实际设置
        //这段js的最后面有两个参数记得要设置，一个为设计稿实际宽度，一个为制作稿最大宽度，例如设计稿为750，最大宽度为750，则为(750,750);
        (function(designWidth, maxWidth) {
            var doc = document,
                win = window,
                docEl = doc.documentElement,
                remStyle = document.createElement("style"),
                tid;

            function refreshRem() {
                var width = docEl.getBoundingClientRect().width;
                maxWidth = maxWidth || 540;
                width>maxWidth && (width=maxWidth);
                var rem = width * 100 / designWidth;
                remStyle.innerHTML = 'html{font-size:' + rem + 'px;}';
            }

            if (docEl.firstElementChild) {
                docEl.firstElementChild.appendChild(remStyle);
            } else {
                var wrap = doc.createElement("div");
                wrap.appendChild(remStyle);
                doc.write(wrap.innerHTML);
                wrap = null;
            }
            //要等 wiewport 设置好后才能执行 refreshRem，不然 refreshRem 会执行2次；
            refreshRem();

            win.addEventListener("resize", function() {
                refreshRem();
                // clearTimeout(tid); //防止执行两次
                // tid = setTimeout(refreshRem, 300);
            }, false);

            win.addEventListener("pageshow", function(e) {
                if (e.persisted) { // 浏览器后退的时候重新计算
                    refreshRem();
                    // clearTimeout(tid);
                    // tid = setTimeout(refreshRem, 300);
                }
            }, false);

            if (doc.readyState === "complete") {
                doc.body.style.fontSize = "16px";
            } else {
                doc.addEventListener("DOMContentLoaded", function(e) {
                    doc.body.style.fontSize = "16px";
                }, false);
            }
        })(750, 750);
    </script>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>注册</title>
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <script src="/Public/js/dsbridge.js"></script>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/zhuce.css">
</head>
<body>
<header>
    <a href="/" id="back">
        <img src="/Public/img/icon4.png" alt="">
        <span>返回</span>
    </a>
</header>

<!--bg-->
<main>

    <section>
        <div>
            注册
        </div>
    </section>

    <section>
        <input class="one" type="text" placeholder="手机号" id="number">
    </section>

    <section>
        <input type="password" placeholder="输入密码" id="password">
    </section>

    <section class="half .clearFix">
        <input type="text" class="fl .clearFix" placeholder="输入验证码" id="captcha"><input class="fr blue .clearFix" type="button" value="手机验证" id="get_captcha">
    </section>

    <section class="change">
       <input type="submit" class="blue" value="注册" id="register">
    </section>

</main>

<!--  -->
<script>

$('#get_captcha').on('click', function(){
    if($('#number').val() == ''){
        dsBridge.call("toast", "请输入手机号");
        return false;
    }
    $.ajax({
        url: "<?php echo U('desk/captcha/getCaptcha');?>",
        type: "post",
        dataType: "json",
        data: {
            number: $('#number').val()
        },
        success: function(data){
            if(data.status == 1){
                dsBridge.call("toast", data.info);
            }else{
                dsBridge.call("toast", data.info);
            }
        }
    });
})

$('#register').on('click', function(){
    var username = $('#number').val();
    var password = $('#password').val();
    var captcha = $('#captcha').val();
    if(username == '' || password == '' || captcha == ''){
        dsBridge.call("toast", "请填写登陆信息");
        return false;
    }
    $.ajax({
        url: "<?php echo U('desk/index/register');?>",
        type: "post",
        dataType: "json",
        data: {
            username: username,
            password: password,
            captcha: captcha,
            head: 'cat.png'
        },
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                dsBridge.call("toast", data.info);
                location.href = data.url;
            }else{
                dsBridge.call("toast", data.info);
            }
        }
    });
}) 

</script>
</body>
</html>