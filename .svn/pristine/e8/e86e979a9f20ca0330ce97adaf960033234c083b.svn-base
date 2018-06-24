<?php

namespace Desk\Controller;
use Think\Controller;

class ToolsController extends Controller{

    public function jump(){

        if(IS_AJAX){
            // if($_POST['flag'] == 'login'){
            //     $_SESSION['id'] = null;
            // }
            if($_POST['flag1'] == ''){
                $this->success('等待跳转', '/');
            }
            if($_POST['id'] == ''){
                $this->success('等待跳转', '/' . $_POST['flag1'] .'/'. $_POST['flag2'] .'/'. $_POST['flag3']);
            }else{
                $this->success('等待跳转', '/' . $_POST['flag1'] .'/'. $_POST['flag2'] .'/'. $_POST['flag3'] . '/' . $_POST['id']);
            }
        }

    }

}