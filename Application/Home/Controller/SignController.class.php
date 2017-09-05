<?php
namespace Home\Controller;
use \Common\Controller\BaseController;
use Think\Controller;

class SignController extends Controller{
    public function sign()
    {
        if (IS_POST) {
            $model = M('User');
            $post = I('post.');
            $where['username'] = $post['username'];
            if (empty($post['username'])) {
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
            $where['email'] = $post['email'];
            $email = $model->where($where)->find();
            if(!empty($email)){
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
        }else{
            $ret = retErrorMessage('请通过正常渠道注册');
        }
        $this->ajaxReturn($ret, 'JSON');
    }

    public function showVerify(){
        show_verify();
    }
}