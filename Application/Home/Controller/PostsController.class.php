<?php
namespace Home\Controller;
use Common\Controller\UserController;

class PostsController extends UserController{
    public function publishPosts(){
        $post = I('post.');
        $this->is_login();
        $this->isOnePeople($post['username']);
        $ret = M('User')->field('uid')->where('username=%s', array(session('username')))->find();
        if(empty($ret)){
            $this->ajaxReturn(retErrorMessage('没有这个用户'), 'JSON');
        }
        $post['uid'] = $ret['uid'];
        $ret = D('Posts')->publishPosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    //TODO 很多都要判断是否有权限

    public function deletePosts(){
        $get = I('get.');

        $this->is_login();
        $this->isOnePeople($get['username']);
        if(!$this->isOwn($get)){
            $this->ajaxReturn(retErrorMessage('没有权限'), 'JSON');
        }
        if(!$this->isAuthority($get['cid'])){
            $this->ajaxReturn(retErrorMessage('没有权限'), 'JSON');
        }
        $ret = D('Posts')->deletePosts($get);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function editPosts(){
        $post = I('post.');

        $this->is_login();
        $this->isOnePeople($post['username']);
        if(!$this->isOwn($post)){
            $this->ajaxReturn(retErrorMessage('没有权限'), 'JSON');
        }
        $ret = D('Posts')->editPosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function actionPosts(){
        $get = I('get.');

        $this->is_login();
        $this->isOnePeople($get['username']);
        if(!$this->isAuthority($get['cid'])){
            $this->ajaxReturn(retErrorMessage('没有权限'), 'JSON');
        }

        $ret = D('Posts')->actionPosts($get['action'], $get);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function movePosts(){
        $post = I('post.');

        $this->is_login();
        $this->isOnePeople($post['username']);
        if(!$this->isAuthority($post['cid'])){
            $this->ajaxReturn(retErrorMessage('没有权限'), 'JSON');
        }

        $ret = D('Posts')->movePosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getTopPostsList(){
        $get = I('get.');
        $ret = D('Posts')->getTopPostsList($get['page'], $get['row'], '1');
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getRecommendPostsList(){
        $get = I('get.');
        $ret = D('Posts')->getRecommendPostsList($get['page'], $get['row'], '1');
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getPostsList(){
        $get = I('get.');

        $ret = D('Posts')->getPostslist($get['page'], $get['row'], '1');
        $this->ajaxReturn($ret, 'JSON');
    }

    public function searchPostsByKeywords(){
        $post = I('post.');
        $post['is_show'] = 1;

        $ret = D('Posts')->searchPostsByKeywords($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getClassificationPosts(){
        $get = I('get.');

        $ret = D('Posts')->getClassificationPosts($get, '1');
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getOnePosts(){
        $gte = I('gte.');
        $get['is_show'] = 1;

        $ret = D('Posts')->getOnePosts($get);
        $this->ajaxReturn($ret, 'JSON');
    }
}