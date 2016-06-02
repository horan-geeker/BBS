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

//mysql config
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'root');
define('DB_NAME', 'majialichen');

/**
 * _connect() 连接数据库
 * @return void
 */
function _connect(){
    global $_conn;
    if(!$_conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD)){
        exit('mysql connect error');
    }
}

/**
 * 
 */
function _select_db(){
    if(!mysql_select_db(DB_NAME)){
        exit('database name error');
    }
}


/**
 * 
 */
function _set_names(){
    if(!mysql_query('set names UTF8')){
        exit('charset error');
    }
}


function _query($_sql){
    if(!$result = mysql_query($_sql)){
        exit(mysql_error());
    }
    return $result;
}


/**
 * _affect_row判断sql语句执行后是否产生实际影响
 * @return number
 */
function _affected_rows(){
    return mysql_affected_rows();
}

/**
 * _fetch_array只能获取一条数据组
 * @param unknown $_sql
 */
function _fetch_array($_sql){
    return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}


/**
 * _fetch_array_list能获取一组数据组(因为之前生成了$_result资源句柄)
 * @param SQL handle $_result
 */
function _fetch_array_list($_result){
    return mysql_fetch_array($_result,MYSQL_ASSOC);
}

function _is_repeat($_sql,$_info){
    if(_fetch_array($_sql)){
        _alert_back($_info);
    }
}


function _insert_id(){
    return mysql_insert_id();
}

function _close(){
    mysql_close();
}