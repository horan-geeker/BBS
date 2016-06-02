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


//引用公共文件
require dirname(__FILE__).'/include/common.inc.php';

if(isset($_POST['chk'])){
    _check_code($_POST['chk'],$_SESSION['authcode']);
}else{
    session_start();//session保存验证码
    _code(100,30,4);//执行核心函数库中的验证码函数
}
?>
