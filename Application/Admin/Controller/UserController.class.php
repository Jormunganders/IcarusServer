<?php

namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function editPasswd()
    {
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retMessage('请先登录'), 'JSON');
        }
        $post = I("post.");
        $model = D('User');
        $ret = $model->editPasswd($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function forgetPasswd()
    {

    }

    public function getOneUser()
    {
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retMessage('请先登录'), 'JSON');
        }
        $post = I("post.");
        $model = D('User');
        $ret = $model->getOneUser($post);
        $ret = retMessage('', array($ret));
        $this->ajaxReturn($ret, "JSON");
    }

    public function getUserList()
    {
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retMessage('请先登录'), 'JSON');
        }
        $model = D('User');
        $data = I('get.');
        $ret = $model->getUserlist($data['page'], $data['row']);
        $ret = retMessage('', array($ret));
        $this->ajaxReturn($ret, 'JSON');
    }

    public function addModerator()
    {
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retMessage('请先登录'), 'JSON');
        }
        $post = I("post.");
        $model = D('User');
        $ret = $model->addModerator($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function editUserData()
    {
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retMessage('请先登录'), 'JSON');
        }
        $post = I("post.");
        $model = D("User");
        $ret = $model->editUserData($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function addAdministrator()
    {
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retMessage('请先登录'), 'JSON');
        }
        $post = I("post.");
        $model = D("User");
        $ret = $model->addAdministrator($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function sealUser(){
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retMessage('请先登录'), 'JSON');
        }
        $post = I("post.");
        $model = D("User");
        $ret = $model->sealUser($post);
        $this->ajaxReturn($ret, 'JSON');
    }
}