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
    <title>急速审核</title>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/fastSH.css">
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
</head>
<body>
<header>
    <a id="back">
        <img src="/Public/img/return.png" alt="">
        返回
    </a>
    急速审核
</header>

<section class="logo">
    <img src="/Public/img/thunder.png" alt="">
</section>

<section>
    <p>VIP急速审核</p>
    <p class="red" id="fast"><?php echo ($fast); ?>元</p>
    <input type="button" id="demoBtn1" value="支付">
    <p class="sm">声明：如贷款未申请成功，<br>
        极速放款功能费用全额退款</p>
</section>

<form style='display:none;' id='formpay' name='formpay' method='post' action='https://pay.paysapi.com'>
    <input name='goodsname' id='goodsname' type='text' value='' />
    <input name='istype' id='istype' type='text' value='' />
    <input name='key' id='key' type='text' value=''/>
    <input name='notify_url' id='notify_url' type='text' value=''/>
    <input name='orderid' id='orderid' type='text' value=''/>
    <input name='orderuid' id='orderuid' type='text' value=''/>
    <input name='price' id='price' type='text' value=''/>
    <input name='return_url' id='return_url' type='text' value=''/>
    <input name='uid' id='uid' type='text' value=''/>
    <input type='submit' id='submitdemo1'>
</form>

<p id="loan_id" style="display: none"><?php echo ($loan_id); ?></p>
<script>
$().ready(function(){
    // function getistype(){
    //     return ($("#demo1-alipay").is(':checked') ? "1" : "2" ); 
    // }

    $("#demoBtn1").click(function(){
        $.post(
            "/payment/pay/payFunction",
            {
                price : parseFloat($("#fast").text()), 
                istype : 1,
                loan_id: $('#loan_id').text()
            },
            function(data){ 
                if (data.info.code > 0){
                    $("#goodsname").val(data.info.data.goodsname);
                    $("#istype").val(data.info.data.istype);
                    $('#key').val(data.info.data.key);
                    $('#notify_url').val(data.info.data.notify_url);
                    $('#orderid').val(data.info.data.orderid);
                    $('#orderuid').val(data.info.data.orderuid);
                    $('#price').val(data.info.data.price);
                    $('#return_url').val(data.info.data.return_url);
                    $('#uid').val(data.info.data.uid);
                    $('#submitdemo1').click();

                } else {
                    alert(data.info.msg);
                }
            }, "json"
        );
    });
});

$('#back').on('click', function(){
    window.history.back();
})
</script>
</body>
</html>