<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->ajaxReturn(array('这时一片没有东西的荒原'), 'JSON');
    }
}