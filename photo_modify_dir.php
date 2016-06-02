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

// 引用公共文件
require dirname(__FILE__) . '/include/common.inc.php';
// 分页处理

// 定义常量，指定本页名称
define('SCRIPT', 'photo_modify_dir');

_is_manage();



//修改操作
if(isset($_GET['action']) && $_GET['action']=='modify'){
    //唯一标识符,防止伪造cookie
    if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
        _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
    }
    include ROOT_PATH.'include/check.func.php';
    // 发帖写入数据库
    $_html = array();
    $_html['id'] = $_POST['id'];
    $_html['name'] = _check_dirname($_POST['name']);
    $_html['type'] = $_POST['type'];
    if($_html['type']==1){
        $_html['password'] = _check_photo_password($_POST['password']);
    }
    $_html['content'] = $_POST['content'];
    $_html['cover'] = $_POST['cover'];
    $_html = _mysql_string($_html);
    
    // 把当前的目录信息写入数据库
    if ($_html['type']==1){
        _query("UPDATE mj_photo_dir SET
                                        mj_name='{$_html['name']}',
                                        mj_type='{$_html['type']}',
                                        mj_password='{$_html['password']}',
                                        mj_content='{$_html['content']}',
                                        mj_cover='{$_html['cover']}'
                                   WHERE
                                        mj_id='{$_html['id']}'
            ");
    }elseif($_html['type']==0){
        _query("UPDATE mj_photo_dir SET
                                        mj_name='{$_html['name']}',
                                        mj_type='{$_html['type']}',
                                        mj_content='{$_html['content']}',
                                        mj_cover='{$_html['cover']}'
                                   WHERE
                                        mj_id='{$_html['id']}'
            ");
    }
    
    // 判断是否修改成功
    if (_affected_rows() == 1) {
        _close();
        _location('修改成功', 'photo.php');
    } else {
        _close();
        // _session_destory();
        _alert_back('修改失败！');
    }
}


//加载页面处理
if(isset($_GET['id'])){
    $_id = _mysql_string($_GET['id']);
    //唯一标识符,防止伪造cookie
    if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
        //防止伪造cookie
        _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
    }
    if(!!$_rows = _fetch_array("SELECT * FROM mj_photo_dir WHERE mj_id='$_id' LIMIT 1"))
        include ROOT_PATH.'include/check.func.php';
        $_var=array();
        //发帖写入数据库
        $_var['id'] = $_rows['mj_id'];
        $_var['name'] = $_rows['mj_name'];
        $_var['type'] = $_rows['mj_type'];
        $_var['content'] = $_rows['mj_content'];
        $_var['dir'] = $_rows['mj_dir'];
        $_var['cover'] = $_rows['mj_cover'];
        $_var=_mysql_string($_var);
}else{
    _alert_back('非法操作');
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg" />
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/photo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>相册修改</title>
<script type="text/javascript" src="JS/photo.js"></script>
</head>

<body>
<?php
require ROOT_PATH . 'include/header.inc.php';
?>
<div id="photo">
		<h2>修改相册目录</h2>
		<div id="album">
			<form method="post" action="?action=modify">
				<div>
					相册名称：<input type="text" name="name" class="text" />
				</div>
				<div>
					相册类型： <label><input type="radio" name="type" value="0"
						<?php if($_var['type']==0)echo 'checked="checked"'?> />公开 </label> <label><input type="radio"
						name="type" value="1" <?php if($_var['type']==1)echo 'checked="checked"'?> />私密</label>
				</div>
				<div id="pass" <?php if($_var['type']==1)echo 'style="display:block"'?>>
					相册密码：<input type="password" name="password" class="text" />
				</div>
				<div>
					相册封面：<input type="text" name="cover" value="<?php echo $_var['cover']?>" class="text" />
				</div>
				<div>
					相册描述：
					<textarea name="content"><?php echo $_var['content']?></textarea>
				</div>
				<div>
        			<input type="hidden" name="id" value="<?php echo $_var['id']?>" />
					<input type="submit" value="修改相册目录" class="submit">
				
				</div>
			</form>
		</div>
	</div>


<?php
require ROOT_PATH . 'include/footer.inc.php';
?>
</body>
</html>