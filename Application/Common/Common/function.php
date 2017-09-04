<?php
//获取用户ip
function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function show_verify($config=''){
    if($config==''){
        $config=array(
            'codeSet'=>'1234567890',
            'fontSize'=>30,
            'useCurve'=>false,
            'imageH'=>60,
            'imageW'=>240,
            'length'=>4,
            'fontttf'=>'4.ttf',
        );
    }
    $verify=new \Think\Verify($config);
    return $verify->entry();
}

function check_verify($code){
    $verify=new \Think\Verify();
    return $verify->check($code);
}

function retMessage($status, $message = '', $data = array()){
    if(empty($data)){
        return array(
            'status' => $status,
            'message' => $message
        );
    }
    return array(
        'status' => $status,
        'data' => $data,
        'message' => $message
    );
}