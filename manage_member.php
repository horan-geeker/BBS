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
define('SCRIPT','manage_member');

//判断是否登录
if(!isset($_COOKIE['username'])){
    _alert_close("请先登录！");
}

_is_manage();

     
//删除操作
if(isset($_GET['delete'])){
    //print_r($_POST['ids']);
    $_clean=array();
    //将数组中所有元素拼接成一个字符串
    $_clean['id'] = _mysql_string($_GET['delete']);
    //危险操作！
    if(!!$_uniqid = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
        //防止伪造cookie 对比唯一标识符
        _uniqid($_uniqid['mj_uniqid'],$_COOKIE['uniqid']);
        _query("DELETE FROM mj_user WHERE mj_id='{$_clean['id']}'");
        //判断是否删除成功
            if(_affected_rows()){
                _close();
                _location('删除成功','manage_member.php');
            }else{
                _close();
                _alert_back('删除失败！');
            }
    }else{
        _alert_back("非法登录");
    }
}
//读取用户表
global $_pagenum,$_pagesize;
//后台分页处理，sql语句查找总条数，$_size（$_pagesize）每页显示的个数
_page("SELECT mj_id FROM mj_user WHERE mj_active='1'",15);
//$_pagenum $_pagesize在函数_page中声明
$_result=_query("SELECT 
                        mj_id,
                        mj_username,
                        mj_email,
                        mj_reg_time 
                   FROM 
                        mj_user 
                  WHERE 
                        mj_active='1'
               ORDER BY
                        mj_reg_time DESC
                  LIMIT 
                        $_pagenum,$_pagesize
    ");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/member_message.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员列表</title>
<script type="text/javascript" src="JS/member_message.js"></script>
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
		<h2>会员列表</h2>
		<form action="?action=delete" method="post">
		<table cellspacing="1">
		<tr><th>ID</th><th>会员名</th><th>邮件</th><th>注册时间</th><th>操作</th></tr>
		<?php 
             $_html = array();
             while(!!$_rows = _fetch_array_list($_result)){
                 $_html['id'] = $_rows['mj_id'];
                 $_html['username'] = $_rows['mj_username'];
                 $_html['email'] = $_rows['mj_email'];
                 $_html['reg_time'] = $_rows['mj_reg_time'];
                 $_html=_html($_html);
        ?>
        <tr>
			<td><?php echo $_html['id']?></td>
			<td><?php echo $_html['username']?></td>
			<td><?php echo $_html['email']?></td>
			<td><?php echo $_html['reg_time']?></td>
			<td><a href="?delete=<?php echo $_html['id']?>">删除</a><a href="?modify=<?php echo $_html['id']?>">修改</a></td>
		</tr>
        <?php };?>
		</table>
		</form>
		<?php _paging(2,'条数据')?>
	</div>
</div>
<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>