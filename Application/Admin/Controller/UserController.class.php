<?php

namespace Admin\Controller;
use Common\Controller\AdminController;

class UserController extends AdminController
{
    public function editPasswd()
    {
        $post = I("post.");

        $this->is_empty('passwd', $post['passwd']);
        $this->is_empty('old_passwd', $post['old_passwd']);
        $this->is_str_len_long('passwd', $post['passwd'], 255);

        $model = D('User');
        $ret = $model->editPasswd($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getOneUser()
    {
        $post = I("post.");

        $model = D('User');
        $ret = $model->getOneUser($post);
        $ret = retMessage('', array($ret));
        $this->ajaxReturn($ret, "JSON");
    }

    public function getUserList()
    {
        $model = D('User');
        $data = I('get.');
        $ret = $model->getUserlist($data['page'], $data['row']);
        $ret = retMessage('', array($ret));
        $this->ajaxReturn($ret, 'JSON');
    }

    public function addModerator()
    {
        $post = I("post.");
        $model = D('User');
        $ret = $model->addModerator($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function addAdministrator()
    {
        $post = I("post.");
        $model = D("User");
        $ret = $model->addAdministrator($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function sealUser(){
        $post = I("post.");
        $model = D("User");
        $ret = $model->sealUser($post);
        $this->ajaxReturn($ret, 'JSON');
    }
}