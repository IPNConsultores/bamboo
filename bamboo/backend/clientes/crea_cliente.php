<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once "/home/gestio10/public_html/backend/config.php";

function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$rut_completo = str_replace("-", "", estandariza_info($_POST["rut"]));
$nombre = estandariza_info($_POST["nombre"]);
$apellidop = isset($_POST["apellidop"]) ? estandariza_info($_POST["apellidop"]) : '';
$apellidom = isset($_POST["apellidom"]) ? estandariza_info($_POST["apellidom"]) : '';
$rut = estandariza_info(substr($rut_completo, 0, strlen($rut_completo)-1));
$dv = estandariza_info(substr($rut_completo, -1, 1));
$correo_electronico = estandariza_info($_POST["correo_electronico"]);
$direccionp = estandariza_info($_POST["direccionp"]);
$direccionl = estandariza_info($_POST["direccionl"]);
$telefono = estandariza_info($_POST["telefono"]);
$referido = estandariza_info($_POST["referido"]);
$grupo = estandariza_info($_POST["grupo"]);


mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
$query = 'INSERT INTO clientes(nombre_cliente, apellido_paterno, apellido_materno, rut_sin_dv, dv, direccion_personal, correo, direccion_laboral, telefono, referido, grupo) VALUES (\'' . $nombre . '\', \'' . $apellidop . '\', \'' . $apellidom . '\', \'' . $rut . '\', \'' . $dv . '\', \'' . $direccionp . '\', \'' . $correo_electronico . '\', \'' . $direccionl . '\', \'' . $telefono . '\', \'' . $referido . '\', \'' . $grupo . '\');';
mysqli_query($link, "SELECT trazabilidad('" . $_SESSION["username"] . "', 'Agrega clientes', '" . str_replace("'", "**", $query) . "','cliente', NULL, '" . $_SERVER['PHP_SELF'] . "')");

mysqli_query($link, $query);

foreach (array_keys($_POST['nombrecontact']) as $key) {
    $nombrecontact = estandariza_info($_POST['nombrecontact'][$key]);
    $telefonocontact = estandariza_info($_POST['telefonocontact'][$key]);
    $emailcontact = isset($_POST['emailcontact'][$key]) ? estandariza_info($_POST['emailcontact'][$key]) : '';
    $query_contactos = "INSERT INTO clientes_contactos (id_cliente, nombre, telefono, correo) SELECT id, '" . $nombrecontact . "', '" . $telefonocontact . "', '" . $emailcontact . "' FROM clientes WHERE rut_sin_dv='" . $rut . "';";
    mysqli_query($link, $query_contactos);
    mysqli_query($link, "SELECT trazabilidad('" . $_SESSION["username"] . "', 'Agrega contactos', '" . str_replace("'", "**", $query_contactos) . "','contacto', NULL, '" . $_SERVER['PHP_SELF'] . "')");
}
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="/assets/js/jquery.redirect.js"></script>
</head>
<body>
<script>
alert("Cliente Creado correctamente");
var rut = '<?php echo $rut; ?>';
$.redirect('/bamboo/listado_clientes.php', {
  'busqueda': rut
}, 'post');
</script>
</body>
</html>