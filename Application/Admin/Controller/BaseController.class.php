<?php

namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller{
    
    public function checkLogin(){
        if(!$_SESSION['admin_id']){
            $this->error('请登录', '/admin/admin/login');
        }
    }
}