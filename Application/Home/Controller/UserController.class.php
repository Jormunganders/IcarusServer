<?php
namespace Home\Controller;
use \Common\Controller;

class UserController extends Controller\BaseController{

    public function showVerify(){
        echo show_verify();
    }
}