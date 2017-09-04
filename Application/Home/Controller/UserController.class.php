<?php
namespace Home\Controller;
use \Common\Controller;

class UserController extends Controller\BaseController{

    public function addAdministrator(){
        if(IS_POST) {
            $model = M('User');
            $post = I('post.');
            if (empty($post['admin_grade'])) {
                $ret = retMessage(4004, '请填写等级');
            }elseif (empty($post['nick'])) {
                $ret = retMessage(4004, '请填写昵称');
            }
            $data['is_admin'] = $post['admin_grade'];
            if ($model->where("user_nick=" . $post['nick'])->save($data) !== false) {
                $ret = retMessage(0, '添加成功');
            } else {
                $ret = retMessage(4004, '添加失败');
            }
        }else{
            $ret = retMessage(4004, '请通过正常渠道提交');
        }
        $this->ajaxReturn($ret, 'JSON');
    }

    public function addModerator(){
        $model = M('User');
        $post = I('post');
        if(empty($post['admin_grade'])){
            $ret = retMessage(4004, '等级不能为空');
            $this->ajaxReturn($ret, 'JSON');
        }
        if(empty($post['nick'])){
            $ret = retMessage(4004, '昵称不能为空');
            $this->ajaxReturn($ret, 'JOSN');
        }
        $data['is_admin'] = $post['admin_grade'];
        if($model->where("user_nick=".$post['nick'])->save($data) !== false){
            $ret = retMessage(0, '添加成功');
        }else{
            $ret = retMessage(4004, '添加失败');
        }
        $this->ajaxReturn($ret, 'JSON');
    }

    public function editUserData(){
        $model = M('User');
        $post = I('post');
        if(empty($post['passwd'])){
            $ret = retMessage(4004, 'passwd字段为空');
            $this->ajaxReturn($ret, 'JSON');
        }
        if(empty($post['email'])){
            $ret = retMessage(4004, 'email字段为空');
            $this->ajaxReturn($ret, 'JSON');
        }
        if(empty($post['nick'])){
            $ret = retMessage(4004, 'nick字段为空');
            $this->ajaxReturn($ret, 'JSON');
        }
        empty($post['head_img']) ? $data['head_img'] = '' :$data['head_img'] = $post['head_img'];
        $data['email'] = $post['email'];
        $data['passwd'] = $post['passwd'];
        if($model->where('user_nick='.$post['nick'])->save($data) !== false){
            $ret = retMessage(0, '修改成功');
        }else{
            $ret = retMessage(4004, '修改失败');
        }
        $this->ajaxReturn($ret, 'JSON');
    }

    public function get_verify(){
        echo show_verify();
    }
}