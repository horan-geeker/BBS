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
define('SCRIPT', 'photo_add_img');

if(!isset($_COOKIE['username'])){
    _alert_back("请先登录");
}

//提交数据处理
if(isset($_GET['action'])&&$_GET['action']=='addimg'){
    if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
        //防止伪造cookie
        _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
    }
        require_once 'include/check.func.php';
        $_var = array();
        $_var['name'] = _check_dirname($_POST['name']);
        $_var['url'] = _check_url($_POST['url']);
        $_var['content'] = $_POST['content'];
        $_var['sid'] = $_POST['sid'];
        $_var['user'] = $_COOKIE['username'];
        $_var = _mysql_string($_var);
        
        //写入数据库
        _query("INSERT INTO mj_photos(
                                        mj_name,
                                        mj_url,
                                        mj_content,
                                        mj_sid,
                                        mj_user,
                                        mj_date
                                     )
                               VALUES(
                                        '{$_var['name']}',
                                        '{$_var['url']}',
                                        '{$_var['content']}',
                                        '{$_var['sid']}',
                                        '{$_var['user']}',
                                        NOW()
                                      )
            
            ");
        
        //判断是否修改成功
        if(_affected_rows()==1){
            _close();
            //_session_destory();
            _location('图片添加成功','photo_show.php?id='.$_var['sid']);
        }else{
            _close();
            //_session_destory();
            _alert_back('图片添加失败！');
        }
}

//页面加载处理
if(isset($_GET['id'])){
    $_id = _mysql_string($_GET['id']);
    if(!!$_rows = _fetch_array("SELECT mj_id,mj_dir FROM mj_photo_dir WHERE mj_id='$_id' LIMIT 1")){
        $_html = array();
        $_html['id'] = $_rows['mj_id'];
        $_html['dir'] = $_rows['mj_dir'];
        $_html = _html($_html);
    }else{
        _alert_back('不存在此相册');
    }
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
<title>添加图片</title>
<script type="text/javascript" src="JS/photo.js"></script>
</head>

<body>
<?php
require ROOT_PATH . 'include/header.inc.php';
?>
<div id="photo">
		<h2>上传图片</h2>
		<div id="album">
			<form method="post" action="?action=addimg">
			<input type="hidden" name="sid" value="<?php echo $_html['id']?>" />
				<div>
					图片名称： <input type="text" name="name" class="text" />
				</div>
				<div>
					图片地址： <input type="text" name="url" id='url' readonly="readonly" class="text" />
					<a href="javascript:;" id="up" title="<?php echo $_html['dir']?>">上传</a>
				</div>
				<div>
					图片描述：
					<textarea name="content"></textarea>
				</div>
				<div>
					<input type="submit" value="提交图片" class="submit">
				
				</div>
			</form>
		</div>
	</div>


<?php
require ROOT_PATH . 'include/footer.inc.php';
?>
</body>
</html>