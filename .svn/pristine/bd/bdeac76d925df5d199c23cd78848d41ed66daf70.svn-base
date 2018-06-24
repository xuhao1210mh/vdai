<?php
namespace Desk\Controller;
use Think\Controller;
class IndexController extends Controller {
    /**
     * 登陆
     */
    public function login(){

        if(IS_AJAX){
            $username = $_POST['username'];
            $login = D('login');
            if($login->create()){
                if($login->login($_POST['username'], $_POST['password'])){
                    $this->success('登陆成功', 'desk/index/index');
                }else{
                    $this->error('登陆失败');
                }
            }else{
                $this->error($login->getError());
            }
        }

        $this->display();

    }

    public function register(){

        if(IS_AJAX){
            if($_POST['username'] != $_SESSION['number']){
                $this->error('请重新获得验证码');
            }
            if($_POST['captcha'] == $_SESSION['captcha']){
                $register = D('register');
                if($register->create()){
                    $result = $register->add();
                    if($result){
                        $this->success('注册成功', '/');
                    }else{
                        $this->error('注册失败');
                    }
                }else{
                    $this->error($register->getError());
                }
            }else if($_POST['captcha'] == ''){
                $this->error('请输入验证码');
            }else{
                $this->error('验证码错误');
            }
        }

        $this->display();
    }

    public function checkNumber(){
        if(IS_AJAX){
            $username = $_POST['number'];
            $user = M('user');
            $result = $user->query("select username from user where username='$username'");
            if(!$result[0]['username']){
                $this->error('该账号尚未注册');
            }else{
                $this->success('成功');
            }
        }
    }

    public function resetPW(){
        if(IS_AJAX){
            if($_POST['username'] != $_SESSION['number']){
                $this->error('请重新获得验证码');
            }
            if($_POST['captcha'] == $_SESSION['captcha']){
                $user = D('user');
                $username = $_POST['username'];
                $data['password'] = $_POST['password'];
                if($user->create()){
                    $result = $user->where("username='$username'")->save($data);
                    if($result){
                        $this->success('密码更改成功', '/');
                    }else{
                        $this->error('密码更改失败');
                    }
                }else{
                    $this->error($user->getError());
                }
            }else if($_POST['captcha'] == ''){
                $this->error('请输入验证码');
            }else{
                $this->error('验证码错误');
            }
        }
        $this->display();

    }
    /**
     * 判断是否已登陆
     */
    public function checkLogin(){
        if(IS_AJAX){
            if($_SESSION['id']){
                $this->success('登陆成功', 'desk/index/index');
                exit();
            }else{
                $this->error('失败');
            }
        }
    }
    /**
     * 跳转主页
     */
    public function index(){
        $setting = M('setting');
        $result = $setting->select();
        $this->assign('result', $result);
        if(IS_AJAX){
            $this->success('成功', '/desk/index/index');
        }
        $this->display();

    }
    /**
     * 房秒贷
     */
    public function secondLoan(){
        if(IS_AJAX){
            $id = $_SESSION['id'];
            $user = M('user');
            $result = $user->where("id='$id'")->getField('username');
            if($result){
                $data = array(
                    'id' => $result['id'],
                    'number' => $result
                );
                $result = $loan = M('sec_loan')->data($data)->add();
                if($result){
                    $this->success('申请成功，请等待工作人员联系');
                }else{
                    $this->error('申请失败');
                }
            }
        }
    }
    
}