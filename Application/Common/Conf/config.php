<?php
return array(

//*********************************附加设置***********************************
    'SHOW_PAGE_TRACE'       =>  true,                        //关闭Trace信息
//***********************************URL设置*********************************
    'MODULE_ALLOW_LIST'     =>  array('Home','Admin','Api'),  //允许访问列表
//***********************************URL*************************************
    'URL_MODEL'             =>  1,                            // 为了兼容性更好而设置成1 如果确认服务器开启了mod_rewrite 请设置为 2
    'URL_CASE_INSENSITIVE'  =>  false,                        // 区分url大小写
//***********************************SESSION*********************************
    //'SESSION_OPTIONS'       =>  array('path' => '/tmp/session')
    //'SESSION_TYPE'          =>  'Mysqli'
//**********************************邮件相关信息*******************************
    'EMAIL_FROM_NAME'        => '',   // 发件人
    'EMAIL_SMTP'             => '',   // smtp
    'EMAIL_USERNAME'         => '',   // 账号
    'EMAIL_PASSWORD'         => '',   // 密码  注意: 163和QQ邮箱是授权码；不是登录的密码
    'EMAIL_SMTP_SECURE'      => '',   // 链接方式 如果使用QQ邮箱；需要把此项改为  ssl
    'EMAIL_PORT'             => '',
);
