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
define('SCRIPT','photo_detail');




//评论处理
if(isset($_GET['action'])&&$_GET['action']=='rephoto'){
    if($_system['code']==1){
        //验证码
        _check_code($_POST['chk'],$_SESSION['authcode']);
    }
    //唯一标识符,防止伪造cookie
    if(!!$_rows = _fetch_array("SELECT mj_uniqid FROM mj_user WHERE mj_username='{$_COOKIE['username']}' LIMIT 1")){
        _uniqid($_rows['mj_uniqid'],$_COOKIE['uniqid']);
    }
    require_once 'include/check.func.php';
    $_html = array();
//  插入的是图片的ID
    $_html['id'] = $_POST['id'];
//  相册的sid这里暂时没用到
    $_html['sid'] = $_POST['sid'];
    $_html['title'] = _check_post_title($_POST['title'],2,40);
    $_html['content']= _check_post_content($_POST['content']);
    $_html['username'] = $_COOKIE['username'];
    $_html=_mysql_string($_html);
    
    _query("insert into mj_photo_comment(
                                mj_sid,
                                mj_title,
                                mj_content,
                                mj_username,
                                mj_date
                                )
                                value(
                                '{$_html['id']}',
                                '{$_html['title']}',
                                '{$_html['content']}',
                                '{$_html['username']}',
                                NOW()
                                )"
    );
    //判断是否修改成功
    if(_affected_rows()==1){
        _query("UPDATE mj_photos SET mj_comment=mj_comment+1 WHERE mj_id='{$_html['id']}'");
        _close();
        //_session_destory();
        _location('评论成功','photo_detail.php?id='.$_html['id']);
    }else{
        _close();
        //_session_destory();
        _alert_back('评论失败！');
    }
}



//页面加载
if(isset($_GET['id'])){
    //图片id
    $_id = _mysql_string($_GET['id']);
    
    
    //得到图片的信息
    if(!!$_rows = _fetch_array("SELECT 
                                        *
                                  FROM 
                                        mj_photos 
                                  WHERE 
                                        mj_id='$_id' 
                                  LIMIT 
                                        1
        ")){
        $_var = array();
        //得到相册id
        $_var['id'] = $_rows['mj_id'];
        $_var['sid'] = $_rows['mj_sid'];
        $_var['name'] = $_rows['mj_name'];
        $_var['url'] = $_rows['mj_url'];
        $_var['user'] = $_rows['mj_user'];
        $_var['content'] = $_rows['mj_content'];        
        $_var['read'] = $_rows['mj_read'];
        $_var['comment'] = $_rows['mj_comment'];
        $_var['date'] = $_rows['mj_date'];
        $_var = _html($_var);
    }else{
        _alert_back('不存在此图片');
    }
    
    
    //防止加密相册图片通过id访问
    //先取得sid,目录
    //判断目录是否是加密的
    //如果是加密，判断是否有对应的cookie存在，并且合法
    //管理员不受限制
    if(!!$_is_encrypt = _fetch_array("SELECT mj_name,mj_type,mj_id FROM mj_photo_dir WHERE mj_id='{$_rows['mj_sid']}'")){
        if(!isset($_SESSION['admin'])){
            if($_is_encrypt['mj_type']==1 
                && 
                @$_COOKIE['photo'.$_is_encrypt['mj_id']] != $_is_encrypt['mj_name']
                ){
                _alert_back('非法读取');
            }
        }
    }else{
        _alert_back('非法读取');
    }
    
    
    //累计阅读量
    _query("UPDATE mj_photos SET mj_read=mj_read+1 WHERE mj_id='$_id'");
    
    
    
    //读取回复
    global $_pagenum,$_pagesize;
    //后台分页处理，sql语句查找总条数，$_size（$_pagesize）每页显示的个数
    _page("SELECT mj_id FROM mj_photo_comment WHERE mj_sid='$_id'",8);
    //$_pagenum $_pagesize在函数_page中声明
    $_result=_query("SELECT
                            *
                        FROM
                            mj_photo_comment
                       WHERE
                            mj_sid='$_id'
                    ORDER BY
                            mj_date ASC
                       LIMIT
                            $_pagenum,$_pagesize
        ");
    
    //取上一个的id
    $_pre_id = _fetch_array("SELECT min(mj_id) AS id FROM mj_photos WHERE mj_sid='{$_var['sid']}' AND mj_id>'$_id'");
    //取下一个的id
    $_next_id = _fetch_array("SELECT max(mj_id) AS id FROM mj_photos WHERE mj_sid='{$_var['sid']}' AND mj_id<'$_id'");
   
}else{
    _alert_back("非法操作");
}
        
        
        
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="image/icon.jpg"/>
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/photo_detail.css" />
<link rel="stylesheet" type="text/css" href="css/article.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片展示</title>
<script type="text/javascript" src="JS/photo.js"></script>
<script type="text/javascript" src="JS/code.js"></script>
<script type="text/javascript" src="JS/article.js"></script>
</head>

<body>
<?php
require ROOT_PATH.'include/header.inc.php';
?>
<div id="photo_detail">
	<h2>图片详情</h2>
	<div class="detail">
		<div class="name">
			<?php echo $_var['name']?>
		</div>
		<div class="photo_img">
		<?php if(!empty($_pre_id['id'])){?>
			<a href="photo_detail.php?id=<?php echo $_pre_id['id']?>">上一页</a>
		<?php }?>	
			<img src="<?php echo $_var['url']?>" />
		<?php if(!empty($_next_id['id'])){?>	
			<a href="photo_detail.php?id=<?php echo $_next_id['id']?>">下一页</a>
		<?php }?>
		</div>
		<div>
			浏览量（<strong><?php echo $_var['read']?></strong>）
			评论量（<strong><?php echo $_var['comment']?></strong>）
			发表于：<?php echo $_var['date']?>			
			上传者：<?php echo $_var['user']?>
		</div>
		<div>
			图片介绍：<?php echo $_var['content']?>
		</div>
	</div>
	
	
	<p class="line"></p>
	
	
	<?php if(!isset($_GET['page'])||isset($_GET['page'])&&$_GET['page']==1){?>
	<?php 
	   $_i=0;
	   while(!!$_rows = _fetch_array_list($_result)){
	       $_html['reusername']=$_rows['mj_username'];
	       $_html['title']=$_rows['mj_title'];
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
	<div class="re">
    	<dl>
    		<dd class="user">
    		
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
    		<div id="detail">
    			<?php echo $_html['content']?>
    			<?php echo $_html['autograph_html']?>
    		</div>
    	</div>
	</div>
	<p class="line"></p>
	<?php }	?>
	<?php _paging(1,'')?>
	<?php }	?>
	
	
	<?php if(isset($_COOKIE['username'])){?>
	<div class="reply">
	<form method="post" action="?action=rephoto">
		<dl class="rephoto">
    		<input type="hidden" value="<?php echo $_var['sid']?>" name="sid" />
    		<input type="hidden" value="<?php echo $_var['id']?>" name="id" />
			<dd>标  　题 ：<input type="text" name="title" class="text" value="RE:<?php echo $_var['name']?>" /></dd>
			<dd class="text">
				<?php 
				    require ROOT_PATH.'include/ubb.inc.php';
				?>
				<textarea name="content"></textarea>
			</dd>
			<dd>
			<?php if($_system['code']==1){?>
				验 证 码 ：
    			<input type="text" name="chk" class="text code" id="chkcode"/><img src="checkcode.php" id="code"/>
    			<?php }?>
    			<input type="submit" class="submit" value="发表评论" />
			</dd>
		</dl>
	</form>	
	<?php }?>
	</div>
</div>


<?php 
    require ROOT_PATH.'include/footer.inc.php';
?>
</body>
</html>