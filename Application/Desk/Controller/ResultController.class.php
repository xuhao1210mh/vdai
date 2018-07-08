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
                $this->success('成功', '/desk/result/shResult4');
            }else{
                $this->error('失败');
            }
        }
    }

    function shResult1(){
        $loan_id = $_SESSION['loan_id'];
        $this->assign('loan_id', $loan_id);
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

    //自动审批
    public function autoCheck(){
        $loan_id = $_POST['loan_id'];
        $loan = M('loan');
        $sum = $loan->where("loan_id='$loan_id'")->getField('sum');
        
        $autocheck = M('auto_check');
        $result = $autocheck->where("id=1")->find();
        $mini = $result['mini'];
        $max = $result['max'];
        //$this->success($sum);
        if($sum >= $mini && $sum <=$max){
            $setting = M('setting');
            $rate = $setting->where("id='1'")->getField('rate');
            $poundage = $setting->where("id='1'")->getField('poundage');

            $data['sum'] = $result['sum'];
            $data['interest'] = $data['sum'] * ($rate * 0.01);
            $data['mon_interest'] = $data['interest'] / 12;
            $data['poundage'] = $data['sum'] * ($poundage * 0.01);
            $data['status'] = 2;
            $loan->where("loan_id='$loan_id'")->data($data)->save();
            $this->success('自动审批成功', '/desk/result/shResult2');
        }else{
            $this->error('自动审批失败');
        }
    }

}