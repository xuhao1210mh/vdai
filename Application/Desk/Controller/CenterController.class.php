<?php
namespace Desk\Controller;
use Think\Controller;

class CenterController extends Controller{

    public function personalCenter(){
        $id = $_SESSION['id'];
        $user = M('user');
        $result = $user->where("id='$id'")->select();
        $this->assign('result', $result);
        // if(IS_AJAX){
        //     $this->success('成功', '/desk/center/personalCenter');
        // }

        $this->display();

    }

    public function aboutus(){

        if(IS_AJAX){
            $this->success('成功', '/desk/center/aboutus');
        }

        $this->display();
    }

    public function myLoan(){

        $id = $_SESSION['id'];
        $myloan = M('loan');
        $result = $myloan->where("id='$id' and status!='0'")->order('loan_id desc')->select();
        $this->assign('result', $result);

        if(IS_AJAX){

            $this->success('成功', 'myLoan');

        }

         $this->display();

    }

    public function setting(){

        $id = $_SESSION['id'];
        $user = M('user');
        $result = $user->query("select * from user where id='$id'");
        $this->assign('result', $result);
        if(IS_AJAX){
            $this->success('成功', '/desk/center/setting');
        }

        $this->display();
    }

    public function head(){
        $this->display();
    }

    public function upload(){
        if(IS_AJAX){
            $id = $_SESSION['id'];
            $data = array(
                'nickname' => $_POST['nickname'],
                'sex' => $_POST['sex']
            );
            $user = M('user');
            $result = $user->where("id='$id'")->data($data)->save();
            if($result){
                $this->success('成功');
            }else{
                $this->error('失败');
            }
        }
    }

    public function signOut(){
        if($_POST['flag'] == 1){
            session(null);
            $this->success('成功', '/');
            exit();
        }
    }

    public function message(){
        if(IS_AJAX){
            $this->success('成功', '/desk/center/message');
        }

        $this->display();
    }

    public function writeMessage(){
        if(IS_AJAX){
            $id = $_SESSION['id'];
            $user = M('user');
            $result = $user->find($id);
            $username = $result['username'];
            $name = $result['nickname'];
            $content = $_POST['content'];
            $message = M('message');
            $create_time = date('Y-m-d h:i:s');
            $result = $message->execute("insert into message(name, number, content, create_time) values('$name', '$username', '$content', '$create_time')");
            if($result){
                $this->success('成功', '/desk/center/personalCenter');
            }else{
                $this->error('失败');
            }
        }
    }   

    public function printSession(){
        $this->success($_SESSION);
    }

}