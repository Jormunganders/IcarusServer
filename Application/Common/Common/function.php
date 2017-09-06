<?php
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

function retMessage($message = '', $data = array()){
    if(empty($data)){
        return array(
            'status' => 'ok',
            'message' => $message
        );
    }
    return array(
        'status' => 'ok',
        'data' => $data,
        'message' => $message
    );
}

function retErrorMessage($message, $data = array()){
    if(!empty($data)) {
        return array(
            'status' => 'error',
            'message' => $message,
            'data' => $data
        );
    }

    return array(
        'status' => 'error',
        'message' => $message
    );
}