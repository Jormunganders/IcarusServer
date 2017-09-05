<?php
namespace Home\Controller;
use \Common\Controller\BaseController;

class SignController extends BaseController{
    public function sign()
    {
        if (IS_POST) {
            $model = M('User');
            $post = I('post.');
            $where['user_nick'] = $post['nick'];
            if (empty($post['nick'])) {
                $ret = retErrorMessage('昵称不能为空');
                $this->ajaxReturn($ret, 'JSON');
            }elseif (empty($post['passwd'])) {
                $ret = retErrorMessage('密码为空');
                $this->ajaxReturn($ret, 'JSON');
            }elseif (empty($post['email'])) {
                $ret = retErrorMessage('邮箱不能为空');
                $this->ajaxReturn($ret, 'JSON');
            }
            $user = $model->where($where)->find();
            if (!empty($user)) {
                $ret = retErrorMessage('帐号已被注册');
                $this->ajaxReturn($ret, 'JSON');
            }
            $data['user_nick'] = $post['nick'];
            $data['create_time'] = time();
            $data['email'] = $post['email'];
            $data['is_admin'] = 0;
            $data['salt'] = md5(time() . mt_rand(1, 1000));
            $data['passwd'] = md5($post['passwd'] . $user['salt']);

            if ($model->add($data) !== false) {
                $ret = retMessage('注册成功');
            } else {
                $ret = retErrorMessage('注册失败');
            }
        }else{
            $ret = retErrorMessage('请通过正常渠道注册');
        }
        $this->ajaxReturn($ret, 'JSON');
    }

    public function showVerify(){
        show_verify();
    }
}