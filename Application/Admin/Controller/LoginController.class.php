<?php

namespace Admin\Controller;

use Common\Controller\PubController;

class LoginController extends PubController
{
    public function login()
    {
        if(!empty(session('admin_user')) && session('admin_user') === 'is_admin'){
            $this->ajaxReturn(retErrorMessage('已登录，请不要重复登录'), 'JSON');
        }
        $post = I('post.');
        $model = D('user');
        $this->is_empty('username', $post['username']);
        $this->is_empty('passwd', $post['passwd']);
        if (check_verify($post['verify'])) {
            $where['username'] = $post['username'];
            $data = $model->where($where)->find();
            if ($data == false || $data == null) {
                $ret = retMessage('没有此用户', array($model->getDbError()));
                $this->ajaxReturn($ret, 'JSON');
            }
            $is_seal = $model->field('uid')->where(array('is_seal'=>0, 'username'=>$post['username']))->find();
            if(!isset($is_seal)){
                $this->ajaxReturn(retErrorMessage('您已被封号，请联系管理员解封'), 'JSON');
            }
            if ($data['is_admin'] == '2' || $data['is_admin'] == '3') {
                if ($data['passwd'] == md5($post['passwd'] . $data['salt'])) {
                    $insert['last_login_time'] = time();
                    $insert['last_login_ip'] = get_client_ip();
                    $insert['login_times'] = $data['login_times']+1;
                    if (!$model->where($where)->save($insert)) {
                        $ret = retErrorMessage('登录失败');
                        $this->ajaxReturn($ret, 'JSON');
                    }
                    session(array('name' => 'admin_user', 'expire' => 60 * 60 * 3));
                    session('admin_user', 'is_admin');
                    session('admin_username', $post['username']);
                    $ret = retMessage('登录成功');
                    $this->ajaxReturn($ret, 'JSON');
                } else {
                    $ret = retErrorMessage('密码或帐号错误');
                }
            } else {
                $ret = retErrorMessage('不是管理员');
            }
        } else {
            $ret = retErrorMessage('验证码错误');
        }
        $this->ajaxReturn($ret, 'JSON');
    }

    public function showVerify()
    {
        show_verify();
    }

    public function logout(){
        session(null);
        $this->ajaxReturn(retMessage('退出登录成功'), 'JSON');
    }

}