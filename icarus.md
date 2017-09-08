# 返回的字段都一样的
1. 后台登录
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

2. 后台操作
* 更改密码
	* url：http://115.159.56.141/index.php/Admin/User/editPasswd
	* 需输入的字段
		* passwd:新密码
		* old_passwd:旧密码
		* username：用户id
* 获取某个用户所有信息
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
	* url：http://115.159.56.141/index.php/Admin/User/addModerator
	* 需要输入的字段
		* username：id
* 修改用户信息（只能修改邮箱和头像。。。）
	* url：http://115.159.56.141/index.php/Admin/User/editUserData
	* 需要输入的字段
		* username：id
		* email：邮箱
		* head_img：用户头像地址
* 给用户管理员权限
	* url：http://115.159.56.141/index.php/Admin/User/editUserData
	* 需要输入的字段
		* username：id
* 封号
	* url：http://115.159.56.141/index.php/Admin/User/sealUser
	* 需要的字段
		* username：id


# 前台操作
2. 注册
* url
	* http://115.159.56.141/index.php/Home/Sign/sign
* 需要输入的字段
	* username：id
	* passwd：密码
	* email：邮箱
3. 登录
* url
	* http://115.159.56.141/index.php/Home/Login/login
	* http://115.159.56.141/index.php/Home/Login/showVerify
* 需要输入的字段
	* username:用户id
	* verify:验证码
	* passwd:密码
	
# 9月7日后台用户权限变更
1. 减少了以下api接口
    * 修改用户信息的api接口删除
    * 在增加版主时还得加上版块的id，即字段cid
    
# 返回的字段意思见数据库建表语句
# 9月8号增加的API
# 前台接口
1. 登录口令验证
    * url:Home/Login/verification
    * 需要字段
        * token
        * username
2. 用户资料修改
    * url:Home/User/editUserData
    * 需要字段
        * email
        * username
        * nick
3. 修改密码
    * url:Home/User/editPasswd
    * 需要字段
        * username
        * old_passwd
        * passwd
        * repasswd
4. 登出接口
    * url: Home/Login/logout
    * 需要字段:
        * 无
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
            * cid 分类id
            
    * 获取某个帖子信息
        * get提交
        * url: Home/Posts/getOnePosts
        *需要的字段
            * postsId 帖子id
            