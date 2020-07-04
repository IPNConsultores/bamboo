<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
$id=estandariza_info($_POST["id_tarea"]);
mysqli_set_charset( $link, 'utf8');

if ($_POST["accion"]=='cerrar_tarea'){
  mysqli_query($link, 'update tareas set estado="Cerrado", fecha_completada=current_date WHERE id='.$id.';');
}
elseif($_POST["accion"]=='cerrar_tarea_recurrente'){
  mysqli_query($link, 'update tareas_recurrentes set estado="Cerrado", fecha_cierre=current_date WHERE id='.$id.';');
}
else {
mysqli_query($link, 'update tareas set estado="Eliminado", fecha_completada=current_date WHERE id='.$id.';');
}
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  header("location: /bamboo/index.php");
?>