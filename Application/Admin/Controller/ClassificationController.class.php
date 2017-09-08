<?php
namespace Admin\Controller;
use Common\Controller\AdminController;

class ClassificationController extends AdminController{
   public function addClassification(){
       $post = I('post.');

       foreach ($post as $key => $val){
           $this->is_empty($key, $val);
       }
       $ret = D('Classification')->addClassification($post);
       if($ret[0] === false){
           $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
       }
       $this->ajaxReturn(retMessage($ret[1]), 'JSON');
   }

   public function deleteClassification(){
       $get = I('get.');

       foreach ($get as $key => $val){
           $this->is_empty($key, $val);
       }
       $ret = D('Classification')->deleteClassification($get);
       if($ret[0] === false){
           $this->ajaxReturn(retErrorMessage($ret[1], $ret[3]), 'JSON');
       }
       $this->ajaxReturn(retMessage($ret[1]), 'JSON');
   }

   public function editClassification(){
       $post = I('post.');

       foreach ($post as $key => $val){
           $this->is_empty($key, $val);
       }
       $ret = D('Classification')->editClassification($post);
       if($ret[0] === false){
           $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
       }
       $this->ajaxReturn(retMessage($ret[1]), 'JSON');
   }

   public function getOneClassification(){
       $get = I('get.');
       //TODO 将返回的字段名称处理一下

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
       foreach ($get as $key => $val){
           $this->is_empty($key, $val);
       }
       $ret = D('Classification')->getTreeClassification($get['cid']);
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

       foreach ($get as $key => $val){
           $this->is_empty($key, $val);
       }

       if($get['action'] == 'move'){
           $ret = M('Classification')
               ->field('cid')
               ->where(array('cid' => $get['parentId']))
               ->find();
           if(empty($ret)){
               $this->ajaxReturn(retErrorMessage('没有这个版块'), 'JSON');
           }
       }
       $ret = D('Classification')->actionClassification($get);
       if($ret[0] === false){
           $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
       }
       $this->ajaxReturn(retMessage($ret[1]), 'JSON');
   }
}