<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function login(){

        if(IS_AJAX){
            $username = $_POST['username'];
            $login = D('login');
            if($login->create()){
                if($login->login($_POST['username'], $_POST['password'])){
                    session('username', $username);
                    $this->success('登陆成功');
                }else{
                    $this->error('登陆失败');
                }
            }else{
                $this->error($login->getError());
            }
        }

        $this->display();
    }

    public function main(){
        $this->display();
    }

    public function check(){
        $loan = M('loan');
        $result = $loan->where("status = '1'")->order('create_time desc')->select();
        $this->assign('result', $result);
        if(IS_AJAX){
            $this->success('成功', '/admin/index/check');
        }
        $this->display();
    }

    public function second(){
        if(IS_AJAX){
            $this->success('成功', '/admin/index/second');
        }
        $this->display();
    }

    public function order(){
        $loan = M('loan');
        $result = $loan->where("status = '2' or status ='4'")->order('create_time desc')->select();
        $this->assign('result', $result);
        if(IS_AJAX){
            $this->success('成功', '/admin/index/order');
        }
        $this->display();
    }

    public function setting(){
        $setting = M('setting');
        $result = $setting->select();
        $this->assign('result', $result);
        if(IS_AJAX){
            $this->success('成功', '/admin/index/setting');
        }
        $this->display();
    }

    public function updateSetting(){
        if(IS_AJAX){
            $sum = $_POST['sum'];
            $poundage = $_POST['poundage'];
            $rate = $_POST['rate'];
            $setting = M('setting');
            $result = $setting->execute("update setting set sum='$sum',poundage='$poundage',rate='$rate'");
            if($result){
                $this->success('成功', '/admin/index/setting');
            }else{
                $this->error('失败');
            }
        }
    }

    // public function exit(){
    //     if(IS_AJAX){
    //         $this->success('成功', '/admin/index/login');
    //     }
    //     $this->display();
    // }

}