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
    <link rel="stylesheet" href="/Public/css/rzPage.css">
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
<main>
    <section>
        <p class="self">本人</p>
        <p>亲属联系方式</p>
        <form id="user">
            <label for="name">姓名:</label>
            <input type="text" id="name" placeholder="请输入姓名"/>
            <br />
            <label for="number">电话:</label>
            <input type="text" id="number" placeholder="请输入电话" />
        </form>
    </section>

    <section>
        <p class="qs">亲属</p>
        <p>朋友联系方式</p>
        <form id="family">
            <label for="name">姓名:</label>
            <input type="text" id="name" placeholder="请输入姓名" />
            <br />
            <label for="number">电话:</label>
            <input type="text" id="number" placeholder="请输入电话" />
        </form>
    </section>

    <section>
        <p class="friend">朋友</p>
        <p>朋友联系方式</p>
        <form id="friend">
            <label for="name">姓名:</label>
            <input type="text" id="name" placeholder="请输入姓名" />
            <br />
            <label for="number">电话:</label>
            <input type="text" id="number" placeholder="请输入电话" />
        </form>
    </section>

    <div>
        <button type="button" id="submit">下一步</button>
        <span>请详细填写真实的资料</span>
    </div>



</main>


<!--  -->
<script>
    $('#submit').on('click', function(){
        var name = $('#user #name').val();
        var number = $('#user #number').val();
        var family_name = $('#family #name').val();
        var family_number = $('#family #number').val();
        var friend_name = $('#friend #name').val();
        var friend_number = $('#friend #number').val();

        if(name == ''){
            dsBridge.call("toast", '请填写相关内容');
            return false;
        }
        if(number == ''){
            dsBridge.call("toast", '请填写相关内容');
            return false;
        }
        if(family_name == ''){
            dsBridge.call("toast", '请填写相关内容');
            return false;
        }
        if(family_number == ''){
            dsBridge.call("toast", '请填写相关内容');
            return false;
        }
        if(friend_name == ''){
            dsBridge.call("toast", '请填写相关内容');
            return false;
        }
        if(friend_number == ''){
            dsBridge.call("toast", '请填写相关内容');
            return false;
        }

        $.ajax({
            url: "<?php echo U('Desk/loan/rzPage');?>",
            type: "post",
            dataType: "json",
            data: {
                name: name,
                number: number,
                family_name: family_name,
                family_number: family_number,
                friend_name: friend_name,
                friend_number: friend_number,
            },
            success: function(data){
                //console.log(data);
                if(data.status == 1){
                    //console.log(data);
                    location.href = data.url;
                }else{
                    dsBridge.call("toast", data.info);
                }
            }
        });
    });

</script>
</body>
</html>