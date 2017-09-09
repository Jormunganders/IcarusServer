<?php
namespace Admin\Controller;
use Common\Controller\AdminController;

class PostsController extends AdminController{

    public function deletePosts(){
        $get = I('get.');

        $this->is_empty('postsId', $get['postsId']);
        $ret = D('Posts')->deletePosts($get);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function actionPosts(){
        $get = I('get.');

        $this->is_empty('postsId', $get['postsId']);
        $this->is_empty('action', $get['action']);
        $ret = D('Posts')->actionPosts($get['action'], $get);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function movePosts(){
        $post = I('post.');

        $this->is_empty('cid', $post['cid']);
        $this->is_empty('postsId', $post['postsId']);
        $ret = D('Posts')->movePosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getTopPostsList(){
        $get = I('get.');

        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);
        $ret = D('Posts')->getTopPostsList($get['page'], $get['row']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getRecommendPostsList(){
        $get = I('get.');

        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);
        $ret = D('Posts')->getRecommendPostsList($get['page'], $get['row']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getPostsList(){
        $get = I('get.');

        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);
        $ret = D('Posts')->getPostsList($get['page'], $get['row']);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getDeletePosts(){
        $get = I('get');
        $this->is_empty('page', $get['paget']);
        $this->is_empty('row', $get['row']);

        $ret = M('Posts')
            ->field('posts_id, title, author, content, keywords, add_time, click, is_end')
            ->where('is_delete=1')
            ->order($get['page'] . ',' . $get['row'])
            ->select();
        return retMessage('', $ret);
    }

    public function searchPostsByKeywords()
    {
        $post = I('post.');

        $this->is_empty('keywords', $post['keywords']);
        $ret = D('Posts')->searchPostsByKeyWords($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getClassificationPosts(){
        $get = I('get.');

        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);
        $this->is_empty('cid', $get['cid']);
        $ret = D('Posts')->getClassificationPosts($get);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getOnePosts(){
        $get = I('get.');

        $this->is_empty('postsId', $get['postsId']);
        $ret = D('Posts')->getOnePosts($get);
        $click = $ret['data']['click'] + 1;
        M('Posts')->where(array('posts_id' => $get['postsId']))->save(array('click'=>$click));
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getPostsCount(){
        $get = I('get.');

        $this->is_empty('action', $get['action']);

        $ret = D('Posts')->getPostsCount($get['action']);
        $this->ajaxReturn(retMessage('', array('count'=>$ret[2])), 'JSON');
    }
}