<?php
namespace Home\Controller;
use Common\Controller\UserController as Controller;

class UserController extends Controller{
    public function getOneUser(){
        $get = I('get.');

        $this->is_login();
        $this->isOnePeople($get['username']);

        $ret = D('User')->getOneUser($get);
        $falter = array('username'=>'','user_nick'=>'','head_img'=>'','cid'=>'');
        $ret = array_intersect_key($ret, $falter);
        $this->ajaxReturn(retMessage('', $ret), 'JSON');
    }

    public function editUserData()
    {
        $post = I("post.");
        $this->is_login();
        $this->isOnePeople($post['username']);

        if (empty($post['email'])) {
            return retErrorMessage('邮箱不能为空');
        }
        if (empty($post['username'])) {
            return retErrorMessage('用户id不能为空');
        }
        if(empty($post['nick'])){
            return retErrorMessage('昵称不能为空');
        }
        $this->is_str_len_long('email', $post['email'], 255);
        $this->is_str_len_long('nick', $post['nick'], 50, '1');
        $this->checkTheFormat('email', $post['email'], "%^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$%i");

        $model = D("User");
        $ret = $model->editUserData($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function editPasswd(){

        $post = I('post.');

        $this->is_login();
        $this->isOnePeople($post['username']);
        $this->is_empty('passwd', $post['passwd']);
        $this->is_empty('repasswd', $post['repasswd']);

        if($post['repasswd'] != $post['passwd']){
            $this->ajaxReturn(retErrorMessage('两次输入密码不一致'), 'JSON');
        }
        $this->is_str_len_long('passwd', $post['passwd'], 255);
        $ret = D('User')
            ->editPasswd($post);
        $this->ajaxReturn($ret, 'JSON');
    }

    public function forgetPasswd()
    {
        $post = I('post.');

        if(!empty(session('user'))){
            $this->ajaxReturn(retErrorMessage('您已登录，请先退出登录'), 'JSON');
        }
        $this->is_empty('username', $post['username']);
        $this->is_empty('email', $post['email']);

        $ret = D('User')->forgetPasswd($post);
        if($ret[0] === true){
            $content = <<<EOL
Hi,{$post['username']}:
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;    忘记密码了么？别着急，请点击以下链接， 我们协助您找回密码：
    <br/>
&nbsp;&nbsp;&nbsp;&nbsp;     {$ret['url']}
    <br/>
&nbsp;&nbsp;&nbsp;&nbsp;     如果这不是本人操作，请忽略。
EOL;
            $address = $post['email'];
            $subject = '找回Icarus密码';
            $ret = send_email($address, $subject, $content);

            if($ret['error'] !== 1){
                $this->ajaxReturn(retErrorMessage('发送失败'), 'JSON');
            }
            $this->ajaxReturn(retMessage('发送成功,请注意查看邮件'), 'JSON');
        }else{
            $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
        }
    }

    public function getPasswd(){
        $get = I('get.');
        $redis = \Common\Model\RedisModel::getInstance();
        $token = $redis->get($get['username']);
        $username = $redis->get($token);
        list($get['token'], $ext) = explode('.', $get['token']);

        if(empty($username) || empty($token) || $get['token'] != $token){
            http_response_code(404);
            $this->redirect('User/pageNotFound', '',0, '404');
        }

        $this->assign('username', $username);
        $this->assign('token', $get['token']);
        $this->assign('user_token', $get['username']);
        $this->display();
    }

    public function modifyPasswd(){
        $post = I('post.');
        $redis = \Common\Model\RedisModel::getInstance();
        $username = $redis->get($post['token']);

        if(empty($username) || empty($post['token'] || $username != $post['username'])){
            http_response_code(404);
            $this->ajaxReturn(retErrorMessage('口令已过期，找回密码收到邮件后请尽快完成密码修改') ,' JSON');
        }

        $this->is_empty('old_passwd', $post['old_passwd']);
        $this->is_empty('passwd', $post['passwd']);
        $this->is_empty('repasswd', $post['repasswd']);

        if($post['passwd'] != $post['repasswd']){
            $this->ajaxReturn(retErrorMessage('密码确认不正确'), 'JSON');
        }
        $redis->set($post['user_token'], time().mt_rand(1,100));

        $ret = D('User')->editPasswd($post);
        $redis->close();
        $this->ajaxReturn($ret, 'JSON');
    }

    public function pageNotFound(){
        $this->display();
    }

    public function getUserPosts(){
        $get = I('get.');

        $this->is_empty('username', $get['username']);
        $this->is_empty('page', $get['page']);
        $this->is_empty('row', $get['row']);

        $posts = M('Posts')
            ->alias('p')
            ->field('p.posts_id, p.title, p.add_time, p.content')
            ->join('icarus_user u ON p.uid=u.uid')
            ->where(array('u.username'=>$get['username']))
            ->page($get['page'] . ',' . $get['row'])
            ->order('p.posts_id DESC')
            ->select();

        foreach ($posts as $key => $val){
            if(strlen($val['content']) >= 270){
                $val['content'] = substr($val['content'], 0, 270);
                $val['content'] = $val['content'] . "...";
            }
        }

        $this->ajaxReturn(retMessage('', $posts), 'JSON');
    }

    public function getUserReply(){
       $get = I('get.');
       $this->is_empty('username', $get['username']);
       $this->is_empty('page', $get['page']);
       $this->is_empty('row', $get['row']);

       $uid = M('User')
           ->field('uid')
           ->where(array('username'=>$get['username']))
           ->find();

       $reply = M('Reply')
           ->alias('r')
           ->field('r.rid, r.content, r.reply_time, p.posts_id, p.title')
           ->join('icarus_posts p ON r.posts_id=p.posts_id')
           ->where(array('r.uid' => $uid['uid']))
           ->page($get['page'] . ',' . $get['row'])
           ->order('r.rid DESC')
           ->select();

       foreach ($reply as $key => $val){
           if(strlen($val['content']) > 270){
               $val['content'] = substr($val['content'], 0, 270);
               $val['content'] = $val['content'] . '...';
           }
       }

       $this->ajaxReturn(retMessage('', $reply), 'JSON');
    }
}