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
                wrap = ndivl;
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
    <title>认证页面</title>
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <script src="/Public/js/dsbridge.js"></script>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/renZhen.css">
</head>
<body>
<!--nav-->
<header>
    <a href="/desk/index/index" id="back">
        <img src="/Public/img/return.png" alt="">
        返回
    </a>
    认证页面
</header>

<div class="content">
    <ul>
        <a href="javascript:;">
            <li><img src="/Public/img/zhima.png" alt=""><span>芝麻信用</span>
                <form action="" id="upload_form1">
                    <input type="file" class="upload_input1" id="file1" name="file1" accept="image/*" enctype="mdivtipart/form-data" id="file4">
                </form>
            </li>
        </a>
        <!-- <a href="javascript:;">
            <li><img src="/Public/img/yunxings.png" alt=""><span>运营商认证</span>
                <form action="" id="upload_form2">
                    <input type="file" class="upload_input2" id="file2" name="file" accept="image/*" enctype="mdivtipart/form-data" id="file4">
                </form>
            </li>
        </a> -->
        <a href="javascript:;">
            <li><img src="/Public/img/fu.png" alt=""><span>负面记录</span>
                <form action="" id="upload_form3">
                    <input type="file" class="upload_input3" id="file3" name="file3" accept="image/*" enctype="mdivtipart/form-data" id="file4">
                </form>
            </li>
        </a>
    </ul>


    <section>
        <input class="submit" type="button" value="下一步" id="submit">
    </section>
</div>

<!--  -->
<script>
$('#file1').on('click', function(){
    dsBridge.call("toast", "请上传支付宝芝麻分截图");
})
// $('#file2').on('click', function(){
//     dsBridge.call("toast", "请上传近期通话记录");
// })
$('#file3').on('click', function(){
    dsBridge.call("toast", "请上传支付宝负面记录截图");
})
$('#submit').on('click', function(){
    if($('#file1').val() == ''){
        dsBridge.call("toast", "请上传图片");
        return false;
    }
    // if($('#file2').val() == ''){
    //     dsBridge.call("toast", "请上传图片");
    //     return false;
    // }
    if($('#file3').val() == ''){
        dsBridge.call("toast", "请上传图片");
        return false;
    }
    var formData = new FormData();
    formData.append('file1', $('#file1')[0].files[0]);
    formData.append('file2', $('#file3')[0].files[0]);

    $.ajax({
        url: "<?php echo U('desk/loan/auth');?>",
        type: "post",
        contentType: false,
        processData: false,
        dataType: "json",
        data: formData,
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                location.href = data.url;
            }else{
                dsBridge.call("toast", data.info);
            }
        }
    })
})
</script>
</body>
</html>