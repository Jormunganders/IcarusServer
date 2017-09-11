<?php
namespace Home\Controller;
use Common\Controller\UserController;

class ReplyController extends UserController{
    public function addReply(){
        $post = I('post.');

        $this->is_login();
        $this->isOnePeople($post['username']);
        $this->is_empty('username', $post['username']);
        $this->is_empty('postsId', $post['postsId']);
        $this->is_empty('content', $post['content']);

        $ret = M('User')
            ->field('uid')
            ->where(array('username'=>$post['username']))
            ->find();
        $post['uid'] = $ret['uid'];

        $ret = D('Reply')->addReply($post);
        if($ret[0] === true){
            $this->ajaxReturn(retMessage($ret[1]), 'JSON');
        }
        $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
    }

    public function getAllReply(){
        $get = I('get.');
        $get['page'] = floor($get['page']);
        $get['row'] = floor($get['row']);

        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);
        $this->is_empty('postsId', $get['postsId']);

        $ret = D('Reply')->getAllReply($get['page'], $get['row'], $get);
        if($ret[0] === true){
            $this->ajaxReturn(retMessage($ret[1], $ret[2]), 'JSON');
        }
        $this->ajaxReturn(retErrorMessage($ret[1], $ret[2]), 'JSON');
    }

    public function deleteReply(){
        $get = I('get.');
        $this->is_login();

        $this->is_empty('rid', $get['rid']);
        $this->is_empty('username', $get['username']);
        $this->is_empty('cid', $get['cid']);

        $uid = M('Reply')
            ->field('uid')
            ->where(array('rid'=>$get['rid']))
            ->find();
        $username = M('User')
            ->field('username')
            ->where(array('uid'=>$uid['uid']))
            ->find();
        if($username['username'] !== session('username')){
            if(!$this->isAuthority($get['cid'])){
                $this->ajaxReturn(retErrorMessage('没有权限'), 'JSON');
            }
        }

        $ret = D('Reply')->deleteReply($get);
        if($ret[0] === true){
            $this->ajaxReturn(retMessage($ret[1]), 'JSON');
        }
        $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
    }

    public function getOneReply(){
        $get = I('get.');
        $this->is_empty('rid', $get['rid']);

        $ret = D('Reply')->getOneReply($get);
        if($ret[0] === true){
            $this->ajaxReturn(retMessage($ret[1], $ret[2]), 'JSON');
        }
        $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
    }

    public function editReply(){
        $post = I('post.');
        $this->is_empty('rid', $post['rid']);
        $uid = M('Reply')
            ->field('uid')
            ->where(array('rid'=>$post['rid']))
            ->find();
        $username = M('User')
            ->field('username')
            ->where(array('uid'=>$uid['uid']))
            ->find();

        if($username['username'] !== session('username')){
            if(!$this->isAuthority($post['cid'])){
                $this->ajaxReturn(retErrorMessage('没有权限'), 'JSON');
            }
        }

        $ret = D('Reply')->editReply($post);
        if($ret[0] === true){
            $this->ajaxReturn(retMessage($ret[1]), 'JSON');
        }
        $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
    }

    public function approve(){
        $get = I('get.');
        $this->is_login();
        $approve = M('Reply')
            ->field('approve_amount')
            ->where(array('rid'=>$get['rid']))
            ->find();
        $ret = M('Reply')
            ->where(array('rid'=>$get['rid']))
            ->save(array('approve_amount' => (int)$approve['approve_amount']+1));
        if($ret !== false){
            $this->ajaxReturn(retMessage('点赞成功', array('approve_amount' => (int)($approve['approve_amount']+1))), 'JSON');
        }
        $this->ajaxReturn(retErrorMessage('点赞失败'), 'JSON');
    }
}