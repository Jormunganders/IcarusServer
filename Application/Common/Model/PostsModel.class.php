<?php
namespace Common\Model;
use Think\Model;

class PostsModel extends Model{
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

    public function publishPosts($post){
        $insert['uid'] = $post['username'];
        $insert['title'] = $post['title'];
        $insert['author'] = $post['author'];
        $insert['content'] = $post['content'];
        $insert['keywords'] = $post['keywords'];

        //TODO 还有cid

        if($this->create()){
            if($this->add($insert) !== false)
                return retMessage('添加成功');
            else
                return retErrorMessage('添加失败');
        }else{
            return retErrorMessage('添加失败');
        }
        //TODO 将里面的图片链接取出
        //TODO 还要用monggodb加入个人所发帖
    }

    public function deletePosts($post){

    }

    public function editPosts(){

    }

    //Sticky置顶
    //hide隐藏
    //recommend推荐
    public function actionPosts(){

    }

    public function movePosts(){

    }

    public function searchPosts(){

    }
}