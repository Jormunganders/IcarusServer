# 返回的字段都一样的
# 返回的字段意思见数据库建表语句
# 后台的所有操作都是要登录才行的
1. 后台登录
    * 做了登录状态记录， 在一定时间内同一浏览器不能重复登录
    * 想要重新登录，就post提交访问Admin/Login/logout，这是退出登录的url
    * 退出后就能再次登录别的帐号了
    * 需要访问的url有
	    * http://115.159.56.141/index.php/Admin/Login/login
	    * http://115.159.56.141/index.php/Admin/Login/showVerify 登录时需要的验证码，会返回一张jpeg格式的图片，要刷新的话就加个get参数，如：http://115.159.56.141/index.php/Admin/Login/showVerify?m=1 ，啥都行
    * post的字段有
	    * verify 验证码
	    * username 用户id
	    * passwd 用户密码

    * 返回的信息字段
	    * status 为是否操作成功，ok为成功，error为失败
	    * data为成功时返回的数据
	    * message 为失败时返回的信息
	
	* 登出的操作
	    * post操作
	    * url: http://115.159.56.141/index.php/Admin/Login/logout
	    * 需要的字段
	        * 无      

2. 用户相关
    * 更改密码
        * post提交
	    * url：http://115.159.56.141/index.php/Admin/User/editPasswd
	    * 需输入的字段
		    * passwd:新密码
		    * old_passwd:旧密码
		    * username：用户id
    * 获取某个用户所有信息
        * post提交
	    * url：http://115.159.56.141/index.php/Admin/User/getOneUser
	    * 需要输入的字段
		    * username：id
		    * 返回的字段：见数据库建表语句

    * 获取用户列表
        * get提交
	    * url：http://115.159.56.141/index.php/Admin/User/getUserList
	    * 需要输入的字段
		    * page：第几页，从1开始
		    * row：每页几行，默认20
    * 添加版主
        * post提交
	    * url：http://115.159.56.141/index.php/Admin/User/addModerator
	    * 需要输入的字段
		    * username：用户id
		    * cid： 分类id
    * 给用户管理员权限
        * post提交
	    * url：http://115.159.56.141/index.php/Admin/User/addAdministrator
	    * 需要输入的字段
		    * username：用户id
    * 封号
        * post提交
	    * url：http://115.159.56.141/index.php/Admin/User/sealUser
	    * 需要的字段
		    * username：id
	
    * 获取用户的总数
        * get提交
        * url:http://115.159.56.141/index.php/Admin/User/getUserCount
        * 需要的字段
            * 无
        
3. 帖子操作
    * 删除帖子
        * get提交
        * url: Admin/Posts/deletePosts
        * 需要的字段
            * postsId 帖子id
            
    * 对帖子的操作
        * get提交
        * url: Admin/Posts/actionPosts
        * 需要的字段
            * postsId 帖子id
            * action 对帖子进行的操作2，其值有
                * sticky 置顶
                * hide 隐藏
                * recommend 推荐
                * cancelSticky 取消置顶
                * show 显示帖子
                * cancelRecommend 取消推荐
                * recovery 恢复删除的帖子，在回收站里的操作
                
    * 对帖子进行所在版块进行移动
        * post提交
        * url: Admin/Posts/movePosts
        * 需要的字段
            * cid 分类id
            * postsId 帖子id
            
    * 获取置顶帖子列表
        * get提交
        * url:Admin/Posts/getTopPostsList
        * 需要的字段
            * page 第几页
            * row 一页几行
            
    * 获取推荐帖子列表
        * get提交
        * url: Admin/Posts/getRecommendPostsList
        * 需要的字段
            * page 第几页
            * row 一页几行
            
    * 获取帖子的列表
        * get提交
        * url: Admin/Posts/getPostsList
        * 需要的字段
            * page 第几页
            * row 一页几行
            
    * 获取已删除的帖子列表（回收站，防误删）
        * get提交
        * url: Admin/Posts/getDeletePosts
        * 需要的字段
            * page 第几页
            * row 一页几行
            
    * 搜索帖子
        * 还没写好 。。。
        
    * 获取某个分类下的帖子
        * get提交
        * url: Admin/Posts/getClassificationPosts
        * 需要的字段
            * page 第几页
            * row 一页几行
            * cid 分类id
            
    * 获取某个帖子信息
        * get提交
        * url: Admin/Posts/getOnePosts
            * postsId 帖子id
            
    * 获取某种帖子的总数
        * get提交
        * url: Admin/Posts/getPostsCount
        * 需要的字段
             * action 其值有
                  * top 获取置顶帖子总数
                  * recommend 获取推荐帖子总数
                  * delete 获取删除的帖子的总数
                  * general 不分类型的获取帖子数量
                    
4. 分类操作
    * 添加分类
        * post提交
        * url: Admin/Classification/addClassification
        * 需要的字段
            * parentId 如果没有父版块，就为0
            * cName 版块名称
            * is_featured 是否加精
            
    * 删除分类
        * get提交
        * url: Admin/Classification/deleteClassification
        * 需要的字段
            * cid 分类的字段
            
    * 编辑分类
        * post提交
        * url: Admin/Classification/editClassification
        * 需要的字段
            * cid 分类的字段
            * cName 分类名字
            
    * 获取某个分类的信息
        * get提交
        * url: Admin/Classification/getOneClassification
        * 需要的字段
            * cid 分类的id
            
    * 获取某个分类的树形结构
        * get提交
        * url: Admin/Classification/getTreeClassification
        * 需要的字段
            * cid 分类id
            
    * 获取所有的父分类
        * get提交
        * url: Admin/Classification/getParentClassification
        * 需要的字段
            * 无
            
    * 获取删除了的分类
        * get操作
        * url: Admin/Classification/getDeleteClassification
        * 需要的字段
            * 无
            
    * 对分类的操作
        * get操作
        * url: Admin/Classification/actionClassification
        * 需要的字段
            * cid 分类id
            * action 要对分类进行的操作， 其值有
                * show 显示分类
                * hide 隐藏
                * featured 加精
                * cancelFeatured 取消加精
                * recovery 恢复删除的帖子
                * move对分类进行移动，比如将a分类移到b分类下，这还需要一个字段
                    * parentId 要移到的版块的id


# 前台操作
1. 注册
    * url: http://115.159.56.141/index.php/Home/Sign/sign
    * 需要输入的字段
	    * username：id
	    * passwd：密码
	    * email：邮箱
2. 登录
    * url
	    * http://115.159.56.141/index.php/Home/Login/login
	    * http://115.159.56.141/index.php/Home/Login/showVerify
    * 需要输入的字段
	    * username:用户id
	    * verify:验证码
	    * passwd:密码
    
3. 登录口令验证
    * url:Home/Login/verification
    * 需要字段
        * token
        * username
        
    * 登出接口
        * url: Home/Login/logout
        * 需要字段:
            * 无

4. 用户有关操作
    * 忘记密码
        * post提交
        * url: Home/User/forgetPasswd
        * 需要的字段
            * username 用户id
            * email 邮箱
                
    * 获取用户已发布的帖子
        * get提交
        * url: Home/User/getUserPosts
        * 需要的字段
            * username 用户id
            * page 第几页
            * row 一页几行
                
    * 获取用户自己的评论
            * get提交
            * url: Home/User/getUserReply
            * 需要的字段
                * username 用户id
                * page 第几页
                * row 一页几行
                
    * 用户资料修改
        * url:Home/User/editUserData
        * 需要字段
            * email
            * username
            * nick
    * 修改密码
        * url:Home/User/editPasswd
        * 需要字段
            * username
            * old_passwd
            * passwd
            * repasswd

    * 获取某个用户信息
        * url: Home/User/getOneUser
        * 需要的字段
            * username 用户id
5. 分类的相关操作
    * 获取某个分类的信息
        * get提交
        * url: Home/Classification/getOneClassification
        * 需要字段
            * cid 分类的id
        
    * 获取某个分类的树形结构
        * get提交
        * url: Home/Classification/getTreeClassification
        * 需要字段
            * cid
            
    * 获取所有主版块的信息
        * get提交
        * url: Home/Classification/getParentClassification
        * 需要字段
            * 无
            
6. 帖子操作
    * 发表帖子
        * post提交
        * url: Home/Classification/publishPosts
        * 需要字段
            * username 用户id
            * cid 分类id
            * title 标题
            * content 内容
            * keywords 关键词
            
    * 删除帖子
        * get提交
        * url: Home/Posts/deletePosts
        * 需要字段
            * username 用户id
            * cid 分类id
            * postsId 帖子id
            
    * 编辑帖子
        * post提交
        * url: Home/Posts/editPosts
        * 需要字段
            * username 
            * postsId 帖子id
            * title
            * content
            * keywords 关键词
            
    * 对帖子的操作，针对版主设置的
        * get提交
        * url: Home/Posts/actionPosts
        * 需要字段
            * username
            * cid 分类id
            * postsId 帖子id
            * action 执行的操作，它的值有
                * sticky 置顶操作
                * hide 隐藏帖子
                * recommend 推荐帖子
                * cancelSticky 取消置顶
                * show 显示帖子
                * cancelRecommend 取消推荐
                
    * 对帖子进行版块移动
        * post提交
        * url: Home/Posts/movePosts
        * 需要的字段
            * usernmae
            * cid 分类id
            * postsId 帖子id
            
    * 获取置顶帖子列表
        * get提交
        * url: Home/Posts/getTopPostsList
        * 需要的字段
            * page 第几页
            * row 每页的行数
            
    * 获取推荐的帖子列表
        * get提交
        * url: Home/Posts/getRecommendPostsList
        * 需要的字段
            * page 第几页
            * row 每页行数
            
    * 获取帖子列表
        * get提交
        * url: Home/Posts/getPostsList
        * 需要的字段
            * page 第几页
            * row 每页行数
            
    * 搜索帖子功能
        * 还没写好。。。
        
    * 获取某个分类下的帖子
        * get提交
        * url: Home/Posts/getClassificationPosts
        * 需要的字段
            * page 第几页
            * row 第几行
            * cid 分类id
            
    * 获取某个帖子信息
        * get提交
        * url: Home/Posts/getOnePosts
        *需要的字段
            * postsId 帖子id
            
    * 获取某种帖子的总数
        * get提交
        * url: Home/Posts/getPostsCount
        * 需要的字段
            * action 其值有
                * top 获取置顶帖子总数
                * recommend 获取推荐帖子总数
                * general 不分类型的获取帖子数量
 
7. 评论操作
    * 用户对一个帖子发布评论
        * post操作
        * url: Home/Reply/addReply
        * 需要的字段
            * username
            * parentId 没有父级评论，就为0
            * postsId 帖子的id
            * content 评论的内容
            
    * 获取某个帖子下的所有评论
        * get操作
        * url: Home/Reply/getAllReply
        * 需要的字段
            * postsId 帖子id
            * page 第几页
            * row 一页几行
            
    * 删除某个回复
        * get操作
        * url: Home/Reply/deleteReply
        * 需要的字段
            * rid 评论的id
            * username 当前登录的用户id
            * cid 分类id
            
    * 获取某评论的信息（用作修改评论用）
        * get操作
        * url: Home/Reply/getOneReply
        * 需要的字段
            * rid 评论的id
            
    * 修改评论
        * get操作
        * url: Home/Reply/editReply
        * 需要的段
            * rid 评论id
            * cid 分类id
            * content 修改的内容
    
    * 给评论点赞
        * get操作
        * url: Home/Reply/approve
        * 需要的字段
            * rid 评论id
            
# 新增功能
1. 前台操作
    * 举报帖子
        * get操作
        * url: Home/Report/reportPosts
        * 需要字段
            * username 用户id
            * posts_id 帖子id
            
    * 举报回复
        * get操作
        * url: Home/Report/reportReply
        * 需要的字段
            * username 用户id
            * rid 评论id
            
2. 后台操作
    * 解封
        * get提交
        * url: Admin/User/cancelSeal
        * 需要的字段
            * username
            
    * 获取被举报的帖子
        * get提交
        * url: Admin/User/getReportPosts
        * 需要的字段
            * 无
            
    * 获取被举报的评论
        * get提交
        * url: Admin/User/getReportReply
        * 需要的字段
            * 无
