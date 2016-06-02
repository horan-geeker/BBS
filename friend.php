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
define('SCRIPT','friend');
//判断是否登录
if(!isset($_COOKIE['username'])){
    _alert_close("请先登录！");
}
//添加好友
if(isset($_GET['action'])){
    if($_GET['action']=='add'){
        $_var=array();
        _check_code($_POST['chk'],$_SESSION['authcode']);
        //判断cookie中的id是否合法
        if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
            //防止伪造cookie
            _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
            include ROOT_PATH.'include/check.func.php';
            $_var['tofriend']=$_POST['touser'];
            $_var['fromfriend']=$_COOKIE['username'];
            $_var['friend_query']=_check_content($_POST['content']);
            $_var=_mysql_string($_var);
            if($_var['tofriend']==$_var['fromfriend']){
                _alert_back("不能添加自己");
            }
//             print_r($_var);
//             exit();
            //验证数据库好友是否已经添加
            if(!!$_rows[]=_fetch_array("SELECT 
                                              mj_id 
                                          FROM 
                                              mj_friend 
                                         WHERE 
                                              mj_tofriend='{$_var['tofriend']}' AND mj_fromfriend='{$_var['fromfriend']}'
                                            OR
                                              mj_tofriend='{$_var['fromfriend']}' AND mj_fromfriend='{$_var['tofriend']}'
                                         LIMIT
                                              1
                                              ")){
                _alert_close("重复发送");
            }else{
                //echo "add success";
                //添加信息写人数据库
                _query("INSERT INTO mj_friend(
                                               mj_tofriend,
                                               mj_fromfriend,
                                               mj_friend_query,
                                               mj_date
                                             )
                                        VALUE(
                                               '{$_var['tofriend']}',
                                               '{$_var['fromfriend']}',
                                               '{$_var['friend_query']}',
                                               NOW()
                                             )
                      ");
            }
            //判断是否修改成功
            if(_affected_rows()==1){
                _close();
                //_session_destory();
                _alert_close("发送成功,等待验证");
            }else{
                _close();
                //_session_destory();
                _alert_back("发送失败");
            }
        }else{
            _alert_close("唯一标识符异常");
        }
        exit();
    }
}



//获取数据
if(!isset($_GET['id'])){
    _alert_close("非法操作");
}else{
    $_id=_mysql_string($_GET['id']);
    if(!!$_rows=_fetch_array("SELECT mj_username FROM mj_user WHERE mj_id='$_id' LIMIT 1")){
        $_html=array();
        $_html['touser']=$_rows['mj_username'];
    }else{
        _alert_close("不存在此用户");
    }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/message.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>写短信</title>
<script type="text/javascript" src="JS/code.js"></script>
<script type="text/javascript" src="JS/message.js"></script>
</head>

<body>
<div id="message">
	<h3>添加好友</h3>
	<form method="post" action="friend.php?action=add">
	<div id="list">
		<div id="list_content">
			<input type="hidden" name="touser" value="<?php echo $_html['touser']?>"/>
			<input type="text" class="text" value="TO:<?php echo $_html['touser']?>" readonly="readonly" />
		</div>
		<div id="list_content">
			<textarea name="content">我想添加你为好友</textarea>
		</div>
		<div id="list_content">
			验 证 码:<input type="text" name="chk" class="text code" id="chkcode"/>
			<img src="checkcode.php" id="code"/>
			<input type="submit" class="submit" value="发送" />
		</div>
	</div>
	</form>
</div>


</body>
</html>