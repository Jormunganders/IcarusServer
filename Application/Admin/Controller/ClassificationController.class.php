<?php
namespace Admin\Controller;
use Common\Controller\AdminController;

class ClassificationController extends AdminController{
   public function addClassification(){
       $post = I('post.');

       $this->is_empty('parentId', $post['parentId']);
       $this->is_empty('cName', $post['cName']);
       $this->is_empty('is_featured', $post['is_featured']);
       $ret = D('Classification')->addClassification($post);
       if($ret[0] === false){
           $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
       }
       $this->ajaxReturn(retMessage($ret[1]), 'JSON');
   }

   public function deleteClassification(){
       $get = I('get.');

       $this->is_empty('cid', $get['cid']);
       $ret = D('Classification')->deleteClassification($get);
       if($ret[0] === false){
           $this->ajaxReturn(retErrorMessage($ret[1], $ret[3]), 'JSON');
       }
       $this->ajaxReturn(retMessage($ret[1]), 'JSON');
   }

   public function editClassification(){
       $post = I('post.');

       $this->is_empty('cid', $post['cid']);
       $this->is_empty('cName', $post['cName']);
       $ret = D('Classification')->editClassification($post);
       if($ret[0] === false){
           $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
       }
       $this->ajaxReturn(retMessage($ret[1]), 'JSON');
   }

   public function getOneClassification(){
       $get = I('get.');

       $this->is_empty('cid', $get['cid']);
       $ret = D('Classification')->getOneClassification($get);
       if($ret[0] === false){
           $this->ajaxReturn(retErrorMessage($ret[1]), 'JSON');
       }
       $this->ajaxReturn(retMessage($ret[1], $ret[3]), 'JSON');
   }

   public function getTreeClassification(){
       $get = I('get.');

       $this->is_empty('cid', $get['cid']);
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

       $this->is_empty('cid', $get['cid']);
       $this->is_empty('action', $get['action']);

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