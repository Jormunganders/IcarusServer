<?php
namespace Common\Controller;

class PubController extends BaseController{
    public function _initialize()
    {
        parent::_initialize();
        if(!empty(session('admin_user')) && session('admin_user') == 'is_admin'){
            return retErrorMessage('已登录，请不要重复登录');
        }
    }
}