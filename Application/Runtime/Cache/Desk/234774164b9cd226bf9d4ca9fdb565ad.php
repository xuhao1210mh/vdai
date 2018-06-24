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
    <title>资料提交</title>
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/assetSubmit.css">
</head>
<body>
<div class="grey" style="display: none"></div>
<header>
    <a href="#">
        <img src="/Public/img/return.png" alt="">
        返回
    </a>
    资料提交
</header>

<section>
    <img src="/Public/img/icon8.png" alt="">
    <p>借款金额 <input type="text" placeholder="最高可贷30000元" id="sum"></p>
    <p>还款方式 <a id="hk" href="#">请选择还款方式<img src="/Public/img/arrow_right.png" alt=""></a></p>
    <p>还款期限 <a href="#" id="deadline">请选择借款期限<img src="/Public/img/arrow_right.png" alt=""></a></p>
    <p>总利息 <span id="interest">0.00</span></p>
    <p>月利息 <span id="mon_interest">0.00</span></p>
    <p>借款手续费 <span id="poundage">18%</span></p>
    <p>贷款用途 <a href="#" id="use">请选择借款用途 <img src="/Public/img/arrow_right.png" alt=""></a></p>
    <button type="button" id="submit">确认</button>
    <p id="id"><?php echo ($_SESSION['id']); ?></p>
    <p id="name"><?php echo ($_SESSION['name']); ?></p>
    <p id="number"><?php echo ($_SESSION['number']); ?></p>
</section>

<div class="method" style="display: none">
    <div class="tab">
        <a href="javascript:;" class="cancel">取消</a>还款方式 <a href="javascript:;" class="confirm">确认</a>
    </div>
    <div class="content">
        <p><a href="">每月付息，到期还本</a></p>
    </div>
</div>

<script>
    var hk = $('#hk');
    console.log(hk);
    hk.click(function () {
        $('.method').show();
        $('.grey').show()
    });

    var grey = $('.grey');
    grey.click(function(){
        $('.method').hide();
        $(this).hide();
    });

    var canC = $('.cancel');
    canC.click( function () {
        $('.method').hide();
        grey.hide();
    })

    $('#submit').on('click', function(){
        var id = $('#id').text();
        var name = $('#name').text();
        var number = $('#number').text();
        var sum = $('#sum').val();
        var hk = $('#hk').text();
        var deadline = $('#deadline').text();
        var interest = $('#interest').text();
        var mon_interest = $('#mon_interest').text();
        var poundage = $('#poundage').text();
        var use = $('#use').text();
        if(sum == '' || hk == '' || deadline == '' || use == ''){
            alert('请填写相关内容');
        }else{
            $.ajax({
                url: "<?php echo U('desk/loan/assetSubmit');?>",
                type: "post",
                dataType: "json",
                data: {
                    id: id,
                    name: name,
                    number: number,
                    sum: sum,
                    method: hk,
                    deadline: deadline,
                    interest: interest,
                    mon_interest: mon_interest,
                    poundage: poundage,
                    use: use
                },
                success: function(data){
                    console.log(data);
                }
            });
        }
    })



</script>
</body>
</html>