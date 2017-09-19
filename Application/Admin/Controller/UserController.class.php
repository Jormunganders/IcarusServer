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
        $data = I('get.');
        $model = D('User');

        $this->is_empty('page', $data['page']);
        $this->is_empty('row', $data['row']);
        $ret = $model->getUserlist($data['page'], $data['row']);
        $ret = retMessage('', $ret);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function addModerator()
    {
        $post = I("post.");
        $this->is_empty('username', $post['username']);
        $this->is_empty('cName', $post['cName']);
        $model = D('User');
        $ret = $model->addModerator($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function addAdministrator()
    {
        $post = I("post.");
        if(session('admin_username') != 'root'){
            $this->ajaxReturn(retErrorMessage('没有权限'), 'JSON');
        }
        $model = D("User");
        $ret = $model->addAdministrator($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function sealUser(){
        $post = I("post.");
        if($post['username'] == 'root'){
            $this->ajaxReturn(retMessage('封号成功'), 'JSON');
        }
        $model = D("User");
        $ret = $model->sealUser($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getUserCount(){
        $ret = M('User')
            ->count('uid');
        $this->ajaxReturn(retMessage('获取成功', array('count'=>$ret)), 'JSON');
    }

    public function cancelSeal(){
        $get = I('get.');

        $ret = M('User')
            ->where(array('username'=>$get['username']))
            ->save(array('is_seal'=>0));
        if($ret !== false){
            $this->ajaxReturn(retMessage('解封成功'), 'JSON');
        }
        $this->ajaxReturn(retErrorMessage('解封失败，请重试'), 'JSON');
    }

    public function getReportReply(){
        $ret = M('Report')
            ->field('username, rid')
            ->where("rid <> ''")
            ->select();
        $this->ajaxReturn(retMessage('', $ret), 'JSON');
    }

    public function getReportPosts(){
        $ret = M('Report')
            ->field('username, posts_id')
            ->where("posts_id <> ''")
            ->select();
        $this->ajaxReturn(retMessage('', $ret), 'JSON');
    }

    public function getSealUserList(){
        $ret = M('User')
            ->field('username, last_login_time, last_login_ip, login_times, email, is_admin, cid')
            ->where('is_seal=1')
            ->select();
        $this->ajaxReturn(retMessage('', $ret), 'JSON');
    }
}