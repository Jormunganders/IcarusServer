<?php
namespace Common\Controller;
use Think\Controller;
class BaseController extends Controller{
    public function _initialize(){

    }

    protected function is_empty($name, $value){
        if(empty($value) || !isset($value)){
            $this->ajaxReturn(retErrorMessage("{$name}不能为空"), 'JSON');
        }
    }

    protected function is_str_len_long($name, $value, $length){
        if(strlen($value) > $length){
            $this->ajaxReturn(retErrorMessage("{$name}长度应在0~{$length}字以内"), 'JSON');
        }
    }

    protected function checkTheFormat($name, $value, $preg){
        if(!preg_match($preg, $value)){
            $this->ajaxReturn(retErrorMessage("{$name}格式不符"), 'JSON');
        }
    }
}