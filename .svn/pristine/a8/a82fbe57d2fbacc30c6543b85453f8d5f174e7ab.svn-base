<?php
namespace Desk\Model;
use Think\Model;

class LoginModel extends Model{

    protected $tableName = 'user';

    //定义自动验证
    protected $_validate = array(
        array('username','require','请输入用户名'),
        array('password','require','请输入密码'),
    );

    public function login($username, $password){
        $result = $this->query("select id from user where username='$username' and password='$password'");
        if($result[0]['id']){
            session('id', $result[0]['id']);
            return 1;
        }else{
            return 0;
        }
    }

}