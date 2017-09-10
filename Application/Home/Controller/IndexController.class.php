<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        echo session_id();
        //http_response_code(404);

        /*$this->redirect('Home/Index/index1');*/
        /*$this->ajaxReturn(array('这时一片没有东西的荒原'), 'JSON');*/
    }


}