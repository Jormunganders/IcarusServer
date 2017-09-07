<?php
namespace Home\Controller;
use Common\Controller\UserController as Controller;

class UserController extends Controller{
    public function editUserData()
    {
        $post = I("post.");
        $model = D("User");
        $ret = $model->editUserData($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function forgetPasswd()
    {

    }
}