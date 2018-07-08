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
    <title>审核结果</title>
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <script src="/Public/js/dsbridge.js"></script>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/shResult1.css">
</head>
<body>
<header>
    <a class="back">
        <img src="/Public/img/return.png" alt="">
        返回
    </a>
    审核结果
</header>

<section class="one">
    <div class="line">
        <img class="one" src="/Public/img/roundSX.png" alt="">
        <div class="line1"></div>
        <img class="two" src="/Public/img/roundKX.png" alt="">
        <div class="line2"></div>
        <img class="three" src="/Public/img/roundKX.png" alt="">
        <div class="line3"></div>
        <img class="four" src="/Public/img/roundKX.png" alt="">
        <div class="line4"></div>
        <img class="five" src="/Public/img/roundKX.png" alt="">
    </div>
    <div class="tip">
        <span>提交资料</span>
        <span>等待审核</span>
        <span>批款额度</span>
        <span>等待放款</span>
        <span class="last">放款成功</span>
    </div>
</section>

<section class="two">
    <p>请耐心等待工作人员审核结果</p>
    <input type="button" value="确定" class="back">
    <button type="button" id="payMoney">急速审核</button>
    <p class="red">无需等待，立即查看可贷额度</p>
    <button type="button" id="auto_check">自动审批</button>
</section>

<p id="loan_id" style="display: none"><?php echo ($loan_id); ?></p>
<!--  -->
<script>
$('.back').on('click', function(){
    location.href = '/desk/center/myLoan';
})

$('#payMoney').on('click', function(){
    location.href = '/payment/pay/fastSH?loan_id=<?php echo ($loan_id); ?>';
})

$('#auto_check').on('click', function(){
    $.ajax({
        url: "<?php echo U('/desk/result/autoCheck');?>",
        type: "post",
        dataType: "json",
        data: {
            loan_id: $('#loan_id').text()
        },
        success: function(data){
            if(data.status == 1){
                //console.log(data.info);
                dsBridge.call("toast", data.info);
                location.href = data.url;
            }else{
                console.log(data.info);
                dsBridge.call("toast", data.info);
            }
        }
    })
})
</script>
</body>
</html>