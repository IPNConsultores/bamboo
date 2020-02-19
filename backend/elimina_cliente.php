<?php
require_once "/home/asesori1/public_html/bamboo/backend/config.php";
$id=$_GET["cliente"];
mysqli_set_charset( $link, 'utf8');
mysqli_query($link, 'delete from clientes WHERE id='.$id.';');
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
header("Location:http://ipnconsultores.cl/bamboo/index.php");
?>