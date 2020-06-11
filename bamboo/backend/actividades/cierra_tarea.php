<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
$id=estandariza_info($_POST["id_tarea"]);
mysqli_set_charset( $link, 'utf8');
if ($_POST["accion"]=='cerrar_tarea'){
  mysqli_query($link, 'update tareas set estado="Cerrado" WHERE id='.$id.';');
}
else {
mysqli_query($link, 'update tareas set estado="Eliminado" WHERE id='.$id.';');
}
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  header("location: /bamboo/index.php");
?>