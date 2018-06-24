<?php
namespace Desk\Controller;
use Think\Controller;

class ResultController extends Controller{

    function checkResult(){
        if(IS_AJAX){
            $loan_id = $_POST['loan_id'];
            $_SESSION['loan_id'] = $loan_id;
            $loan = M('loan');
            $result = $loan->where("loan_id='$loan_id'")->getField('status');
            if($result == 1){
                //待审核
                $this->success('成功', '/desk/result/shResult1');
            }else if($result == 2){
                //审核成功
                $this->success('成功', '/desk/result/shResult2');
            }else if($result == 3){
                //审核失败
                $this->success('成功', '/desk/result/shResult3');
            }else if($result == 4){
                $this->success('成功', '/desk/result/shResult4');
            }
        }
    }

    function excute(){
        if(IS_AJAX){
            $loan_id = $_SESSION['loan_id'];
            $data['sum'] = $_POST['sum'];
            $data['interest'] = $_POST['sum'] * (1 + 0.2);
            $data['mon_interest'] = $data['interest']/12;
            $data['status'] = 4;
            //$this->success($data);
            $loan = M('loan');
            $result = $loan->where("loan_id='$loan_id'")->data($data)->save();
            if($result){
                $this->success('成功', 'shResult4');
            }else{
                $this->error('失败');
            }
        }
    }

    function shResult1(){
        $this->display();
    }

    function shResult2(){
        $loan_id = $_SESSION['loan_id'];
        $loan = M('loan');
        $result = $loan->query("select sum from loan where loan_id='$loan_id'");
        $this->assign('result', $result);
        $this->display();
    }

    function shResult3(){
        $this->display();
    }

    function shResult4(){
        $loan_id = $_SESSION['loan_id'];
        $loan = M('loan');
        $result = $loan->query("select sum from loan where loan_id='$loan_id'");
        $this->assign('result', $result);
        $this->display();
    }

}