function tabular(e,obj) {
  tecla=(document.all) ? e.keyCode : e.which;
  if(tecla!=13 && tecla!=38 ) return;
  frm=obj.form;
  for(i=0;i<frm.elements.length;i++)
    if(frm.elements[i]==obj) {
      if (i==frm.elements.length-1) i=-1;
      break }
  if(tecla==13) frm.elements[i+1].focus();
  if(tecla==38) frm.elements[i-1].focus();
  return false;
}

function validaFechaDDMMAAAA(fecha){
	var dtCh= "-";
	var minYear=1900;
	var maxYear=2100;
	function isInteger(s){
		var i;
		for (i = 0; i < s.length; i++){
			var c = s.charAt(i);
			if (((c < "0") || (c > "9"))) return false;
		}
		return true;
	}
}
