<?php 

include("lib/funciones.php");
include("mod_sql/sql.php");	

$propietarios = sql_traer_propietarios();	


$stmtP = sql_buscar_personas();

//Si hay resultados...
if (mysql_num_rows($stmtP) > 0){

while($fila = mysql_fetch_assoc($stmtP)){
		 // se recoge la información según la vamos a pasar a la variable de javascript
				 $texto .= '"'.$fila['documento'].' '.$fila['nombre'].' '.$fila['apellido'].'",';
	}

}else{
		$texto = "NO HAY RESULTADOS EN LA BBDD";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script language='javascript' src="../js/jquery-1.12.3.js"></script>
    <script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/bootstrap-datetimepicker.es.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	
	<script src="jscripts/funciones.js"></script>
	<script src="mod_validacion/validacion.js"></script>

	<!-- Combobox autocomplete -->  
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Bootstrap -->

    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    
    
    <script type="text/JavaScript">
	
	//Funcion COMBOBOX Autocomplete

	  $( function() {
	    $.widget( "custom.combobox", {
	      _create: function() {
	        this.wrapper = $( "<span>" )
	          .addClass( "custom-combobox" )
	          .insertAfter( this.element );
	 
	        this.element.hide();
	        this._createAutocomplete();
	        this._createShowAllButton();
	      },
	 
	      _createAutocomplete: function() {
	        var selected = this.element.children( ":selected" ),
	          value = selected.val() ? selected.text() : "";
	 
	        this.input = $( "<input>" )
	          .appendTo( this.wrapper )
	          .val( value )
	          .attr( "title", "" )
	          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
	          .autocomplete({
	            delay: 0,
	            minLength: 0,
	            source: $.proxy( this, "_source" )
	          })
	          .tooltip({
	            classes: {
	              "ui-tooltip": "ui-state-highlight"
	            }
	          });
	 
	        this._on( this.input, {
	          autocompleteselect: function( event, ui ) {
	            ui.item.option.selected = true;
	            this._trigger( "select", event, {
	              item: ui.item.option
	            });
	          },
	 
	          autocompletechange: "_removeIfInvalid"
	        });
	      },
	 
	      _createShowAllButton: function() {
	        var input = this.input,
	          wasOpen = false;
	 
	        $( "<a>" )
	          .attr( "tabIndex", -1 )
	          .attr( "title", "Show All Items" )
	          .tooltip()
	          .appendTo( this.wrapper )
	          .button({
	            icons: {
	              primary: "ui-icon-triangle-1-s"
	            },
	            text: false
	          })
	          .removeClass( "ui-corner-all" )
	          .addClass( "custom-combobox-toggle ui-corner-right" )
	          .on( "mousedown", function() {
	            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
	          })
	          .on( "click", function() {
	            input.trigger( "focus" );
	 
	            // Close if already visible
	            if ( wasOpen ) {
	              return;
	            }
	 
	            // Pass empty string as value to search for, displaying all results
	            input.autocomplete( "search", "" );
	          });
	      },
	 
	      _source: function( request, response ) {
	        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
	        response( this.element.children( "option" ).map(function() {
	          var text = $( this ).text();
	          if ( this.value && ( !request.term || matcher.test(text) ) )
	            return {
	              label: text,
	              value: text,
	              option: this
	            };
	        }) );
	      },
	 
	      _removeIfInvalid: function( event, ui ) {
	 
	        // Selected an item, nothing to do
	        if ( ui.item ) {
	          return;
	        }
	 
	        // Search for a match (case-insensitive)
	        var value = this.input.val(),
	          valueLowerCase = value.toLowerCase(),
	          valid = false;
	        this.element.children( "option" ).each(function() {
	          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
	            this.selected = valid = true;
	            return false;
	          }
	        });
	 
	        // Found a match, nothing to do
	        if ( valid ) {
	          return;
	        }
	 
	        // Remove invalid value
	        this.input
	          .val( "" )
	          .attr( "title", value + " didn't match any item" )
	          .tooltip( "open" );
	        this.element.val( "" );
	        this._delay(function() {
	          this.input.tooltip( "close" ).attr( "title", "" );
	        }, 2500 );
	        this.input.autocomplete( "instance" ).term = "";
	      },
	 
	      _destroy: function() {
	        this.wrapper.remove();
	        this.element.show();
	      }
	    });
	 
		    $( "#combobox" ).combobox();
		    $( "#toggle" ).on( "click", function() {
		      $( "#combobox" ).toggle();
		    });
	  	} );	
	   
	    $( function() {
			// Variable que recoge el resultado de la consulta sobre la tabla Provincias, Jquery trabajará sobre este resultado para dinamizar el funcionamiento.
			var availableTags = [<?php echo $texto ?>];
			$("#buscar_propietario").autocomplete({
				source: availableTags
			});

	  } );

	//	</script>
////////////////////////////////////////////////////////////
	  
	




</head>

<body>



<div class="col-xs-15 selectContainer">
																				<select id="combobox" class="form_control" name="select_propietarios">
																					<?php 					
																						while ($row=mysql_fetch_array($propietarios))
																						{
																							$id_persona = ($row['id_persona']);
																							$documento = ($row['documento']);
																							$nombre = ($row['nombre']);
																							$apellido = ($row['apellido']);

																						?>
																						<option value = "<?php echo $id_persona;?>" selected="selected"><?php echo  utf8_encode($documento." ".$nombre." ".$apellido);?> </option>
																					<?php						
																						}

																						if($propietarioPrincipal != "")
																						{
																							$persona = sql_buscar_persona_id($propietarioPrincipal);

																							$rowPersona=mysql_fetch_array($persona);

																							$id_persona = ($rowPersona['id_persona']);
																							$documento = ($rowPersona['documento']);
																							$nombre = ($rowPersona['nombre']);
																							$apellido = ($rowPersona['apellido']);
																						?>
																							<option value = "<?php echo $id_persona;?>" selected="selected"><?php echo  utf8_encode($documento." ".$nombre." ".$apellido);?> </option>
																						<?php 
																						}
																					?>						
																				</select>
																			</div>


</body>
</html>