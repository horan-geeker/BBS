<?php
/**
 * Author:Hejunwei
*
* Version:1.0
*
* To:Majialichen
*
* happy birthday!!!
*
*/
session_start();

//引用公共文件
require dirname(__FILE__).'/include/common.inc.php';

//定义常量，指定本页名称
define('SCRIPT','thumb');

if(isset($_GET['filename'])&&isset($_GET['percent'])){
    _thumb($_GET['filename'], $_GET['percent']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片展示</title>
</head>

<body>

</body>
</html>