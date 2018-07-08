<?php

namespace Payment\Controller;

use Think\Controller;

class PayReturnController extends Controller{
    public function shResult2(){
        /**
         * ---------------------支付成功，用户会跳转到这里-------------------------------
         * 
         * 此页就是您之前传给pay.paysapi.com的return_url页的网址
         * 支付成功，PaysApi会把用户跳转回这里。
         * 
         * --------------------------------------------------------------
         */
        $orderid = $_GET["orderid"];

        //此处在您数据库中查询：此笔订单号是否已经异步通知给您付款成功了。如成功了，就给他返回一个支付成功的展示。
        //echo "恭喜，支付成功!，订单号：".$orderid;
        $loan = M('loan');
        $data['status'] = 2;
        $data['isfast'] = 1;
        $loan->where("orderid='$orderid'")->data($data)->save();
        $result = $loan->where("orderid='$orderid'")->find();
        $this->assign('result', $result);
        $this->display();
    
    }
}