<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_prePAP');
$rut_completo = preg_replace('/[^k0-9]/i', '', $_POST["rut2"]);

$id=estandariza_info($_POST["id"]);

$rut=estandariza_info(substr($rut_completo, 0, strlen($rut_completo)-1));
$dv=estandariza_info(substr($rut_completo, -1));
$nombre=estandariza_info($_POST["nombre"]);
$telefono=estandariza_info($_POST["telefono"]);
$direccionp=estandariza_info($_POST["direccionp"]);
$direccionl=estandariza_info($_POST["direccionl"]);
$correo=estandariza_info($_POST["correo_electronico"]);
$referido=estandariza_info($_POST["referido"]);
$grupo=estandariza_info($_POST["grupo"]);
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_prePAP');
$query = 'UPDATE clientes SET referido=\''.$referido.'\' , grupo=\''.$grupo.'\' , nombre_cliente=\''.$nombre.'\' ,rut_sin_dv=\''.$rut.'\' ,dv=\''.$dv.'\' ,telefono=\''.$telefono.'\' ,direccion_personal=\''.$direccionp.'\' ,direccion_laboral=\''.$direccionl.'\' ,correo=\''.$correo.'\'  WHERE id='.$id.';';
mysqli_query($link,$query);
mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Modifica cliente', '".str_replace("'","**",$query)."','cliente',".$id.", '".$_SERVER['PHP_SELF']."')");
$borrar=  'DELETE from clientes_contactos  WHERE id_cliente='.$id.';';
mysqli_query($link,$borrar);
foreach (array_keys($_POST['nombrecontact']) as $key) {
   
    $nombrecontact = $_POST['nombrecontact'][$key];
    $telefonocontact = $_POST['telefonocontact'][$key];
    $emailcontact = $_POST['emailcontact'][$key];
	
	$agregar_contacto[$key] = 'INSERT INTO clientes_contactos (id_cliente, nombre, telefono, correo) values (\''.$id.'\', \''.$nombrecontact.'\',\''.$telefonocontact.'\',\''.$emailcontact.'\') ;';
    mysqli_query($link, $agregar_contacto[$key]);
    
  }
  $vacio = "";
  $borrar2=  "DELETE from clientes_contactos  WHERE id_cliente=".$id." and nombre='".$vacio."';";
mysqli_query($link,$borrar2);
mysqli_close($link);
/*
ECHO "<br>".$borrar;
ECHO "<br>".$borrar2;
ECHO "<br>".$agregar_contacto;
print_r($agregar_contacto[0])."<br>";
print_r($agregar_contacto[1])."<br>";
print_r($agregar_contacto[2])."<br>";
print_r($agregar_contacto[3])."<br>";
print_r($agregar_contacto[4])."<br>";
ECHO "<br>".$query;
echo "<br>".$nombre_contactos;
echo "<br>RUT completo:".$rut_completo;
echo "<br>RUT:".$rut;
echo "<br>DV:".$dv;
*/
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
 // header("Location:http://gestionipn.cl/bambooQA/listado_clientes.php");
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
	
alert("Cliente Modificado Correctamente")
var rut='<?php echo $rut; ?>'
  $.redirect('/bambooQA/listado_clientes.php', {
  'busqueda': rut
}, 'post');


</script>
</body>
</html>