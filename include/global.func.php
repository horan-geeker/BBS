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

/**
 * _is_manage 管理员登录验证
 */
function _is_manage(){
    if(!(isset($_COOKIE['username'])&&isset($_SESSION['admin']))){
        _alert_back("非法登录");
    }
}


/**
 * _runtime()用来获取程序执行耗时的
 * @access public
 * @
 * @return float
 */
function _runtime(){
    $_mtime=explode(' ',microtime());
    return $_mtime[0]+$_mtime[1];
}


function _timed($_pre_time,$_second){
    //限制发帖时间
    if(@time()-$_pre_time<$_second){
        _alert_back('请阁下休息'.$_second.'s再发帖');
    }
}

/**
 * _code()验证码函数
 * @access
 * @param int $width 验证码长度
 * @param int $height 验证码高度
 * @param int $n 验证码有几位组成
 * @return void 返回一个验证码
 */
function _code($width=100,$height=30,$n=4){
    
    $captch_code='';//准备保存验证码
    
    $image = imagecreatetruecolor($width,$height);//创建一张图片，宽100高30
    $bgcolor = imagecolorallocate( $image, 255, 255, 255 );//指定图片背景色
    imagefill( $image, 0, 0, $bgcolor );//将背景色填充到图片
    
    // 创建一个循环，循环200次
    // 在循环内，用GD库生成一个随机颜色
    // 在随机位置上画一个干扰点，颜色使用上面的随机颜色
    for($i=0;$i<$n;$i++){
        $fontsize=6;//验证码字体大小
        $fontcolor=imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));
        $data='abcdefghijklmnopqrstuvwxyz1234567890';
        $fontcontent=substr($data,rand(0,strlen($data)-1),1);
        $captch_code.=$fontcontent;//将四个码保存到该变量中
        $x=($i*$width/$n)+rand(5,10);
        $y=rand($height/5,$height/2);
        imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);//参数1.原图 2.字体大小 3.一个点xy的坐标 4.内容 5.字体颜色
    }
    for($i=0;$i<200;$i++){
        $pointcolor=imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
        imagesetpixel($image,rand(1,$width-1),rand(1,$height-1),$pointcolor);//设置干扰点的方法
    }
    for($i=0;$i<3;$i++)
    {
        $linecolor=imagecolorallocate($image,rand(80,220),rand(80,220),rand(80,220));
        imageline($image,rand(1,$width-1),rand(1,$height-1),rand(1,$width-1),rand(1,$height-1),$linecolor);//设置干扰线的元素1.操作图 2.设置两个点的坐标，两点确定一条线 3.颜色
    }
    
    header( 'content-type: image/png' );//指定图片类型
    imagepng( $image );//输出图片
    imagedestroy( $image );//释放资源
    
    $_SESSION['authcode']=$captch_code;//保存在session
}

/**
 * _alert_back警告返回
 * @param unknown $_info
 */
function _alert_back($_info){
    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    echo "<script type='text/javascript'>alert('".$_info."');history.back();</script>";
    exit();
}


/**
 * _alert_back警告关闭
 * @param unknown $_info
 */
function _alert_close($_info){
    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    echo "<script type='text/javascript'>alert('".$_info."');window.close();</script>";
    exit();
}


/**
 * _check_code检测验证码
 * @param unknown $var_code
 * @param unknown $session_code
 */
function _check_code($var_code,$session_code){
    if($var_code!=$session_code){
        _alert_back("验证码不正确");
    }
}


/**
 * 
 */
function _location($info,$url){
    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    echo "<script type='text/javascript'>alert('$info');window.location='$url';</script>";
    exit();
}


/**
 * _mysql_string 判断魔术引号是否开启，并对字符串或数组转义
 * @param unknown $str
 * @return string|unknown
 */
function _mysql_string($_str){
    if(!get_magic_quotes_gpc()){
        if(is_array($_str)){
            foreach ($_str as $_key=>$_value){
                $_str[$_key]=_mysql_string($_value);
            }
        }else{
            return mysql_real_escape_string($_str);
        }
    }
    return $_str;
}


/**
 * _login_state登录状态判断
 */
function _login_state(){
    if(isset($_COOKIE['username'])){
        _alert_back("登录状态无法进行本操作");
    }
}



/**
 * 
 * 
 */
function _session_destory(){
    if(@session_start()){    
        session_destroy();
    }
}


function _unsetcookie(){
    setcookie('username','',time()-1);
    setcookie('uniqid','',time()-1);
    _session_destory();
}

/**
 * _title 短信以标题的形式处理
 * @param unknown $_str
 * @return string
 */
function _title($_str,$_len){
    if(mb_strlen($_str,'utf-8')>$_len){
        $_str = mb_substr($_str,0,$_len,'utf-8').'...';
    }
    return $_str;
}


function _html($_str){
    if(is_array($_str)){
        foreach ($_str as $_key=>$_value){
            $_str[$_key]=_html($_value);
        }
        return $_str;
    }else{
        return htmlspecialchars($_str);
    }
}

/**
 * _paging 分页函数(前端) 1是数字分页 2是文字分页
 * @param int $_type
 * return 
 */
function _paging($_type,$_content){
    global $_page,$_pageabsolute,$_num,$_id;
    if($_type==1){
        echo '<div id="page_num">';
        echo '<ul>';
        for($i=1;$i<=$_pageabsolute;$i++){
            if($_page==$i){
                echo "<li><a href='".SCRIPT.".php?".$_id."page=$i' class='selected'>$i</a></li>";
            }else{
                echo "<li><a href='".SCRIPT.".php?".$_id."page=$i'>$i</a></li>";
            }
        }
        echo "</ul>";
        echo "</div>";
    }elseif($_type==2){
        echo '<div id="page_text">';
        echo '<ul>';
        echo '<li>'.$_page."/".$_pageabsolute.'页 |</li>';
        echo '<li>共有<strong>'.$_num.'</strong>'.$_content.' |</li>';
        			//在首页和尾页的时候不显示对应首页（尾页）的超链接
        			 if($_page==1){
            			    echo "<li>首页 |</li>";
            			    echo "\n";
            			    echo "<li>上一页 |</li>";
            			    echo "\n";
        			 }
                     else{
                         echo "<li><a href='".SCRIPT.".php'>首页 |</a></li>";
                         echo "\n";
                         echo "<li><a href='".SCRIPT.".php?".$_id."page=".($_page-1)."'>上一页 |</a></li>";
                         echo "\n";
                     }
                     if($_page==$_pageabsolute){
                         echo "<li>下一页 |</li>";
                         echo "\n";
                         echo "<li>尾页</li>";
                         echo "\n";
                     }
                     else{
                         echo "<li><a href='".SCRIPT.".php?".$_id."page=".($_page+1)."'>下一页|</a></li>";
                         echo "\n";
                         echo "<li><a href='".SCRIPT.".php?".$_id."page=".($_pageabsolute)."'>尾页</a></li>";
                         echo "\n";
                     }
        	echo '</ul>';
        	echo '</div>';
    }
}

/**
 * _page 每页(后台)处理
 * @param unknown $_pagesize每页显示的个数
 */
function _page($_sql,$_size){
    global $_page,$_pagesize,$_pagenum,$_pageabsolute,$_num;
    //默认打开page=1
    if(isset($_GET['page'])){
        $_page=$_GET['page'];
        if(empty($_page) || $_page<=0 || !is_numeric($_page)){
            $_page=1;
        }else{
            $_page=intval($_page);
        }
    }else{
        $_page=1;
    }
    //得到所有的数据的总数
    $_num = mysql_num_rows(_query($_sql));
    //从数据库中得到用户的好友信息
    $_pagesize=$_size;
    
    if($_num==0){
        //如果数据库为0的时候，默认有一页
        $_pageabsolute=1;
    }else{
        //得到最终有多少页
        $_pageabsolute=ceil($_num/$_pagesize);
    }
    if($_page>$_pageabsolute){
        $_page=$_pageabsolute;
    }
    $_pagenum=($_page-1)*$_pagesize;//每页显示的第一个在数据库LIMIT查询的起始位置
    
}


/**
 * _uniqid判断唯一标识符是否正常
 * @param unknown $_mysql_uniqid
 * @param unknown $_cookie_uniqid
 */
function _uniqid($_mysql_uniqid,$_cookie_uniqid){
    if($_mysql_uniqid!=$_cookie_uniqid){
        _unsetcookie();
        _alert_back("非法登录");
    }
}

/**
 * 
 * @param unknown $_file
 * @param unknown $_array
 */
function _set_xml($_file,$_array){
    $_fp=fopen("new.xml","w");
    if(!$_fp){
        exit("文件错误");
    }
    //防止多人同时操作，进行锁定
    flock($_fp,LOCK_EX);
    $string="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
    fwrite($_fp,$string,strlen($string));
    $string="<vip>\r\n";
    fwrite($_fp,$string,strlen($string));
    $string="\t<id>{$_array['id']}</id>\r\n";
    fwrite($_fp,$string,strlen($string));
    $string="\t<username>{$_array['username']}</username>\r\n";
    fwrite($_fp,$string,strlen($string));
    $string="\t<sex>{$_array['gender']}</sex>\r\n";
    fwrite($_fp,$string,strlen($string));
    $string="\t<face>{$_array['face']}</face>\r\n";
    fwrite($_fp,$string,strlen($string));
    $string="\t<email>{$_array['email']}</email>\r\n";
    fwrite($_fp,$string,strlen($string));
    $string="</vip>";
    fwrite($_fp,$string,strlen($string));
    flock($_fp,LOCK_UN);
}


function _get_xml($_xmlfile){
    $_html=array();
    //读取xml文件
    if(file_exists($_xmlfile)){
        $_xml_content=file_get_contents($_xmlfile);
        preg_match_all('/<vip>(.*)<\/vip>/s', $_xml_content,$_dom);
        //print_r($_dom);
        foreach ($_dom[1] as $_value){
            preg_match_all('/<id>(.*)<\/id>/s',$_value,$_id);
            preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
            preg_match_all('/<sex>(.*)<\/sex>/s',$_value,$_sex);
            preg_match_all('/<face>(.*)<\/face>/s',$_value,$_face);
            preg_match_all('/<email>(.*)<\/email>/s',$_value,$_email);
            $_html['id']=$_id[1][0];
            $_html['username']=$_username[1][0];
            $_html['sex'] = $_sex[1][0];
            $_html['face'] = $_face[1][0];
            $_html['email'] = $_email[1][0];
        }
    }else{
        echo "xml error";
    }
    return $_html;
}


function _ubb($_string){
    $_string = nl2br($_string);
    //粗体
    $_string = preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
    //斜体
    $_string = preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$_string);
    //下划线
    $_string = preg_replace('/\[u\](.*)\[\/u\]/U','<span style="text-decoration:underline">\1</span>',$_string);
    //删除线
    $_string = preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through">\1</span>',$_string);
    //字体颜色
    $_string = preg_replace('/\[color=(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$_string);
    //字体大小
    $_string = preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px">\2</span>',$_string);
    //url
    $_string = preg_replace('/\[url\](.*)\[\/url\]/U','<a href="\1" style="text-decoration:none">\1</a>',$_string);
    //email
    $_string = preg_replace('/\[email\](.*)\[\/email\]/U','<a href="mailto:\1" style="text-decoration:none">\1</a>',$_string);
    //图片
    $_string = preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1" alt="pic" />',$_string);
    //flash
    $_string = preg_replace('/\[flash\](.*)\[\/flash\]/U','<embed style="width:480px;height:400px;" src="\1" />',$_string);
    return $_string;
}


function _thumb($_filename,$_percent){
    //生成png标头文件
    header('Content-type:image/png');
    
    //获取文件扩展名,拼接文件名
    $_suffix = explode('.', $_filename);
    switch ($_suffix[1]){
        case 'jpg':
            //按照已有的图片创建一个画布
            $_img = imagecreatefromjpeg($_filename);
            break;
        case 'png':
            //按照已有的图片创建一个画布
            $_img = imagecreatefrompng($_filename);
            break;
        case 'gif':
            //按照已有的图片创建一个画布
            $_img = imagecreatefromgif($_filename);
            break;
    }
    //得到图片宽和高
    list($_width,$_height)=getimagesize($_filename);
    //创建新的缩略图
    if($_width>1000 || $_height>1000){
        $_new_width=$_width*($_percent-0.15);
        $_new_height=$_height*($_percent-0.15);
    }elseif($_width<100 || $_height<100){
        $_new_width=$_width;
        $_new_height=$_height;
    }else{
        $_new_width=$_width*$_percent;
        $_new_height=$_height*$_percent;
    }
    //创建新画布
    $_new_img = imagecreatetruecolor($_new_width, $_new_height);
    
    //将原图采集后重新复制到新图上
    imagecopyresampled($_new_img, $_img, 0, 0, 0, 0, $_new_width, $_new_height, $_width, $_height);
    //显示
    imagepng($_new_img);
    //释放
    imagedestroy($_img);
    imagedestroy($_new_img);
}

function rmdir_r($dirname){
    if(!is_dir($dirname)){
        return false;
    }
    $handle=@opendir($dirname);
    while(($file = @readdir($handle)) !== false){
        if($file != '.' && $file != '..'){
            $dir = $dirname . '/' . $file;
            is_dir($dir) ? rmdir_r($dir) : @unlink($dir);
        }
    }
    closedir($handle);
    return rmdir($dirname) ;
}
?>
