DROP DATABASE IF EXISTS `icarus`;
CREATE DATABASE `icarus` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE icarus;

CREATE TABLE `icarus_user`(
  uid INT (10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '主键',
  username VARCHAR (20) NOT NULL DEFAULT '' COMMENT '用户id',
  user_nick VARCHAR (30) NOT NULL DEFAULT '' COMMENT '用户昵称',
  passwd VARCHAR (255) NOT NULL DEFAULT '' COMMENT '密码',
  head_img VARCHAR (255) NOT NULL DEFAULT '' COMMENT '用户头像地址',
  create_time INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '用户注册时间',
  last_login_time INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '用户最后一次登录时间',
  last_login_ip VARCHAR (17) NOT NULL DEFAULT '' COMMENT '用户最后一次登录的ip地址',
  login_times INT (6) unsigned NOT NULL DEFAULT '0' COMMENT '用户登录次数',
  status tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户的登录状态',
  email VARCHAR (255) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  is_admin tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否为管理员,0为普通用户,1为版主,2为超级用户,',
  is_seal tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否被封',
  salt VARCHAR (255) NOT NULL DEFAULT '' COMMENT '盐',
  cid int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '版主所属版块id'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `icarus_posts`(
  posts_id INT (10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '主键',
  uid INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '作者id',
  title VARCHAR (255) NOT NULL DEFAULT '' COMMENT '帖子标题',
  author VARCHAR (30) NOT NULL DEFAULT '' COMMENT '帖子作者',
  content mediumtext NOT NULL COMMENT '内容',
  keywords varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  is_show tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  is_delete tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  is_top tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶',
  add_time  INT(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  click SMALLINT(5) unsigned NOT NULL DEFAULT '0' COMMENT '查看数',
  is_featured tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否加入精选',
  is_end tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否结帖'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE icarus_classification(
  cid INT (10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '分类id',
  parents_id INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '父类id,不是父类则为0',
  c_name VARCHAR (255) NOT NULL DEFAULT '' COMMENT '分类名称',
  is_show tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  is_delete tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  is_featured tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否加入精选'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE icarus_posts_classification(
  posts_id INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '帖子id',
  cid INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '分类id'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE icarus_posts_image(
  p_iid INT (10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '主键',
  posts_id INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '帖子id',
  path VARCHAR (255) NOT NULL DEFAULT '' COMMENT '图片地址'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE icarus_reply(
  rid INT (10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '主键',
  uid INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '回复的人的id',
  parents_id INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '这回复所回复的回复id',
  posts_id INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '所回复的帖子id',
  content mediumtext NOT NULL COMMENT '回复的内容',
  is_show tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示',
  is_delete tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  reply_time INT(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复的时间',
  approve_amount SMALLINT(5) unsigned NOT NULL DEFAULT '0' COMMENT '点赞的数量'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE icarus_reply_image(
  r_iid INT(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '主键',
  rid INT(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复的id',
  path VARCHAR (255) NOT NULL DEFAULT '' COMMENT '回复里图片的路径'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE icarus_report(
  posts_id INT(10) unsigned NOT NULL DEFAULT '0' COMMENT '帖子id',
  rid INT(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论id',
  username VARCHAR (20) NOT NULL DEFAULT '' COMMENT '用户id'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE icarus_posts ADD INDEX index_uid (uid);
ALTER TABLE icarus_posts_classification ADD INDEX index_p_c_id(posts_id, cid);
ALTER TABLE icarus_posts_image ADD INDEX index_posts_id(posts_id);
ALTER TABLE icarus_reply_image ADD INDEX index_rid(rid);
ALTER TABLE icarus_posts ADD FULLTEXT index_keywords(keywords);
ALTER TABLE icarus_posts ADD FULLTEXT index_title(title);

ALTER TABLE icarus_user ADD index index_name(username);
alter table icarus_classification add index index_c_name(c_name);
alter table icarus_posts add index keywords(keywords);




CREATE TABLE icarus_user_posts_status(
  uid INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  posts_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT '帖子id',
  is_collection tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否收藏帖子'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE icarus_user_following(
  uid INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  following_id INT (10) unsigned NOT NULL DEFAULT '0' COMMENT '本用户关注了的人的id'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

