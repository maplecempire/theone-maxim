function number_format(str,decimal,prefix){
    var prefix = prefix || '';
	var decimal = decimal || 0;
    var nStr=''+str;
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
	if(decimal>0){
		if(x2.length>(decimal+1)){
			x2=x2.substr(0, decimal+1);
		}else if(x2.length<(decimal+1)){
			if(x2.length==0){
				x2='.';
			}
			for(var i=x2.length;i<(decimal+1);i++){
				x2+='0';
			}
		}
	}else{
		x2='';
	}
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    return prefix + x1 + x2;
}