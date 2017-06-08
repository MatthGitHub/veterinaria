<?php 

include("lib/funciones.php");
include("mod_sql/sql.php");	

//Cargo propietarios
$propietarios = sql_traer_propietarios();	

?>

<!DOCTYPE html">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <script language='javascript' src="js/jquery-1.12.3.js"></script>
    <script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.js"></script>

	

	<!-- Combobox autocomplete -->  
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Bootstrap -->

    <link href="css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!--estilo para combobox-->
	
	<style>
	.custom-combobox {
	position: relative;
	display: inline-block;
	}
	.custom-combobox-toggle {
	position: absolute;
	top: 0;
	bottom: 0;
	margin-left: -1px;
	padding: 0;
	}
	.custom-combobox-input {
	margin: 0;
	padding: 5px 10px;
	height: 50px;
    width: 180%;
	}
	</style>

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

	//////////////////////////////////////////////////////////////
	  
	function set_focus()
	{
		document.getElementById("txt_nombre_animal").focus();
		alert("focus animal nombre");
		return (false);	
	}


	</script>
</head>

<body onLoad="document.form1.select_propietarios.focus();">

	<div class="container">
		<br>
		<?php include("inc/menu.php"); ?>

	  <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info">Cargar Animal</h4>
			<div class="container">
				
				<form id="form1" name="form1" method="post" onsubmit="" action="mostrar.php">
					
					
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
																						<option value = "<?php echo $id_persona;?>" selected="selected"><?php echo  utf8_encode($nombre." ".$apellido);?> </option>
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
																		

																	<input name="Submit" type="submit" method="post" class="btn btn-sm btn-primary btn-block" value="GUARDAR" />	
																

										
									</form>
								</div>
							</div>
						</div>
					</div>

				</form>	<!-- form principal -->
			</div><!-- Container -->
		</div><!-- Jumbotron -->
		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>
	</div><!-- Container principal -->
				
	<script type="text/javascript">
	$('#divMiCalendario').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	
	$('#divMiCalendario1').datetimepicker({
      format: 'DD-MM-YYYY'
    });

    $('#divMiCalendario2').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	
	//Canino
	 $('#divMiCalendarioSextuple').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	
	 $('#divMiCalendarioQuintuple').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	
	 $('#divMiCalendarioRabia').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	
	 $('#divMiCalendarioHidatidosis').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	
	 $('#divMiCalendarioGusanos').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	 //Equinos
	 $('#divMiCalendarioAnemia').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioInfluenza').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioAdenitis').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioEncefalomielitis').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	
	//Felinos
	$('#divMiCalendarioLeucemia').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioRabiaFelino').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioTriple').datetimepicker({
      format: 'DD-MM-YYYY'
    });


    </script>
</body>
</html>
