<?php
namespace Common\Controller;

class UserController extends BaseController{
    public function _initialize()
    {
        parent::_initialize();
        if(empty(session('user')) || session('user') !== 'is_login'){
            return retErrorMessage('请先登录');
        }
    }
}