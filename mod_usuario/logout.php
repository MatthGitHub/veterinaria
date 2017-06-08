<?php
include("../lib/sesion.php");
session_unset();
session_destroy(); 
header("Location:../index.php");
?>