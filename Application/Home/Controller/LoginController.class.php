<?php

namespace Home\Controller;
use Common\Controller\BaseController;

class LoginController extends BaseController
{

    public function login()
    {
        if (IS_POST) {
            $model = M('User');
            $post = I('post.');
            $where['user_nick'] = $post['nick'];
            $data = $model->where($where)->find();

            if(empty($post['nick'])){
                $ret = array(
                    'status' => 4004,
                    'message' => '昵称不能为空'
                );
                $this->ajaxReturn($ret, 'JSON');
            }

            if(empty($post['passwd'])){
                $ret = array(
                    'status' => 4004,
                    'message' => '密码不能为空'
                );
                $this->ajaxReturn($ret, 'JSON');
            }

            if (check_verify($post['verify'])) {

                if (empty($data)) {
                    $ret = array(
                        'status' => 4004,
                        'message' => '您还没注册，请先注册'
                    );

                    $this->ajaxReturn($ret, 'JSON');
                }
                if ($data['is_seal'] == '1') {
                    $ret = array(
                        'status' => 4004,
                        'message' => '您已被封号，请先解封'
                    );

                    $this->ajaxReturn($ret, 'JSON');
                }

                if ($data['passwd'] != md5($post['passwd'] . $data['salt'])) {
                    $ret = array(
                        'status' => 4004,
                        'message' => '密码或帐号错误'
                    );
                    $this->ajaxReturn($ret, 'JSON');
                }

                if ($data['is_seal'] == '0' && !empty($data) && $data['passwd'] == md5($post['passwd'] . $data['salt'])) {
                    $inert['last_login_time'] = time();
                    $inert['last_login_ip'] = getIp();
                    $inert['login_times'] = $data['login_times'] + 1;
                    $model->where($where)->save($inert);
                    session('user', "is_login");

                    $ret = array(
                        'status' => 0,
                        'data' => array(
                            'nick' => $post['nick'],
                            'head_img' => $data['head_img']
                        ),
                        'message' => '登录成功'
                    );
                    $this->ajaxReturn($ret, 'JSON');
                }
            } else {
                $ret = array(
                    'status' => 4004,
                    'message' => '验证码错误'
                );

                $this->ajaxReturn($ret, 'JSON');
            }
        } else {
            $ret = array(
                'status' => 4004,
                'message' => '请通过正规渠道登录'
            );

            $this->ajaxReturn($ret, 'JSON');
        }

    }
}