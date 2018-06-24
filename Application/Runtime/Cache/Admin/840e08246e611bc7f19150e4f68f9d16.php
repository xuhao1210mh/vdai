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
            <h2>setting</h2>
        </div>
        <div class="body">
            <div>
                <div class="panel panel-default">
                    <div class="panel-body" style="text-align: center;">
                        平台设置
                    </div>
                </div>
                    <label>贷款额度</label><input type="text" id="sum" placeholder="<?php echo ($result[0]["sum"]); ?>">
                    <label>手续费(%)</label><input type="text" id="poundage" placeholder="<?php echo ($result[0]["poundage"]); ?>">
                    <label>利率(%)</label><input type="text" id="rate" placeholder="<?php echo ($result[0]["rate"]); ?>">
                <div class="col-md-6 offset-3">
                    <button class="btn btn-primary btn-lg btn-block" id="submit">保存</button>
                </div>
            </div>
        </div>
        <div class="footer">

        </div>
    </div>

<!--  -->
<script>
$('#submit').on('click', function(){
    if($('#poundage').val() == ''){
        alert('请输入信息');
        return false;
    }
    if($('#rate').val() == ''){
        alert('请输入信息');
        return false;
    }
    $.ajax({
        url: "<?php echo U('admin/index/updateSetting');?>",
        type: "post",
        dataType: "json",
        data: {
            sum: $('#sum').val(),
            poundage: $('#poundage').val(),
            rate: $('#rate').val()
        },
        success: function(data){
            //console.log(data);
            if(data.status == 1){
                location.href = data.url;
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