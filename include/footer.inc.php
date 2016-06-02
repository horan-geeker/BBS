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
mysql_close();
?>

<div id="footer">
<p>运行耗时:<?php echo round(_runtime()-$start_time,3)?>秒</p>
<p>Power By Hejunwei (c) hejunweimake@gmail.com</p>
</div>