function code(){
	var code=document.getElementById('code');
	code.onclick = function(){
		this.src="checkcode.php?tm="+Math.random();
	};
};