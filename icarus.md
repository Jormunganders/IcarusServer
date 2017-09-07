# 返回的字段都一样的
1. 后台登录
* 需要访问的url有
	* http://115.159.56.141/index.php/Admin/Login/login
	* http://115.159.56.141/index.php/Admin/Login/showVerify登录时需要的验证码，会返回一张jpeg格式的图片，要刷新的话就加个get参数，如：http://115.159.56.141/index.php/Admin/Login/showVerify?m=1，啥都行
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
	* http://115.159.56.141/index.php/Admin/Login/showVerify
* 需要输入的字段
	* username:用户id
	* verify:验证码
	* passwd:密码
	
# 9月7日后台用户权限变更
1. 减少了以下api接口
    * 修改用户信息的api接口删除
    * 在增加版主时还得加上版块的id，即字段cid
