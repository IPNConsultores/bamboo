<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
$id=$_POST["cliente"];
mysqli_set_charset( $link, 'utf8');
mysqli_query($link, 'delete from clientes WHERE id='.$id.';');
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  header("Location:http://gestionipn.cl/bamboo/listado_clientes.php");
?>