<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height,user-scalable=no">
    <title>后台管理</title>
    <link rel="stylesheet" href="/Public/admin/css/foundation.min.css" />
    <link rel="stylesheet" href="/Public/admin/css/normalize.css">
    <link rel="stylesheet" href="/Public/admin/css/index.css" />
    <script src="/Public/js/jquery-3.3.1.min.js"></script>
    <script src="/Public/js/popper.min.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/Public/dist/css/bootstrap.min.css">
</head>
<body>
    <!--left Menu-->
    <div class="large-2 columns">
        <div>
        	<img src="/Public/admin/images/logo.png"/>
        </div>
        
        <ul class="menu-list">
            <li data-icon="work-summary1" data-code="work-summary" class="selected" id="check">
                <img src="/Public/admin/images/work-plan.png" />
                <span>信息审核</span>
            </li>
            <!-- <li data-icon="work-summary1" data-code="work-plan" id="second" >
                <img src="/Public/admin/images/work-summary.png" />
                <span>房秒借</span>
            </li> -->
            <li data-icon="work-summary1" data-code="work-summary" id="order">
                <img src="/Public/admin/images/work-plan.png" />
                <span>申请信息</span>
            </li>
            <li data-icon="work-summary1" data-code="work-summary" id="setting">
                <img src="/Public/admin/images/work-plan.png" />
                <span>设置</span>
            </li>
            <li data-icon="work-summary1" data-code="work-plan" id="exit">
                <img src="/Public/admin/images/work-summary.png" />
                <span>退出系统</span>
            </li>
        </ul>
    </div>

    <!--right content-->
    <div class="large-10 columns content"><html>
<head>
    <title></title>
</head>
<body>
    
    <div class="container">
        <div class="header">
            <h2>checkLoan</h2>
        </div>
        <div class="body">
            <div>
                <div class="panel panel-default">
                    <div class="panel-body" style="text-align: center;">
                        信息审核
                    </div>
                </div>

                <table class="table table-secondary table-hover text-center col-md-2">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>姓名</td>
                            <td><?php echo ($result1["name"]); ?></td>
                        </tr>
                        <tr>
                            <td>电话</td>
                            <td><?php echo ($result1["number"]); ?></td>
                        </tr>
                        <tr>
                            <td>亲属姓名</td>
                            <td><?php echo ($result1["family_name"]); ?></td>
                        </tr>
                        <tr>
                            <td>亲属电话</td>
                            <td><?php echo ($result1["family_number"]); ?></td>
                        </tr>
                        <tr>
                            <td>朋友姓名</td>
                            <td><?php echo ($result1["friend_name"]); ?></td>
                        </tr>
                        <tr>
                            <td>朋友电话</td>
                            <td><?php echo ($result1["friend_number"]); ?></td>
                        </tr>
                        <tr>
                            <td>身份证正面</td>
                            <td><img class="rounded col-3" src="/Public/authpic/<?php echo ($result2["pic1"]); ?>" alt=""></td>
                        </tr>
                        <tr>
                            <td>身份证反面</td>
                            <td><img class="rounded col-3" src="/Public/authpic/<?php echo ($result2["pic2"]); ?>" alt=""></td>
                        </tr>
                        <tr>
                            <td>手持身份证反面</td>
                            <td><img class="rounded col-3" src="/Public/authpic/<?php echo ($result2["pic3"]); ?>" alt=""></td>
                        </tr>
                        <tr>
                            <td>银行卡照片</td>
                            <td><img class="rounded col-3" src="/Public/authpic/<?php echo ($result2["pic4"]); ?>" alt=""></td>
                        </tr>
                        <tr>
                            <td>银行卡号</td>
                            <td><?php echo ($result2["card_number"]); ?></td>
                        </tr>
                        <tr>
                            <td>开户名</td>
                            <td><?php echo ($result2["card_name"]); ?></td>
                        </tr>
                        <tr>
                            <td>芝麻信用</td>
                            <td><img class="rounded col-3" src="/Public/authpic2/<?php echo ($result3["auth1"]); ?>" alt=""></td>
                        </tr>
                        <tr>
                            <td>行商记录</td>
                            <td><img class="rounded col-3" src="" alt=""></td>
                        </tr>
                        <tr>
                            <td>负面记录</td>
                            <td><img class="rounded col-3" src="/Public/authpic2/<?php echo ($result3["auth2"]); ?>" alt=""></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-6 offset-3">
                    <!-- <input type="text" id="sum" placeholder="请输入贷款额度"> -->
                    <button class="btn btn-primary btn-lg btn-block" id="access">审核通过</button>
                    <button class="btn btn-danger btn-lg btn-block" id="forbid">审核不通过</button>
                </div>
            </div>
        </div>
        <div class="footer">

        </div>
    </div>

<!--  -->
<script>
$('#access').on('click', function(){
    if($('#sum').val() == ''){
        alert('请输入额度');
        return false;
    }
    $.ajax({
        url: "<?php echo U('admin/check/access');?>",
        type: "post",
        dataType: "json",
        data: {
            //sum: $('#sum').val()
        },
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                alert('审核通过');
                location.href = data.url;
            }else{
                alert(data.info);
            }
        }
    });
})

$('#forbid').on('click', function(){
    $.ajax({
        url: "<?php echo U('admin/check/forbid');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                alert('审核不通过');
                location.href = data.url;
            }else{
                alert(data.info);
            }
        }
    });
})
</script>
</body>
</html></div>

<!--footer-->
<!-- <footer class=""> -->
<!--     <div class="large-12 columns"> -->
<!--         <hr/> -->
<!--         <div class="row"> -->
<!--             <div class="large-6 columns"> -->
<!--                 <p>© Copyright no one at all. Go to town.</p> -->
<!--             </div> -->
<!--             <div class="large-6 columns"> -->
<!--                 <ul class="inline-list right"> -->
<!--                     <li><a href="#">Section 1</a></li> -->
<!--                     <li><a href="#">Section 2</a></li> -->
<!--                     <li><a href="#">Section 3</a></li> -->
<!--                     <li><a href="#">Section 4</a></li> -->
<!--                 </ul> -->
<!--             </div> -->
<!--         </div> -->
<!--     </div> -->
<!-- </footer> -->
</body>
<script src="/Public/admin/js/jquery-3.3.1.min.js"></script>

<script type="text/javascript">
$(function(){

    var arr = new Array();
    arr = location.href .split('/')
    var id = arr.pop();
    $('#'+id).children('img').attr('src', "/Public/admin/images/work-summary1.png");

    // var code = $(".menu-list .selected").attr("data-code");
    // var selectedLi = $(".menu-list .selected");

    // selectedLi.css({
    // 	background:"#16171c",
    // 	color:"#ecedf1"
    // });

    // selectedLi.find("img").attr("src","/Public/admin/images/" + code + "1.png");

    // $(".menu-list li").click(function(){
    //     if($(this).hasClass("selected")==false){
    //         $(this).addClass("selected").css({
    //             background:"#16171c",
    //             color:"#ecedf1"
    //         }).siblings().removeClass("selected").css({
    //             background:"#202028",
    //             color:"#71747b"
    //         });

    //         var code = $(this).attr("data-code");
    //         $(".menu-list li").each(function(){
    //         	$(this).find("img").attr("src","/Public/admin/images/" +$(this).attr("data-code")+ ".png");
    //         });

    //         $(this).find("img").attr("src","/Public/admin/images/" +$(this).attr("data-icon") + ".png");
 
    //     }
    // });
});

$('#check').on('click', function(){
    $.ajax({
        url: "<?php echo U('admin/index/check');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                location.href = data.url;
            }
        }
    });
})

$('#second').on('click', function(){
    $.ajax({
        url: "<?php echo U('admin/index/second');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                location.href = data.url;
            }
        }
    });
})

$('#order').on('click', function(){
    $.ajax({
        url: "<?php echo U('admin/index/order');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                location.href = data.url;
            }
        }
    });
})

$('#setting').on('click', function(){
    $.ajax({
        url: "<?php echo U('admin/index/setting');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                location.href = data.url;
            }
        }
    });
})

$('#exit').on('click', function(){
    $.ajax({
        url: "<?php echo U('admin/index/exit');?>",
        type: "post",
        dataType: "json",
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                location.href = data.url;
            }
        }
    });
})

</script>
</html>