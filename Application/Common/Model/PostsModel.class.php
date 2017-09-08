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
    //recovery
    public function actionPosts($action, $post){
        $where['is_delete'] = 0;
        if(!empty($post['is_show'])){
            $where['is_show'] = $post['is_show'];
        }
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
                return retMessage('恢复成功');
            default :
                return retErrorMessage('没有这种操作');
        }
    }

    //更改时，先查出所有版块信息，弄一个像下拉列表那样的，第一个下拉列表是主版块，第二个是二级版块，以此类推，只需给最后版块的id就好
    public function movePosts($post){
        $update['cid'] = $post['cid'];
        if(M('PostsClassification')
            ->where('posts_id=%d',array($post['postsId']))
            ->save($update)) {
            return retMessage('更改成功');
        }else{
            return retErrorMessage('更改失败');
        }
    }

    public function getTopPostsList($page = '', $row = '20', $is_show = ''){
        $where['is_top'] = 1;
        $where['is_delete'] = 0;
        if(!empty($is_show)){
            $where['is_show'] = $is_show;
        }
        //TODO 限制返回字段，不要返回uid
        $ret = $this
            ->field('posts_id, title, author, content, keywords, is_top, is_end, is_featured, add_time, click')
            ->where($where)
            ->order('posts_id desc')
            ->page($page.','.$row)
            ->select();
        return retMessage('', $ret);
    }

    public function getRecommendPostsList($page = '', $row = '20', $is_show = ''){
        if(!empty($is_show)){
            $where['is_show'] = $is_show;
        }
        $where['is_featured'] = 1;
        $where['is_delete'] = 0;
        $ret = $this
            ->field('posts_id, title, author, content, keywords, is_top, is_end, is_featured, add_time, click')
            ->where($where)
            ->order('posts_id desc')
            ->page($page.','.$row)
            ->select();
        return retMessage('', $ret);
    }

    public function getPostsList($page = '', $row = '20', $is_show = ''){
        if(!empty($is_show)){
            $where['is_show'] = $is_show;
        }
        $where['is_delete'] = 0;
        $ret = $this
            ->field('posts_id, title, author, content, keywords, is_top, add_time, click, is_featured, is_end')
            ->where($where)
            ->order('posts_id')
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
                WHERE MATCH(title, keywords) AGAINST({$post['keywords']} IN BOOLEAN MODE) AND id_delete = 0 AND is_show = {$post['is_show']}
                ORDER BY posts_id DESC, score1 DESC, keywords_score DESC, title_score DESC";
        $ret = $this->query($sql);
        return retMessage('', array($ret));
    }

    public function getClassificationPosts($get, $is_show = ''){
        $ret = M('Classification')->field('cid')
            ->where('is_delete=0 ADN cid=%d', array($get['cid']));
        if(empty($ret))
            return retErrorMessage('没有此版块');
        $where['p.is_delete'] = 0;
        if(!empty($is_show)){
            $where['p.is_show'] = $is_show;
        }
        $ret = $this->field('p.posts_id, p.title, p.author, p.content, p.keywords, p.add_time, p.click, p.is_end')
            ->alias('p')
            ->join("icarus_posts_classification pc ON p.posts_id=pc.posts_id")
            ->where($where)
            ->order('posts_id')
            ->select();
        return retMessage('', $ret);
    }

    public function getOnePosts($get){
        $is_show = ', is_show';
        if(!empty($get['is_show'])){
            $is_show = '';
            $where['is_show'] = $get['is_show'];
        }
        $where['posts_id'] = $get['postsId'];
        $where['is_delete'] = 0;
        $ret = $this
            ->field('posts_id, title, author, content, keywords, is_top, is_end, is_featured, add_time, click' . $is_show)
            ->where($where)
            ->select();
        return retMessage('', $ret);
    }
}