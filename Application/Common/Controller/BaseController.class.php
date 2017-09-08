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
}