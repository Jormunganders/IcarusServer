<?php
namespace Common\Model;

class ClassificationModel extends BaseModel {

    //如果没有父版块，就传个parentId=0
    public function addClassification($post){
        $where['cid'] = $post['parentId'];
        $where['is_delete'] = 0;
        if($post['parentId'] != 0){
            $ret = $this->field('cid')->where($where)->find();
            if(empty($ret))
                return array(false, '没有此父版块');
        }

        $parent['is_delete'] = 0;
        $parent['c_name'] = $post['cName'];
        $ret = $this
            ->field('c_name')
            ->where($parent)
            ->find();
        if(!empty($ret))
            return array(false, '此版块名称已添加，请不要重复添加');


        $insert['parents_id'] = $post['parentId'];
        $insert['c_name'] = $post['cName'];
        $insert['is_featured'] = $post['is_featured'];

        if($this->create()){
            $this->add($insert);
            return array(true, '添加成功');
        }else{
            return array(false, '添加失败');
        }

    }

    public function deleteClassification($get){
        $ret = $this
            ->field('cid')
            ->where('cid=%d AND is_delete=0', array($get['cid']))
            ->find();
        if(empty($ret))
            return array(false, '没有此版块');

        $where['cid'] = $get['cid'];
        $delete['is_delete'] = 1;
        $this->where($where)
            ->save($delete);
        $ret = $this->deleteChild($get['cid']);
        if(!isset($ret)){
            return array(false, '以下版块删除未成功', $ret);
        }
        return array(true, '删除版块成功');
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
        static $fail = array();
        foreach ($ret as $v){
            $fail[] = $this->deleteChild($v['cid']);
        }
        return $fail;
    }

    public function editClassification($post){
        $ret = $this
            ->field('cid')
            ->where('cid=%d AND is_delete=0', array($post['cid']))
            ->find();
        if(empty($ret))
            return array(false, '没有此版块');

        $where['is_delete'] = 0;
        $where['c_name'] = $post['cName'];
        $ret = $this
            ->field('c_name')
            ->where($where)
            ->find();
        if(!empty($ret))
            return array(false, '已有此版块名称');

        $update['c_name'] = $post['cName'];
        $wh['cid'] = $post['cid'];
        $this->where($wh)->save($update);
        return array(true, '修改成功');
    }

    public function searchClassification($post){

    }

    public function getOneClassification($get){
        $where['cid'] = $get['cid'];
        if(!empty($get['is_show'])){
            $where['is_show'] = $get['is_show'];
        }
        $where['is_delete'] = 0;
        $child = $this->field('cid, c_name, parents_id, is_featured')
            ->where($where)
            ->find();

        if(empty($child)){
            return array(false, '没有此版块');
        }

        $parent = $this
            ->field('c_name')
            ->where('cid=%d', array($child['parents_id']))
            ->find();
        $child['parentName'] = $parent['c_name'];
        return array(true, '', $child);
    }

    public function getTreeClassification($cid, $get = array()){
        $where['parents_id'] = $cid;
        if(!empty($get['is_show'])){
            $where['is_show'] = $get['is_show'];
        }
        $where['is_delete'] = 0;
        $ret = $this->field('cid, c_name, is_featured')
            ->where($where)
            ->select();

        if($ret === false){
            return;
        }

        if(!isset($ret) || empty($ret) || $ret === false){
            return;
        }
        foreach ($ret as $val){
            $tree[$val['cid']]['cName'] = $val['c_name'];
            $tree[$val['cid']]['is_featured'] = $val['is_featured'];
            $tree[$val['cid']]['child'] = $this->getTreeClassification($val['cid']);
        }
        return $tree;
    }

    public function getParentClassificationList($get = array()){
        $where['parents_id'] = 0;
        $where['is_delete'] = 0;
        if(!empty($get['is_show'])){
            $where['is_show'] = $get['is_show'];
        }
        $ret = $this->field('cid, c_name, is_featured')
            ->where($where)
            ->select();
        return $ret;
    }

    public function getDeleteClassificationList(){
        $ret = $this->field('cid,c_name')
            ->where('is_delete=1')
            ->select();
        return $ret;
    }

    public function getClassificationList($get){

    }

    //show,hide显示和隐藏版块
    //featured加精版块
    //move移动版块
    public function actionClassification($get){
        $where['cid'] = $get['cid'];
        $where['is_delete'] = 0;
        switch ($get['action']){
            case 'show':
                $update['is_show'] = 1;
                $this->where($where)
                    ->save($update);
                return array(true, '修改成功');
            case 'hide':
                $update['is_show'] = 0;
                $this->where($where)
                    ->save($update);
                return array(true, '隐藏成功');
            case 'featured':
                $update['is_featured'] = 1;
                $this->where($where)
                    ->save($update);
                return array(true, '加精成功');
            case 'cancelFeatured':
                $update['is_featured'] = 0;
                $this->where($where)
                    ->save($update);
                return array(true, '取消加精成功');
            case 'recovery':
                $where['is_delete'] = 1;
                $update['is_delete'] = 0;
                $this->where($where)
                    ->save($update);
                return array(true, '恢复成功');
            case 'move':
                $update['parents_id'] = $get['parentId'];
                $this->where($where)
                    ->save($update);
                return array(true, '移动成功');
            default :
                return array(false, '没有这种操作');
        }
    }
}