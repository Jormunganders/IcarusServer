<?php
namespace Home\Controller;
use Common\Controller\UserController as Controller;

class UserController extends Controller{
    public function editUserData()
    {
        $post = I("post.");
        $this->is_login();
        $this->isOnePeople($post['username']);

        if (empty($post['email'])) {
            return retErrorMessage('邮箱不能为空');
        }
        if (empty($post['username'])) {
            return retErrorMessage('用户id不能为空');
        }
        if(empty($post['nick'])){
            return retErrorMessage('昵称不能为空');
        }
        $this->checkTheFormat('email', $post['email'], '%[\w!#$%&\'*+/=?^_`{|}~-]+(?:\.[\w!#$%&\'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?%i');
        $this->checkTheFormat('username', $post['username'], '%[a-zA-z]%i');
        $model = D("User");
        $ret = $model->editUserData($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function editPasswd(){

        $post = I('post.');

        $this->is_login();
        $this->isOnePeople($post['username']);

        if($post['repasswd'] != $post['passwd']){
            $this->ajaxReturn(retErrorMessage('两次输入密码不一致'), 'JSON');
        }
        $ret = D('User')
            ->editPasswd($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function forgetPasswd()
    {

    }

    public function getUserData(){

    }
}