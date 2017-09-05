<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
    public function login(){
        if(IS_POST){
            $post = I('post.');
            $model = D('user');
            if(check_verify($post['verify'])){
                $where['user_nick'] = $post['nick'];
                $data = $model->where($where)->find();
                if($data == false || $data == null){
                    $ret = retMessage('', array($model->getDbError()));
                    $this->ajaxReturn($ret, 'JSON');
                }
                if($data['is_admin'] == '2' || $data['is_admin'] == '3'){
                    if($data['passwd'] == md5($post['passwd'].$data['salt'])){
                        $insert['last_login_time'] = time();
                        $insert['last_login_ip'] = getIp();
                        $insert['login_time'] = $data['login_time']+1;
                        if(!$model->where($where)->save($insert)){
                            $ret = retErrorMessage('登录失败');
                            $this->ajaxReturn($ret, 'JSON');
                        }
                        session('user', 'is_admin');
                        $ret = retMessage('登录成功');
                    }else{
                        $ret = retErrorMessage('密码或帐号错误');
                    }
                }else{
                    $ret = retErrorMessage('不是管理员');
                }
            }else{
                $ret = retErrorMessage('验证码错误');
            }
            $this->ajaxReturn($ret, 'JSON');
        }else{
            $this->display();
        }
    }

    public function showVerify(){
        show_verify();
    }
}