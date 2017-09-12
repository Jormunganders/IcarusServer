<?php
namespace Home\Controller;
use Common\Controller\UserController;

class ReportController extends UserController{
    public function reportReply(){
        $get = I('get.');

        $this->is_login();
        $this->is_empty('rid', $get['rid']);
        $this->is_empty('username', $get['username']);

        $ret = M('Report')
            ->where(array('username'=>$get['username'],'rid'=>$get['rid']))
            ->find();
        if(empty($ret)){
            $insert['username'] = $get['username'];
            $insert['rid'] = $get['rid'];
            M('Report')->add($insert);
        }
        $this->ajaxReturn(retMessage('举报成功'), 'JSON');
    }

    public function reportPosts(){
        $get = I('get.');

        $this->is_login();
        $this->is_empty('username', $get['username']);
        $this->is_empty('posts_id', $get['posts_id']);

        $ret = M('Report')
            ->where(array('username'=>$get['username'], 'posts_id'=>$get['posts_id']))
            ->find();
        if(empty($ret)){
            $insert['username'] = $get['username'];
            $insert['posts_id'] = $get['posts_id'];
            M('Report')->add($insert);
        }
        $this->ajaxReturn(retMessage('举报成功'), 'JSON');
    }
}