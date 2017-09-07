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
        $ret = D('Posts')->actionPosts($get['action'], $get);
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

    public function getDeletePosts(){
        $ret = M('Posts')
            ->field('posts_id, title, author, content, keywords, add_time, click, is_end')
            ->where('is_delete=1')
            ->select();
        return retMessage('', $ret);
    }

    public function searchPostsByKeywords()
    {
        $post = I('post.');
        $ret = D('Posts')->searchPostsByKeyWords($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getClassificationPosts(){
        $get = I('get.');
        $ret = D('Posts')->getClassificationPosts($get);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getOnePosts(){
        $get = I('get.');
        $ret = D('Posts')->getOnePosts($get);
        $this->ajaxReturn($ret, 'JSON');
    }
}