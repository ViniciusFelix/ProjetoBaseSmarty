/* Máscaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
//Essa fun��o � utilizada pela Fun��o maskEvent
//Modo de Usar: <script>document.write(mask('####/####','{$res[i].nu_contrato}'))</script> 
function mask(_mask, val) {
	var i, mki;
	var aux="";
	
	for(i=mki=0; i<val.length; i++, mki++) {
		if(_mask.charAt(mki)=='' || _mask.charAt(mki)=='#' || _mask.charAt(i)==val.charAt(i)) {
			aux+=val.charAt(i);
		} else {
			aux+=_mask.charAt(mki)+val.charAt(i);
			mki++;
		}
	}
	return aux;
}
//Fun��o Generica para Mascaras
//Modo de Usar: onKeyPress="return(maskEvent(this, '####/####',event))"
function maskEvent(field, _mask, event) {
	var key ='';
	var aux='';
	var len=0;
	var i=0;
	var strCheck = '0123456789';
	if(navigator.appName.indexOf("Netscape")!= -1)	 
		rcode= event.which;	 
	 else	 
		rcode= event.keyCode;	 
	
	if(rcode == 8) {
		return true;
	}
		
	if(rcode == 13 || rcode == 0 || field.value.length == _mask.length  ) {
		//Enter
		key=String.fromCharCode(rcode);
				
		if(rcode!=13 && rcode!=0) {
			return false;
		}
				
		return true;
	}
	
	//Obtenha valor chave de c�digo chave
	key=String.fromCharCode(rcode);
	
	if(strCheck.indexOf(key)==-1) {
		//Not a valid key
		return false;
	}
	
	aux=field.value+key;
	//window.alert(aux);
	aux=mask(_mask,aux);
	//window.alert(aux);
	field.value=aux;	
	return false;
}
function maskEvent2(field, _mask, event) {
	var key ='';
	var aux='';
	var len=0;
	var i=0;
	var strCheck = 'xX0123456789';
	if(navigator.appName.indexOf("Netscape")!= -1)	 
		rcode= event.which;	 
	 else	 
		rcode= event.keyCode;	 
	
	if(rcode == 8) {
		return true;
	}
		
	if(rcode == 13 || rcode == 0 || field.value.length == _mask.length  ) {
		//Enter
		key=String.fromCharCode(rcode);
				
		if(rcode!=13 && rcode!=0) {
			return false;
		}
				
		return true;
	}
	
	//Obtenha valor chave de c�digo chave
	key=String.fromCharCode(rcode);
	
	if(strCheck.indexOf(key)==-1) {
		//Not a valid key
		return false;
	}
	
	aux=field.value+key;
	//window.alert(aux);
	aux=mask(_mask,aux);
	//window.alert(aux);
	field.value=aux;	
	return false;
}

function currencyFormat(fld, milSep, decSep, e) {
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	var whichCode;
	if(navigator.appName.indexOf("Netscape")!= -1)	 
		whichCode = e.which;	 
	 else	 
		whichCode = e.keyCode;	
    if (whichCode == 13) return true;
    if (whichCode == 8) return true;	
    if (whichCode == 9) return true;	
    if (whichCode == 0) return true;

	if (whichCode == 13 || whichCode == 0) {		//Enter
		return true;  
	}
	key = String.fromCharCode(whichCode);  // Get key value from key code
	if (strCheck.indexOf(key) == -1) {
		return false;  // Not a valid key
	}
	var Max = parseInt(document.getElementById(fld.id).maxLength);
	len = parseInt(fld.value.length);
	if (len < Max) { 
		for(i = 0; i < len; i++) {
			if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) {
				break;
			}
		}
		aux = '';
		for(; i < len; i++) {
			if (strCheck.indexOf(fld.value.charAt(i))!=-1) {
				aux += fld.value.charAt(i);
			}
		}
		aux += key;
				
		len = aux.length;
		if (len == 0) {
			fld.value = '';
		} else if (len == 1) {
			fld.value = '0'+ decSep + '0' + aux;
		} else if (len == 2) {
			fld.value = '0'+ decSep + aux;
		} else if (len > 2) {
			aux2 = '';
	
			for (j = 0, i = len - 3; i >= 0; i--) {
				if (j == 3) {
					aux2 += milSep;
					j = 0;
				}
				aux2 += aux.charAt(i);
				j++;
			}
			fld.value = '';
			len2 = aux2.length;
			for (i = len2 - 1; i >= 0; i--) {
				fld.value += aux2.charAt(i);
			}
			fld.value += decSep + aux.substr(len - 2, len);
		}	
	}	
	return false;
}