<?php
namespace Home\Controller;
use Common\Controller\UserController;

class ClassificationController extends UserController{
    public function getOneClassification(){
        $get = I('get.');
        $get['is_show'] = 1;

        foreach ($get as $key => $val){
            $this->is_empty($key, $val);
        }
        $ret = D('Classification')->getOneClassification($get);

        if($ret[0] === false){
            $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
        }
        $this->ajaxReturn(retMessage($ret[1], $ret[3]), 'JSON');
    }

    public function getTreeClassification(){
        $get = I('get.');
        $get['is_show'] = 1;

        foreach ($get as $key => $val){
            $this->is_empty($key, $val);
        }
        $ret = D('Classification')->getTreeClassification($get['cid'], $get);
        $this->ajaxReturn(retMessage('', $ret), 'JSON');
    }

    public function getParentClassificationList(){
        $get['is_show'] = 1;

        $ret = D('Classification')->getParentClassificationList($get);
        $this->ajaxReturn(retMessage('', $ret), 'JSON');
    }
}