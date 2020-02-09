<?php
require_once "/home/asesori1/public_html/bamboo/backend/config.php";
 $texto=estandariza_info($_POST["buscacliente"]);
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'asesori1_bamboo');
$resultado=mysqli_query($link, 'select * from clientes where nombre_cliente like \'%'.$buscacliente.'%\' or apellido_paterno like \'%'.$buscacliente.'%\' or rut_sin_dv like \'%'.$buscacliente.'%\';');
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  header("Location:http://ipnconsultores.cl/bamboo/index.php");
?>