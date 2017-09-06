<?php
namespace Home\Controller;
use Common\Controller\AdminController;

class PostsController extends AdminController{
    public function publishPosts(){
        $post = I('post.');
        $this->isOnePeople($post['username']);
        $ret = M('User')->field('uid')->where('username=%s', array(session('username')))->find();
        if(empty($ret)){
            $this->ajaxReturn(retErrorMessage('没有这个用户'), 'JSON');
        }
        $post['uid'] = $ret['uid'];
        $ret = D('Posts')->publishPosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function editPosts(){
        $post = I('post.');

        $this->isOnePeople($post['username']);
        $ret = D('Posts')->editPosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }
}