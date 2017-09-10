<?php
namespace Home\Controller;
use Common\Controller\UserController;

class PostsController extends UserController{
    public function publishPosts(){
        $post = I('post.');

        $this->is_login();
        $this->isOnePeople($post['username']);
        $this->is_empty('username', $post['username']);
        $this->is_empty('cid', $post['cid']);
        $this->is_empty('title', $post['title']);
        $this->is_empty('content', $post['content']);
        $this->is_empty('keywords', $post['keywords']);
        $this->is_str_len_long('title', $post['title'], 255, '1');
        $this->is_str_len_long('keywords', $post['keywords'], 255, '1');

        $model = M('User');
        $ret = $model
            ->field('uid')
            ->where(array('username' => $post['username']))
            ->find();
        if(empty($ret)){
            $this->ajaxReturn(retErrorMessage('没有这个用户'), 'JSON');
        }
        $post['uid'] = $ret['uid'];
        $ret = D('Posts')->publishPosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

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
        $this->is_empty('username', $get['username']);
        $this->is_empty('cid', $get['cid']);
        $this->is_empty('postsId', $get['postsId']);

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
        $this->is_empty('username', $post['username']);
        $this->is_empty('postsId', $post['postsId']);
        $this->is_empty('title', $post['title']);
        $this->is_empty('content', $post['content']);
        $this->is_empty('keywords', $post['keywords']);
        $this->is_str_len_long('title', $post['title'], 255, '1');
        $this->is_str_len_long('keywords', $post['keywords'], 255, '1');

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
        $this->is_empty('username', $get['username']);
        $this->is_empty('cid', $get['cid']);
        $this->is_empty('postsId', $get['postsId']);
        $this->is_empty('action', $get['action']);

        $get['is_show'] = 1;

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
        $this->is_empty('username', $post['username']);
        $this->is_empty('cid', $post['cid']);
        $this->is_empty('postsId', $post['postsId']);

        $ret = D('Posts')->movePosts($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getTopPostsList(){
        $get = I('get.');
        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);
        $ret = D('Posts')->getTopPostsList($get['page'], $get['row'], '1');
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getRecommendPostsList(){
        $get = I('get.');

        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);
        $ret = D('Posts')->getRecommendPostsList($get['page'], $get['row'], '1');
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getPostsList(){
        $get = I('get.');

        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);
        $ret = D('Posts')->getPostslist($get['page'], $get['row'], '1');
        $this->ajaxReturn($ret, 'JSON');
    }

    public function searchPostsByKeywords(){
        $post = I('post.');
        $post['is_show'] = 1;

        $this->is_empty('keywords', $post['keywords']);
        $ret = D('Posts')->searchPostsByKeywords($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getClassificationPosts(){
        $get = I('get.');

        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);
        $this->is_empty('cid', $get['cid']);
        $ret = D('Posts')->getClassificationPosts($get, '1');
        $this->ajaxReturn($ret, 'JSON');
    }

    public function getOnePosts(){
        $get = I('get.');
        $get['is_show'] = 1;

        $this->is_empty('postsId', $get['postsId']);
        $ret = D('Posts')->getOnePosts($get);
        $click = $ret['data']['click'] + 1;
        M('Posts')->where(array('posts_id' => $get['postsId']))->save(array('click'=>$click));

        $this->ajaxReturn($ret, 'JSON');
    }

    public function getPostsCount(){
        $get = I('get.');

        $this->is_empty('action', $get['action']);

        if($get['action'] == 'delete'){
            $get['action'] = 'general';
        }

        $ret = D('Posts')->getPostsCount($get['action'], '1');
        $this->ajaxReturn(retMessage('', array('count'=>$ret[2])), 'JSON');
    }
}