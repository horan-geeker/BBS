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

define('SCRIPT','index');
//引用公共文件
require dirname(__FILE__).'/include/common.inc.php';

//删除操作
if(isset($_GET['delete'])){
    _is_manage();
    $_id = _mysql_string($_GET['delete']);
    if(!!$_uniqid = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
        //防止伪造cookie 对比唯一标识符
        _uniqid($_uniqid['mj_uniqid'],$_COOKIE['uniqid']);
        _query("DELETE FROM mj_article WHERE mj_id='$_id' OR mj_reid='$_id'");
        //判断是否删除成功
        if(_affected_rows()){
            _close();
            _location('删除成功','index.php');
        }else{
            _close();
            _alert_back('删除失败！');
        }
    }else{
        _alert_back("非法登录");
    }
}





//加载处理
//读取xml
$_html=_html(_get_xml('new.xml'));
//生成帖子列表
global $_pagenum,$_pagesize;
//后台分页处理，sql语句查找总条数，$_size（$_pagesize）每页显示的个数
_page("SELECT mj_id FROM mj_article WHERE mj_reid=0",$_system['article']);
//$_pagenum $_pagesize在函数_page中声明
$_result=_query("SELECT 
                        mj_id,
                        mj_title,
                        mj_type,
                        mj_read,
                        mj_comment
                   FROM 
                        mj_article
                  WHERE 
                        mj_reid=0
               ORDER BY 
                        mj_date DESC
                  LIMIT $_pagenum,$_pagesize
                ");
//最新图片，找到时间点最新上传的图片，并且是公开的
//两层嵌套的sql语句，先在相册的表里找到所有公开的相册，再到这些相册里找时间最新的
$_photo = _fetch_array("SELECT * FROM mj_photos WHERE mj_sid IN(SELECT mj_id FROM mj_photo_dir WHERE mj_type=0) ORDER BY mj_date DESC LIMIT 1");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/index.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_system['webname']?></title>
<script type="text/javascript" src="JS/blog.js"></script>
</head>

<body>
<?php 
    require ROOT_PATH.'include/header.inc.php';
?>

<div id="list">
	<h2>帖子列表</h2>
	<a href="post.php" class="post"></a>
	<ul class="article">
	<?php 
    	$_htmllist=array();
    	while(!!$_rows=_fetch_array_list($_result)){ 
	        $_htmllist['id']=$_rows['mj_id'];
	        $_htmllist['type']=$_rows['mj_type'];
	        $_htmllist['title']=$_rows['mj_title'];
	        $_htmllist['read']=$_rows['mj_read'];
	        $_htmllist['comment']=$_rows['mj_comment'];
    	    $_htmllist=_html($_htmllist);
	        if(isset($_SESSION['admin'])){
    	        echo '<li class="icon'.$_htmllist['type'].'">
                        <em>阅读数(<strong>'.$_htmllist['read'].'</strong>) 
                                                                评论数(<strong>'.$_htmllist['comment'].'</strong>)
                            <a href="index.php?delete='.$_htmllist['id'].'">[删除]</a>
                        </em><a href="article.php?id='.$_htmllist['id'].'"> '._title($_htmllist['title'],20).'</a></li>';
    	
	        }else{
	            echo '<li class="icon'.$_htmllist['type'].'">
                        <em>阅读数(<strong>'.$_htmllist['read'].'</strong>)
                                                                评论数(<strong>'.$_htmllist['comment'].'</strong>)
                        </em><a href="article.php?id='.$_htmllist['id'].'"> '._title($_htmllist['title'],20).'</a></li>';
	        }
    	}
	?>
	</ul>
	<?php _paging(2,"篇帖子")?>
</div>
<div id="user">
	<h2>新进会员</h2>
	<dl>
		<dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex']?>)</dd>
		<dt><img src="image/<?php echo $_html['face']?>.jpg" alt="face" /></dt>
		<dd class="sendmsg" ><a href="javascript:;" name="message" id="<?php echo $_rows['mj_id']?>">发消息</a></dd>
		<dd class="addfriend"><a href="javascript:;" name="friend" id="<?php echo $_rows['mj_id']?>">加为好友</a></dd>
		<dd class="guest"><a href="javascript:;" name="text" id="<?php echo $_rows['mj_id']?>">写留言</a></dd>
		<dd class="flower"><a href="javascript:;" name="flower" id="<?php echo $_rows['mj_id']?>">送  　花</a></dd>
		<dd class="email">邮件:<br /><?php echo $_html['email']?></dd>
	</dl>
</div>
<div id="pics">
	<h2>最新图片</h2>
	<dl>
		<dd class="user"><?php echo $_photo['mj_name']?></dd>
		<dt><a href="photo_detail.php?id=<?php echo $_photo['mj_id']?>"><img src="<?php echo $_photo['mj_url']?>" alt="new" /></a></dt>
		<dd class="info">
			<p>浏览量（<strong><?php echo $_photo['mj_read']?></strong>）</p>
			<p>评论量（<strong><?php echo $_photo['mj_comment']?></strong>）</p>
			<p>发表于：<?php echo $_photo['mj_date']?></p>			
			<p>上传者：<?php echo $_photo['mj_user']?></p>
		</dd>
	</dl>
</div>
<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>
