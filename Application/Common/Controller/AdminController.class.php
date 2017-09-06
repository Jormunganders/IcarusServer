<?php
namespace Common\Controller;

class AdminController extends BaseController{
    public function _initialize()
    {
        parent::_initialize();
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
    }

    public function isOnePeople($username){
        if($username != session('admin_username')){
            $this->ajaxReturn(retErrorMessage('用户名不一致'), 'JSON');
        }
    }
}