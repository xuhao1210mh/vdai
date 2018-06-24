<?php

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
    $msg = array('code' => 1, 'msg' => 'success');
    echo json_encode($msg);
}else{
    $msg = array('code' => 0, 'msg' => 'fail');
    echo json_encode($msg);
}
