/* Caracteres Unicode
\u00e1 = á
\u00e9 = é
\u00ed = í
\u00f3 = \u00f3
\u00fa = ú
\u00c1 = Á
\u00c9 = É
\u00cd = Í
\u00d3 = Ó
\u00da = Ú
\u00f1 = ñ
\u00d1 = Ñ
¿ = 0191
*/

/**************************************************************
Mscara de entrada. Script creado por Tunait! (21/12/2004)
Si quieres usar este script en tu sitio eres libre de hacerlo con la condicin de que permanezcan intactas estas lneas, osea, los crditos.
No autorizo a distribur el cdigo en sitios de script sin previa autorizacin
Si quieres distriburlo, por favor, contacta conmigo.
Ver condiciones de uso en http://javascript.tunait.com/
tunait@yahoo.com 
****************************************************************/

function mascara(d,sep,pat,nums){
var patron = new Array(2,2,4)
var patron2 = new Array(1,3,3,3,3)

if(d.valant != d.value){
	val = d.value
	largo = val.length
	val = val.split(sep)
	val2 = ''
	for(r=0;r<val.length;r++){
		val2 += val[r]	
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),"g")
				val2 = val2.replace(letra,"")
			}
		}
	}

	val = ''
	val3 = new Array()
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s])
		val2 = val2.substr(pat[s])
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q]
		}
		else{
			if(val3[q] != ""){
				val += sep + val3[q]
				}
		}
	}
	d.value = val
	d.valant = val
	}
}



 function validarNroCapturas(pValor) {
     var error = ''; 
     var re = /^(-)?[0-9]*$/;
	 var falg = false;	 
     if (!re.test(pValor)) {
         alert("El campo  debe ser un numero entero");		
		 return false;
     }else flag = true;
  return flag;
 }
 
 function validarNroRecibo(pValor) {
     var error = ''; 
     var re = /^(-)?[0-9]*$/;
	 var falg = false;	 
     if (!re.test(pValor)) {
         alert("El campo NRO. RECIBO debe ser un numero entero");		
		 return false;
     }else flag = true;
  return flag;
 }
 
  function validarNroDocumento(pValor) {
     var error = ''; 
     var re = /^(-)?[0-9]*$/;
	 var falg = false;	 
     if (!re.test(pValor)) {
         alert("El campo DOCUMENTO debe ser un numero entero");		
		 return false;
     }else flag = true;
  return flag;
 }


function vacio(q) {  
        for ( i = 0; i < q.length; i++ ) {  
                if ( q.charAt(i) != " " ) {  
                        return true  
                }  
        }  
        return false  
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
	function stripCharsInBag(s, bag){
		var i;
		var returnString = "";
		for (i = 0; i < s.length; i++){
			var c = s.charAt(i);
			if (bag.indexOf(c) == -1) returnString += c;
		}
		return returnString;
	}
	function daysInFebruary (year){
		return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
	}
	function DaysArray(n) {
		for (var i = 1; i <= n; i++) {
			this[i] = 31
			if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
			if (i==2) {this[i] = 29}
		}
		return this
	}
	function isDate(dtStr){
		var daysInMonth = DaysArray(12)
		var pos1=dtStr.indexOf(dtCh)
		var pos2=dtStr.indexOf(dtCh,pos1+1)
		var strDay=dtStr.substring(0,pos1)
		var strMonth=dtStr.substring(pos1+1,pos2)
		var strYear=dtStr.substring(pos2+1)
		strYr=strYear
		if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
		if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
		for (var i = 1; i <= 3; i++) {
			if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
		}
		month=parseInt(strMonth)
		day=parseInt(strDay)
		year=parseInt(strYr)
		if (pos1==-1 || pos2==-1){
			return false
		}
		if (strMonth.length<1 || month<1 || month>12){
			return false
		}
		if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
			return false
		}
		if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
			return false
		}
		if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
			return false
		}
		return true
	}
	if(isDate(fecha)){
		return true;
	}else{
		return false;
	}
}

function cargar_animal()
{
    var propietario = document.form_alta_animal.txt_nombre_propietario.value;

	
	if (propietario.length == 0)
    {
		alert("Debe cargar un propietario!");
	    document.getElementById("txt_buscar_dni").focus();
		return (false);	
	}else
	{
	 document.getElementById("txt_guardar").value = "guardar";
	}

}


function validar_frm_alta_ejemplar(frm)
{
    var fk_id_especie = 0;
	var raza = "";
	var flag = false; 
	var campo = "";
	
	campo = document.form_alta_animal.txt_especie.value;
	if (!vacio(campo) || campo == "Seleccione una especie.."){
    	alert("El campo ESPECIE no puede estar vacio"); 
		document.form_alta_animal.txt_especie.focus();
		return false;
  	}
	
	campo = document.form_alta_animal.txt_raza.value;
	if (!vacio(campo) || campo == "Seleccione una raza.."){
    	alert("El campo RAZA no puede estar vacio"); 
		document.form_alta_animal.txt_raza.focus();
		return false;
  	}
	
	campo = document.form_alta_animal.select_pelaje.value; 
	if (!vacio(campo) || campo == "Seleccione un pelaje.."){
    	alert("El campo Pelaje no puede estar vacio"); 
		document.form_alta_animal.select_pelaje.focus();
		return false;
  	}
	
	campo = document.form_alta_animal.select_tamanio.value;
	if (!vacio(campo) || campo == "Seleccione un tamanio.."){
    	alert("El campo TAMANIO no puede estar vacio"); 
		document.form_alta_animal.select_tamanio.focus();
		return false;
  	}

	if (!vacio(document.form_alta_animal.txt_nombre_animal.value)){
    	alert("El campo NOMBRE no puede estar vacio"); 
		document.form_alta_animal.txt_nombre_animal.focus();
		return false;
  	}			
	
	campo = document.form_alta_animal.txt_capturas.value;
	if (!vacio(campo)){
		alert("El campo CAPTURAS no puede estar vacio"); 
		document.form_alta_animal.txt_capturas.focus();
		return false;
	}	
	
	if (!validarNroCapturas(campo)) {
		document.form_alta_animal.txt_capturas.focus();
		return false;
	}
	
	campo = document.form_alta_animal.select_caracter.value;
	if (!vacio(campo) || campo == "Seleccione un caracter.."){
    	alert("El campo CARACTER no puede estar vacio"); 
		document.form_alta_animal.select_caracter.focus();
		return false;
  	}	txt_fecha_alta_carnet
	
	campo = document.form_alta_animal.txt_nro_recibo.value;
	if (!vacio(campo)){
    	alert("El campo NRO. RECIBO no puede estar vacio"); 
		document.form_alta_animal.txt_nro_recibo.focus();
		return false;
  	}	
	
	if (!validarNroRecibo(campo)) {
		document.form_alta_animal.txt_nro_recibo.focus();
		return false;
	}

	 cargar_animal();
	
	if(!confirm("Confirma alta del ejemplar?") ) {
	document.form_alta_animal.txt_txt_nro_chip.focus();
	return false;
	}

}

  
function vacio(q) {  
	for ( i = 0; i < q.length; i++ ) {  
			if ( q.charAt(i) != " " ) {  
					return true  
			}  
	}  
	return false  
}

function validarEntero(pValor,pNombre) {
     var error = ''; 
     var re = /^(-)?[0-9]*$/;
	 var falg = false;	 
     if (!re.test(pValor)) {
         alert("El campo DNI debe ser un número entero");		
		 return false;
     }else flag = true;
  return flag;
 }


function validar_frm_mod_propietario(f)
{
    var fk_id_especie = 0;
	var raza = "";
	var flag = false;
	
	if (!vacio(document.form_mod_propietario.txt_nombre_propietario.value)){
    	alert("El NOMBRE del propietario no puede estar vacio"); 
		document.form_mod_propietario.txt_nombre_propietario.focus();
		return false;
  	}
	
	if (!vacio(document.form_mod_propietario.txt_apellido.value)){
    	alert("El APELLIDO del propietario no puede estar vacio"); 
		document.form_mod_propietario.txt_apellido.focus();
		return false;
  	}
	
	if (!vacio(document.form_mod_propietario.txt_dni_modificado.value)){   
	 	alert("El DNI del propietario no puede estar vacio"); 
		document.form_mod_propietario.txt_dni_modificado.focus();
		return false;
  	}
	
	if (!validarNroDocumento(document.form_mod_propietario.txt_dni_modificado.value)) {
		document.form_mod_propietario.txt_dni_modificado.focus();
		return false;
	}
	
	if (!vacio(document.form_mod_propietario.txt_calle.value)){
    	alert("La CALLE del propietario no puede estar vacia"); 
		document.form_mod_propietario.txt_calle.focus();
		return (false);
  	}
	
	if (!vacio(document.form_mod_propietario.txt_nro.value)){
    	alert("El NRO. DE VIVIENDA del propietario no puede estar vacia"); 
		document.form_mod_propietario.txt_nro.focus();
		return false;
  	}
	
	if(!confirm("Confirma modificacion del propietario?") ) {
		document.formBuscar.txt_buscar_dni.focus();
		return false;

	}
	


}

function validar_frm_alta_propietario(txt_nombre_propietario,txt_apellido,txt_dni,txt_calle,txt_nro,txt_telefono)
{
	var validado = false;

	console.log("entro");

	if (!vacio(txt_nombre_propietario)){
    	alert("El NOMBRE del propietario no puede estar vacio"); 
		//document.form1.txt_nombre_propietario.focus();
		validado = false;
  	}
	
	if (!vacio(txt_apellido)){
    	alert("El APELLIDO del propietario no puede estar vacio"); 
		//document.form1.txt_apellido.focus();
		validado = false;
  	}
	
	if (!vacio(txt_dni)){   
	 	alert("El DNI del propietario no puede estar vacio"); 
		//document.form1.txt_dni.focus();
		validado = false;
  	}
		
	if (!validarEntero(txt_dni,'DNI')) {
		//document.form1.txt_dni.focus();
		validado = false;
	}
	
	
	if (!vacio(txt_calle)){
    	alert("La CALLE del propietario no puede estar vacia"); 
		//document.form1.txt_calle.focus();
		validado = false;
  	}
	
	if (!vacio(txt_nro)){
    	alert("El NRO.DE VIVIENDA del propietario no puede estar vacia"); 
		//document.form1.txt_nro.focus();
		validado = false;
  	}

  	if (!vacio(txt_telefono)){
    	alert("El TELEFONO del propietario no puede estar vacio"); 
		//document.form1.txt_calle.focus();
		validado = false;
  	}
	
	//$txt_email = test_input($_POST["txt_email"]);
   // var atpos = $txt_email.indexOf("@");
   // var dotpos = $txt_email.lastIndexOf(".");
    //if (atpos<1 || dotpos<atpos+2 || dotpos+2>=$txt_email.length) {
   //     alert("El formato del email es incorrecto");
   //     return false;
   // }

	if(!confirm("Confirma la carga del propietario?") ) {
		//document.form1.txt_nombre_propietario.focus();
		validado = false;
	}else{
		validado = true;
	}

	return validado;
}

function validar_frm_mod_ejemplar(frm)
{
    var fk_id_especie = 0;
	var raza = "";
	var flag = false; 
	var campo = "";


	if (!vacio(document.form_mod_ejemplar.txt_nombre.value)){
    	alert("El campo NOMBRE no puede estar vacio"); 
		document.form_mod_ejemplar.txt_nombre.focus();
		return false;
	}
	
	if(!confirm("Confirma modificacion del ejemplar?") ) {
		document.formBuscar.txt_buscar_nro.focus();
		return false;

	}

}
