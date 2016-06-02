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

if(isset($_GET['action']))
    if($_GET['action']=='modify'){
        _check_code($_POST['chk'],$_SESSION['authcode']);
        //判断cookie中的id是否合法
        if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
            //防止伪造cookie
            _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
            include ROOT_PATH.'include/check.func.php';
            $_var=array();
            $_var['username']=_check_username($_POST['username']);
            $_var['password']=_check_modify_password($_POST['password'],6);
            $_var['email']=_check_email($_POST['email']);
            $_var['gender']=_check_gender($_POST['gender']);
            $_var['face']=_check_face($_POST['face']);
            $_var['switch']=$_POST['switch'];
            $_var['autograph']=_check_autograph($_POST['autograph']);
            //判断密码是否保持默认
            if(empty($_var['password'])){
                $_sql="UPDATE mj_user SET 
                                          mj_email='{$_var['email']}',
                                          mj_gender='{$_var['gender']}',
                                          mj_face='{$_var['face']}',
                                          mj_switch='{$_var['switch']}',
                                          mj_autograph='{$_var['autograph']}'
                                      WHERE 
                                          mj_username='{$_var['username']}'
                                      ";
            }else{
                $_sql="UPDATE mj_user SET 
                                          mj_email='{$_var['email']}',
                                          mj_gender='{$_var['gender']}',
                                          mj_face='{$_var['face']}',
                                          mj_switch='{$_var['switch']}',
                                          mj_autograph='{$_var['autograph']}',
                                          mj_password='{$_var['password']}'
                                      WHERE 
                                          mj_username='{$_var['username']}'
                                      ";
            }
            _query($_sql);
        }
        //判断是否修改成功
        if(_affected_rows()==1){
            _close();
            //_session_destory();
            _location('恭喜你，修改成功','member.php');
        }else{
            _close();
            //_session_destory();
            _location('修改失败！', 'register.php');
        }
}

//定义常量，指定本页名称
define('SCRIPT','member_modify');

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
     $_html=array();
     $_html['email'] = $_rows['mj_email'];
     //个性签名
     $_html['autograph']=$_rows['mj_autograph'];
     if($_rows['mj_switch']==1){
         $_html['switch']='<input type="radio" name="switch" checked="checked" value="1" />启用 <input type="radio" name="switch" value="0" />禁用';
     }elseif($_rows['mj_switch']==0){
         $_html['switch']='<input type="radio" name="switch" value="1" />启用 <input type="radio" name="switch" checked="checked" value="0" />禁用';
     }
     //个人信息
     $_html['username']='<input type="hidden" name="username" value="'.$_rows['mj_username'].'" />';
     if($_rows['mj_gender']=='boy'){
         $_html['gender']='<input type="radio" name="gender" value="boy" checked="checked" /> boy <input type="radio" name="gender" value="girl" /> girl';
     }else{
         $_html['gender']='<input type="radio" name="gender" value="boy" /> boy <input type="radio" name="gender" value="girl" checked="checked" /> girl';
     }
     $_html['face'] = '<select name="face">';
     foreach (range(1,32) as $_num){
         $_html['face'] .= '<option value="'.$_num.'">image/'.$_num.'.jpg</option>';
     }
     $_html['face'] .= "</select>";
    }else{
        _alert_back("此用户不存在");
    }
}else{
    _alert_back("非法登录");
    _unsetcookie();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/member_modify.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>个人中心</title>

<script src="JS/member_modify.js" type="text/javascript"></script>
<script src="JS/code.js" type="text/javascript"></script>
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
		<form method="post" action="member_modify.php?action=modify">
		<dl>
			<dd>用  户  名 ：<?php echo $_html['username'];echo $_rows['mj_username']?></dd>
			<dd>密 　   码 ：<input type="password" name="password" class="text" value=""/>(留空默认不变)</dd>
			<dd>性 　   别 ：<?php echo $_html['gender']?></dd>
			<dd>邮 　   箱 ：<input type="text" name="email" class="text" value="<?php echo $_html['email']?>"/></dd>
			<dd>选择头像：<?php echo $_html['face']?></dd>
			<dd>个性签名：<?php echo $_html['switch']?>
				<p><textarea name="autograph"><?php echo $_html['autograph']?></textarea></p>
			</dd>
			<dd>验 证 码 ：<input type="text" name="chk" class="text code" id="chkcode"/><img src="checkcode.php" id="code"/></dd>
			<dd><input type="submit" class="submit" value="修改资料"/></dd>
		</dl>
		</form>
	</div>
</div>


<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>