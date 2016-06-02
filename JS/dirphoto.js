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
function centerWindow(url,name,height,width){
	var top=(screen.height-height)/2;
	var left=(screen.width-width)/2;
	window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
};

window.onload=function(){
	var form=document.getElementsByTagName("form")[0];
	var pass=document.getElementById("pass");
	form[2].onclick=function(){
		pass.style.display='none';
	};
	form[3].onclick=function(){
		pass.style.display='block';
	};
	
	form.onsubmit=function(){
		if(form.name.value.length<2 ||form.name.value.length>20){
			alert("相册名不得小于2位或者大于20位");
			form.name.focus();
			return false;
		}
		if(form[2].checked){
			if(form.password.value.length<6){
				alert("密码不得小于6位");
				form.password.value='';
				form.password.focus();
				return false;
			}
		}
		return true;
	};
	//add_img
	var up=document.getElementById("up");
	up.onclick=function(){
		centerWindow('updirimg.php','up','200','500');
	};
	
	
};