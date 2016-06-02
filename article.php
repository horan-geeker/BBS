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
//定义常量，指定本页名称
define('SCRIPT','article');

//精华帖设置
if(isset($_GET['nice'])&&isset($_GET['id'])){
    $_id=_mysql_string($_GET['id']);
    _is_manage();
    //唯一标识符,防止伪造cookie
    if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1"))
        _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
    
    if($_GET['nice']=='on'){
        _query("UPDATE mj_article SET mj_nice=1 WHERE mj_id='$_id'");
        _alert_back('设置成功');
    }
    if($_GET['nice']=='off'){
        _query("UPDATE mj_article SET mj_nice=0 WHERE mj_id='$_id'");
        _alert_back('成功取消');
    }
}


//处理回帖请求
if(isset($_GET['action'])){
    if($_GET['action']=='reply'){
        if($_system['code']==1){
        //验证码
        _check_code($_POST['chk'],$_SESSION['authcode']);
        }
        //唯一标识符,防止伪造cookie
        if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1"))
            _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
        
        include ROOT_PATH.'include/check.func.php';
        $_var=array();
        //发帖写入数据库
        $_var['reid'] = $_POST['reid'];
        $_var['type'] = $_POST['type'];
        $_var['title'] = _check_post_title($_POST['title'],2,40);
        $_var['content']= _check_post_content($_POST['content']);
        $_var['username'] = $_COOKIE['username'];
        $_var=_mysql_string($_var);
        _query("insert into mj_article(
                                        mj_reid,
                                        mj_type,
                                        mj_title,
                                        mj_content,
                                        mj_username,
                                        mj_date
                                       )
                                value(
                                '{$_var['reid']}',
                                '{$_var['type']}',
                                '{$_var['title']}',
                                '{$_var['content']}',
                                '{$_var['username']}',
                                NOW()
                                )"
        );
        //判断是否修改成功
        if(_affected_rows()==1){
            //获取刚才产生的id
            _query("UPDATE mj_article SET mj_comment=mj_comment+1 WHERE mj_reid=0 AND mj_id='{$_var['reid']}'");
            _close();
            //_session_destory();
            _location('回帖成功','article.php?id='.$_var['reid']);
        }else{
            _close();
            //_session_destory();
            _alert_back('回帖失败！');
        }
    }else{
        echo "非法操作";
    }
}
//加载时数据处理
if(isset($_GET['id'])){
    $_id=_mysql_string($_GET['id']);
    //得到主题帖的内容
    if(!!$_rows = _fetch_array("SELECT * FROM mj_article WHERE mj_reid=0 AND mj_id='{$_id}'")){
        $_html=array();
        $_html['reid']=$_rows['mj_id'];
        $_html['username'] = $_rows['mj_username'];
        $_html['title'] = $_rows['mj_title'];
        $_html['type'] = $_rows['mj_type'];
        $_html['content'] = $_rows['mj_content'];
        $_html['read'] = $_rows['mj_read'];
        $_html['comment'] = $_rows['mj_comment'];
        $_html['nice'] = $_rows['mj_nice'];
        $_html['last_modify_date'] = $_rows['mj_last_modify'];
        $_html['date'] = $_rows['mj_date'];
        //累计阅读量
        _query("UPDATE mj_article SET mj_read=mj_read+1 WHERE mj_id='{$_id}'");
        
        //得到发帖人的信息
        if(!!$_rows=_fetch_array("SELECT 
                                        mj_id,
                                        mj_gender,
                                        mj_face,
                                        mj_email,
                                        mj_switch,
                                        mj_autograph
                                   FROM 
                                        mj_user 
                                  WHERE 
                                        mj_username='{$_html['username']}'
                                  ")){
            $_html['userid']=$_rows['mj_id'];
            $_html['gender']=$_rows['mj_gender'];
            $_html['face']=$_rows['mj_face'];
            $_html['email']=$_rows['mj_email'];
            $_html['switch']=$_rows['mj_switch'];
            $_html['autograph']=$_rows['mj_autograph'];
            $_html = _html($_html);
        }else{
            //这个用户已被删除
        }
        //创建全局变量进行分页处理
        global $_id;
        $_id='id='.$_html['reid'].'&';
        
        //主题帖子修改
        $_modify='';
        if(isset($_COOKIE['username'])&&$_COOKIE['username']==$_html['username']){
            $_modify='<a href="article_modify.php?id='.$_html['reid'].'">[修改]</a>';
        }
        
        //读取最后修改时间
        if($_html['last_modify_date'] != '0000-00-00 00:00:00'){
            $_html['last_modify_string'] = "本帖已由[".$_html['username']."]于"."{$_html['last_modify_date']}修改";
        }
        
        //个性签名
        if($_html['switch']==1){
            $_html['autograph_html']='<p class="autograph">'.$_html['autograph'].'</p>';
        }else{
            $_html['autograph_html']='';
        }
        
        //读取回帖
        global $_pagenum,$_pagesize;
        //后台分页处理，sql语句查找总条数，$_size（$_pagesize）每页显示的个数
        _page("SELECT mj_id FROM mj_article WHERE mj_reid='{$_html['reid']}'",8);
        //$_pagenum $_pagesize在函数_page中声明
        $_result=_query("SELECT
                                *
                            FROM
                                mj_article
                            WHERE
                                mj_reid='{$_html['reid']}'
                            ORDER BY
                                mj_date ASC
                            LIMIT 
                                $_pagenum,$_pagesize
            ");
        
    }else{
        _alert_back("无此帖子");
    }
}else{
        _alert_back("非法操作");
    }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/article.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>帖子详情</title>
<script type="text/javascript" src="JS/code.js"></script>
<script type="text/javascript" src="JS/article.js"></script>
</head>

<body>
<?php
require ROOT_PATH.'include/header.inc.php';
?>
<div id="article">
	<h2>帖子详情</h2>
	
	
	<?php if($_html['nice']==1){?>
	<img class="nice" src="image/icon/nice.png" alt="nice" />
	<?php }?>
	
	<?php
	//浏览量达到100，评论量达到10就是热帖
	   if($_html['read']>=100&&$_html['comment']>=5){
	?>
	<img class="hot" src="image/icon/hot.png" alt="hot" />
	<?php }?>
	
	
	<?php if(!isset($_GET['page'])||isset($_GET['page'])&&$_GET['page']==1){?>
	
	<div id="subject">
    	<dl>
    		<dd class="user">[楼主] <?php echo $_html['username']?>(<?php echo $_html['gender']?>)</dd>
    		<dt><img src="image/<?php echo $_html['face']?>.jpg" id="face" alt="<?php echo $_html['username']?>" /></dt>
    		<dd class="sendmsg" ><a href="javascript:;" name="message" id="<?php echo $_html['userid']?>">发消息</a></dd>
    		<dd class="addfriend"><a href="javascript:;" name="friend" id="<?php echo $_html['userid']?>">加为好友</a></dd>
    		<dd class="guest"><a href="javascript:;" name="text" id="<?php echo $_html['userid']?>">写留言</a></dd>
    		<dd class="flower"><a href="javascript:;" name="flower" id="<?php echo $_html['userid']?>">送  　花</a></dd>
    		<dd class="email">邮件：<?php echo $_html['email']?></dd>
    	</dl>
    	<div id="content">
    		<div id="user">
    		
    			<span>
    		<?php if(isset($_SESSION['admin'])){?>
    			<a href="?<?php echo $_id.'nice=on'?>">[设置精华]</a>
    			
    			<a href="?<?php echo $_id.'nice=off'?>">[取消精华]</a>
    		<?php }?>
    			<?php echo $_modify?> 1#
    			</span><?php echo $_html['username']?> | 发表于： <?php echo $_html['date']?>
    		</div>
    		<h3>主题： <?php echo $_html['title']?> <img id="title_icon" src="image/icon/icon<?php echo $_html['type']?>.png" />
    		<?php if(isset($_COOKIE['username'])){?>
    		<span><a href="#re_board" name="re" title="回复1楼的<?php echo $_html['username']?>">[回复]</a></span>
    		<?php }?>
    		</h3>
    		<div id="detail">
    			<?php echo _ubb($_html['content'])?>
    			<?php echo $_html['autograph_html']?>
    		</div>
    		<div id="read">
    			<?php 
    			if(isset($_html['last_modify_string']))
    			    echo $_html['last_modify_string'];
    			?>
    			<br/>
    			阅读量(<?php echo $_html['read']?>) 评论量(<?php echo $_html['comment']?>)
    		</div>
    	</div>
	</div>
	<?php }?>
	
	
	<?php 
	   $_i=1;
	   $_sofa=0;
	   while(!!$_rows = _fetch_array_list($_result)){
	       $_html['reusername']=$_rows['mj_username'];
	       $_html['type']=$_rows['mj_type'];
	       $_html['retitle']=$_rows['mj_title'];
	       $_html['content']=$_rows['mj_content'];
	       $_html['date']=$_rows['mj_date'];
	       //得到发帖人的信息
	       if(!!$_rows=_fetch_array("SELECT
                            	           mj_id,
                            	           mj_gender,
                            	           mj_face,
                            	           mj_email,
                            	           mj_switch,
                            	           mj_autograph
                            	       FROM
                            	           mj_user
                            	       WHERE
                            	           mj_username='{$_html['reusername']}'
	           ")){
	           $_html['userid']=$_rows['mj_id'];
	           $_html['gender']=$_rows['mj_gender'];
	           $_html['face']=$_rows['mj_face'];
	           $_html['email']=$_rows['mj_email'];
	           $_html['switch']=$_rows['mj_switch'];
	           $_html['autograph']=$_rows['mj_autograph'];
	           $_html = _html($_html);
	           //个性签名
                if($_html['switch']==1){
                    $_html['autograph_html']='<p class="autograph">'.$_html['autograph'].'</p>';
                }else{
                    $_html['autograph_html']='';
                }
    	       }else{
    	           //这个用户已被删除
    	       }
	       //楼层显示
	       $_i++;
	       
	 ?>
	<p class="line"></p>
	<div class="re">
    	<dl>
    		<dd class="user">
    		<?php
	           //楼主沙发显示
	           if($_i==2){
	               if($_html['reusername']==$_html['username']){
	                   echo '[楼主] ';
	               }else{
	                   echo '[沙发] ';
	               }
	           }
	           ?>
    		<?php echo $_html['reusername'].'('.$_html['gender'].')';?>
    		
	        </dd>
    		<dt><img src="image/<?php echo $_html['face']?>.jpg" id="face" alt="<?php echo $_html['reusername']?>" /></dt>
    		<dd class="sendmsg" ><a href="javascript:;" name="message" id="<?php echo $_html['userid']?>">发消息</a></dd>
    		<dd class="addfriend"><a href="javascript:;" name="friend" id="<?php echo $_html['userid']?>">加为好友</a></dd>
    		<dd class="guest"><a href="javascript:;" name="text" id="<?php echo $_html['userid']?>">写留言</a></dd>
    		<dd class="flower"><a href="javascript:;" name="flower" id="<?php echo $_html['userid']?>">送  　花</a></dd>
    		<dd class="email">邮件：<?php echo $_html['email']?></dd>
    	</dl>
    	<div id="content">
    		<div id="user">
    			<span><?php echo ($_i+($_page-1)*$_pagesize)?>#</span><?php echo $_html['reusername']?> | 发表于： <?php echo $_html['date']?>
    		</div>
    		<h3>主题： <?php echo $_html['retitle']?> <img id="title_icon" src="image/icon/icon<?php echo $_html['type']?>.png" />
    		<?php if(isset($_COOKIE['username'])){?>
    		<span><a href="#re_board" name="re" title="回复<?php echo ($_i+($_page-1)*$_pagesize)?>楼的<?php echo $_html['reusername']?>">[回复]</a></span>
    		<?php }?>
    		</h3>
    		<div id="detail">
    			<?php echo _ubb($_html['content'])?>
    			<?php echo $_html['autograph_html']?>
    		</div>
    	</div>
	</div>
	<?php }	?>
	<p class="line"></p>
	<?php _paging(1,'')?>
	<?php if(isset($_COOKIE['username'])){?>
	<div class="reply">
	<form method="post" action="?action=reply">
		<a name="re_board"></a>
		<dl>
    		<input type="hidden" value="<?php echo $_html['reid']?>" name="reid" />
    		<input type="hidden" value="<?php echo $_html['type']?>" name="type" />
			<dd>标  　题 ：<input type="text" name="title" class="text" value="RE:<?php echo $_html['title']?>" /></dd>
			<dd class="text">
				<?php 
				    require ROOT_PATH.'include/ubb.inc.php';
				?>
				<textarea name="content"></textarea>
			</dd>
			<dd>
			<?php if($_system['code']==1){?>验 证 码 ：
    			<input type="text" name="chk" class="text code" id="chkcode"/><img src="checkcode.php" id="code"/>
    			<?php }?>
    			<input type="submit" class="submit" value="发表帖子" />
			</dd>
		</dl>
	</form>	
	<?php }
	
	?>
	</div>
</div>


<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>