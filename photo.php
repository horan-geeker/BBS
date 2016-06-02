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
define('SCRIPT','photo');

//读取数据
global $_pagenum,$_pagesize;
//后台分页处理，sql语句查找总条数，$_size（$_pagesize）每页显示的个数
_page("SELECT mj_id FROM mj_photo_dir",$_system['photo']);
//$_pagenum $_pagesize在函数_page中声明
$_result=_query("SELECT 
                        mj_id,
                        mj_name,
                        mj_type,
                        mj_cover
                    FROM 
                        mj_photo_dir 
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
<title>相册</title>
</head>

<body>
<?php
require ROOT_PATH.'include/header.inc.php';
?>
<div id="photo">
	<h2>相册列表</h2>
	<?php 
	   $_html = array();
	   while(!!$_rows = _fetch_array_list($_result)){
	       $_html['id']=$_rows['mj_id'];
	       $_html['name']=$_rows['mj_name'];
	       $_html['type']=$_rows['mj_type'];
	       $_html = _html($_html);
	       $_html['cover']='<img src="'.$_rows['mj_cover'].'" alt="封面" />';
	       if($_html['type'] == 0){
	           $_html['type_html']='(公开)';
	       }else{
	           $_html['type_html']='(私密)';
	       }
	       
	       //统计照片里的数量
	       $_html['photo'] = _fetch_array("SELECT COUNT(*) AS count FROM mj_photos WHERE mj_sid={$_html['id']}");
	       
	       ?>
	<dl>
		<dt><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['cover']?></a></dt>
		<dd><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['name'].' '.$_html['type_html']?></a></dd>
		<dd>共有<?php echo $_html['photo']['count']?>张照片</dd>
		<?php if(isset($_SESSION['admin'])&&isset($_COOKIE['username'])){?>
		<dd>
			[<a href="photo_modify_dir.php?id=<?php echo $_html['id']?>">修改</a>]
			[<a href="photo_delete_dir.php?id=<?php echo $_html['id']?>">删除</a>]
		</dd>
    	<?php }?>
	</dl>
	<?php }?>
	<?php if(isset($_SESSION['admin'])&&isset($_COOKIE['username'])){?>
	<p><a href="photo_add_dir.php">添加目录</a></p>
	<?php }?>
</div>


<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>