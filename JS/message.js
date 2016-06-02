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
		//验证码验证
		if(form.chk.value.length==0){
			alert("验证码不得为空");
			form.chk.focus();
			return false;
		}
		//内容验证
		if(form.content.value.length<1 || form.content.value.length>200){
			alert("短信内容不得为空或大于200");
			form.content.focus();
			return false;
		}
		return true;
	};
	
};