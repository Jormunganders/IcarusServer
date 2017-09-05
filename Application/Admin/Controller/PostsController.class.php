<?php
namespace Admin\Controller;
use Think\Controller;

class PostsController extends Controller{
    public function publishPosts(){
        $post = I('post.');
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        if($post['username'] != session('username')){
            $this->ajaxReturn(retErrorMessage('用户名不一致'), 'JSON');
        }

        $ret = M('User')->field('uid')->where('username=%s', array(session('username')))->find();
        if(empty($ret)){
            $this->ajaxReturn(retErrorMessage('没有这个用户'), 'JSON');
        }
        $post['uid'] = $ret['uid'];
        $ret = D('Posts')->publishPosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function deletePosts(){
        $post = I('get.');
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        $ret = D('Posts')->deletePosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function editPosts(){
        $post = I('post.');
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        if($post['username'] != session('username')){
            $this->ajaxReturn(retErrorMessage('用户名不一致'), 'JSON');
        }
        $ret = D('Posts')->editPosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function actionPosts(){
        $get = I('get.');
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        $ret = D('Posts')->actionPosts($get['action'], $get['posts_id']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function movePosts(){
        $post = I('post.');
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        $ret = D('Posts')->movePosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getTopPostsList(){
        $get = I('get.');
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        $ret = D('Posts')->getTopPostsList($get['page'], $get['row']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getRecommendPostsList(){
        $get = I('get.');
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        $ret = D('Posts')->getRecommendPostsList($get['page'], $get['row']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getPostsList(){
        $get = I('get.');
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        $ret = D('Posts')->getPostsList($get['page'], $get['row']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function searchPostsByKeywords()
    {
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        $post = I('post.');
        $ret = D('Posts')->searchPostsByKeyWords($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function uploadImage(){
        if(empty(session('admin_user')) || session('admin_user') !== 'is_admin'){
            $this->ajaxReturn(retErrorMessage('请先登录'), 'JSON');
        }
        $ret = D('Posts')->uploadImage();
        $this->ajaxReturn($ret, 'JSON');
    }
}