<?php

namespace Common\Model;

use Think\Model;

class UserModel extends Model
{
    /*protected $_validate = array(
        array('repasswd', 'passwd', '密码确认不正确', 0, 'confirm'),
    );*/

    public function editPasswd($data)
    {
        $where['username'] = $data['username'];
        if(empty($this->where($where)->find())){
            return retErrorMessage('没有此用户');
        }
        $ret = $this->where($where)->find();
        if ($ret['passwd'] != md5($data['old_passwd'] . $ret['salt'])) {
            return retErrorMessage('原密码不正确');
        }

        $update['passwd'] = md5($data['passwd'] . $ret['salt']);
        if ($this->create()) {
            $this->where($where)->save($update);
            return retMessage('修改密码成功');
        }
    }

    public function forgetPasswd()
    {

    }


    public function getOneUser($nick)
    {
        $where['username'] = $nick['username'];
        if(empty($this->where($where)->find())){
            return retErrorMessage('没有此用户');
        }
        return $this->where($where)->find();
    }

    public function getUserList($page = '1', $row = '20')
    {
        return $this->page($page . ',' . $row)->select();
    }

    public function addModerator($post)
    {
        $where['username'] = $post['username'];
        if (empty($post['username'])) {
            return retErrorMessage('昵称不能为空');
        }
        if(empty($this->where($where)->find())){
            return retErrorMessage('没有此用户');
        }
        $data['is_admin'] = 1;
        $data['cid'] = $post['cid'];
        if ($this->where($where)->save($data) !== false) {
            $ret = retMessage('添加成功');
        } else {
            $ret = retErrorMessage('添加失败');
        }
        return $ret;
    }

    public function editUserData($post)
    {
        $where['username'] = $post['username'];
        $wh['email'] = $post['email'];
        if(empty($this->where($where)->find())){
            return retErrorMessage('没有此用户');
        }
        if(!empty($this->where($wh)->find())){
            $ret = retErrorMessage('邮箱已被注册');
            return $ret;
        }
        empty($post['head_img']) ? $data['head_img'] = '' :$data['head_img'] = $post['head_img'];
        $data['user_nick'] = $post['nick'];
        $data['email'] = $post['email'];
        if ($this->where($where)->save($data) != false) {
            $ret = retMessage('修改成功');
        } else {
            $ret = retMessage('修改失败', array('data' => $this->getDbError()));
        }
        return $ret;
    }

    public function addAdministrator($post)
    {
        if (empty($post['username'])) {
            $ret = retErrorMessage('请填写用户名称');
            return $ret;
        }
        $where['username'] = $post['username'];
        if(empty($this->where($where)->find())){
            return retErrorMessage('没有此用户');
        }
        $data['is_admin'] = 2;
        if ($this->where($where)->save($data) !== false) {
            $ret = retMessage('添加成功');
        } else {
            $ret = retErrorMessage('添加失败');
        }
        return $ret;
    }

    public function sealUser($post){
        if(empty($post['username'])){
            $ret = retErrorMessage('请填写昵称');
            return $ret;
        }
        $where['username'] = $post['username'];
        $result = $this->where($where)->find();
        if(empty($result)){
            return retErrorMessage('没有此用户');
        }
        $update['is_seal'] = 1;
        if($this->where($where)->save($update) !== false){
            return retMessage('封号成功');
        }else{
            return retMessage('封号失败，请重试', array($this->getDbError()));
        }
    }
}