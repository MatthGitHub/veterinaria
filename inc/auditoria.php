<?php

// Comprobamos si existe la variable
function auditar($sql,$link){


  $date = date();

  $sql = "INSERT INTO auditorias(usuario,query,time) VALUES ("$_POST['usuario']","$sql","$date")";


  $stmt = mysqli_query($link,$stmt);

  return $stmt;
}

?>
