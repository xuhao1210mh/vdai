<?php

namespace Payment\Controller;

use Think\Controller;

class PayNotiController extends Controller{

    public function payNotify(){
        $paysapi_id = $_POST["paysapi_id"];
        $orderid = $_POST["orderid"];
        $price = $_POST["price"];
        $realprice = $_POST["realprice"];
        $orderuid = $_POST["orderuid"];
        $key = $_POST["key"];

        //校验传入的参数是否格式正确，略

        $token = "abc6582ae4a605f39e052d5d28efd126";
        
        $temps = md5($orderid . $orderuid . $paysapi_id . $price . $realprice . $token);

        if ($temps != $key){
            echo $paysapi_id . '<br>';
            echo $orderid . '<br>';
            echo $price . '<br>';
            echo $realprice . '<br>';
            echo $orderuid . '<br>';
            echo self::jsonError("key值不匹配");
        }else{
            //校验key成功，是自己人。执行自己的业务逻辑：加余额，订单付款成功，装备购买成功等等。
            echo '成功';
        }

    }

    //返回错误
    private function jsonError($message = '',$url=null) 
    {
        $return['msg'] = $message;
        $return['data'] = '';
        $return['code'] = -1;
        $return['url'] = $url;
        return json_encode($return);
    }

    //返回正确
     private function jsonSuccess($message = '',$data = '',$url=null) 
    {
        $return['msg']  = $message;
        $return['data'] = $data;
        $return['code'] = 1;
        $return['url'] = $url;
        return json_encode($return);
    }
}