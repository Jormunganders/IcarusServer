<?php
namespace Home\Controller;
use Common\Controller\UserController;

class UploadController extends UserController{
    public function uploadImage(){
        $this->is_login();
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    './Uploads/',
            'savePath'   =>    '',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new \Think\Upload($config);
        $info = $upload->upload();
        if(!$info) {
            $this->ajaxReturn(retErrorMessage($upload->getError()), 'JSON');
        }else{
            $this->ajaxReturn(retMessage('', array('url' => 'http://localhost:8000/IcarusServer/Uploads/'.$info['image']['savepath'].$info['image']['savename'])), 'JSON');
        }
    }
}