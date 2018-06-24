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
    <title>首页</title>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/index.css">
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <!-- <script src="https://unpkg.com/dsbridge/dist/dsbridge.js"> </script> -->
    <script src="/Public/js/dsbridge.js"></script>
</head>
<body>
<header>
    <p class="vd">V贷</p>
    <p class="able">最高贷款金额</p>
    <p class="num"><?php echo ($result[0]["sum"]); ?>元</p>
    <input type="text" placeholder="请输入您的姓名" id="name">
    <input type="number" class="yourNum" placeholder="请输入您的电话" id="number">
    <input class="loan" type="button" value="申请贷款" id="submit">
</header>

<main>
    <section class="one">
        <img src="/Public/img/lianheZX.png" alt="">
    </section>

    <section class="clearFix">
        <div class="fmj">
            <span><img src="/Public/img/money.png" alt="">v秒借</span>
            <span class="top"><img src="/Public/img/top.png" alt=""></span>
        </div>
        <div class="fl num">
            <p class="kw">1K-2W</p>
            <p class="kdje">可贷金额</p>
        </div>
        <div class="data">
            <p>24小时快速放款</p>
            <p class="time">贷款期限12月</p>
            <input type="button" value="立即贷款" id="submit_2">
        </div>
    </section>

    <div class="tip">"不向学生提供借钱服务，网贷有风险，贷款需谨慎，放款时间.金额.因个人情况不同额度有所不同"</div>

    <section class="three">
        <a href="" class="fl home"><img src="/Public/img/home.png" alt=""><span>首页</span></a>
        <a class="fr person" id="personal_center"><img src="/Public/img/person.png" alt=""><span>个人中心</span></a>
    </section>


</main>


<!--  -->
<script>

    $('#submit').on('click', function(){
        var name = $('#name').val();
        var number = $('#number').val();
        if(name == '' || number == ''){
            dsBridge.call("toast", "请填写相关信息");
        }else{
            $.ajax({
                url: "<?php echo U('Desk/loan/fill');?>",
                type: "post",
                dataType: "json",
                data: {
                    name: $('#name').val(),
                    number: $('#number').val()
                },
                success: function(data){
                    //console.log(data);
                    if(data.status == 1){
                        location.href = '/desk/loan/assetSubmit';
                    }else{
                        dsBridge.call("toast", data.info);
                    }
                }
            });
        }
    });

    $('#submit_2').on('click', function(){
        $.ajax({
            url: "<?php echo U('/Desk/index/secondLoan');?>",
            type: "post",
            dataType: "json",
            success: function(data){
                if(data.status == 1){
                    dsBridge.call("toast", data.info);
                }else{
                    dsBridge.call("toast", data.info);
                }
            }
        });
    })

    $('#personal_center').on('click', function(){
        location.href = '/desk/center/personalCenter'
    })
  
</script>
</body>
</html>