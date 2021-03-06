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
    <title>认证页面</title>
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <script src="/Public/js/dsbridge.js"></script>
    <link rel="stylesheet" href="/Public/css/base.css">
    <link rel="stylesheet" href="/Public/css/rzPage1.css">

</head>
<body>
<header>
    <a href="/desk/index/index" id="back">
        <img src="/Public/img/return.png" alt="">
        返回
    </a>
    认证页面
</header>

<!--bg-->
<!-- <form action="" id="upload_form" style="top: -10rem;"> -->
    <section>
        <div class="IDzm">
            上传
            <div class="img">
                <a href="">
                    <input type="file" class="upload_input" name="file1" accept="image/*" enctype="multipart/form-data" id="file1" capture="camera">
                    <img src="/Public/img/IDzm.png">
                </a>
                <!-- <input type="file" accept="image/*" /> -->
            </div>
            <p>身份证正面</p>
        </div>
        <div class="IDfz">
            上传
            <div class="img">
                <a href="">
                    <input type="file" class="upload_input" name="file2" accept="image/*" enctype="multipart/form-data" id="file2" capture="camera">
                    <img src="/Public/img/IDfm.png">
                </a>
            </div>
            <p>身份证反面</p>
        </div>
    </section>

    <section>
        <div class="scID">
            上传
            <div class="img">
                <a href="">
                    <input type="file" class="upload_input" name="file3" accept="image/*" enctype="multipart/form-data" id="file3" capture="camera">
                    <img src="/Public/img/scID.png">
                </a>
            </div>
            <p>手持身份证反面</p>
        </div>
        <div class="bank">
            上传
            <div class="img">
                <a href="">
                    <input type="file" class="upload_input" name="file4" accept="image/*" enctype="multipart/form-data" id="file4" capture="camera">
                    <img src="/Public/img/bank.png">
                </a>
            </div>
            <p>银行卡照片</p>
        </div>
    </section>
<!-- </form> -->
<section class="three">
    <input type="text" placeholder="确认银行卡卡号" id="card_number">
    <input class="name" type="text" placeholder="开户名" id="card_name">
</section>

<section>
    <button type="button" id="upload_button">下一步</button>
</section>


<!--  -->
<script>

$('.upload_input').each(function(i, e){
    $(e).change(function(){
        $(this).next().attr('src', URL.createObjectURL($(this)[0].files[0]));
    })
});

$('#upload_button').on('click', function(){
    if($('#file1').val() == ''){
        dsBridge.call("toast", "请上传图片");
        return false;
    }
    if($('#file2').val() == ''){
        dsBridge.call("toast", "请上传图片");
        return false;
    }
    if($('#file3').val() == ''){
        dsBridge.call("toast", "请上传图片");
        return false;
    }
    if($('#file4').val() == ''){
        dsBridge.call("toast", "请上传图片");
        return false;
    }
    if($('#card_number').val() == ''){
        dsBridge.call("toast", "请填写银行卡号");
        return false;
    }
    if($('#card_name').val() == ''){
        dsBridge.call("toast", "请填写开户名");
        return false;
    }
    var formData = new FormData();
    formData.append('file1', $('#file1')[0].files[0]);
    formData.append('file2', $('#file2')[0].files[0]);
    formData.append('file3', $('#file3')[0].files[0]);
    formData.append('file4', $('#file4')[0].files[0]);
    formData.append('card_number', $('#card_number').val());
    formData.append('card_name', $('#card_name').val());
    //
    $.ajax({
        url: "<?php echo U('desk/loan/upload');?>",
        type: "post",
        contentType: false,
        processData: false,
        dataType: "json",
        data: formData,
        success: function(data){
            //console.log(data);
            if(data.status == 0){
                dsBridge.call("toast", data.info);
                return false;
            }else{
                location.href = data.url;
            }
        }
    })

})

</script>
</body>
</html>