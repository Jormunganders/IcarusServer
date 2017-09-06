<?php
namespace Admin\Controller;
use Common\Controller\AdminController;

class PostsController extends AdminController{

    public function deletePosts(){
        $post = I('get.');
        $ret = D('Posts')->deletePosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function actionPosts(){
        $get = I('get.');
        $ret = D('Posts')->actionPosts($get['action'], $get['posts_id']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function movePosts(){
        $post = I('post.');
        $ret = D('Posts')->movePosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getTopPostsList(){
        $get = I('get.');
        $ret = D('Posts')->getTopPostsList($get['page'], $get['row']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getRecommendPostsList(){
        $get = I('get.');
        $ret = D('Posts')->getRecommendPostsList($get['page'], $get['row']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getPostsList(){
        $get = I('get.');
        $ret = D('Posts')->getPostsList($get['page'], $get['row']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function searchPostsByKeywords()
    {
        $post = I('post.');
        $ret = D('Posts')->searchPostsByKeyWords($post);
        $this->ajaxReturn($ret, 'JSON');
    }

}