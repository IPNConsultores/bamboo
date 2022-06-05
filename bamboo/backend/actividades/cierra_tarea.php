<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
$id=estandariza_info($_POST["id_tarea"]);
mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_prePAP');

if ($_POST["accion"]=='cerrar_tarea'){
  $query='update tareas set estado="Cerrado", fecha_completada=current_date WHERE id='.$id.';';
  mysqli_query($link, $query);
  mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Cierra tarea', '".str_replace("'","**",$query)."','tarea',".$id.", '".$_SERVER['PHP_SELF']."')");
}
elseif($_POST["accion"]=='cerrar_tarea_recurrente'){
  $query='update tareas_recurrentes set estado="Cerrado", fecha_cierre=current_date WHERE id='.$id.';';
  mysqli_query($link, $query);
  mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Cierra tarea recurrente', '".str_replace("'","**",$query)."','tarea',".$id.", '".$_SERVER['PHP_SELF']."')");
}
else {
  $query='update tareas set estado="Eliminado", fecha_completada=current_date WHERE id='.$id.';';
mysqli_query($link, $query);
mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Elimina tarea', '".str_replace("'","**",$query)."','tarea',".$id.", '".$_SERVER['PHP_SELF']."')");
}
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
//  header("location: /bamboo_prePAP/index.php");
//$message = "Tarea Finalizada";
//echo "<script type='text/javascript'>alert('$message');</script>";

?>