<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
$rut_completo = str_replace("-", "", estandariza_info($_POST["rut"]));
 $nombre=estandariza_info($_POST["nombre"]);
 $rut=estandariza_info(substr($rut_completo, 0, strlen($rut_completo)-1));
 $dv=estandariza_info(substr($rut_completo, -1,1));
 $correo_electronico=estandariza_info($_POST["correo_electronico"]);
 $direccionp=estandariza_info($_POST["direccionp"]);
 $direccionl=estandariza_info($_POST["direccionl"]);
 $telefono=estandariza_info($_POST["telefono"]);
 $referido=estandariza_info($_POST["referido"]);
 $grupo=estandariza_info($_POST["grupo"]);


mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
$query='insert into clientes(nombre_cliente, apellido_paterno, apellido_materno, rut_sin_dv, dv, direccion_personal, correo,direccion_laboral, telefono, referido, grupo) values (\''.$nombre.'\', \''.$apellidop.'\', \''.$apellidom.'\', \''.$rut.'\', \''.$dv.'\', \''.$direccionp.'\', \''.$correo_electronico.'\', \''.$direccionl.'\', \''.$telefono.'\', \''.$referido.'\', \''.$grupo.'\');';
mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Agrega clientes', '".str_replace("'","**",$query)."','cliente',null, '".$_SERVER['PHP_SELF']."')");

mysqli_query($link, $query);

//echo 'insert into clientes(nombre_cliente, rut_sin_dv, dv, direccion_personal, correo,direccion_laboral, telefono, referido, grupo) values (\''.$nombre.'\', \''.$rut.'\', \''.$dv.'\', \''.$direccionp.'\', \''.$correo_electronico.'\', \''.$direccionl.'\', \''.$telefono.'\', \''.$referido.'\', \''.$grupo.'\');';
  foreach (array_keys($_POST['nombrecontact']) as $key) {
    $nombrecontact = $_POST['nombrecontact'][$key];
    $telefonocontact = $_POST['telefonocontact'][$key];
    $emailcontact = $_POST['emailcontact'][$key];
    $query_contactos="INSERT INTO clientes_contactos (id_cliente,indice, nombre, telefono, correo) select id , '".$nombrecontact."', '".$key."',, '".$telefonocontact."', '".$emailcontact."' from clientes where rut_sin_dv='".$rut."';";
    mysqli_query($link, $query_contactos);
    mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Agrega contactos', '".str_replace("'","**",$query_contactos)."','contacto',null, '".$_SERVER['PHP_SELF']."')");
   
    //echo "INSERT INTO clientes_contactos (id_cliente,indice, nombre, telefono, correo) select id , '".$nombrecontact."', '".$key."',, '".$telefonocontact."', '".$emailcontact."' from clientes where rut_sin_dv='".$rut."';";
  }


//echo '<script type="text/javascript">
//redirige('.$rut.');
//</script>';
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js">
    </script>
<script src="/assets/js/jquery.redirect.js">
</script>
</head>
<body>
<script >

var rut='<?php echo $rut; ?>'
  $.redirect('/bamboo/listado_clientes.php', {
  'busqueda': rut
}, 'post');


</script>
</body>
</html>