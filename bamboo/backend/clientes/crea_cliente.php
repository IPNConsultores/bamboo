<?php
require_once "/home/gestio10/public_html/backend/config.php";
 $nombre=estandariza_info($_POST["nombre"]);
 $apellidop=estandariza_info($_POST["apellidop"]);
 $apellidom=estandariza_info($_POST["apellidom"]);
 $rut=estandariza_info($_POST["rut"]);
 $dv=estandariza_info($_POST["dv"]);
 $correo_electronico=estandariza_info($_POST["correo_electronico"]);
 $direccionp=estandariza_info($_POST["direccionp"]);
 $direccionl=estandariza_info($_POST["direccionl"]);
 $telefono=estandariza_info($_POST["telefono"]);
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
mysqli_query($link, 'insert into clientes(nombre_cliente, apellido_paterno, apellido_materno, rut_sin_dv, dv, direccion_personal, correo,direccion_laboral, telefono) values (\''.$nombre.'\', \''.$apellidop.'\', \''.$apellidom.'\', \''.$rut.'\', \''.$dv.'\', \''.$direccionp.'\', \''.$correo_electronico.'\', \''.$direccionl.'\', \''.$telefono.'\');');
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
header("Location:http://ipnconsultores.cl/bamboo/index.php");
?>