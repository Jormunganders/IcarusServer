<?php
namespace Home\Controller;
use Common\Controller\AdminController;

class UploadController extends AdminController{
    public function uploadImage(){
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    __ROOT__ . '/Uploads/',
            'savePath'   =>    '',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new \Think\Upload($config);
        $info   =   $upload->upload();
        if(!$info) {
            $this->ajaxReturn(retMessage($upload->getError()), 'JSON');
        }else{
            $this->ajaxReturn(retMessage('', array('path' => $info['image']['savepath'])), 'JSON');
        }
    }
}