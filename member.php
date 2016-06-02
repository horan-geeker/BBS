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
define('SCRIPT','member');

//是否已经登录
if(isset($_COOKIE['username'])){
//获取数据
    $_rows=_fetch_array("SELECT * FROM mj_user WHERE mj_username='{$_COOKIE['username']}'");
    if($_rows){
        switch ($_rows['mj_level']){
            case 1:
                $_level="管理员";
                break;
            default:
                $_level="普通会员";
        }
    }else{
        _alert_back("此用户不存在");
    }
}else{
    _alert_back("非法登录");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/member.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人中心</title>
</head>

<body>
<?php
require ROOT_PATH.'include/header.inc.php';
?>
<div id="member">
	<?php 
	   require ROOT_PATH.'include/member.inc.php';
	?>
	
	<div id="member_main">
		<h2>会员管理中心</h2>
		<dl>
			<dd>用户名: <?php echo $_rows['mj_username'];?></dd>
			<dd>性　别: <?php echo $_rows['mj_gender'];?></dd>
			<dd><span>头　像: </span><?php echo '<img src="image/'.$_rows['mj_face'].'.jpg" alt="头像" class="face" />'?></dd>
			<dd>电子邮件: <?php echo $_rows['mj_email'];?></dd>
			<dd>注册时间: <?php echo $_rows['mj_reg_time'];?></dd>
			<dd>身　份: <?php echo $_level;?></dd>
		</dl>
	</div>
</div>


<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>