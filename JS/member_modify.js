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
		//邮箱验证
		if(!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(form.email.value)){
			alert("邮箱格式不正确");
			form.email.focus();
			return false;
		}
		
		return true;
	};
};