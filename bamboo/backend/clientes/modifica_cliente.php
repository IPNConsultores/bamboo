<?php
require_once "/home/gestio10/public_html/backend/config.php";
$id=estandariza_info($_POST["idcliente"]);
$rut=estandariza_info($_POST["rut"]);
$dv=estandariza_info($_POST["rut"]);
$nombre=estandariza_info($_POST["nombre"]);
$apellidop=estandariza_info($_POST["apellidop"]);
$apellidom=estandariza_info($_POST["apellidom"]);
$telefono=estandariza_info($_POST["telefono"]);
$direccionp=estandariza_info($_POST["direccionp"]);
$direccionl=estandariza_info($_POST["direccionl"]);
$correo=estandariza_info($_POST["correo_electronico"]);
mysqli_set_charset( $link, 'utf8');
mysqli_query($link, 'UPDATE clientes SET nombre_cliente=\''.$nombre.'\' ,apellido_paterno=\''.$apellidop.'\' ,apellido_materno=\''.$apellidom.'\' ,rut_sin_dv=\''.$rut.'\' ,dv=\''.$dv.'\' ,telefono=\''.$telefono.'\' ,direccion_personal=\''.$direccionp.'\' ,direccion_laboral=\''.$direccionl.'\' ,correo=\''.$correo.'\'  WHERE id='.$id.';');
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
header("Location:http://ipnconsultores.cl/bamboo/index.php");
?>