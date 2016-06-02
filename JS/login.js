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
			alert("用户名不得小于2位或者大于20位!");
			form.username.value='';
			form.username.focus();
			return false;
		}
		if(/[<>\'\"\ ]/.test(form.username.value)){
			alert("用户名包含非法字符！");
			form.username.value='';
			form.username.focus();
			return false;
		}
		return true;
	};
	
};

