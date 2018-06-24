<?php
namespace Admin\Controller;
use Think\Controller;

class CheckController extends Controller{

    public function checkLoan(){
        $arr = explode('/', $_SERVER["REQUEST_URI"]);
        //$loan_id = $_GET['id'];
        $loan_id = end($arr);
        $_SESSION['loan_id'] = $loan_id;
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

    public function access(){
        if(IS_AJAX){
            // $arr = explode('/', $_SERVER["REQUEST_URI"]);
            // $loan_id = end($arr);
            $loan_id = $_SESSION['loan_id'];
            $loan = M('loan');
            // $data['create_time'] = date("Y-m-d h:i:s");
            $data['status'] = 2;
            //$data['sum'] = $_POST['sum'];
            $result = $loan->where("loan_id='$loan_id'")->data($data)->save();
            if($result){
                session('session', null);
                $this->success('成功', '/admin/index/check');
            }else{
                $this->error('失败');
            }
        }
    }

    public function forbid(){
        if(IS_AJAX){
            // $arr = explode('/', $_SERVER["REQUEST_URI"]);
            // $loan_id = end($arr);
            $loan_id = $_SESSION['loan_id'];
            $loan = M('loan');
            $data['status'] = 3;
            $result = $loan->where("loan_id='$loan_id'")->data($data)->save();
            if($result){
                session('session', null);
                $this->success('成功', '/admin/index/check');
            }else{
                $this->error('失败');
            }
        }
    }
}