<?php
require_once "/home/gestio10/public_html/backend/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  mysqli_set_charset( $link, 'utf8');
  mysqli_select_db($link, 'gestio10_asesori1_bamboo');
  $prioridad=estandariza_info($_POST["prioridad"]);
  $fechavencimiento=estandariza_info($_POST["fechavencimiento"]);
  $tarea=estandariza_info($_POST["tarea"]);
  $largo=6;
$token = bin2hex(random_bytes($largo));
//echo 'insert into tareas(fecha_vencimiento, tarea, prioridad) values (\''.$fechavencimiento.'\', \''.$tarea.'\', \''.$prioridad.'\');';
    //if (empty(trim($_POST["id_cliente"])) && empty(trim($_POST["id_poliza"]))){

      mysqli_query($link, 'insert into tareas(fecha_vencimiento, tarea, prioridad, token) values (\''.$fechavencimiento.'\', \''.$tarea.'\', \''.$prioridad.'\', \''.$token.'\');');
    /*}
    if(!empty(trim($_POST["id_cliente"])) && !empty(trim($_POST["id_poliza"]))){
      $id_cliente=estandariza_info($_POST["id_cliente"]);
      $id_poliza=estandariza_info($_POST["id_poliza"]);
      mysqli_query($link, 'insert into tareas(fecha_vencimiento, tarea, prioridad, id_cliente, id_poliza ) values (\''.$fechavencimiento.'\', \''.$tarea.'\', \''.$prioridad.'\', '.$id_cliente.' , '.$id_poliza.');');
    }
    if(!empty(trim($_POST["id_cliente"])) && empty(trim($_POST["id_poliza"]))){
      $id_cliente=estandariza_info($_POST["id_cliente"]);
      mysqli_query($link, 'insert into tareas(fecha_vencimiento, tarea, prioridad, id_cliente ) values (\''.$fechavencimiento.'\', \''.$tarea.'\', \''.$prioridad.'\', '.$id_cliente.' );');
    }   
    if(empty(trim($_POST["id_cliente"])) && !empty(trim($_POST["id_poliza"]))){
      $id_poliza=estandariza_info($_POST["id_poliza"]);
      mysqli_query($link, 'insert into tareas(fecha_vencimiento, tarea, prioridad, id_poliza ) values (\''.$fechavencimiento.'\', \''.$tarea.'\', \''.$prioridad.'\', '.$id_poliza.');');
    }
    */
    header("location: /bamboo/index.php");
}

function estandariza_info($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
