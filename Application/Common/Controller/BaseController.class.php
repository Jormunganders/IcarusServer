<?php
namespace Common\Controller;
use Think\Controller;
class BaseController extends Controller{
    public function _initialize(){
        header("Access-Control-Allow-Origin: *");
    }
}