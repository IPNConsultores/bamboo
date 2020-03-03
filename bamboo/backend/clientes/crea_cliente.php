<?php
require_once "/home/gestio10/public_html/backend/config.php";
$rut_completo = str_replace("-", "", estandariza_info($_POST["rut"]));
 $nombre=estandariza_info($_POST["nombre"]);
 $apellidop=estandariza_info($_POST["apellidop"]);
 $apellidom=estandariza_info($_POST["apellidom"]);
 $rut=estandariza_info(substr($rut_completo, 0, strlen($rut_completo)-1));
 $dv=estandariza_info(substr($rut_completo, -1,1));
 $correo_electronico=estandariza_info($_POST["correo_electronico"]);
 $direccionp=estandariza_info($_POST["direccionp"]);
 $direccionl=estandariza_info($_POST["direccionl"]);
 $telefono=estandariza_info($_POST["telefono"]);

mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
mysqli_query($link, 'insert into clientes(nombre_cliente, apellido_paterno, apellido_materno, rut_sin_dv, dv, direccion_personal, correo,direccion_laboral, telefono) values (\''.$nombre.'\', \''.$apellidop.'\', \''.$apellidom.'\', \''.$rut.'\', \''.$dv.'\', \''.$direccionp.'\', \''.$correo_electronico.'\', \''.$direccionl.'\', \''.$telefono.'\');');

echo '<script type="text/javascript">
redirige('.$rut.');
</script>';
//header("Location:http://gestionipn.cl/bamboo/index.php");

function estandariza_info($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<script src="/bamboo/js/jquery.redirect.js">
</script>
</head>
<body>
<script >
window.document.onload = function(e){ 
    console.log("document.onload", e, Date.now() ,window.tdiff,  
    (window.tdiff[0] = Date.now()) && window.tdiff.reduce(fred) ); 
}

function redirige($dato){
  $.redirect('/bamboo/listado_clientes.php', {
  'dato': $dato
}, 'post');
}

</script>
</body>
</html>