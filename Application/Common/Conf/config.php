<?php
return array(

//*********************************附加设置***********************************
    'SHOW_PAGE_TRACE'       =>  true,                        //关闭Trace信息
    'LOAD_EXT_CONFIG'       =>  'db',         //加载网站设置文件
//***********************************URL设置*********************************
    'MODULE_ALLOW_LIST'     =>  array('Home','Admin','Api'),  //允许访问列表
    'TMPL_EXCEPTION_FILE'   =>  APP_DEBUG ? THINK_PATH.'Tpl/think_exception.tpl' : './Template/default/Home/Public/404.html',                                    //404设置
//***********************************URL*************************************
    'URL_MODEL'             =>  1,                            // 为了兼容性更好而设置成1 如果确认服务器开启了mod_rewrite 请设置为 2
    'URL_CASE_INSENSITIVE'  =>  false,                        // 区分url大小写
);
