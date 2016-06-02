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
define('SCRIPT','photo_show');

//页面加载
if(isset($_GET['id'])){
    $_id = _mysql_string($_GET['id']);
    if(!!$_rows = _fetch_array("SELECT mj_id,mj_name,mj_type FROM mj_photo_dir WHERE mj_id='$_id' LIMIT 1")){
        $_var = array();
        //得到相册id
        $_var['id'] = $_rows['mj_id'];
        $_var['name'] = $_rows['mj_name'];
        $_var['type'] = $_rows['mj_type'];
        $_var = _html($_var);
        //对比加密相册的验证信息
        if(isset($_POST['password'])){
            if(!!$_rows = _fetch_array("SELECT 
                                              mj_id
                                          FROM 
                                              mj_photo_dir 
                                         WHERE 
                                              mj_password='".md5($_POST['password'])."'
                                         LIMIT 1")){
                //生成cookie
                setcookie('photo'.$_var['id'],$_var['name']);
                //重定向
                header('Location:photo_show.php?id='.$_id);
            }else{
                _alert_back('相册密码不正确');
            }
        }
        
        
    }else{
        _alert_back('不存在此相册');
    }
}else{
    _alert_back('非法操作');
}


//读取数据
global $_pagenum,$_pagesize,$_id;
//拼接在分页函数中用到的全局$_id
$_id='id='.$_id.'&';
//后台分页处理，sql语句查找总条数，$_size（$_pagesize）每页显示的个数
_page("SELECT mj_id FROM mj_photos WHERE mj_sid='{$_var['id']}'",$_system['photo']);
//$_pagenum $_pagesize在函数_page中声明
$_result=_query("SELECT 
                        mj_id,
                        mj_name,
                        mj_url,
                        mj_read,
                        mj_comment,
                        mj_user
                    FROM 
                        mj_photos
                    WHERE
                        mj_sid='{$_var['id']}'
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
<link rel="stylesheet" type="text/css" href="css/photo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片展示</title>
<script type="text/javascript" src="JS/photo.js"></script>
</head>

<body>
<?php
require ROOT_PATH.'include/header.inc.php';
?>
<div id="photo_show">
	<h2><?php echo $_var['name']?></h2>
	
	<?php 
	
    if($_var['type']==1 && !isset($_COOKIE['photo'.$_var['id']])){
        
        echo '<form method="post" action="?id='.$_var['id'].'">';
        echo '<p>请输入密码：<input type="password" name="password" /><input type="submit" value="确认" /></p>';
        echo '</from>';
    }elseif($_var['type']==0 || $_COOKIE['photo'.$_var['id']]==$_var['name'] || isset($_SESSION['admin'])){
	
	$_html = array();
	$_percent = 0.3;
	while(!!$_rows=_fetch_array_list($_result)){ 
	    //得到当前图片的id
	    $_html['id'] = $_rows['mj_id'];
	    $_html['url'] = $_rows['mj_url'];
	    $_html['name'] = $_rows['mj_name'];
	    $_html['read'] = $_rows['mj_read'];
	    $_html['comment'] = $_rows['mj_comment'];
	    $_html['user'] = $_rows['mj_user'];
	    $_html=_html($_html);
	?>
	<dl>
		<dt>
    		<a href="photo_detail.php?id=<?php echo $_html['id']?>">
    			<img src="thumb.php?filename=<?php echo $_html['url']?>&percent=<?php echo $_percent?>" />
    		</a>
		</dt>
		<dd>
    		<a href="photo_detail.php?id=<?php echo $_html['id']?>">
    			<?php echo $_html['name']?>
    		</a>
		</dd>
		<dd>阅读（<strong><?php echo $_html['read']?></strong>）评论（<strong><?php echo $_html['comment']?></strong>）上传者:<?php echo $_html['user']?></dd>
		<?php if($_html['user']==@$_COOKIE['username'] || isset($_SESSION['admin'])) echo '<dd>[<a href="photo_delete.php?id='.$_html['id'].'">删除</a>]</dd>' ?>
	</dl>
	
	<?php }
	if(isset($_COOKIE['username'])){
        echo '<p><a href="photo_add_img.php?id='.$_var['id'].'">添加图片</a></p>';
    }
   _paging(2,"张图片");
	?>
        
	<?php }?>
</div>


<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>