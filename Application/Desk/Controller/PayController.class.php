<?php
namespace Desk\Controller;
use Think\Controller;

class PayController extends Controller{
    public function payFunction(){
        //从网页传入price:支付价格， istype:支付渠道：1-支付宝；2-微信支付
        $price = $_POST["price"];
        $istype = $_POST["istype"];
        
        $orderuid = "username";       //此处传入您网站用户的用户名，方便在paysapi后台查看是谁付的款，强烈建议加上。可忽略。

        //校验传入的表单，确保价格为正常价格（整数，1位小数，2位小数都可以），支付渠道只能是1或者2，orderuid长度不要超过33个中英文字。

        //此处就在您服务器生成新订单，并把创建的订单号传入到下面的orderid中。
        $goodsname = "急速审核费用";
        $orderid = "1234567890";    //每次有任何参数变化，订单号就变一个吧。
        $uid = "7d119e2dfc70ab48e11b884e";//"此处填写PaysApi的uid";
        $token = "abc6582ae4a605f39e052d5d28efd126";//"此处填写PaysApi的Token";
        $return_url = 'http://www.demo.com/payreturn.php';
        $notify_url = 'http://www.demo.com/paynotify.php';
        
        $key = md5($goodsname. $istype . $notify_url . $orderid . $orderuid . $price . $return_url . $token . $uid);
        //经常遇到有研发问为啥key值返回错误，大多数原因：1.参数的排列顺序不对；2.上面的参数少传了，但是这里的key值又带进去计算了，导致服务端key算出来和你的不一样。

        $returndata['goodsname'] = $goodsname;
        $returndata['istype'] = $istype;
        $returndata['key'] = $key;
        $returndata['notify_url'] = $notify_url;
        $returndata['orderid'] = $orderid;
        $returndata['orderuid'] =$orderuid;
        $returndata['price'] = $price;
        $returndata['return_url'] = $return_url;
        $returndata['uid'] = $uid;
        $this->success(self::jsonSuccess("OK",$returndata,""));
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