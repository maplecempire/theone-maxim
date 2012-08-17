function q(id) {
	if(document.getElementById(id)){
		obj=document.getElementById(id);
	}else{
		obj=document.getElementsByName(id);
		if(obj){
			obj=obj[0];
		}
	}
	return obj;
}