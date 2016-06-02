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
define('SCRIPT','manage');

_is_manage();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/manage.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理中心</title>
</head>

<body>
<?php
require ROOT_PATH.'include/header.inc.php';
?>
<div id="member">
	<?php 
	   require ROOT_PATH.'include/manage.inc.php';
	?>
	
	<div id="member_main">
		<h2>后台管理中心</h2>
		<dl>
			<dd>*服务器主机名称: <?php echo $_SERVER['SERVER_NAME']?></dd>
			<dd>*通讯协议名称/版本: <?php echo $_SERVER['SERVER_PROTOCOL']?></dd>
			<dd>*服务器IP: <?php echo $_SERVER['SERVER_ADDR'];?></dd>
			<dd>*客户端IP: <?php echo $_SERVER['REMOTE_ADDR'];?></dd>
			<dd>*服务器端口: <?php echo $_SERVER['SERVER_PORT'];?></dd>
			<dd>*服务器端口: <?php echo $_SERVER['REMOTE_PORT'];?></dd>
			<dd>*管理员邮箱: <?php echo $_SERVER['SERVER_ADMIN'];?></dd>
			<dd>*HOST头部内容: <?php echo $_SERVER['HTTP_HOST'];?></dd>
			<dd>*服务器主目录: <?php echo $_SERVER['DOCUMENT_ROOT'];?></dd>
			<dd>*脚本执行的绝对路径: <?php echo $_SERVER['SCRIPT_FILENAME'];?></dd>
			<dd>*Apache及PHP版本: <?php echo $_SERVER['SERVER_SOFTWARE'];?></dd>
		</dl>
	</div>
</div>


<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>