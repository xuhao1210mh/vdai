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
    <title>认证</title>
    <!--<link rel="stylesheet" href="css/base.css">-->
    <link rel="stylesheet" href="/Public/css/login.css">
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <script src="/Public/js/dsbridge.js"></script>
</head>
<body>
<header>
        <img src="/Public/img/vdLogo.png" alt="" style="width: 1.33rem;height: 1.33rem;margin-bottom: 0.5rem">
        <img src="/Public/img/VD.png" alt="">
        <img src="/Public/img/login.png" class="dengl" alt="">
</header>

<!--bg-->
<main>
    <section>
        <input class="one" type="text" placeholder="登录账号" id="username">
    </section>
    <section>
        <input type="password" placeholder="输入密码" id="password">
    </section>
    <section>
        <div class="p">
            <p class="fl wj"><a href="" id="forget">忘记密码?</a></p>
            <P class="fr zc"><a href="" id="register">注册账号</a></P>
        </div>
    </section>
    <section class="login">
        <input type="button" value="登录" id="submit">
    </section>

</main>
<!--  -->
<script>
$(function(){
    $.ajax({
        url: "<?php echo U('Desk/index/checkLogin');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            if(data.status == 1){
                location.href = data.url;
            }else{
                //console.log(data.info);
            }
        }
    });
})

$('#submit').on('click', function(){
    $.ajax({
        url: "<?php echo U('Desk/index/login');?>",
        type: "post",
        dataType: "json",
        data: {
            username: $('#username').val(),
            password: $('#password').val()
        },
        success: function(data){
            if(data.status == 1){
                location.href = data.url;
            }else{
                dsBridge.call("toast", data.info);
            }
        }
    });
});   

$('#register').on('click', function(){
    $.ajax({
        url: "<?php echo U('/desk/tools/jump');?>",
        type: "post",
        dataType: "json",
        data: {
            flag1: 'desk',
            flag2: 'index',
            flag3: 'register'
        },
        success: function(data){
            location.href = data.url;
        }
    });
}) 

$('#forget').on('click', function(){
    $.ajax({
        url: "<?php echo U('/desk/tools/jump');?>",
        type: "post",
        dataType: "json",
        data: {
            flag1: 'desk',
            flag2: 'index',
            flag3: 'resetPW'
        },
        success: function(data){
            location.href = data.url;
        }
    });
});
</script>
</body>
</html>