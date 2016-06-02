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

_login_state();

if(isset($_GET['action'])){
    if($_GET['action']=='login'){
        if($_system['code']==1){
            _check_code($_POST['chk'],$_SESSION['authcode']);
        }
        include 'include/login.func.php';
        require_once 'include/check.func.php';
        $_clean=array();
        $_clean['username']=_check_username($_POST['username']);
        $_clean['password']=_check_login_password($_POST['password']);
        
        if(!!$_rows=_fetch_array("SELECT mj_username,mj_uniqid,mj_level FROM mj_user WHERE mj_username='{$_clean['username']}' AND mj_password='{$_clean['password']}' AND mj_active='1' LIMIT 1")){
            //echo "登陆成功!";
            //登录成功后记录登录信息
            $_sql="UPDATE mj_user SET 
                                    mj_last_time=NOW(),
                                    mj_last_ip='{$_SERVER["REMOTE_ADDR"]}',
                                    mj_login_count=mj_login_count+1
                                WHERE
                                    mj_username='{$_rows['mj_username']}'
                                    ";
            _query($_sql);
            if($_rows['mj_level']==1){
                $_SESSION['admin']=$_rows['mj_username'];
            }
            _close();
            _setcookies($_rows['mj_username'],$_rows['mj_uniqid']);
            header('Location:index.php');
        }
        else{
            _close();
            _session_destory();
            _location("用户名密码错误！",'login.php');
        }
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/login.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>账号登录</title>
<script src="JS/code.js" type="text/javascript"></script>
<script src="JS/login.js" type="text/javascript"></script>
</head>

<body>
<?php 
    require ROOT_PATH.'include/header.inc.php';
?>
<div id="login">
	<h2>登录</h2>
	<form method="post" action="login.php?action=login">
	
		<dl>
			<dd>用  户  名：<input type="text" name="username" class="text" /></dd>
			<dd>密 　   码：<input type="password" name="password" class="text" /></dd>
			<?php if($_system['code']==1){?>
			<dd>验 证 码：<input type="text" name="chk" class="text code" /><img src="checkcode.php" id="code"/></dd>
			<?php }?>
			<dd><input type="checkbox" name="rem_password" class="chkbox"/> 记住密码</dd>
			<dd><input type="submit" value="登录" class="button"/><input type="button" value="注册" id="reg" class="button" onclick="javascript:location.href='register.php'" /></dd>
		</dl>
	</form>
</div>

<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>