<?php
namespace Payment\Controller;
use Think\Controller;

class PayController extends Controller{

    public function fastSH(){
        $loan_id = $_GET['loan_id'];
        $this->assign('loan_id', $loan_id);

        $setting = M('setting');
        $fast = $setting->where("id=1")->getField('fast');
        $this->assign('fast', $fast);
        $this->display();
    }

    public function payFunction(){
        //从网页传入price:支付价格， istype:支付渠道：1-支付宝；2-微信支付
        $price = $_POST["price"];
        $istype = $_POST["istype"];
        
        $orderuid = 'username';//$_SESSION['username'];       //此处传入您网站用户的用户名，方便在paysapi后台查看是谁付的款，强烈建议加上。可忽略。
    
        $loan_id = $_POST['loan_id'];

        //校验传入的表单，确保价格为正常价格（整数，1位小数，2位小数都可以），支付渠道只能是1或者2，orderuid长度不要超过33个中英文字。

        //此处就在您服务器生成新订单，并把创建的订单号传入到下面的orderid中。
        $goodsname = "急速审核费用";
        $orderid = time() . mt_rand(10000, 99999);    //每次有任何参数变化，订单号就变一个吧。
        $uid = "7d119e2dfc70ab48e11b884e";//"此处填写PaysApi的uid";
        $token = "abc6582ae4a605f39e052d5d28efd126";//"此处填写PaysApi的Token";
        $return_url = 'http://95.169.20.94:501/payment/PayReturn/shResult2';
        $notify_url = 'http://95.169.20.94:501/payment/PayNoti/payNotify';
        
        $key = md5($goodsname. $istype . $notify_url . $orderid . $orderuid . $price . $return_url . $token . $uid);
        //经常遇到有研发问为啥key值返回错误，大多数原因：1.参数的排列顺序不对；2.上面的参数少传了，但是这里的key值又带进去计算了，导致服务端key算出来和你的不一样。

        $loan = M('loan');
        $data['orderid'] = $orderid;
        $loan->where("loan_id='$loan_id'")->data($data)->save();

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
        return $return;
    }

    //返回正确
    private function jsonSuccess($message = '',$data = '',$url=null) 
    {
        $return['code'] = 1;
        $return['msg']  = $message;
        $return['data'] = $data;
        $return['url'] = $url;
        return $return;
    }
}