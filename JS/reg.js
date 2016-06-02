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

window.onload=function(){
	code();
	
	var form=document.getElementsByTagName('form')[0];
	form.onsubmit = function(){
		//用户名验证
		if(form.username.value.length<2 ||form.username.value.length>20){
			alert("用户名不得小于2位或者大于20位");
			form.username.focus();
			return false;
		}
		if(/[<>\'\"\ \　]/.test(form.username.value)){
			alert("用户名包含非法字符！");
			form.username.focus();
			return false;
		}
		//密码验证
		if(form.password.value.length<6){
			alert("密码不得小于6位！");
			form.password.value='';
			form.password.focus();
			return false;
		}
		if(form.password.value != form.repassword.value){
			alert("两次输入的密码不一致！");
			form.repassword.value='';
			form.repassword.focus();
			return false;
		}
		//邮箱验证
		if(!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(form.email.value)){
			alert("邮箱格式不正确");
			form.email.value='';
			form.email.focus();
			return false;
		}
		
		//ajax验证码验证
		/*var request = new XMLHttpRequest();
		request.open("POST", "checkcode.php");
		var data = "chk=" + document.getElementById("chkcode").value;
		request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		request.send(data);
		request.onreadystatechange = function() {
			if (request.readyState===4) {
				if (request.status===200) { 
					alert("发送成功");
				} else {
					alert("发生错误：" + request.status);
					return false;
				}
			} 
		}*/
		//验证码长度验证
		if(form.chk.value.length!=4){
			alert("验证码必须为4位");
			form.chk.value='';
			form.chk.focus();
			return false;
		}
		
		return true;
	}
};

