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
	var del=document.getElementById("del");
	del.onclick=function(){
		if(confirm("确定要删除吗?")){
			location.href="?id="+del.name+"&action=delete";
		}
	};
	
};
