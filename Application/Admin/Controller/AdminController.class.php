<?php

namespace Admin\Controller;

//use Think\Controller;
use Admin\Controller\BaseController;

class AdminController extends BaseController{

    //welcome
    public function welcome(){
        $uid = $_SESSION['admin_id'];
        $admin = M('admin');
        $username = $admin->where("uid='$uid'")->getField('username');
        $this->assign('username', $username);
        $this->display();
    }

    //用户管理
    public function userList(){
        $username = $_GET['username'];
        if($username != ''){
            $user = M('user');
            $result = $user->where("username='$username'")->order('create_time desc')->select();
            $this->assign('result', $result);
            $this->display();
            exit();
        }

        $user = M('user');
        $result = $user->order('create_time desc')->select();
        $this->assign('result', $result);
        $this->display();
    }

    //用户删除
    public function delUser(){
        $id = $_POST['id'];
        $user = M('user');
        $result = $user->where("id='$id'")->delete();
        if($result){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    //登陆
    public function login(){

        if(IS_AJAX){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $admin = M('admin');
            $result = $admin->where("username='$username' and password='$password'")->getField('uid');
            if($result){
                $_SESSION['admin_id'] = $result;
                $this->success('登陆成功', '/admin/admin/index');
            }else{
                $this->error('登陆失败');
            }
        }
        $this->display();
    }

    public function index(){
        parent::checkLogin();
        $uid = $_SESSION['admin_id'];
        $admin = M('admin');
        $username = $admin->where("uid='$uid'")->getField('username');
        $this->assign('username', $username);
        $this->display();
    }

    //展示用户借款信息
    public function showLoan(){
        $name = $_GET['name'];
        if($name != ''){
            $loan = M('loan');
            $result = $loan->where("status='1' and name='$name'")->order('create_time desc')->select();
            $this->assign('result', $result);
            $this->display();
            exit();
        }

        $loan = M('loan');
        $result = $loan->where("status='1'")->order('create_time desc')->select();
        $this->assign('result', $result);
        $this->display();
    }

    //对用户信息进行审核
    public function checkLoan(){

        $loan_id = $_GET['loan_id'];
        $id = $_GET['id'];
        //$user = M('user');

        // $this->assign('loan_id', $loan_id);

        // $username = $user->where("id='$id'")->getField('username');
        // $this->assign('username', $username);

        // $loan = M('loan_info');
        // $result1 = $loan->where("loan_id='$loan_id'")->find();
        // $this->assign('result1', $result1);

        // $identify1 = M('identify_one');
        // $result2 = $identify1->where("loan_id='$loan_id'")->find();
        // $this->assign('result2', $result2);

        // $identify2 = M('identify_two');
        // $result3 = $identify2->where("loan_id='$loan_id'")->find();
        // $this->assign('result3', $result3);

        // $info = M('base_info');
        // $result4 = $info->where("loan_id='$loan_id'")->find();
        // $this->assign('result4', $result4);

        // $seasame = M('seasame');
        // $result5 = $seasame->where("loan_id='$loan_id'")->find();

        // $contact = M('contact');
        // $result6 = $contact->where("uid='$uid'")->select();
        // $this->assign('result6', $result6);
        // $this->assign('result5', $result5);
        // $this->display();

        $auth_first = M('auth_first');
        $auth_second = M('auth_second');
        $auth_third = M('auth_third');
        $result1 = $auth_first->find($loan_id);
        $result2 = $auth_second->find($loan_id);
        $result3 = $auth_third->find($loan_id);
        $this->assign('result1', $result1);
        $this->assign('result2', $result2);
        $this->assign('result3', $result3);
        //return json_encode($loan_id);
        // if(IS_AJAX){
        //     $this->success($result1, '/admin/check/checkLoan');
        // }
        $this->display();
    }

    //审核通过。
    public function yes(){
        $loan_id = $_POST['loan_id'];
        $data['status'] = 2;
        $loan = M('loan');
        $result = $loan->where("loan_id='$loan_id'")->data($data)->save();
        if($result){
            $this->success('该用户通过审核');
        }else{
            $this->error($loan_id);
        }
    }

    //审核不通过
    public function no(){
        $loan_id = $_POST['loan_id'];
        $data['status'] = 3;
        $loan = M('loan');
        $result = $loan->where("loan_id='$loan_id'")->data($data)->save();
        if($result){
            $this->success('该用户未通过审核');
        }else{
            $this->error($loan_id);
        }
    }

    public function applyLoan(){
        $name = $_GET['name'];
        if($name != ''){
            $loan = M('loan');
            $result = $loan->where("status=4 and name='$name'")->order('create_time desc')->select();
            $this->assign('result', $result);
            $this->display();
            exit();
        }

        $loan = M('loan');
        $result = $loan->where("status=4")->order('create_time desc')->select();
        $this->assign('result', $result);
        $this->display();
    }

    //删除借款人信息
    public function delete(){
        $loan_id = $_POST['loan_id'];
        $data['status'] = 0;
        $loan = M('loan');
        $result = $loan->where("loan_id='$loan_id'")->data($data)->save();
        if($result){
            $this->success('删除成功');
        }else{
            $this->error($loan_id);
        }
    }

    //管理员信息
    public function adminList(){
        $admin = M('admin');
        $result = $admin->order('uid asc')->select();
        // print_r($result);
        $this->assign('result', $result);
        if(IS_AJAX){
            $uid = $_POST['uid'];
            $data['status'] = 0;
            $result = $admin->where("uid='$uid'")->data($data)->save();
            if($result){
                $this->success('success');
            }else{
                $this->error('error');
            }
        }
        $this->display();
    }

    //增加管理员
    public function adminAdd(){
        if(IS_AJAX){
            $uid = $_POST['uid'];
            $username = $_POST['username'];
            $data = [
                'username' => $username,
                'password' => $_POST['password'],
            ];
            $admin = M('admin');
            $result = $admin->data($data)->add();
            if($result){
                $this->success('成功');
            }else{
                $this->error('失败');
            }
        }
        $this->display();
    }

    //管理员信息修改
    public function adminEdit(){
        $uid = $_GET['uid'];
        $admin = M('admin');
        $admin->where("uid='$uid'")->getField('uid');
        $this->assign('uid', $uid);

        if(IS_AJAX){
            $uid = $_POST['uid'];
            $username = $_POST['username'];
            $data = [
                'username' => $username,
                'password' => $_POST['password'],
            ];
            $admin = M('admin');
            $result = $admin->where("uid='$uid'")->data($data)->save();
            if($result){
                $this->success('成功');
            }else{
                $this->error('失败');
            }
        }
        $this->display();
    }

    //平台设置
    public function setting(){
        $setting = M('setting');
        $result = $setting->where("id=1")->find();
        $this->assign('result', $result);
        $this->display();
    }

    public function settingEdit(){
        $setting = M('setting');
        $result = $setting->where("id=1")->find();
        $this->assign('result', $result);

        if(IS_AJAX){
            $data = [
                'sum' => $_POST['sum'],
                'poundage' => $_POST['poundage'],
                'rate' => $_POST['rate'],
            ];
            $setting = M('setting');
            $result = $setting->where("id=1")->data($data)->save();
            if($result){
                $this->success('成功');
            }else{
                $this->error('失败');
            }
        }

        $this->display();
    }

    //急速审核列表
    public function fastList(){
        $name = $_GET['name'];
        if($name != ''){
            $loan = M('loan');
            $result = $loan->where("status='1',isfast='1',name='$name'")->order('create_time desc')->select();
            $this->assign('result', $result);
            $this->display();
            exit();
        }

        $loan = M('loan');
        $result = $loan->where("status='1' and isfast='1'")->order('create_time desc')->select();
        $this->assign('result', $result);
        $this->display();
    }

    //自动审批设置
    public function autoCheck(){
        $autocheck = M('auto_check');
        $result = $autocheck->where("id=1")->find();
        $this->assign('result', $result);
        $this->display();
    }

    //自动审批编辑/修改
    public function autoCheckEdit(){
        $autocheck = M('auto_check');
        $result = $autocheck->where("id=1")->find();
        $this->assign('result', $result);

        if(IS_AJAX){
            $data = [
                'mini' => $_POST['mini'],
                'max' => $_POST['max'],
                'sum' => $_POST['sum'],
            ];
            $autocheck = M('auto_check');
            $result = $autocheck->where("id=1")->data($data)->save();
            if($result){
                $this->success('成功');
            }else{
                $this->error('失败');
            }
        }

        $this->display();
    }
}