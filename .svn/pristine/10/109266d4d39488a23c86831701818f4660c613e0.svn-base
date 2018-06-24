<?php
namespace Desk\Model;
use Think\Model;

class RegisterModel extends Model{

    protected $tableName = 'user';

    //定义自动验证
    protected $_validate = array(
        //array('username','require','请输入用户名'),
        array('username', '', '该用户已经存在！', 0 ,'unique', 1), // 在新增的时候验证username字段是否唯一
        //array('password', 'require', '请输入密码'),
    );

    protected $_auto = array(
        array('create_time','time',1,'function'),
    );

}