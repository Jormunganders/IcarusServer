<?php if (!defined('THINK_PATH')) exit();?><!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form action="<?php echo U('Admin/Login/login');?>" method="post">
    <input type="text" name="username"/>
    <input type="text" name="passwd"/>
    <input type="text" name="verify"/>
    <img src="<?php echo U('Admin/Login/showVerify');?>"/>
    <input type="submit" value="tijiao"/>
</form>
</body>
</html>-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="./jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var post_flag = false;
            if(post_flag) return; //如果正在提交则直接返回，停止执行

            post_flag = true;//标记当前状态为正在提交状态
            $("a").click(function(){
                $.ajax({
                    type:'post',
                    url:'http://localhost:8000/IcarusServer/index.php/Admin/Login/login.html',
                    data:$("#myform").serialize(),
                    cache:false,
                    dataType:'json',
                    success:function(data){
                        post_flag =false;
                    }
                });
            });
        });
    </script>
</head>
<body>
<form action="" id="myform">
    <input type="text" name="username"/>
    <input type="text" name="passwd"/>
    <input type="text" name="verify"/>
    <img src="http://localhost:8000/IcarusServer/index.php/Admin/Login/showVerify.html"/>
</form>
<a href="#" style="text-decoration: none;">使用ajax提交表单数据</a>
</body>
</html>