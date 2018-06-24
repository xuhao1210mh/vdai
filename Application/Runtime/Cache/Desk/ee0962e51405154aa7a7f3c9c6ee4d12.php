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
    <script src="/Public/js/dsbridge.js"></script>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/assetSubmit.css">
</head>
<body>
<div class="grey" style="display: none"></div>
<header>
    <a href="/desk/index/index/" id="back">
        <img src="/Public/img/return.png" alt="">
        返回
    </a>
    资料提交
</header>

<section>
    <img src="/Public/img/icon8.png" alt="">
    <p>借款金额 <input type="number" placeholder="<?php echo ($result[0]["sum"]); ?>" id="sum" style="text-align: center;width: 1.2rem;right:0;"></p>
    <p>还款方式 <a id="hk" href="#">每月付息，到期还本<img src="/Public/img/arrow_right.png" alt=""></a></p>
    <p>还款期限 <a id="qixian" href="#">12个月<img src="/Public/img/arrow_right.png" alt="">
        <!-- <img src="/Public/img/arrow_right.png" alt=""> -->
    </a></p>
    <p>总利息 <span id="interest" class="<?php echo ($result[0]["rate"]); ?>">0.00</span></p>
    <p>月利息 <span id="mon_interest">0.00</span></p>
    <p>借款手续费 <span id="poundage" class="<?php echo ($result[0]["poundage"]); ?>">0</span></p>
    <p>贷款用途 <select name="" id="use" style="line-height:0.8rem;border: none;float: right;margin-right: 0.2rem">
        <option value="">装修</option>
        <option value="">旅游</option>
        <option value="">购物</option>
        <option value="">其他</option>
    </select>
        <!-- <img src="/Public/img/arrow_right.png" alt=""> -->
        
    </p>
    <button type="button" id="submit" class="submit">确认</button>
    <p id="id" style="display: none"><?php echo ($_SESSION['id']); ?></p>
    <p id="name" style="display: none"><?php echo ($_SESSION['name']); ?></p>
    <p id="number" style="display: none"><?php echo ($_SESSION['number']); ?></p>
</section>

<div class="method" style="display: none">
    <div class="tab">
        <a href="javascript:;" class="cancel">取消</a>还款方式<a href="javascript:;" class="confirm">确认</a>
    </div>
    <div class="content">
        <p><a href="">每月付息，到期还本</a></p>
    </div>
</div>

<div class="data" style="display: none">
    <div class="tab">
        <a href="javascript:;" class="cancel fl" style="padding-left: 0.3rem">取消</a><a href="javascript:;" class="confirm fr" style="padding-right: 0.3rem">确认</a>
    </div>
    <div class="content">
        <p><a href="">12个月</a></p>
    </div>
</div>

<script>
    $('.confirm').on('click', function(){
        $('.method').hide();
        $('.data').hide();
        $('.grey').hide()
    })

    var hk = $('#hk');
    var grey = $('.grey');
    var canC = $('.cancel');
    var qixian =$('#qixian');

    hk.click(function () {
        $('.method').show();
        $('.grey').show()
    });
   
    grey.click(function(){
        $('.method').hide();
        $(this).hide();
    });

    
    canC.click( function () {
        $('.method').hide();
        grey.hide();
    });

    qixian.click(function () {
        $('.data').show();
        $('.grey').show()
    });
   
    grey.click(function(){
        $('.data').hide();
        $(this).hide();
    });

    
    canC.click( function () {
        $('.data').hide();
        grey.hide();
    });





    $('#sum').bind('input propertychange', function(){
        if($(this).val() > parseInt($(this).attr('placeholder'))){
            dsBridge.call("toast", "金额超过限制");
            $(this).val('');
            return false;
        }
        var sum = $('#sum').val();
        var interest = sum * (parseInt($('#interest').attr('class'))/100);
        // $('#deadline').bind('input propertychange', function(){
        //     var mon_interest = interest / 12;
        //     $('#mon_interest').html(mon_interest);
        // });
        //var mon_interest = interest / parseInt($('#deadline').val());
        var mon_interest = interest / 12;
        $('#mon_interest').html(mon_interest);
        var poundage = sum * ($('#poundage').attr('class'))/100;
        $('#interest').html(interest);
        //$('#mon_interest').html(mon_interest);
        $('#poundage').html(poundage);
    })

    // $('#deadling').bind('input propertychange', function(){
    //     var sum = $('#sum').val();
    //     var mon_interest = interest / parseInt($('#deadline').val());
    //     $('#mon_interest').html(mon_interest);
    // })

    $('#submit').on('click', function(){
        var id = $('#id').text();
        var name = $('#name').text();
        var number = $('#number').text();
        var sum = $('#sum').val();
        var hk = $('#hk').text();
        var deadline = $('#qixian').text();
        var interest = $('#interest').text();
        var mon_interest = $('#mon_interest').text();
        var poundage = $('#poundage').text();
        var use = $('#use').find('option:selected').text();
        if(sum == '' || hk == '' || deadline == '' || use == ''){
            dsBridge.call("toast", "请填写相关信息");
        }else{
            var date = new Date();
            var seperator1 = "-";
            var month = date.getMonth() + 1;
            var strDate = date.getDate();
            var hour = date.getHours();
            var minutes = date.getMinutes();
            var second = date.getSeconds();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var create_time = date.getFullYear() + seperator1 + month + seperator1 + strDate +':'+ hour +':'+ minutes +':'+ second;
            //
            $.ajax({
                url: "<?php echo U('desk/loan/assetSubmit');?>",
                type: "post",
                dataType: "json",
                data: {
                    //loan_id: loan_id,
                    id: id,
                    name: name,
                    number: number,
                    sum: sum,
                    method: hk,
                    deadline: deadline,
                    interest: interest,
                    mon_interest: mon_interest,
                    poundage: poundage,
                    use: use,
                    create_time: create_time
                    //status: 0
                },
                success: function(data){
                    // console.log(data);
                    if(data.status == 1){
                        //console.log(data);
                        location.href = data.url;
                    }else{
                        dsBridge.call("toast", data.info);
                    }
                }
            });
        }
    })


</script>
</body>
</html>