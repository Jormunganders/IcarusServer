<?php
namespace Common\Model;

class ReplyModel extends BaseModel{

    public function addReply($post){
        $insert['uid'] = $post['uid'];
        $insert['parent_id'] = $post['parentId'];
        $insert['posts_id'] = $post['postsId'];
        $insert['content'] = $post['content'];
        $insert['is_show'] = 1;
        $insert['is_delete'] = 0;
        $insert['reply_time'] = time();
        $insert['approve_amount'] = 0;

        if($this->add($insert)){
            return array(true, '发表成功');
        }else{
            return array(false, '发表失败');
        }
    }

    //分页获取
    public function getAllReply($page = '1', $row = '20', $get = array()){
        $all = $this
            ->alias('r')
            ->field('r.rid, r.parents_id, r.content, r.reply_time, r.approve_amount, u.username')
            ->join('icarus_user u ON u.uid=r.uid')
            ->where(array(
                'is_delete' => 0,
                'posts_id' => $get['postsId']
                ))
            ->page($page . ',' . $row)
            ->select();

        $delete = $this
            ->field('rid, parents_id')
            ->where(array(
                'posts_id' => $get['postsId'],
                'is_delete' => 1
            ))
            ->select();
        $rid = array();
        $parents_id = array();
        foreach ($delete as $key => $val){
            $rid[$key] = $val['rid'];
            $parents_id[$key] = $val['parents_id'];
        }
        $already_handler = array();
        foreach ($all as $key => $val){
            if($val['parents_id'] != 0) {
                if ($val['rid'] < $delete[0]['rid'] || $val['parents_id'] < $delete[0]['rid']) {
                    $already_handler[$val['parents_id']]['child'] = $val;
                } else {

                }
            }else{
                $already_handler[$val['rid']] =  $val;
            }
        }
    }

    public function deleteReply($get){
        $where['rid'] = $get['rid'];
        $update['is_delete'] = 1;

        if($this->where($where)->save($update)){
            return array(true, '删除成功');
        }else{
            return array(false, '删除成功');
        }
    }

    public function getOneReply($get){
        $where['rid'] = $get['rid'];
        $where['is_delete'] = 0;

        $ret = $this
            ->field('rid, parents_id, posts_id, content, reply_time')
            ->where($where)
            ->find();
        if($ret !== false){
            return array(true, '', $ret);
        }
        return array(false, '获取失败');
    }

    public function editReply($post){
        $update['content'] = $post['content'];
        $where['rid'] = $post['rid'];
        if($this->where($where)->save($update)){
            return array(true, '修改成功');
        }else{
            return array(false, '修改失败');
        }
    }
}