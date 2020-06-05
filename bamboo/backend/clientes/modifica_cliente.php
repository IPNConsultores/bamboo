<?php
require_once "/home/gestio10/public_html/backend/config.php";
$rut_completo = preg_replace('/[^k0-9]/i', '', $_POST["rut"]);
$id=estandariza_info($_POST["idcliente"]);
$rut=estandariza_info(substr($rut_completo, 0, strlen($rut_completo)-1));
 $dv=estandariza_info(substr($rut_completo -1));
$nombre=estandariza_info($_POST["nombre"]);
$apellidop=estandariza_info($_POST["apellidop"]);
$apellidom=estandariza_info($_POST["apellidom"]);
$telefono=estandariza_info($_POST["telefono"]);
$direccionp=estandariza_info($_POST["direccionp"]);
$direccionl=estandariza_info($_POST["direccionl"]);
$correo=estandariza_info($_POST["correo_electronico"]);
mysqli_set_charset( $link, 'utf8');
mysqli_query($link, 'UPDATE clientes SET nombre_cliente=\''.$nombre.'\' ,apellido_paterno=\''.$apellidop.'\' ,apellido_materno=\''.$apellidom.'\' ,rut_sin_dv=\''.$rut.'\' ,dv=\''.$dv.'\' ,telefono=\''.$telefono.'\' ,direccion_personal=\''.$direccionp.'\' ,direccion_laboral=\''.$direccionl.'\' ,correo=\''.$correo.'\'  WHERE id='.$id.';');

mysqli_query($link, 'DELETE clientes_contactos  WHERE id_cliente='.$id.';');

foreach (array_keys($_POST['nombrecontact']) as $key) {
    $nombrecontact = $_POST['nombrecontact'][$key];
    $telefonocontact = $_POST['telefonocontact'][$key];
    $emailcontact = $_POST['emailcontact'][$key];
		
    mysqli_query($link, "INSERT INTO clientes_contactos (id_cliente, nombre, telefono, correo) select id , '".$nombrecontact."', '".$telefonocontact."', '".$emailcontact."' from clientes where rut_sin_dv='".$rut."';");
  }


function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  header("Location:http://gestionipn.cl/bamboo/listado_clientes.php");
?>