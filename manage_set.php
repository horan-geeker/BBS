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
define('SCRIPT','manage_set');

_is_manage();

//修改操作
if(isset($_GET['action'])&&$_GET['action']=='set'){
    //判断cookie中的id是否合法
    if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
        //防止伪造cookie
        _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
    }
    include ROOT_PATH.'include/check.func.php';
    $_var=array();
    $_var['webname']=$_POST['webname'];
    $_var['article']=$_POST['article'];
    $_var['blog']=$_POST['blog'];
    $_var['photo']=$_POST['photo'];
    $_var['skin']=$_POST['skin'];
    $_var['string']=$_POST['string'];
    $_var['post']=$_POST['post'];
    $_var['re']=$_POST['re'];
    $_var['code']=$_POST['code'];
    $_var['register']=$_POST['register'];
    $_var = _mysql_string($_var);
    //判断密码是否保持默认
    
    $_sql="UPDATE mj_system SET
                                mj_webname='{$_var['webname']}',
                                mj_article='{$_var['article']}',
                                mj_blog='{$_var['blog']}',
                                mj_photo='{$_var['photo']}',
                                mj_string='{$_var['string']}',
                                mj_re='{$_var['re']}',
                                mj_post='{$_var['post']}',
                                mj_skin='{$_var['skin']}',
                                mj_code='{$_var['code']}',
                                mj_register='{$_var['register']}'
                          WHERE
                                mj_id=1
                          LIMIT
                                1
                    ";
    _query($_sql);
    //判断是否修改成功
    if(_affected_rows()==1){
        _close();
        //_session_destory();
        _location('恭喜你，修改成功','manage_set.php');
    }else{
        _close();
        //_session_destory();
        _location('修改失败！', 'register.php');
    }
}

//读取系统表
if(!!$_rows = _fetch_array("SELECT 
                                  * 
                              FROM 
                                  mj_system 
                             WHERE 
                                    mj_id=1
                             LIMIT 1
                             ")){
    $_html = array();
    $_html['webname'] = $_rows['mj_webname'];
    $_html['article'] = $_rows['mj_article'];
    $_html['blog'] = $_rows['mj_blog'];
    $_html['photo'] = $_rows['mj_photo'];
    $_html['skin'] = $_rows['mj_skin'];
    $_html['string'] = $_rows['mj_string'];
    $_html['post'] = $_rows['mj_post'];
    $_html['re'] = $_rows['mj_re'];
    $_html['code'] = $_rows['mj_code'];
    $_html['register'] = $_rows['mj_register'];
    $_html=_html($_html);
    //首页文章列表
    if($_html['article']==9){
        $_html['article_html']='<select name="article"><option value="9" selected="selected">每页9篇</option><option value="15">每页15篇</option></select>';
    }elseif($_html['article']==15){
        $_html['article_html']='<select name="article"><option value="9">每页9篇</option><option value="15" selected="selected">每页15篇</option></select>';
    }
    //博友列表
    if($_html['blog']==10){
        $_html['blog_html']='<select name="blog"><option value="10" selected="selected">每页10人</option><option value="15">每页15人</option></select>';
    }elseif($_html['blog']==15){
        $_html['blog_html']='<select name="blog"><option value="10">每页10人</option><option value="15" selected="selected">每页15人</option></select>';
    }
    //相册列表
    if($_html['photo']==8){
        $_html['photo_html']='<select name="photo"><option value="8" selected="selected">每页8张</option><option value="12">每页12张</option></select>';
    }elseif($_html['photo']==12){
        $_html['photo_html']='<select name="photo"><option value="8">每页8张</option><option value="12" selected="selected">每页12张</option></select>';
    }
    //站点皮肤
    if($_html['skin']==1){
        $_html['skin_html']='<select name="skin"><option value="1" selected="selected">1号皮肤</option><option value="2">2号皮肤</option><option value="3">3号皮肤</option></select>';
    }elseif($_html['skin']==2){
        $_html['skin_html']='<select name="skin"><option value="1">1号皮肤</option><option value="2" selected="selected">2号皮肤</option><option value="3">3号皮肤</option></select>';
    }elseif($_html['skin']==3){
        $_html['skin_html']='<select name="skin"><option value="1">1号皮肤</option><option value="2">2号皮肤</option><option value="3" selected="selected">3号皮肤</option></select>';
    }
    //发帖限制
    if($_html['post']==30){
        $_html['post_html']='<select name="post"><option value="30" selected="selected">30s</option><option value="60">60s</option><option value="180">180s</option></select>';
    }elseif($_html['post']==60){
        $_html['post_html']='<select name="post"><option value="30">30s</option><option value="60" selected="selected">60s</option><option value="180">180s</option></select>';
    }elseif($_html['post']==180){
        $_html['post_html']='<select name="post"><option value="30">30s</option><option value="60">60s</option><option value="180" selected="selected">180s</option></select>';
    }
    //回帖限制
    if($_html['re']==15){
        $_html['re_html']='<select name="re"><option value="15" selected="selected">15s</option><option value="30">30s</option><option value="60">60s</option></select>';
    }elseif($_html['re']==30){
        $_html['re_html']='<select name="re"><option value="15">15s</option><option value="30" selected="selected">30s</option><option value="60">60s</option></select>';
    }elseif($_html['re']==60){
        $_html['re_html']='<select name="re"><option value="15">15s</option><option value="30">30s</option><option value="60" selected="selected">60s</option></select>';
    }

    //是否启用验证码
    if($_html['code']==1){
        $_html['code_html']='<input type="radio" name="code" value="1" checked="checked">启用<input type="radio" name="code" value="0">禁用';
    }else{
        $_html['code_html']='<input type="radio" name="code" value="1">启用<input type="radio" name="code" value="0" checked="checked">禁用';
    }
    
    //是否开放注册
    if($_html['register']==1){
        $_html['register_html']='<input type="radio" name="register" value="1" checked="checked">开放注册<input type="radio" name="register" value="0">关闭注册';
    }else{
        $_html['register_html']='<input type="radio" name="register" value="1">开放注册<input type="radio" name="register" value="0" checked="checked">关闭注册';
    }
}else{
    _alert_back("系统读取错误，联系管理员检测");
}
     
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/manage_set.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理中心</title>
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
		<h2>后台管理中心</h2>
		<form action="?action=set" method="post">
		<dl>
			<dd>*网站名称: <input type="text" class="text" name="webname" value="<?php echo $_html['webname']?>" /></dd>
			<dd>*文章每页列表数: <?php echo $_html['article_html']?></dd>
			<dd>*博客每页列表: <?php echo $_html['blog_html']?></dd>
			<dd>*相册每页列表: <?php echo $_html['photo_html']?></dd>
			<dd>*站点默认皮肤: <?php echo $_html['skin_html']?></dd>
			<dd>*非法字符过滤: <input type="text" class="text" name="string" value="<?php echo $_html['string']?>" />（请用|隔开）</dd>
			<dd>*每次发帖限制: <?php echo $_html['post_html']?></dd>
			<dd>*每次回帖限制: <?php echo $_html['re_html']?></dd>
			<dd>*是否启用验证码: <?php echo $_html['code_html']?></dd>
			<dd>*是否开放注册: <?php echo $_html['register_html']?></dd>
			<dd><input type="submit" value="修改系统设置" class="submit" /></dd>
		</dl>
		</form>
	</div>
</div>


<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>