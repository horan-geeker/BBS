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
	var all=document.getElementById("all");
	var form=document.getElementsByTagName('form')[0];
	all.onclick=function(){
		for(var i=0;i<form.elements.length-1;i++){
			if(form.elements[i].name!='checkall'){
				form.elements[i].checked=this.checked;
			}
		}
	};
	
	form.onsubmit=function(){
		if(confirm('确定删除这些数据吗？')){
			return true;
		}else{
			return false;
		}
		
	};
};
