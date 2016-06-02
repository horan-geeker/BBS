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

//判断版本
if(PHP_VERSION<'4.0.0'){
    echo "Version is too Low";
    exit();
}

//定义一个常量防止非法调用
define("TOKEN",true);
//定义根目录
define("ROOT_PATH", substr(dirname(__FILE__),0,-7));

$_system=array();
global $_system;

//引入核心函数库
require ROOT_PATH.'include/global.func.php';
require ROOT_PATH.'include/mysql.func.php';


//执行耗时
$start_time=_runtime();


//初始化数据库
_connect();
_select_db();
_set_names();


//短信提醒
if(isset($_COOKIE['username'])){
    $_message=_fetch_array("SELECT count(mj_id) AS t FROM mj_message WHERE mj_touser='{$_COOKIE['username']}' AND mj_state=0");
    $_friend =_fetch_array("SELECT count(mj_id) AS count FROM mj_friend WHERE  mj_tofriend='{$_COOKIE['username']}' AND mj_friend_state=0");
    if($_friend['count']>0)
        $_unread=' (</a><a href="member_friend.php">'.$_friend["count"].' <img src="image/icon/unread.png" alt="未读消息" class="unread"/> )';
    elseif($_message['t']>0)
        $_unread=' (</a><a href="member_message.php">'.$_message["t"].' <img src="image/icon/unread.png" alt="未读消息" class="unread"/> )';
    else
        $_unread='';
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
    
    $_system['webname'] = $_rows['mj_webname'];
    $_system['article'] = $_rows['mj_article'];
    $_system['blog'] = $_rows['mj_blog'];
    $_system['photo'] = $_rows['mj_photo'];
    $_system['skin'] = $_rows['mj_skin'];
    $_system['string'] = $_rows['mj_string'];
    $_system['post'] = $_rows['mj_post'];
    $_system['re'] = $_rows['mj_re'];
    $_system['code'] = $_rows['mj_code'];
    $_system['register'] = $_rows['mj_register'];
    $_system = _html($_system);        
}else{
    exit("系统表异常");
}
?>