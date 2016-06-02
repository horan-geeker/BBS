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
//自己提交的数据进行处理
if(isset($_GET['article'])){
    if($_GET['article']=='post'){
        //验证码
        _check_code($_POST['chk'],$_SESSION['authcode']);
        //唯一标识符,防止伪造cookie
        if(!!$_rows = _fetch_array("SELECT mj_uniqid,mj_post_time FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
            _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
        }
        //限制发帖时间
        _timed($_rows['mj_post_time'], $_system['post']);
        
        
        include ROOT_PATH.'include/check.func.php';
        $_var=array();
        //发帖写入数据库
        $_var['username'] = $_COOKIE['username'];
        $_var['type'] = $_POST['type'];
        $_var['title'] = _check_post_title($_POST['title'],2,40);
        $_var['content']= _check_post_content($_POST['content']);
        
        _query("insert into mj_article(
                                        mj_username,
                                        mj_type,
                                        mj_title,
                                        mj_content,
                                        mj_date
                                        )
                                   value(
                                        '{$_var['username']}',
                                        '{$_var['type']}',
                                        '{$_var['title']}',
                                        '{$_var['content']}',
                                        NOW()
                                        )"
                   );
        //判断是否修改成功
        if(_affected_rows()==1){
            //获取刚才产生的id
            $_var['id']=_insert_id();
//          setcookie("post_time",time());
            //写入发帖时间
            $_now = time();
            _query("UPDATE mj_user SET mj_post_time='$_now' WHERE mj_username='{$_COOKIE['username']}'");
            
            _close();
            //_session_destory();
            _location('发帖成功','article.php?id='.$_var['id']);
        }else{
            _close();
            //_session_destory();
            _alert_back('发帖失败！');
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
<title>发表帖子</title>
<script src="JS/code.js" type="text/javascript"></script>
<script src="JS/post.js" type="text/javascript"></script>
</head>

<body>
<?php 
    require ROOT_PATH.'include/header.inc.php';
?>

<div id="post">
	<h2>发表帖子</h2>
	<form method="post" action="?article=post">
		<dl>
			<dt>请认真填写下面内容</dt>
			<dd>类  　型 ：
			<?php 
				foreach (range(1,8) as $_num){
				    if($_num==1){
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
			<dd>标  　题 ：<input type="text" name="title" class="text" />(*必填,2-40位)</dd>
			<dd class="text">
				<?php 
				    require ROOT_PATH.'include/ubb.inc.php';
				?>
				<textarea name="content"></textarea>
			</dd>
			<dd>验 证 码 ：
    			<input type="text" name="chk" class="text code" id="chkcode"/><img src="checkcode.php" id="code"/>
    			<input type="submit" class="submit" value="发表帖子" />
			</dd>
		</dl>
	</form>
</div>

<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>