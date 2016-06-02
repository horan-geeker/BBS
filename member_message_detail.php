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
define('SCRIPT','member_message');
//判断是否登录
if(!isset($_COOKIE['username'])){
    _alert_close("请先登录！");
}

if(isset($_GET['id'])){
    //获取数据
    $_id=_mysql_string($_GET['id']);
    //判断是否为删除操作
    if(isset($_GET['action'])){
        if($_GET['action']=="delete"){
            if(!!$_rows=_fetch_array("SELECT mj_id FROM mj_message WHERE mj_id='$_id' LIMIT 1")){
                //危险操作！
                if(!!$_uniqid = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
                    //防止伪造cookie
                    _uniqid($_uniqid['mj_uniqid'],$_COOKIE['uniqid']);
                }else{
                    _alert_back("非法登录");
                }
                //echo "删除操作";
                _query("DELETE FROM mj_message WHERE mj_id='{$_rows['mj_id']}' LIMIT 1");
                //判断是否删除成功
                if(_affected_rows()==1){
                    _close();
                    _location('删除成功','member_message.php');
                }else{
                    _close();
                    _alert_back('删除失败！');
                }
            }else{
                _alert_back("非法操作");
            }
            exit();
        }
    }
    //写入数据库
    
    if(!!$_rows=_fetch_array("SELECT mj_id,mj_state,mj_fromuser,mj_content,mj_date FROM mj_message WHERE mj_id='$_id' LIMIT 1")){
        $_html=array();
        $_html['state']=$_rows['mj_state'];
        $_html['state']++;
        //将短信读的次数写入数据库
        _query("UPDATE mj_message SET mj_state={$_html['state']} WHERE mj_id='$_id' LIMIT 1");
        if(!_affected_rows()){
            _alert_back("异常");
        }
        $_html['id']=$_rows['mj_id'];
        $_html['fromuser']=$_rows['mj_fromuser'];
        $_html['content']=$_rows['mj_content'];
        $_html['date']=$_rows['mj_date'];
    }else{
        _alert_back("短信不存在");
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
<link rel="stylesheet" type="text/css" href="css/member_message_detail.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>收信箱</title>
<script type="text/javascript" src="JS/member_message_detail.js"></script>
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
		<h2>短信详情</h2>
		<div id="list">
			<div id="list_content">发 信 人：<?php echo $_html['fromuser']?></div>
			<div id="list_content">内      容：<strong><?php echo $_html['content']?></strong></div>
			<div id="list_content">发信时间：<?php echo $_html['date']?></div>
			<div class="button">
    			<input type="button" value="返回列表" onclick="javascript:location.href='member_message.php'"/>
    			<input type="button" value="删除短信" id="del" name="<?php echo $_html['id']?>" />
			</div>
		</div>
	</div>
</div>
<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>