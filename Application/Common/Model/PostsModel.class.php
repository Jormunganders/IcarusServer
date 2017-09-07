<?php
namespace Common\Model;
use Think\Model;

class PostsModel extends Model{
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

    public function publishPosts($post){
        $insert['uid'] = $post['uid'];
        $insert['title'] = $post['title'];
        $insert['author'] = $post['username'];
        $insert['content'] = $post['content'];
        $insert['keywords'] = $post['keywords'];
        $c_p['cid'] = $post['cid'];

        if($this->create()){
            $result = $this->add($insert);
            if($result !== false) {
                $c_p['posts_id'] = $result;
                $result = D('PostsClassification')->add($c_p);
                ($result !== false) ? $ret = retErrorMessage('发帖失败') : $ret = retMessage('发帖成功');
                return $ret;
            }
            else
                return retErrorMessage('发帖失败');
        }else{
            return retErrorMessage('发帖失败');
        }
        //TODO 将里面的图片链接取出
        //TODO 还要用monggodb加入个人所发帖
    }

    public function deletePosts($post){
        $where['posts_id'] = $post['postsId'];
        $insert['is_delete'] = 1;
        if($this->where($where)->save($insert) !== false){
            return retMessage('删除成功');
        }else{
            return retErrorMessage('删除失败');
        }
    }

    public function editPosts($post){
        $where['posts_id'] = $post['posts_id'];
        $where['is_show'] = 1;
        $where['is_delete'] = 0;
        //$ret = M('User')->field('username')->alias('u')->field('username')->join('__POSTS__ p on p.uid = u.uid')->find();
        $update['title'] = $post['title'];
        $update['content'] = $post['content'];
        $update['keywords'] = $post['keywords'];
        $update['author'] = $post['username'];

        if($this->where($where)->save($update) !== false){
            return retMessage('修改成功');
        }else{
            return retErrorMessage('修改失败');
        }
    }

    //Sticky置顶
    //hide隐藏
    //recommend推荐
    public function actionPosts($action, $post){
        $where['is_delete'] = 0;
        $where['is_show'] = $post['is_show'];
        switch ($action){
            case 'sticky':
                $update['is_top'] = 1;
                $this->where($where)
                    ->where('posts_id=%d', array($post['postsId']))
                    ->save($update);
                return retMessage('置顶成功');
            case 'hide':
                $update['is_show'] = 1;
                $this->where($where)
                    ->where('posts_id=%d', array($post['postsId']))
                    ->save($update);
                return retMessage('隐藏成功');
            case 'recommend':
                $update['is_featured'] = 1;
                $this->where($where)
                    ->where('posts_id=%d', array($post['postsId']))
                    ->save($update);
                return retMessage('推荐成功');
            case 'cancelSticky' :
                $update['is_top'] = 0;
                $this->where($where)
                    ->where('posts_id=%d', array($post['postsId']))
                    ->save($update);
                return retMessage('取消置顶成功');
            case 'show' :
                $update['is_show'] = 0;
                $this->where($where)
                    ->where('posts_id=%d', array($post['postsId']))
                    ->save($update);
                return retMessage('显示成功');
            case 'cancelRecommend' :
                $update['is_featured'] = 0;
                $this->where($where)
                    ->where('posts_id=%d', array($post['postsId']))
                    ->save($update);
                return retMessage('取消置顶成功');
            case 'recovery':
                $update['is_delete'] = 0;
                $where['is_delete'] = 1;
                $this->where($where)
                    ->where('posts_id=%d', array($post['postsId']))
                    ->save($update);
                return retMessage('回复成功');
            default :
                return retErrorMessage('没有这种操作');
        }
    }

    //更改时，先查出所有版块信息，弄一个像下拉列表那样的，第一个下拉列表是主版块，第二个是二级版块，以此类推，只需给最后版块的id就好
    public function movePosts($post){
        $update['cid'] = $post['cid'];
        M('PostsClassification')
            ->where('posts_id=%d',array($post['postsId']))
            ->save($update);
        return retMessage('更改成功');
    }

    public function getTopPostsList($page = '', $row = '20'){
        $ret = $this
            ->where('is_top=1 AND is_show=1 AND is_delete=0')
            ->page($page.','.$row)
            ->select();
        return retMessage('', $ret);
    }

    public function getRecommendPostsList($page = '', $row = '20'){
        $ret = $this
            ->where('is_featured=1 AND is_show=1 AND is_delete=0')
            ->page($page.','.$row)
            ->select();
        return retMessage('', $ret);
    }

    public function getPostsList($page = '', $row = '20'){
        $ret = $this
            ->where('is_show=1 AND is_delete=0')
            ->page($page.','.$row)
            ->select();
        return retMessage('', $ret);
    }

    public function searchPostsByKeywords($post){
        $sql = "SELECT *, 
                MATCH (keywords) AGAINST({$post['keywords']}) as keywords_score,
                MATCH (title) AGAINST({$post['keywords']}) as title_score,
                IF(MATCH (keywords) AGAINST({$post['keywords']}) > 0 
                AND MATCH (title) AGAINST({$post['keywords']}) > 0) as score1
                FROM icarus_posts 
                WHERE MATCH(title, keywords) AGAINST({$post['keywords']} IN BOOLEAN MODE)
                ORDER BY score1 DESC, keywords_score DESC, title_score DESC";
        $ret = $this->query($sql);
        return retMessage('', array($ret));
    }


    public function getClassificationPosts($get){
        //TODO 获取某个版块下的帖子
    }

    public function getOnePosts($get){
        //TODO 获取某个帖子信息
    }
}