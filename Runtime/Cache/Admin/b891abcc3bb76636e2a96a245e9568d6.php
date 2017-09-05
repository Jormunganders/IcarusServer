<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form action="<?php echo U('Admin/Login/login');?>" method="POST">
    <input type="text" name="nick"/>
    <input type="text" name="passwd"/>
    <img src="<?php echo U('Admin/Login/showVerify');?>" title="点击更换"  onclick="this.src+='/'+Math.random();"/>
    <input type="text" name="verify">
    <input type="submit" value="提交"/>
</form>
</body>
</html>