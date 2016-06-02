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
define('SCRIPT', 'photo_add_dir');

_is_manage();

// 数据处理
if (isset($_GET['action']) && $_GET['action'] == 'adddir') {
    if (! ! $_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")) {
        _uniqid($_rows['mj_uniqid'], $_COOKIE['uniqid']);
    }
    
    include ROOT_PATH . 'include/check.func.php';
    $_var = array();
    // 发帖写入数据库
    $_var['name'] = _check_dirname($_POST['name']);
    $_var['type'] = $_POST['type'];
    if($_var['type']==1){
        $_var['password'] = _check_photo_password($_POST['password']);
    }
    $_var['content'] = $_POST['content'];
    $_var['dir'] = time();
    $_var['cover'] = $_POST['url'];
    $_var = _mysql_string($_var);
    
    // 检查目录是否存在,没有则创建
    if (! is_dir('photos')) {
        mkdir('photos', 0777);
    }
    // 创建相册目录
    if (! is_dir('photos/' . $_var['dir'])) {
        mkdir('photos/' . $_var['dir'],0777);
    }
    // 把当前的目录信息写入数据库
    if ($_var['type']==1){
        _query("insert into mj_photo_dir(
                                    mj_name,
                                    mj_type,
                                    mj_password,
                                    mj_content,
                                    mj_dir,
                                    mj_cover,
                                    mj_date
                                    )
                             value(
                                    '{$_var['name']}',
                                    '{$_var['type']}',
                                    '{$_var['password']}',
                                    '{$_var['content']}',
                                    'photos/{$_var['dir']}',
                                    '{$_var['cover']}',
                                    NOW()
                                    )
           ");
    }elseif($_var['type']==0){
        _query("insert into mj_photo_dir(
                                        mj_name,
                                        mj_type,
                                        mj_content,
                                        mj_dir,
                                        mj_cover,
                                        mj_date
                                        )
                                        value(
                                        '{$_var['name']}',
                                        '{$_var['type']}',
                                        '{$_var['content']}',
                                        'photos/{$_var['dir']}',
                                        '{$_var['cover']}',
                                        NOW()
                                        )
            ");
    }
    // 判断是否修改成功
    if (_affected_rows() == 1) {
        _close();
        _location('添加成功', 'photo.php');
    } else {
        _close();
        // _session_destory();
        _alert_back('添加失败！');
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg" />
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/photo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加相册</title>
<script type="text/javascript" src="JS/dirphoto.js"></script>
</head>

<body>
<?php
require ROOT_PATH . 'include/header.inc.php';
?>
<div id="photo">
		<h2>添加相册</h2>
		<div id="album">
			<form method="post" action="?action=adddir">
				<div>
					相册名称：<input type="text" name="name" class="text" />
				</div>
				<div>
					相册封面：<input type="text" name="url" id='url' readonly="readonly" class="text" />
					<a href="javascript:;" id="up">上传</a>
				</div>
				<div>
					相册类型： <label><input type="radio" name="type" value="0"
						checked="checked" />公开 </label> <label><input type="radio"
						name="type" value="1" />私密</label>
				</div>
				<div id="pass">
					相册密码：<input type="password" name="password" class="text" />
				</div>
				<div>
					相册描述：
					<textarea name="content"></textarea>
				</div>
				<div>
					<input type="submit" value="添加相册目录" class="submit">
				
				</div>
			</form>
		</div>
	</div>


<?php
require ROOT_PATH . 'include/footer.inc.php';
?>
</body>
</html>