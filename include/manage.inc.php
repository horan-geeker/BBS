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
?>
<div id="member_sidebar">
		<h2>管理导航</h2>
		<dl>
			<dt>系统管理</dt>
			<dd><a href="manage.php">后台设置</a></dd>
			<dd><a href="manage_set.php">系统设置</a></dd>
		</dl>
		<dl>
			<dt>会员管理</dt>
			<dd><a href="manage_member.php">会员列表</a></dd>
			<dd><a href="manage_job.php">职务设置</a></dd>
		</dl>
</div>