<?php

namespace Admin\Controller;

use Common\Controller\PubController;

class LoginController extends PubController
{
    public function login()
    {
        $post = I('post.');
        $model = D('user');
        $this->ajaxReturn(retMessage('', array($_SESSION, 'post' => $post)), 'JSON');
        if (check_verify($post['verify'])) {
            $where['username'] = $post['username'];
            $data = $model->where($where)->find();
            if ($data == false || $data == null) {
                $ret = retMessage('没有此用户', array($model->getDbError()));
                $this->ajaxReturn($ret, 'JSON');
            }
            if ($data['is_admin'] == '2' || $data['is_admin'] == '3') {
                if ($data['passwd'] == md5($post['passwd'] . $data['salt'])) {
                    $insert['last_login_time'] = time();
                    $insert['last_login_ip'] = get_client_ip();
                    $insert['login_times'] = (int)$data['login_times']++;
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

}