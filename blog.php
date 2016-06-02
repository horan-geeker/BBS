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
//分页处理

//定义常量，指定本页名称
define('SCRIPT','blog');

global $_pagenum,$_pagesize;
//后台分页处理，sql语句查找总条数，$_size（$_pagesize）每页显示的个数
_page("SELECT mj_id FROM mj_user WHERE mj_active='1'",$_system['blog']);
//$_pagenum $_pagesize在函数_page中声明
$_result=_query("SELECT mj_id,mj_username,mj_face,mj_gender FROM mj_user WHERE mj_active='1' LIMIT $_pagenum,$_pagesize");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/blog.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>博友</title>
<script type="text/javascript" src="JS/blog.js"></script>
</head>

<body>
<?php
require ROOT_PATH.'include/header.inc.php';
?>
<div id="blog">
	<h2>博友列表</h2>
	<?php while(!!$_rows=_fetch_array_list($_result)){ ?>
	<dl>
		<dd class="user"><?php echo $_rows['mj_username']?><?php echo "(".$_rows['mj_gender'].")"?></dd>
		<dt><img src="image/<?php echo $_rows['mj_face'];?>.jpg" alt="face" /></dt>
		<dd class="sendmsg" ><a href="javascript:;" name="message" id="<?php echo $_rows['mj_id']?>">发消息</a></dd>
		<dd class="addfriend"><a href="javascript:;" name="friend" id="<?php echo $_rows['mj_id']?>">加为好友</a></dd>
		<dd class="guest"><a href="javascript:;" name="text" id="<?php echo $_rows['mj_id']?>">写留言</a></dd>
		<dd class="flower"><a href="javascript:;" name="flower" id="<?php echo $_rows['mj_id']?>">送  　花</a></dd>
	</dl>
	<?php }
	   _paging(2,"个会员");
	?>
	
</div>


<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>