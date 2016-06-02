<?php
//防止恶意调用
if(!defined("TOKEN")){
    echo "Access Defined!!!";
    exit();
}

/**
 * 
 */
function _check_uniqid($_first_uniqid,$_end_uniqid){
    if(strlen($_first_uniqid)!=40 || $_first_uniqid!=$_end_uniqid){
        _alert_back("唯一标识符异常！");
    }
    return _mysql_string($_first_uniqid);
}



/**
 * check_username()用户名注册验证
 * @access public
 * @param string $name
 * @return string $name
 */
function _check_username($name){
    $name=trim($name);
    if(mb_strlen($name,'utf-8') < 2 || mb_strlen($name,'utf-8')>20){
        _alert_back("用户名长度不得小于2位或大于20位");
    }
    $pattern='/[<>\'\"\ ]/';
    if(preg_match($pattern, $name)){
        _alert_back("用户名不得包含敏感字符");
    }
    return _mysql_string($name);
}


/**
 * 
 */
function check_question($question){
    $question=trim($question);
    return _mysql_string($question);
}


/**
 * _check_password密码注册格式检验
 * @param unknown $password
 * @param unknown $repassword
 * @return string
 */
function _check_password($password,$repassword){
    if(strlen($password)<6){
        _alert_back("密码不得小于6位");
    }
    if($password!=$repassword){
        _alert_back("两次输入的密码不一致");
    }
    return md5($password);
}


/**
 * _check_password密码注册格式检验
 * @param unknown $password
 * @param unknown $repassword
 * @return string
 */
function _check_login_password($password){
    if(strlen($password)<6){
        _alert_back("密码不得小于6位");
    }
    return md5($password);
}


function _check_modify_password($_string,$_min_num){
    if($_string==null){
        return null;
    }elseif(strlen($_string)<$_min_num){
        _alert_back("密码不得小于".$_min_num."位!");
    }else{
        return md5($_string);
    }
}

/**
 * _check_email邮箱格式验证
 * @param unknown $email
 * @return string|unknown
 */
function _check_email($email){
    if(!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$email)){
        _alert_back("邮箱格式不正确");
    }
    return _mysql_string($email);
}


function _check_gender($_string){
    if($_string!='boy' && $_string!='girl'){
        _alert_back("非法操作");
    }
    return _mysql_string($_string);
}

function _check_face($_string){
    return _mysql_string($_string);
}



/**
 * check_mobilphone手机号格式验证
 * @param unknown $_mobilephone
 * @return unknown
 */
function check_mobilphone($_mobilephone){
    if(!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/",$_mobilephone)){
        _alert_back("手机号格式不正确");
    }
    return $_mobilephone;
}


function _check_content($_str){
    if(mb_strlen($_str,'utf-8')>200){
        _alert_back("短信内容不得大于200");
    }
    return $_str;
}

function _check_post_title($_string,$_min,$_max){
    if(mb_strlen($_string,'utf-8')>40 || mb_strlen($_string,'utf-8')<2){
        _alert_back("文章标题不得小于2位或大于40位");
    }
    return $_string;
}

function _check_post_content($_str){
    if(mb_strlen($_str,'utf-8')<10){
        _alert_back("内容不得小于10位");
    }
    return $_str;
}

function _check_autograph($_str){
    if(mb_strlen($_str,'utf-8')>200){
        _alert_back("内容不得大于200位");
    }
    return $_str;
}


function _check_dirname($_name){
    $_name=trim($_name);
    if(mb_strlen($_name,'utf-8') < 2 || mb_strlen($_name,'utf-8')>20){
        _alert_back("名称长度不得小于2位或大于20位");
    }
    $pattern='/[<>\'\"\ ]/';
    if(preg_match($pattern, $_name)){
        _alert_back("名称不得包含敏感字符");
    }
    return _mysql_string($_name);
}


function _check_photo_password($password){
    if(strlen($password)<6){
        _alert_back("密码不得小于6位");
    }
    return md5($password);
}


function _check_url($_str){
    if(empty($_str)){
        _alert_back('地址不能为空');
    }
    return $_str;
}