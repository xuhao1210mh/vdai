<?php
namespace Desk\Controller;
use Think\Controller;

class PhotoController extends Controller{

    public function upload(){
        if(empty($_FILES['file']['name'])){
            $msg = array('code' => 0, 'msg' => '请上传图片');
            echo json_encode($msg);
            exit();
        }
        $filename = $_FILES['file'];
        $ext = strrchr($filename['name'], '.');
        $name = md5($filename['name']);
        $dir_name = dirname(dirname(dirname(__DIR__))) . '/Public/heads/' . $name . $ext;
        
        if(move_uploaded_file($filename['tmp_name'], $dir_name)){
            $id=$_SESSION['id'];
            $data['head'] = $name . $ext;
            $msg = array('code' => 1, 'msg' => 'success');
            $user = M('user');
            $result = $user->where("id='$id'")->save($data);
            if($result){
                $this->success('保存成功', '/desk/center/setting');
            }else{
                $this->error('该图片已存在');
            }
        }else{
            $this->error('图片上传失败');
        }
    }

}