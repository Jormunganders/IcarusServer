<?php

namespace Home\Controller;

use Common\Controller\PubController;

class SignController extends PubController
{
    public function sign()
    {
            $model = M('User');
            $post = I('post.');
            $where['username'] = $post['username'];
            if (empty($post['username'])) {
                $ret = retErrorMessage('用户名不能为空');
                $this->ajaxReturn($ret, 'JSON');
            } elseif (empty($post['passwd'])) {
                $ret = retErrorMessage('密码为空');
                $this->ajaxReturn($ret, 'JSON');
            } elseif (empty($post['email'])) {
                $ret = retErrorMessage('邮箱不能为空');
                $this->ajaxReturn($ret, 'JSON');
            }
            $this->is_str_len_long('username', $post['username'], 20);
            $this->is_str_len_long('email', $post['email'], 255);
            $this->checkTheFormat('email', $post['email'], "%^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$%i");
            $this->checkTheFormat('username', $post['username'], "%[a-zA-z]%i");

            $user = $model->where($where)->find();
            $wh['email'] = $post['email'];
            $email = $model->where($wh)->find();
            if (!empty($email)) {
                $ret = retErrorMessage('邮箱已被注册');
                $this->ajaxReturn($ret, 'JSON');
                exit;
            }
            if (!empty($user)) {
                $ret = retErrorMessage('帐号已被注册');
                $this->ajaxReturn($ret, 'JSON');
                exit;
            }
            $data['username'] = $post['username'];
            $data['create_time'] = time();
            $data['email'] = $post['email'];
            $data['is_admin'] = 0;
            $data['salt'] = md5(time() . mt_rand(1, 1000));
            $data['passwd'] = md5($post['passwd'] . $data['salt']);

            if ($model->add($data) !== false) {
                $ret = retMessage('注册成功');
            } else {
                $ret = retErrorMessage('注册失败');
            }

            $this->ajaxReturn($ret, 'JSON');
    }

    public function showVerify()
    {
        show_verify();
    }
}