<?php
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://127.0.0.1:6379');
session_start();
function test($url = '', $data = array())
{
    $url = 'localhost:8000/IcarusServer/index.php/' . $url;
    //$url = 'http://115.159.56.141/index.php/' . $url;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    var_export(json_decode($result));
}

function get($url = '', $data = array()){
    $get = array();
    foreach ($data as $k => $v){
        $get[] = $k . '=' . $v;
    }
    $param = implode('&', $get);
    $url = 'localhost:8000/IcarusServer/index.php/' . $url . "?$param";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    var_export(json_decode($result));
}


/*test('Home/Sign/sign', array(
    'username'      => 'root',
    'passwd'        => '123456',
    'email'         => '1407064241@163.com'
));
test('Admin/User/editPasswd', array(
    'username'      => 'ltal',
    'old_passwd'    => '123456',
    'passwd'        => '1234',
    'repasswd'      => '1234'
));
test('Admin/User/getOneUser', array(
    'username'      => 'ltl'
));
test('Admin/User/getUserList', array(
    '1',
    '20'
));
test('Admin/User/addModerator', array(
    'username'      =>'ltal'
));
test('Admin/User/editUserData', array(
    'username'      => 'ltal',
    'email'         => 'skyloon@163.com'
));
test('Admin/User/sealUser', array(
    'username'      => 'ltal'
));*/

/**
 * UserController
 */

var_export($_SESSION);
/*test('Home/User/editPasswd', array(
    'username'      => 'root',
    'old_passwd'    => '123456',
    'repasswd'      => '1234',
    'passwd'        => '1234'
));*/
/*test('Home/User/editUserData', array(
    'username'      => '',
    'email'         => '',
    'nick'          => ''
));*/

/**
 * LoginController
 */
/*test('Home/Login/verification', array(
    'username'       => '',
    'token'          => ''
));

test('Home/Login/logout', array(

));*/

/**
 * PostsController
 */
//多个关键词用、隔开
/*test('Home/Posts/publishPosts', array(
    'username'      => '',
    'cid'           => '',
    'title'         => '',
    'content'       => '',
    'keywords'      => ''
));

get('Home/Posts/deletePosts', array(
    'username'      => '',
    'cid'           => '',
    'postsId'       => ''
));

test('Home/Posts/editPosts', array(
    'username'      => '',
    'postsId'       => '',
    'title'         => '',
    'content'       => '',
    'keywords'      => ''
));

get('Home/Posts/actionPosts', array(
    'username'      => '',
    'cid'           => '',
    'action'        => 'sticky' //置顶
));

get('Home/Posts/actionPosts', array(
    'username'      => '',
    'cid'           => '',
    'action'        => 'recommend' //推荐
));

get('Home/Posts/actionPosts', array(
    'username'      => '',
    'cid'           => '',
    'action'        => 'cancelRecommend' //推荐
));

get('Home/Posts/actionPosts', array(
    'username'      => '',
    'cid'           => '',
    'action'        => 'cancelSticky' //推荐
));

test('Home/Posts/movePosts', array(
    'username'      => '',
    'cid'           => '',
    'postsId'       => ''
));

get('Home/Posts/getTopPostsList', array(
    'page'          => '',
    'row'           => ''
));

get('Home/Posts/getRecommendPostsList', array(
    'page'          => '',
    'row'           => ''
));

get('Home/Posts/getPostsList', array(
    'page'          => '',
    'row'           => ''
));

get('Home/Posts/searchPostsByKeywords', array(
    'keywords'      => ''
));

get('Home/Posts/getClassificationPosts', array(
    'cid'           => ''
));

get('Home/Posts/getOnePosts', array(
    'postsid'       => ''
));*/

/**
 * UploadController
 */
/*test('Home/Upload/uploadImage', array(
    'image'         => ''
));*/


/**
 * ClassificationController
 */
/*get('Home/Classification/getOneClassification', array(
    'cid'           => ''
));

get('Home/Classification/getTreeClassification', array(
    'cid'           => ''
));

get('Home/Classification/getParentClassificationList', array(

));*/

/********************Admin******************/

/**
 * ClassificationController
 */
/*test('Admin/Classification/addClassification', array(
    'parentId'      => '',
    'cName'         => '',
    'is_featured'   => ''
));

get('Admin/Classification/deleteClassification', array(
    'cid'           => ''
));

test('Admin/Classification/editClassification', array(
    'cid'           => '',
    'cName'         => ''
));

get('Admin/Classification/getOneClassification', array(
    'cid'           => ''
));

get('Admin/Classification/getTreeClassification', array(
    'cid'           => ''
));

get('Admin/Classification/getParentClassificationList', array(

));

get('Admin/Classification/getDeleteClassificationList', array(

));

get('Admin/Classification/actionClassification', array(
    'action'        => '',
    'cid'           => ''
));*/
