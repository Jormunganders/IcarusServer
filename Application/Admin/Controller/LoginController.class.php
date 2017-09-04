<?php
namespace Admin\Controller;
use \Common\Controller\BaseController;

class LoginController extends BaseController{
    public function login(){
        if(IS_POST){
            $post = I('post.');
            if(check_verify($post['verify'])){

            }else{
                $ret = retMessage(4004, '验证码错误');
            }
        }
    }
}