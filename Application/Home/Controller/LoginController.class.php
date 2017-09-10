<?php

namespace Home\Controller;

use Common\Controller\PubController;

class LoginController extends PubController
{

    public function login()
    {
        if(!empty(session('user')) && session('user') == 'is_login'){
            $this->ajaxReturn(retErrorMessage('已登录，请不要重复登录'), 'JSON');
        }

        $model = M('User');
        $post = I('post.');
        $where['username'] = $post['username'];
        $data = $model->where($where)->find();

        if (empty($post['username'])) {
            $ret = retErrorMessage('用户名不能为空');
            $this->ajaxReturn($ret, 'JSON');
        }

        if (empty($post['passwd'])) {
            $ret = retErrorMessage('密码不能为空');
            $this->ajaxReturn($ret, 'JSON');
        }

        if (check_verify($post['verify'])) {

            if (empty($data)) {
                $ret = retErrorMessage('您还未注册，请先注册');

                $this->ajaxReturn($ret, 'JSON');
            }
            if ($data['is_seal'] == '1') {
                $ret = retErrorMessage('您已被封号，请先申请解封');

                $this->ajaxReturn($ret, 'JSON');
            }

            if ($data['passwd'] != md5($post['passwd'] . $data['salt'])) {
                $ret = retErrorMessage('密码或帐号错误');
                $this->ajaxReturn($ret, 'JSON');
            }

            if ($data['is_seal'] == '0' && !empty($data) && $data['passwd'] == md5($post['passwd'] . $data['salt'])) {
                $inert['last_login_time'] = time();
                $inert['last_login_ip'] = get_client_ip();
                $inert['login_times'] = $data['login_times'] + 1;
                $model->where($where)->save($inert);
                /*$expire = 60*60*3;
                ini_set('session.gc_maxlifetime',  $expire);
                ini_set('session.cookie_lifetime',  $expire);
                session_start();
                $_SESSION['user'] = 'is_login';
                $_SESSION['username'] = $post['username'];*/
                session(array('name' => 'user', 'expire' => 60 * 60 * 3));
                session('user', "is_login");
                session('username', $post['username']);
                $token = md5(time().$inert['last_login_ip'].mt_rand(1, 1000));
                $redis = \Common\Model\RedisModel::getInstance();
                $redis->set($post['username'], $token);
                $redis->setTimeout($post['username'], 2592000);
                $redis->close();

                $ret = retMessage('登录成功', array('username' => $post['username'], 'token' => $token));
                $this->ajaxReturn($ret, 'JSON');
            }
        } else {
            $ret = retErrorMessage('验证码错误');

            $this->ajaxReturn($ret, 'JSON');
        }
    }

    public function verification(){
        $post = I('post.');

        $redis = \Common\Model\RedisModel::getInstance();
        $token = $redis->get($post['username']);
        if(!$token == $post['token'] || $token === false){
            $this->ajaxReturn(retErrorMessage('登录失败'), 'JSON');
        }
        session(array('name' => 'user', 'expire' => 60 * 60 * 3));
        session('user', "is_login");
        session('username', $post['username']);
        $this->ajaxReturn(retMessage('登录成功'), 'JSON');
    }

    public function logout(){
        $redis = \Common\Model\RedisModel::getInstance();
        $ret = $redis->get(session('username'));
        if($ret !== false){
            $redis->delete(session('username'));
        }
        session(null);
        $redis->close();
        $this->ajaxReturn(retMessage('退出登录成功'), 'JSON');
    }

    public function showVerify()
    {
        show_verify();
    }
}