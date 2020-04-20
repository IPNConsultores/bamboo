<?php
require_once "/home/gestio10/public_html/backend/config.php";
$id=estandariza_info($_POST["id_tarea"]);
mysqli_set_charset( $link, 'utf8');
mysqli_query($link, 'update tareas set estado="Cerrado" WHERE id='.$id.';');
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  header("location: /bamboo/index.php");
?>