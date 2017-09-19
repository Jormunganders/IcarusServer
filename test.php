<?php
/*ob_start();
$header = "Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN'];
ob_clean();
header('Access-Control-Allow-Credentials:true');
header($header);
//header("Access-Control-Allow-Origin: http://localhost:63342");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
function sum($n){
    if(is_int($n/2)){
        $ret = $n/2;
        $str = '';
        for($i = 0; $i < $ret; $i++){
            $str .= '2';
        }
        echo $str;
    }else{
        $ret = ($n-1)/2;
        $str = '1';
        for ($i = 0; $i < $ret; $i++){
            $str .= '2';
        }
        echo $str;
    }
}
function get($n){
    $n = (string)$n;
    $d_n = array();
    $len = strlen($n);
    for ($i = $len-1; $i >= 0; $i--){
        if($n[$i] != 0){
            $d_n[] = $n[$i];
        }
    }
    $dn = implode($d_n);
    $n = (int)$dn+(int)$n;
    echo $n;
}

function avg($s){
    $len = strlen($s);
    $sum = array();
    $j = 1;
    for ($i = 0; $i < $len-1; $i++){
        if($s[$i] == $s[$i+1]){
            $s[$i] = ++$j;
        }else{
            $sum[] = $s[$i-1];
            $j = 1;
            if($i == $len-2){
                $sum[] = 1;
            }
        }
    }
    $avg = 0;
    foreach ($sum as $val){
        $avg = (int)$avg+(int)$val;
    }
    $avg = $avg/count($sum);
    echo $avg;
}
var_dump($_REQUEST);*/