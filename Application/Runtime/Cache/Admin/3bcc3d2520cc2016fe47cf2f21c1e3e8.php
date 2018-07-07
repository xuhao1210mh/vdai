<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/Public/assets/css/dialog.css">
    <script src="/Public/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/Public/assets/js/popper.min.js"></script>
    <script src="/Public/assets/js/bootstrap.min.js"></script>
    <script src="/Public/assets/js/dialog.min.js"></script>
    <link rel="stylesheet" href="/Public/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
 
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
                        <!-- <tr>
                            <td>行商记录</td>
                            <td><img class="rounded col-3" src="" alt=""></td>
                        </tr> -->
                        <tr>
                            <td>负面记录</td>
                            <td><img class="rounded col-3" src="/Public/authpic2/<?php echo ($result3["auth2"]); ?>" alt=""></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-6 offset-3">
                    <!-- <input type="text" id="sum" placeholder="请输入贷款额度"> -->
                </div>
            </div>
        </div>
        <div class="footer">

        </div>
    </div>
<!--  -->
<script>
$('#yes').on('click', function(){
    $.ajax({
        url: "<?php echo U('/admin/admin/check');?>",
        type: "post",
        dataType: "json",
        data: {
            loan_id: $('#loan_id').text(),
        },
        success: function(data){
            if(data.status == 1){
                $(document).dialog({
                    titleShow: false,
                    content: data.info,
                    onClickConfirmBtn: function(){
                        $('#search').click();
                    }
                });
                return false;
            }else{
                $(document).dialog({
                    titleShow: false,
                    content: data.info,
                });
                return false;
            }
        }
    })
})
</script>
</body>
</html>