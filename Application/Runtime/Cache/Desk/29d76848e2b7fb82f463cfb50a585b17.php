<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PaysApi PHP Demo Index</title>
</head>
<body>

    <form>
        <p><input id="inputprice" type="text" name="inputprice" class="form-control" placeholder="请输入金额" required></p>
                
        <div class="radio">
            <label>            
                <p><input type="radio" name="demo1" id="demo1-alipay" value="option1" checked="">
                    支付宝支付</p>
            </label>
        </div>
        <div class="radio">
            <label>
                <p><input type="radio" name="demo1" id="demo1-weixin" value="option2">
                微信支付</p>
            </label>
        </div>
        <button type="button" id="demoBtn1">确认购买</button>        
    </form>



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

<!-- Jquery files -->
<script type="text/javascript" src="https://cdn.staticfile.org/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
$().ready(function(){
    function getistype(){
        return ($("#demo1-alipay").is(':checked') ? "1" : "2" ); 
    }

    $("#demoBtn1").click(function(){
        $.post(
            "/desk/pay/payFunction",
            {
                price : $("#inputprice").val(), 
                istype : getistype(),
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
</script>    


</body>
</html>