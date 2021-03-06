<?php
namespace Desk\Controller;
use Think\Controller;

class LoanController extends Controller{

    public function fill(){
        if(IS_AJAX){
            session('name', $_POST['name']);
            session('number', $_POST['number']);
            $this->success('成功', '/desk/loan/assetSubmit');
        }else{
            $this->error('失败');
        }

    }

    public function assetSubmit(){
        $setting = M('setting');
        $result = $setting->select();
        $this->assign('result', $result);
        if(IS_AJAX){
            $loan = M('loan');
            if($loan->create()){
                $result = $loan->add();
                if($result){
                    session('loan_id', $result);
                    $this->success('成功', '/desk/loan/rzPage');
                }else{
                    $this->error('失败');
                }
            }else{
                $this->error('出错');
            }
        }

        $this->display();

    }

    public function rzPage(){

        if(IS_AJAX){
            $loan_id = $_SESSION['loan_id'];
            $data['name'] = $_POST['name'];
            $data['number'] = $_POST['number'];
            $data['family_name'] = $_POST['family_name'];
            $data['family_number'] = $_POST['family_number'];
            $data['friend_name'] = $_POST['friend_name'];
            $data['friend_number'] = $_POST['friend_number'];
            $authfirst = M('auth_first');
            if($authfirst->create()){
                $result = $authfirst->where("loan_id='$loan_id'")->find();
                if($result){
                    $authfirst->where("loan_id='$loan_id'")->data($data)->save();
                    $this->success('修改信息', '/desk/loan/rzPage1');
                }

                $data['loan_id'] = $loan_id;
                $result = $authfirst->data($data)->add();
                if($result){
                    $this->success('成功','/desk/loan/rzPage1');
                }else{
                    $this->error($authfirst->getError());
                }
            }else{
                $this->error($authfirst->getError());
            }
        }

        $this->display();
    }

    public function upload(){

        $filename = [
            $_FILES['file1']['name'],
            $_FILES['file2']['name'],
            $_FILES['file3']['name'],
            $_FILES['file4']['name'],
        ];

        $tmpname = [
            $_FILES['file1']['tmp_name'],
            $_FILES['file2']['tmp_name'],
            $_FILES['file3']['tmp_name'],
            $_FILES['file4']['tmp_name'],
        ];

        foreach($filename as $k => $v){
            $dir_name[$k] = dirname(dirname(dirname(__DIR__))) . '/Public/authpic/' . $v;
            if(!move_uploaded_file($tmpname[$k], $dir_name[$k])){
                $this->error('图片上传失败');
                exit();
            }
        }

        $loan_id = $_SESSION['loan_id'];
        $card_number = $_POST['card_number'];
        $card_name = $_POST['card_name'];
        $auth = M('auth_second');
        $result = $auth->where("loan_id='$loan_id'")->find();
        if($result){
            $this->success('已存在', '/desk/loan/renZheng');
        }
        $result = $auth->execute("insert into auth_second(loan_id,pic1,pic2,pic3,pic4,card_number,card_name) values('$loan_id', '$filename[0]', '$filename[1]', '$filename[2]', '$filename[3]', '$card_number', '$card_name')");
        if($result){
            $this->success('成功', 'renZheng');
        }else{
            $auth->where("loan_id='$loan_id'")->delete();
            $this->error('资料提交失败，请重新填写');
        }

    }

    public function auth(){

        $filename = [
            $_FILES['file1']['name'],
            $_FILES['file2']['name'],
        ];

        $tmpname = [
            $_FILES['file1']['tmp_name'],
            $_FILES['file2']['tmp_name'],
        ];

        foreach($filename as $k => $v){
            $dir_name[$k] = dirname(dirname(dirname(__DIR__))) . '/Public/authpic2/' . $v;
            if(!move_uploaded_file($tmpname[$k], $dir_name[$k])){
                $this->error('图片上传失败');
                exit();
            }
        }

        $loan_id = $_SESSION['loan_id'];
        $auth = M('auth_third');
        $result = $auth->where("loan_id='$loan_id'")->find();
        if($result){
            $this->success('已存在', '/desk/result/shResult1');
        }
        $result = $auth->execute("insert into auth_third(loan_id, auth1, auth2) values('$loan_id', '$filename[0]', '$filename[1]')");
        if($result){
            $data['status'] = 1;
            $loan = M('loan');
            $auth1 = M('auth_first');
            $auth2 = M('auth_second');
            $auth3 = M('auth_third');
            $loan->where("loan_id='$loan_id'")->data($data)->save();
            $auth1->where("loan_id='$loan_id'")->data($data)->save();
            $auth2->where("loan_id='$loan_id'")->data($data)->save();
            $auth3->where("loan_id='$loan_id'")->data($data)->save();
            $this->success('成功', '/desk/result/shResult1');
        }else{
            $auth->where("loan_id='$loan_id'")->delete();
            $this->error('资料提交失败，请重新填写');
        }

    }


    public function renZheng(){
        $this->display();
    }

}