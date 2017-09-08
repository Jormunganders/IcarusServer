<?php
namespace Admin\Controller;
use Common\Controller\AdminController;

class ClassificationController extends AdminController{
   public function addClassification(){
       $post = I('post.');

       $ret = D('Classification')->addClassification($post);
       $this->ajaxReturn($ret, 'JSON');
   }

   public function deleteClassification(){
       $get = I('get.');

       $ret = D('Classification')->deleteClassification($get);
       $this->ajaxReturn($ret, 'JSON');
   }

   public function editClassification(){
       $post = I('post.');

       $ret = D('Classification')->editClassification($post);
       $this->ajaxReturn($ret, 'JSON');
   }

   public function getOneClassification(){
       $get = I('get.');
       //TODO 将返回的字段名称处理一下

       $ret = D('Classification')->getOneClassification($get);
       $this->ajaxReturn(retMessage('', $ret), 'JSON');
   }

   public function getTreeClassification(){
       $get = I('get.');

       $ret = D('Classification')->getTreeClassification($get['cid'], $get);
       $this->ajaxReturn(retMessage('',$ret), 'JSON');
   }

   public function getParentClassificationList(){

       $ret = D('Classification')->getParentClassificationList();
       $this->ajaxReturn(retMessage('', $ret), 'JSON');
   }

   public function getDeleteClassificationList(){
       $ret = D('Classification')->getDeleteClassificationList();
       $this->ajaxReturn(retMessage('', $ret), 'JSON');
   }

   public function actionClassification(){
       $get = I('get.');

       $ret = D('Classification')->actionClassification($get);
       $this->ajaxReturn(retMessage('', $ret), 'JSON');
   }
}