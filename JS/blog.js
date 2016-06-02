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
	//发送消息
	var msg=document.getElementsByName('message');
	//加为好友
	var friend=document.getElementsByName('friend');
	//送花
	var flower=document.getElementsByName('flower');
	for(var i=0;i<msg.length;i++){
		msg[i].onclick=function(){
			centerWindow('message.php?id='+this.id,'message',300,400);
		};
		friend[i].onclick=function(){
			centerWindow('friend.php?id='+this.id,'friend',300,400);
		};
		flower[i].onclick=function(){
			centerWindow('flower.php?id='+this.id,'flower',300,400);
		}
	}
	
};