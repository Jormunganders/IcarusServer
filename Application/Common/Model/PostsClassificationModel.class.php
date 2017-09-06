<?php
namespace Common\Model;
use Think\Model;

class PostsClassification extends Model{
    protected $_auto = array(
        array('is_show', '1', 1),
        array('is_delete', '0', 1),
    );

    //如果没有父版块，就传个parentId=0
    public function addClassification($post){
        $where['cid'] = $post['parentId'];
        $where['is_show'] = 1;
        $where['is_delete'] = 0;
        $ret = $this->field('cid')->where($where)->find();
        if(empty($ret))
            return retErrorMessage('没有此父版块');
        $ret = $this
            ->field('c_name')
            ->where('is_show=1 AND is_delete=0 c_name=%s', array($post['cName']))
            ->find();
        if(!empty($ret))
            return retErrorMessage('此版块名称已添加，请不要重复添加');

        $insert['parents_id'] = $post['parentId'];
        $insert['c_name'] = $post['cName'];
        $insert['is_featured'] = $post['is_featured'];

        if($this->create()){
            $this->add($insert);
            return retMessage('添加成功');
        }else{
            return retErrorMessage('添加失败');
        }

    }

    public function deleteClassification($get){
        $ret = $this
            ->field('cid')
            ->where('cid=%d ADN is_show=1 AND is_delete=0', array($get['cid']))
            ->find();
        if(empty($ret))
            return retErrorMessage('没有此版块');
        $where['cid'] = $get['cid'];
        $delete['is_delete'] = 1;
        $this->where($where)
            ->save($delete);
        $ret = $this->deleteChild($get['cid']);
        if(!empty($ret)){
            return retErrorMessage('以下版块删除未成功', $ret);
        }
        return retMessage('删除版块成功');
    }

    protected function deleteChild($parentId){
        $ret = $this->field('cid')
            ->where('parents_id=%d', array($parentId))
            ->select();
        if(empty($ret))
            return;
        $where['parents_id'] = $parentId;
        $update['is_delete'] = 1;
        if(!$this->where($where)->save($update)){
            return $parentId;
        }
        $fail = array();
        foreach ($ret as $v){
            $fail[] = $this->deleteChild($v['cid']);
        }
        return $fail;
    }

    public function editClassification($post){
        $ret = $this
            ->field('cid')
            ->where('cid=%d AND is_show=1 AND is_delete=0', array($post['cid']))
            ->find();
        if(empty($ret))
            return retErrorMessage('没有此版块');
        $ret = $this
            ->field('c_name')
            ->where('is_show=1 AND is_delete=0 AND c_name=%s', array($post['cName']))
            ->find();
        if(!empty($ret))
            return retErrorMessage('已有此版块名称');

        $update['c_name'] = $post['cName'];
        $this->add($update);
        return retMessage('修改成功');
    }

    public function searchClassification($post){

    }

    public function getOneClassification($get){
        $where['cid'] = $get['cid'];
        $child = $this
            ->where($where)
            ->find();

        $parent = $this
            ->field('c_name')
            ->where('cid=%d', array($child['parent_id']))
            ->find();
        $child['parentName'] = $parent['c_name'];
        return $child;
    }

    protected function getTreeClassification($cid){
        $where['parent_id'] = $cid;
        $ret = $this->field('cid, c_name, ')
            ->where($where)
            ->select();

    }

    public function getClassificationList($get){

    }

    //show,hide显示和隐藏版块
    //featured加精版块
    //move移动版块
    public function actionClassification($post){

    }
}