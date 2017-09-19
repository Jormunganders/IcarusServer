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
        $ret = $this->where($where)->find();
        if(empty($ret)){
            return retErrorMessage('没有此用户');
        }

        if ($ret['passwd'] != md5($data['old_passwd'] . $ret['salt'])) {
            return retErrorMessage('原密码不正确');
        }

        $update['passwd'] = md5($data['passwd'] . $ret['salt']);
        if ($this->create()) {
            $this->where($where)->save($update);
            return retMessage('修改密码成功');
        }
    }

    public function forgetPasswd($post)
    {
        $where['username'] = $post['username'];
        $ret = $this->field('email')->where($where)->find();
        if(empty($ret)){
            return array(false, '没有此用户');
        }

        if($post['email'] != $ret['email']){
            return array(false, '用户名或邮箱错误');
        }

        $rand = md5(time().get_client_ip().mt_rand(1, 1000));
        $username = md5($post['username'].mt_rand(1,100));

        $redis = \Common\Model\RedisModel::getInstance();
        $redis->set($username, $rand);
        $redis->set($rand, $post['username']);
        $redis->setTimeout($username, 3600);

        return array(true, 'url' => "http://localhost:8000/IcarusServer/index.php/Home/User/getPasswd/username/{$username}/token/{$rand}");
    }

    public function getOneUser($nick)
    {
        $where['username'] = $nick['username'];
        $ret = $this->field('username,user_nick,head_img,create_time,last_login_time,last_login_ip,login_times,email,is_admin,is_seal,cid')->where($where)->find();
        if(empty($ret)){
            return retErrorMessage('没有此用户');
        }
        return $ret;
    }

    public function getUserList($page = 1, $row = 20)
    {
        return $this->field('username,user_nick,head_img,create_time,last_login_time,last_login_ip,login_times,email,is_admin,is_seal,cid')->page($page . "," . $row)->select();
    }

    public function addModerator($post)
    {
        $where['username'] = $post['username'];
        $ret = $this->field('uid, is_admin')->where($where)->find();
        if(empty($ret) || $ret['is_admin'] == 3){
            return retErrorMessage('没有此用户');
        }
        $ret = M('Classification')
            ->field('cid')
            ->where(array('c_name'=>$post['cName'], 'is_delete'=>0))
            ->find();
        if(empty($ret)){
            return retErrorMessage('没有此版块');
        }
        $data['is_admin'] = 1;
        $data['cid'] = $ret['cid'];
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
        $username = $this->field('username')->where($wh)->find();
        if(!empty($username) && $username['username'] != $post['username']){
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
            $ret = retErrorMessage('请填写用户id');
            return $ret;
        }
        if(empty($this->field('uid')->where(array('username'=>$post['username']))->find())){
            return retErrorMessage('没有此用户');
        }
        $where['username'] = $post['username'];
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
            $ret = retErrorMessage('请填写用户id');
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