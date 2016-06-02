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
//防止恶意调用
if(!defined("TOKEN")){
    echo "Access Defined!!!";
    exit();
}

//判断版本
if(PHP_VERSION<'4.0.0'){
    echo "Version is too Low";
    exit();
}


/**
 * _setcookies
 * @param string $_username
 * @param string $_uniqid
 * @param int $_time
 */
function _setcookies($_username,$_uniqid,$_time){
    //保留一天
    $_time=86400;
    //保留一周
    //$_time=604800;
    //保留一月
    //$_time=2592000;
    setcookie('username',$_username,time()+$_time);
    setcookie('uniqid',$_uniqid,time()+$_time);
}