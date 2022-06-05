<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
$id=$_POST["cliente"];
mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_prePAP');
$query='delete from clientes WHERE id='.$id.';';
mysqli_query($link, $query);
mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Eliminar cliente', '".str_replace("'","**",$query)."','cliente',".$id.", '".$_SERVER['PHP_SELF']."')");
mysqli_close($link);
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  header("Location:http://gestionipn.cl/bamboo_prePAP/listado_clientes.php");
?>