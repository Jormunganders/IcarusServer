<?php

namespace Home\Controller;

use Common\Controller\PubController;

class LoginController extends PubController
{

    public function login()
    {
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
                session(array('name' => 'user', 'expire' => 60 * 60 * 3));
                session('user', "is_login");
                session('username', $post['username']);

                $ret = retMessage('登录成功');
                $this->ajaxReturn($ret, 'JSON');
            }
        } else {
            $ret = retErrorMessage('验证码错误');

            $this->ajaxReturn($ret, 'JSON');
        }
    }

    public function logout(){
        session(null);
        $this->ajaxReturn(retMessage('退出登录成功'), 'JSON');
    }

    public function showVerify()
    {
        show_verify();
    }
}