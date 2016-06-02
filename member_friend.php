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
define('SCRIPT','member_friend');
//判断是否登录
if(!isset($_COOKIE['username'])){
    _alert_close("请先登录！");
}


if(isset($_GET['action'])){
//好友验证
    if($_GET['action']=='check'&&isset($_GET['id'])){
        if(!!$_uniqid = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
            //防止伪造cookie 对比唯一标识符
            _uniqid($_uniqid['mj_uniqid'],$_COOKIE['uniqid']);
            $_id=_mysql_string($_GET['id']);
            _query("UPDATE mj_friend SET mj_friend_state=1 WHERE mj_id='$_id'");
            //判断是否验证成功
            if(_affected_rows()==1){
                _close();
                _location('成功加为好友','member_friend.php');
            }else{
                _close();
                _alert_back('验证失败！');
            }
        }else{
            _alert_back("非法登录");
        }
    }
//好友删除请求操作
    if($_GET['action']=='delete'&&isset($_POST['ids'])){
        //print_r($_POST['ids']);
        $_clean=array();
        //将数组中所有元素拼接成一个字符串
        $_clean['ids'] = _mysql_string(implode(',',$_POST['ids']));
        //危险操作！
        if(!!$_uniqid = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
            //防止伪造cookie 对比唯一标识符
            _uniqid($_uniqid['mj_uniqid'],$_COOKIE['uniqid']);
            _query("DELETE FROM mj_friend WHERE mj_id in ({$_clean['ids']})");
            //判断是否删除成功
                if(_affected_rows()){
                    _close();
                    _location('删除成功','member_friend.php');
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
_page("SELECT mj_id FROM mj_friend WHERE mj_tofriend='{$_COOKIE['username']}'",10);
$_result=_query("SELECT 
                        * 
                   FROM 
                        mj_friend 
                  WHERE 
                        mj_tofriend='{$_COOKIE['username']}'
                     OR 
                        mj_fromfriend='{$_COOKIE['username']}'
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
<link rel="stylesheet" type="text/css" href="css/member_friend.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>好友设置</title>
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
		<h2>好友设置</h2>
		<form action="?action=delete" method="post">
		<table cellspacing="1">
			<tr><th>请求好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
		<?php 
		  while(!!$_rows=_fetch_array_list($_result)){
		      $_html=array();
		      if($_rows['mj_tofriend']==$_COOKIE['username']){
		          $_html['friend']=$_rows['mj_fromfriend'];
		          if($_rows['mj_friend_state']!=0){
		              $_html['state']='<span style="color:green">已为好友</span>';
		              $_html['content']=$_rows['mj_friend_query'];
		          }else{
		              $_html['state']='<a href="?action=check&id='.$_rows['mj_id'].'" style="color:red">你未验证</a>';
		              $_html['content']=$_rows['mj_friend_query'];
		          }
		      }elseif($_rows['mj_fromfriend']==$_COOKIE['username']){
		          $_html['friend']=$_rows['mj_tofriend'];
		          if($_rows['mj_friend_state']!=0){
		              $_html['state']='<span style="color:green">已为好友</span>';
		              $_html['content']=$_rows['mj_friend_query'];
		          }else{
		              $_html['state']='<span style="color:blue">对方未验证</span>';
		              $_html['content']=$_rows['mj_friend_query'];
		          }
		      }
		?>
			<tr>
			<td><?php echo $_html['friend']?></td>
			<td title="<?php echo $_html['content']?>"><strong><?php echo _title($_html['content'],15)?></strong></td>
			<td><?php echo $_rows['mj_date']?></td>
			<td><?php echo $_html['state']?></td>
			<td><input type="checkbox" name="ids[]" value="<?php echo $_rows['mj_id']?>" /></td>
			</tr>
		<?php 
	      }
		?>
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