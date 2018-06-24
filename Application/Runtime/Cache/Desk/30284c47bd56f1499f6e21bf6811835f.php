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
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <script src="/Public/js/dsbridge.js"></script>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/perCenter.css">
</head>
<body>
<header>
    个人中心
</header>

<!--bg-->
<main>
    <section>
        <div class="blue"></div>
        <div class="info" id="my_loan">
            <img src="/Public/heads/<?php echo ($result[0]["head"]); ?>" class="cat" alt="">
            <p class="name"><?php echo ($result[0]["nickname"]); ?></p>
            <p class="num"><?php echo ($result[0]["username"]); ?></p>
            <img src="/Public/img/loan.png" class="loan" alt="">
            <p class="ml">我的贷款</p>
        </div>
    </section>

    <section class="two">
        <a href="javascript:;" id="about"><p><img src="/Public/img/icon5.png" alt="">关于我们</p></a>
        <a href="javascript:;" id="update"><p><img src="/Public/img/icon6.png" alt="">版本更新</p></a>
        <a href="javascript:;" id="setting"><p><img src="/Public/img/icon7.png" alt="">设置</p></a>
    </section>

    <section style="text-align: center;margin-top: 2.3rem;font-size: 0.16rem">
        <a href="javascript:;">在线客服</a>	&nbsp;|	&nbsp;<a href="javascript:;">客服电话</a>
        <p style="margin-top: 0.2rem">9:00-18:00</p>
    </section>

    <section class="three" style="margin-top:0 ">
        <a class="fl home" href="/desk/index/index" id="index"><img src="/Public/img/homeH.png" alt=""><span>首页</span></a>
        <a href="javascript:;" class="fr person"><img src="/Public/img/people.png" alt=""><span>个人中心</span></a>
    </section>
    
</main>
<!--  -->
<script>

$('#about').on('click', function(){
    $.ajax({
        url: "<?php echo U('/desk/center/aboutus');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            location.href = data.url;
        }
    });
})

$('#my_loan').on('click', function(){
    $.ajax({
        url: "<?php echo U('/desk/center/myLoan');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            //console.log(data);
            location.href = data.url;
        }
    });
})

$('#setting').on('click', function(){
    $.ajax({
        url: "<?php echo U('/desk/center/setting');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            //console.log(data);
            location.href = data.url;
        }
    });
})

$('#update').on('click', function(){
    $.ajax({
        url: "<?php echo U('/desk/center/printSession');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            //console.log(data);
            //location.href = data.url;
        }
    });
})
</script>
</body>
</html>