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
<script type="text/javascript" src="JS/skin.js"></script>
<div id="header">
	<h1>天地不仁</h1>
	<p>以万物为刍狗......</p>
	<ul>
		<li><a href="index.php">首页　</a></li>
		
		<?php 
		  if(isset($_COOKIE['username'])){
		      echo "<li><a href='member.php'>".$_COOKIE['username']."●个人中心".$_unread."</a></li>";
		      echo "\n";
		  }
		  else{
		      echo "<li><a href='login.php'>登录</a></li>　";
		      echo "\n";
		      echo "<li><a href='register.php'>注册</a></li>  　";
		      echo "\n";
		  }
	      echo "<li><a href='blog.php'>博友</a></li>";
	      echo "\n";
	      echo "<li><a href='photo.php'>相册</a></li>";
	      echo "\n";
		?>
		
		<li>
			<a href="javascript:;" class="skin" onmouseover='inskin()' onmouseout='outskin()'>风格</a>
    		<dl id="skin" style="display: none" onmouseover='inskin()' onmouseout='outskin()'>
    			<dd><a href="skin.php?id=1">1号皮肤</a></dd>
    			<dd><a href="skin.php?id=1">2号皮肤</a></dd>
    			<dd><a href="skin.php?id=1">3号皮肤</a></dd>
    		</dl>
		</li>
		<?php 
		  if(isset($_COOKIE['username'])){
		      if(isset($_SESSION['admin'])){
		          echo '<li><a href="manage.php">管理</a></li>';
		      }
		      echo "<li><a href='logout.php'>退出</a></li>";
		  }
		  
		  
		?>
		
	</ul>
</div>