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
require 'include/common.inc.php';

if(isset($_GET['id'])){
    //图片id
    $_id = _mysql_string($_GET['id']);
    if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
            //防止伪造cookie
            _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
            require_once ROOT_PATH.'include/check.func.php';
            $_html = array();
            //取得图片的发布人
            if(!!$_rows = _fetch_array("SELECT mj_user,mj_url FROM mj_photos WHERE mj_id='$_id'")){
                $_html['user'] = $_rows['mj_user'];
                $_html['url'] = $_rows['mj_url'];
                if($_html['user']==$_COOKIE['username'] || isset($_SESSION['admin'])){
                    //首先删除图片的数据库
                    _query("DELETE FROM mj_photos WHERE mj_id=$_id");
                    
                    //判断是否删除成功
                    if(_affected_rows()==1){
                        //删除图片的物理地址
                        if(file_exists($_html['url'])){
                            unlink($_html['url']);
                            _close();
                            _alert_back('恭喜你，删除成功');
                        }else{
                            _alert_back('本地不存在此图片');
                        }
                    }else{
                        _close();
                        _alert_back('删除失败！');
                    }
                    
                }else{
                    _alert_back('你没有权限删除！');
                }
            
            }else{
                _alert_back('此图片不存在');
            }
            
            
    }
}else{
    _alert_back('非法操作');
}
?>