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
define('SCRIPT','member_flower');
//判断是否登录
if(!isset($_COOKIE['username'])){
    _alert_close("请先登录！");
}

//花朵删除操作
if(isset($_GET['action'])){
    if($_GET['action']=='delete'&&isset($_POST['ids'])){
        //print_r($_POST['ids']);
        $_clean=array();
        //将数组中所有元素拼接成一个字符串
        $_clean['ids'] = _mysql_string(implode(',',$_POST['ids']));
        //危险操作！
        if(!!$_uniqid = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
            //防止伪造cookie 对比唯一标识符
            _uniqid($_uniqid['mj_uniqid'],$_COOKIE['uniqid']);
            _query("DELETE FROM mj_flower WHERE mj_id in ({$_clean['ids']})");
            //判断是否删除成功
                if(_affected_rows()){
                    _close();
                    _location('删除成功','member_flower.php');
                }else{
                    _close();
                    _alert_back('删除失败！');
                }
        }else{
            _alert_back("非法登录");
        }
    }else{
        _alert_back("请勾选需要删除的数据");
    }
}

//分页处理
global $_pagenum,$_pagesize;
//后台分页处理，sql语句查找总条数，$_size（$_pagesize）每页显示的个数
_page("SELECT mj_id FROM mj_message WHERE mj_touser='{$_COOKIE['username']}'",10);
$_result=_query("SELECT 
                        mj_id,
                        mj_fromuser,
                        mj_flower_num,
                        mj_content,
                        mj_date 
                   FROM 
                        mj_flower 
                  WHERE 
                        mj_touser='{$_COOKIE['username']}' 
               ORDER BY 
                        mj_date DESC 
                  LIMIT 
                        $_pagenum,$_pagesize
                ");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/member_flower.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>花朵管理中心</title>
<script type="text/javascript" src="JS/member_message.js"></script>
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
		<h2>花朵</h2>
		<form action="?action=delete" method="post">
		<table cellspacing="1">
			<tr><th>送花人</th><th>花朵数量</th><th>随花赠言</th><th>时间</th><th>操作</th></tr>
		<?php 
		  $_html=array();
		  $_html['count']=0;
		  while(!!$_rows=_fetch_array_list($_result)){
	          $_html['flower']='<img src="image/icon/4.png" title="花朵" alt="花朵" class="unread" /> x '.$_rows['mj_flower_num'].'';
	          $_html['content']='<strong>'.$_rows['mj_content'].'</strong>';
		      $_html['count']+=$_rows['mj_flower_num'];
	    ?>
			<tr>
			<td><?php echo $_rows['mj_fromuser']?></td>
			<td><?php echo $_html['flower']?></td>
			<td><a href="member_message_detail.php?id=<?php echo $_rows['mj_id']?>"><?php echo _title($_html['content'],15)?></a></td>
			<td><?php echo $_rows['mj_date']?></td>
			<td><input type="checkbox" name="ids[]" value="<?php echo $_rows['mj_id']?>" /></td>
			</tr>
			
		<?php 
	      }
		?>
		<tr><td colspan="5">共收到<?php echo $_html['count']?>朵花</td></tr>
		<tr><td colspan="5"><label for="all">全选 <input type="checkbox" name="checkall" id="all" /></label><input class="submit" type="submit" value="批量删除" /></td></tr>
		</table>
		</form>
		<?php _paging(1,'')?>
	</div>
</div>
<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>