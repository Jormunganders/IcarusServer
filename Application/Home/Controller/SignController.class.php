<?php
namespace Home\Controller;
use \Common\Controller\BaseController;

class SignController extends BaseController{
    public function addUser()
    {
        if (IS_POST) {
            $model = M('User');
            $post = I('post.');
            if (empty($post['nick'])) {
                $ret = retMessage(4004, '昵称不能为空');
                $this->ajaxReturn($ret, 'JSON');
            }elseif (empty($post['passwd'])) {
                $ret = retMessage(4004, '密码为空');
                $this->ajaxReturn($ret, 'JSON');
            }elseif (empty($post['email'])) {
                $ret = retMessage(4004, '邮箱不能为空');
                $this->ajaxReturn($ret, 'JSON');
            }
            $user = $model->where('user_nick=' . $post['nick'])->find();
            if (!empty($user)) {
                $ret = retMessage(4004, '帐号已被注册');
                $this->ajaxReturn($ret, 'JSON');
            }
            $data['user_nick'] = $post['nick'];
            $data['create_time'] = time();
            $data['email'] = $post['email'];
            $data['is_admin'] = 0;
            $data['salt'] = md5(time() . mt_rand(1, 1000));
            $data['passwd'] = md5($post['passwd'] . $user['salt']);

            if ($model->add($data) !== false) {
                $ret = retMessage(0, '注册成功');
            } else {
                $ret = retMessage(4004, '注册失败');
            }
        }else{
            $ret = retMessage(4004, '请通过正常渠道注册');
        }
        $this->ajaxReturn($ret, 'JSON');
    }
}