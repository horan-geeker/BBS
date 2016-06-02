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
function content(string){
	var form=document.getElementsByTagName("form")[0];
	form.content.value+=string;
};
function font(size){
	document.getElementsByTagName("form")[0].content.value += '[size='+size+'][/size]';
};
function showcolor(value){
	content('[color='+value+'][/color]');
};
window.onload=function(){
	code();
	var ubb=document.getElementById("ubb");
	var ubbs=document.getElementsByName("ubbs");
	var form=document.getElementsByTagName("form")[0];
	form.onsubmit = function(){
		if(form.title.value.length<2 ||form.title.value.length>20){
			alert("标题不得小于2位或者大于20位");
			form.title.value='';
			form.title.focus();
			return false;
		}
		if(form.content.value.length<10){
			alert("内容不得小于10位");
			form.content.focus();
			return false;
		}
		if(form.chk.value.length!=4){
			alert("验证码必须为4位");
			form.chk.value='';
			form.chk.focus();
			return false;
		}
		return true;
	};
	var font=document.getElementById("font");
	var html=document.getElementsByTagName('html')[0];
	//在点击其他地方的时候自动关闭已经display:block的
	html.onmouseup=function(){
		font.style.display='none';
		color.style.display='none';
	};
	//点击后显示
	ubbs[2].onclick=function(){
		var url=prompt('请输入超链接网址','www.');
		if(url){
			content('[url]'+url+'[/url]');
		}
	};
	
	ubbs[6].onclick=function(){
		font.style.display='block';
	};
	
	ubbs[8].onclick=function(){
		content('[b][/b]');
	};
	ubbs[9].onclick=function(){
		content('[i][/i]');
	};
	ubbs[10].onclick=function(){
		content('[u][/u]');
	};
	ubbs[11].onclick=function(){
		content('[s][/s]');
	};
	ubbs[12].onclick=function(){
		var color=document.getElementById('color');
		color.style.display='block';
	};
	
};

