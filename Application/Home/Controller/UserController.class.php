<?php
namespace Home\Controller;
use \Common\Controller;

class UserController extends Controller\BaseController{
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