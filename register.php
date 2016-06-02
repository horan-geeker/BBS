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

if($_system['register']==0){
    _alert_back('未开放注册');
}
    
//自己提交的数据进行处理
include ROOT_PATH.'include/check.func.php';
if(isset($_POST['action'])){
    if($_POST['action']=='regsiter'){
        $_var=array();
        //验证码
        $_var['code']=$_POST['chk'];
        _check_code($_var['code'],$_SESSION['authcode']);
        //唯一标识符
        $_var['uniqid']=$_POST['uniqid'];
        _check_uniqid($_var['uniqid'], $_SESSION['uniqid']);
        //对新用户激活处理
        $_var['active'] =sha1(uniqid(rand(),true));
        $_var['username']=_check_username($_POST['username']);
        $_var['password']=_check_password($_POST['password'],$_POST['repassword']);
        $_var['pwdget']=check_question($_POST['pwdget']);
        $_var['pwdans']=check_question($_POST['pwdans']);
        $_var['email']=_check_email($_POST['email']);
        $_var['gender']=_check_gender($_POST['gender']);
        $_var['face']=_check_face($_POST['face']);
        
        _is_repeat("SELECT mj_username FROM mj_user WHERE mj_username='{$_var['username']}' LIMIT 1",
                    "用户名已被注册！");
        _query("insert into mj_user(
                                        mj_uniqid,
                                        mj_active,
                                        mj_username,
                                        mj_password,
                                        mj_question,
                                        mj_answer,
                                        mj_email,
                                        mj_gender,
                                        mj_face,
                                        mj_reg_time,
                                        mj_last_time,
                                        mj_last_ip
                                        )
                                   value(
                                        '{$_var['uniqid']}',
                                        '{$_var['active']}',
                                        '{$_var['username']}',
                                        '{$_var['password']}',
                                        '{$_var['pwdget']}',
                                        '{$_var['pwdans']}',
                                        '{$_var['email']}',
                                        '{$_var['gender']}',
                                        '{$_var['face']}',
                                        NOW(),
                                        NOW(),
                                        '{$_SERVER["REMOTE_ADDR"]}'
                                        )"
                   );
        //获取刚才产生的id
        $_var['id']=_insert_id();
        _close();
        //生成xml
        _set_xml('new.xml',$_var);
        _location("注册成功！", "active.php?active=".$_var['active']);
    }
}
else{
    $_SESSION['uniqid'] = $_uniqid = sha1(uniqid(rand(),true));
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/reg.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册</title>
<script src="JS/code.js" type="text/javascript"></script>
<script src="JS/reg.js" type="text/javascript"></script>
</head>

<body>
<?php 
    require ROOT_PATH.'include/header.inc.php';
?>

<div id="reg">
	<h2>会员注册</h2>
	<form method="post" action="register.php">
	
	
		<dl>
			<dt>请认真填写下面内容</dt>
			
			<dd>用  户  名 ：<input type="text" name="username" class="text" />(*必填)</dd>
			<dd>密 　   码 ：<input type="password" name="password" class="text" />(*必填)</dd>
			<dd>确认密码：<input type="password" name="repassword" class="text" />(*必填)</dd>
			<dd>密码提示：<input type="text" name="pwdget" class="text" /></dd>
			<dd>提示回答：<input type="text" name="pwdans" class="text" /></dd>
			<dd>性 　   别 ：<input type="radio" name="gender" class="gender" checked="checked" value="boy"/>男<input type="radio" name="gender" class="gender" value="girl"/>女</dd>
			<dd>邮 　   箱 ：<input type="text" name="email" class="text" />(*必填)</dd>
			<dd>验 证 码 ：<input type="text" name="chk" class="text code" id="chkcode"/><img src="checkcode.php" id="code"/></dd>
			<dd>选择头像：<input type="hidden" name="face" class="text" value="<?php echo mt_rand(1,30);?>"/></dd>
			
		</dl>
			<div>
			<input type="hidden" name="action" value="regsiter" />
			<input type="hidden" name="uniqid" value="<?php echo $_uniqid; ?>" />
			<input type="submit" class="submit" value="注册" />
			</div>
	</form>
	
</div>

<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>
