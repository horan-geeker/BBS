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
define('SCRIPT','upimg');

if(!isset($_COOKIE['username'])){
    _alert_back('非法操作');
}


//上传图片
if(isset($_GET['action'])&&$_GET['action']=='up'){
    if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
        //防止伪造cookie
        _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
    }
    
    //设置上传图片的类型
    $_files = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/jpg','image/gif');
    //判断上传类型是否符合
    if(is_array($_files)){
        if(!in_array($_FILES['userfile']['type'], $_files)){
            _alert_back('上传图片必须是jpg,png,gif中的一种！');
        }
    }
    
    //出错是判断错误类型
    if($_FILES['userfile']['error']>0){
        switch ($_FILES['userfile']['error']){
            case 1:
                _alert_back('上传文件超过约定值1');
                break;
            case 2:_alert_back('上传文件超过约定值2');
                break;
            case 3:_alert_back('部分文件被上传');
                break;
            case 4:_alert_back('上传失败');
                break;
        }
    }
    
    //判断文件大小
    if($_FILES['userfile']['size']>$_POST['MAX_FILE_SIZE']){
        _alert_back('上传文件不得超过'.($_POST['MAX_FILE_SIZE']/1000000).'M');
    }
    
    //获取文件扩展名,拼接文件名
    $_suffix = explode('.', $_FILES['userfile']['name']);
    $_name = $_POST['dir'].'/'.time().'.'.$_suffix[1];
    //移动文件
    if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
        if(!move_uploaded_file($_FILES['userfile']['tmp_name'], $_name)){
            _alert_back('文件移动失败');
        }else{
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script type='text/javascript'>alert('上传成功');window.opener.document.getElementById('url').value='$_name';window.close();</script>";
            exit();
        }
    }
}

//加载页面
if(!isset($_GET['dir'])){
    _alert_back('非法操作');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传图片</title>
</head>

<body>

<div id="upimg">
	<form enctype="multipart/form-data" action="upimg.php?action=up" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
    	选择图片：
    	<input type="file" name="userfile" />
    	<input type="hidden" name="dir" value="<?php echo $_GET['dir']?>">
    	<input type="submit" value="上传" />
	</form>
</div>

</body>
</html>