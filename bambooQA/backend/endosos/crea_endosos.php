<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

require_once "/home/gestio10/public_html/backend/config.php";
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_QA');
$mensaje='';
$busqueda='';
$listado='';
if ($_SERVER[ "REQUEST_METHOD" ] == "POST" and $_POST["accion"] == 'crea_propuesta_endoso')
    {
        $listado='listado_propuesta_endosos';
        $tipo_endoso=cambia_puntos_por_coma(estandariza_info($_POST["tipo_endoso"]));
        $ramo=estandariza_info($_POST["ramo"]);
        $nro_poliza=estandariza_info($_POST["nro_poliza"]);
        $fecha_ingreso=estandariza_info($_POST["fecha_ingreso"]);
        $fecha_vigencia_inicial=estandariza_info($_POST["fecha_vigencia_inicial"]);
        $fecha_vigencia_final=estandariza_info($_POST["fecha_vigencia_final"]);
        $dias=estandariza_info($_POST["dias"]);

        $rut_completo_prop = str_replace("-", "", estandariza_info($_POST["rutprop"]));
        $rut_prop=estandariza_info(substr($rut_completo_prop, 0, strlen($rut_completo_prop)-1));
        $dv_prop=estandariza_info(substr($rut_completo_prop, -1,1));
        $nombre=estandariza_info($_POST["nombre"]);

        $descripcion_endoso=cambia_puntos_por_coma(estandariza_info($_POST["descripcion_endoso"]));
        $dice=cambia_puntos_por_coma(estandariza_info($_POST["dice"]));
        $debe_decir=cambia_puntos_por_coma(estandariza_info($_POST["debe_decir"]));

        $monto=cambia_puntos_por_coma(estandariza_info($_POST["monto"]));
        $moneda_poliza=estandariza_info($_POST["moneda_poliza"]);
        $prima_neta_exenta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta_exenta"]));
        $iva=cambia_puntos_por_coma(estandariza_info($_POST["iva"]));
        $prima_neta_afecta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta_afeca"]));
        $prima_total=cambia_puntos_por_coma(estandariza_info($_POST["prima_total"]));
        $largo = 6;
        $token = bin2hex(random_bytes($largo));
        $query="insert into propuesta_endosos(tipo_endoso, ramo, numero_poliza, fecha_ingreso_endoso, vigencia_inicial, vigencia_final, rut_proponente, dv_proponente, nombre_proponente, descripcion_endoso, dice, debe_decir, monto_asegurado_endoso, moneda_poliza_endoso, prima_neta_exenta, IVA, prima_neta_afecta, prima_total, token) values ('".$tipo_endoso."','".$ramo."',  '".$nro_poliza."','".$fecha_ingreso."','".$fecha_vigencia_inicial."','".$fecha_vigencia_final."','".$rut_prop."','".$dv_prop."','".$nombre."','".$descripcion_endoso."','".$dice."','".$debe_decir."','".$monto."','".$moneda_poliza."','".$prima_neta_exenta."','".$iva."','".$prima_neta_afecta."','".$prima_total."','".$token."')";
        
        mysqli_query($link, $query);
        mysqli_query($link, 'update propuesta_endosos set numero_propuesta_endoso=CONCAT(\'E\', LPAD(id,6,0)) where token=\'' . $token . '\';');
        $resultado = mysqli_query($link, 'select id, numero_propuesta_endoso from propuesta_endosos where token=\'' . $token . '\';');
        while ($fila = mysqli_fetch_object($resultado))
        {
            // printf ("%s (%s)\n", $fila->id);
            $id_poliza = $fila->id;
            $numero_propuesta_endoso = $fila->numero_propuesta_endoso;
        }
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Creación propuesta endoso', '".str_replace("'","**",$query)."','propuesta_endoso', '".$numero_propuesta_endoso."' , '".$_SERVER['PHP_SELF']."')");
 
    }




//echo $query;

function estandariza_info($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function cambia_puntos_por_coma($data){
  //$data=str_replace('.','',$data);
$data=str_replace(',','.',$data);
return $data;
}

mysqli_close($link);
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

var mensaje= '<?php echo $mensaje; ?>';
alert(mensaje);
var busqueda= '<?php echo $busqueda; ?>';
var listado= '<?php echo $listado; ?>';
  $.redirect(listado, {
 'busqueda': busqueda
}, 'post');

</script>
</body>
</html>