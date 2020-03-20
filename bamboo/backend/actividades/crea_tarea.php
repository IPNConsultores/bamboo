<?php
require_once "/home/gestio10/public_html/backend/config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
$rut_completo = str_replace("-", "", estandariza_info($_POST["rut"]));
 $nombre=estandariza_info($_POST["nombre"]);
 $apellidop=estandariza_info($_POST["apellidop"]);
 $apellidom=estandariza_info($_POST["apellidom"]);
 $rut=estandariza_info(substr($rut_completo, 0, strlen($rut_completo)-1));
 $dv=estandariza_info(substr($rut_completo, -1,1));
 $poliza=estandariza_info($_POST["poliza"]);
 $compania=estandariza_info($_POST["compania"]);
 $prioridad=estandariza_info($_POST["prioridad"]);
 $fechavencimiento=estandariza_info($_POST["fechavencimiento"]);
 $tarea=estandariza_info($_POST["tarea"]);


mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if ($rut_completo=='' && $poliza==''){
      mysqli_query($link, 'insert into tareas(fecha_vencimiento, tarea, prioridad) values (\''.$fechavencimiento.'\', \''.$tarea.'\', \''.$prioridad.'\');');
    }
    
}
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