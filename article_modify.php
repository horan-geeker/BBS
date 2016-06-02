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
//判断是否登录
if(!isset($_COOKIE['username'])){
    _location("请先登录！","login.php");
}

//读取数据
if(isset($_GET['id'])){
    $_id=_mysql_string($_GET['id']);
    if(!!$_rows=_fetch_array("SELECT * FROM mj_article WHERE mj_reid=0 AND mj_id='$_id'")){
        $_html=array();
        $_html['username'] = $_rows['mj_username'];
        $_html['title'] = $_rows['mj_title'];
        $_html['type'] = $_rows['mj_type'];
        $_html['content'] = $_rows['mj_content'];
        $_html=_html($_html);
        
        //判断权限
        if($_COOKIE['username']!=$_html['username']){
            _alert_back("无法修改");
        }
    }else{
        _alert_back("不存在此贴");
    }
}        
        
//修改操作
if(isset($_GET['article'])){
    if($_GET['article']=='modify'){
        //验证码
        _check_code($_POST['chk'],$_SESSION['authcode']);
        //唯一标识符,防止伪造cookie
        if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1"))
            _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);

            //发帖写入数据库
            include ROOT_PATH.'include/check.func.php';
            $_var=array();
            $_var['id'] = $_POST['id'];
            $_var['type'] = $_POST['type'];
            $_var['title'] = _check_post_title($_POST['title'],2,40);
            $_var['content']= _check_post_content($_POST['content']);

            _query("UPDATE mj_article
                                SET
                                    mj_type='{$_var['type']}',
                                    mj_title='{$_var['title']}',
                                    mj_content='{$_var['content']}',
                                    mj_last_modify=NOW()
                                WHERE
                                    mj_id='{$_var['id']}'
                ");
            //判断是否修改成功
            if(_affected_rows()==1){
                _close();
                //_session_destory();
                _location('修改成功','article.php?id='.$_var['id']);
            }else{
                _close();
                //_session_destory();
                _alert_back('修改失败！');
            }
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
<link rel="stylesheet" type="text/css" href="css/post.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改帖子</title>
<script src="JS/code.js" type="text/javascript"></script>
<script src="JS/post.js" type="text/javascript"></script>
</head>

<body>
<?php 
    require ROOT_PATH.'include/header.inc.php';
?>

<div id="post">
	<h2>修改帖子</h2>
	<form method="post" action="?article=modify">
		<input type="hidden" name="id" value="<?php echo $_id?>" />
		<dl>
			<dt>请认真修改下面内容</dt>
			<dd>类  　型 ：
			<?php 
				foreach (range(1,8) as $_num){
				    if($_num==$_html['type']){
				        echo '<label><input checked="checked" type="radio" id="radio" name="type" value="'.$_num.'" />';
				    }else{
    				    echo '<label><input type="radio" id="radio" name="type" value="'.$_num.'" />';
				    }
				    echo '<img src="image/icon/icon'.$_num.'.png" alt="类型"  /></label>';
				    if($_num==8){
				        echo "<br />     ";
				    }
				}
			?>
			</dd>
			<dd>标  　题 ：<input type="text" name="title" class="text" value="<?php echo $_html['title']?>" />(*必填,2-40位)</dd>
			<dd class="text">
				<?php 
				    require ROOT_PATH.'include/ubb.inc.php';
				?>
				<textarea name="content"><?php echo $_html['content']?></textarea>
			</dd>
			<dd>验 证 码 ：
    			<input type="text" name="chk" class="text code" id="chkcode"/><img src="checkcode.php" id="code"/>
    			<input type="submit" class="submit" value="修改帖子" />
			</dd>
		</dl>
	</form>
</div>

<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>