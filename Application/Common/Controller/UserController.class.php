<?php
namespace Common\Controller;

class UserController extends BaseController{
    public function _initialize()
    {
        parent::_initialize();
    }

    protected function is_login(){
        if(empty(session('user')) || session('user') !== 'is_login'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        /*if(empty($_SESSION['user']) || $_SESSION['user'] !== 'is_login'){
            $this->ajaxReturn(retErrorMessage('请先登录', array($_SESSION['user'])), 'JSON');
        }*/
    }

    protected function isOnePeople($username){
        if($username != session('username')){
            $this->ajaxReturn(retErrorMessage('用户名不一致'), 'JSON');
        }
    }

    protected function isOwn($data){
        $ret = M('Posts')->field('uid')
            ->where('posts_id=%d', array($data['postsId']))
            ->find();
        $user = M('User')->field('username')
            ->where('uid=%d', array($ret['uid']))
            ->find();
        if($data['username'] === $user['username']){
            return true;
        }
        return false;
    }

    protected function isAuthority($cid){
        $username = session('username');

        $ret = M('User')
            ->field('is_admin, cid')
            ->where('username=%s', array($username))
            ->find();
        if($ret['is_admin'] == 2 || $ret['is_admin'] == 3){
            return true;
        }elseif ($ret['is_admin'] == 1){
            if($ret['cid'] == $cid){
                return true;
            }
        }
        return false;
    }
}