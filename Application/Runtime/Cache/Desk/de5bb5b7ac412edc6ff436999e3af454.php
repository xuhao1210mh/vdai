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
    <title>我的贷款</title>
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/myLoan.css">
</head>
<body>
<!--nav-->
<header>
    <a href="">
        <img src="/Public/img/return.png" alt="">
        返回
    </a>
    我的贷款
</header>
<!--pannel-->

<section>
    <?php if(is_array($result)): foreach($result as $key=>$val): ?><div class="panel">
            <div class="panel-body">
                <p>贷款金额：<?php echo ($val["sum"]); ?></p>
                <!-- <p>当前已还: 20000</p> -->
                <p>贷款时间: <span> <?php echo ($val["deadline"]); ?></span></p>
                <div class="rate">
                    总利率:<?php echo ($val["interest"]); ?>  &#160;&#160;还款方式：<?php echo ($val["method"]); ?> &#160;&#160; 月利率：<?php echo ($val["mon_interest"]); ?>
                </div>
                <div class="img"><img src="/Public/img/icon1.png" alt=""></div>
                <p class="top">教育</p>
            </div>
            <div class="panel-heading">
                <h3 class="panel-title"><a href="">还款</a></h3>
            </div>
        </div><?php endforeach; endif; ?>

    <!-- <div class="panel">
        <div class="panel-body">
            <p>贷款金额：20000</p>
            <p>当前已还: 20000</p>
            <p>贷款时间: <span> 2018/12/21-2019/12/21</span></p>
            <div class="rate">
                总利率:自动核算   &#160;&#160;  还款方式：银行卡   &#160;&#160;  月利率：自动核算
            </div>
            <div class="img"><img src="/Public/img/icon2.png" alt=""></div>
            <p class="top">买房</p>
        </div>
        <div class="panel-heading">
            <h3 class="panel-title"><a href="">还款</a></h3>
        </div>
    </div> -->

    <!-- <div class="panel">
        <div class="panel-body">
            <p>贷款金额：20000</p>
            <p>当前已还: 20000</p>
            <p>贷款时间: <span> 2018/12/21-2019/12/21</span></p>
            <div class="rate">
                总利率:自动核算  &#160;&#160;还款方式：银行卡  &#160;&#160;月利率：自动核算
            </div>
            <div class="img"><img src="/Public/img/icon3.png" alt=""></div>
            <p class="top">买车</p>
        </div>
        <div class="panel-heading">
            <h3 class="panel-title"><a href="">还款</a></h3>
        </div>
    </div> -->


</section>


</body>
</html>