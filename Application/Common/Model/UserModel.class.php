<?php

namespace Common\Model;

use Think\Model;

class UserModel extends Model
{
    protected $_validate = array(
        array('repasswd', 'passwd', '密码确认不正确', 0, 'confirm'),
    );

    public function editPasswd($data)
    {
        $where['user_nick'] = $data['nick'];
        $ret = $this->where($where)->find();
        if ($ret['passwd'] != md5($data['old_passwd'] . $ret['salt'])) {
            return retErrorMessage('原密码不正确');
        }

        $update['passwd'] = $data['old_passwd'];
        if ($this->create()) {
            $this->where($where)->save();
            return retMessage('修改密码成功');
        }
    }

    public function forgetPasswd()
    {

    }


    public function getOneUser($nick)
    {
        $where['user_nick'] = $nick;
        return $this->where($where)->find();
    }

    public function getUserList($page, $row)
    {
        return $this->page($page . ',' . $row)->select();
    }

    public function addModerator($post)
    {
        $where['user_nick'] = $post['nick'];
        if (empty($post['admin_grade'])) {
            return retErrorMessage('等级不能为空');
        }
        if (empty($post['nick'])) {
            return retErrorMessage('昵称不能为空');
        }
        $data['is_admin'] = $post['admin_grade'];
        if ($this->where($where)->save($data) !== false) {
            $ret = retMessage('添加成功');
        } else {
            $ret = retErrorMessage('添加失败');
        }
        return $ret;
    }

    public function editUserData($post)
    {
        $where['user_nick'] = $post['nick'];
        if (empty($post['passwd'])) {
            return retErrorMessage('passwd字段为空');
        }
        if (empty($post['email'])) {
            return retErrorMessage('email字段为空');
        }
        if (empty($post['nick'])) {
            return retErrorMessage('nick字段为空');
        }
        empty($post['head_img']) ? $data['head_img'] = '' : $data['head_img'] = $post['head_img'];
        $data['email'] = $post['email'];
        $data['passwd'] = $post['passwd'];
        if ($this->where($where)->save($data) !== false) {
            $ret = retMessage('修改成功');
        } else {
            $ret = retErrorMessage('修改失败');
        }
        return $ret;
    }

    public function addAdministrator($post)
    {
        $where['user_nick'] = $post['nick'];
        if (empty($post['admin_grade'])) {
            $ret = retErrorMessage('请填写等级');
        } elseif (empty($post['nick'])) {
            $ret = retErrorMessage('请填写昵称');
        }
        $data['is_admin'] = $post['admin_grade'];
        if ($this->where($where)->save($data) !== false) {
            $ret = retMessage('添加成功');
        } else {
            $ret = retErrorMessage('添加失败');
        }
        return $ret;
    }
}