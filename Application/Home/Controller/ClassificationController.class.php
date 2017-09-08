<?php
namespace Home\Controller;
use Common\Controller\UserController;

class ClassificationController extends UserController{
    public function getOneClassification(){
        $get = I('get.');
        $get['is_show'] = 1;

        $ret = D('Classification')->getOneClassification($get);
        $this->ajaxReturn(retMessage('', $ret), 'JSON');
    }

    public function getTreeClassification(){
        $get = I('get.');
        $get['is_show'] = 1;

        $ret = D('Classification')->getTreeClassification($get['cid'], $get);
        $this->ajaxReturn(retMessage('', $ret), 'JSON');
    }

    public function getParentClassificationList(){
        $get['is_show'] = 1;

        $ret = D('Classification')->getParentClassificationList($get);
        $this->ajaxReturn(retMessage('', $ret), 'JSON');
    }
}