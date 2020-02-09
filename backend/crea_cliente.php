<?php
require_once "/home/asesori1/public_html/bamboo/backend/config.php";
 $nombre=estandariza_info($_POST["nombre"]);
 $apellidop=estandariza_info($_POST["apellidop"]);
 $apellidom=estandariza_info($_POST["apellidom"]);
 $rut=estandariza_info($_POST["rut"]);
 $dv=estandariza_info($_POST["dv"]);
 $correo_electronico=estandariza_info($_POST["correo_electronico"]);
 $direccion=estandariza_info($_POST["direccion"]);
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'asesori1_bamboo');
mysqli_query($link, 'insert into clientes(nombre_cliente, apellido_paterno, apellido_materno, rut_sin_dv, dv, direccion_personal, correo) values (\''.$nombre.'\', \''.$apellidop.'\', \''.$apellidom.'\', \''.$rut.'\', \''.$dv.'\', \''.$direccion.'\', \''.$correo_electronico.'\');');
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  header("Location:http://ipnconsultores.cl/bamboo/index.php");
?>