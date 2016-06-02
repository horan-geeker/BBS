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
require 'include/common.inc.php';

if(isset($_GET['action'])&&isset($_GET['active'])&&$_GET['action']=='ok'){
    $_active=_mysql_string($_GET['active']);
    if(_fetch_array("SELECT mj_active FROM mj_user WHERE mj_active='$_active' LIMIT 1")){
        //将mj_active设置为空
        _query("UPDATE mj_user SET mj_active='1' where mj_active='$_active' LIMIT 1");
        if(mysql_affected_rows()==1){
            _close();
            //_session_destory();
            _location("账户激活成功", "login.php");
        }else{
            _close();
            //_session_destory();
            _location("账户激活失败", "register,php");
        }
    }else{
        _alert_back('非法操作');
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/active.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>账号激活</title>
<script src="JS/code.js" type="text/javascript"></script>
</head>

<body>

<?php 
    require ROOT_PATH.'include/header.inc.php';
?>

<div id="active">
	<h2>激活账户</h2>
	<p>请点击<a href="active.php?action=ok&active=<?php echo $_GET['active']?>">此处</a>激活账户，或点击下方的超链接</p>
	<p><a href="active.php?action=ok&active=<?php echo $_GET['active']?>"><?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF']."?active=".$_GET['active']?></a>
</div>

<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>
