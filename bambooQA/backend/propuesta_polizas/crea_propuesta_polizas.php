<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

require_once "/home/gestio10/public_html/backend/config.php";
$rut_completo_prop = str_replace("-", "", estandariza_info($_POST["rutprop"]));
$rut_completo_aseg = str_replace("-", "", estandariza_info($_POST["rutaseg"]));
$rut_prop=estandariza_info(substr($rut_completo_prop, 0, strlen($rut_completo_prop)-1));
$dv_prop=estandariza_info(substr($rut_completo_prop, -1,1));
$rut_aseg=estandariza_info(substr($rut_completo_aseg, 0, strlen($rut_completo_aseg)-1));
$dv_aseg=estandariza_info(substr($rut_completo_aseg, -1,1));
$selcompania=estandariza_info($_POST["selcompania"]);
$ramo=estandariza_info($_POST["ramo"]);
$id_propuesta=estandariza_info($_POST["id_propuesta"]);
$fechainicio=estandariza_info($_POST["fechainicio"]);
$fechavenc=estandariza_info($_POST["fechavenc"]);
$cobertura=estandariza_info($_POST["cobertura"]);
$materia=estandariza_info($_POST["materia"]);
$detalle_materia=estandariza_info($_POST["detalle_materia"]);
$moneda_poliza=estandariza_info($_POST["moneda_poliza"]);
$deducible=cambia_puntos_por_coma(estandariza_info($_POST["deducible"]));
$prima_afecta=cambia_puntos_por_coma(estandariza_info($_POST["prima_afecta"]));
$prima_exenta=cambia_puntos_por_coma(estandariza_info($_POST["prima_exenta"]));
$prima_neta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta"]));
$prima_bruta=cambia_puntos_por_coma(estandariza_info($_POST["prima_bruta"]));
$monto_aseg=cambia_puntos_por_coma(estandariza_info($_POST["monto_aseg"]));
$nro_propuesta=estandariza_info($_POST["nro_propuesta"]);
$fechaprop=estandariza_info($_POST["fechaprop"]);
$item=estandariza_info($_POST["item"]);


mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_QA');
$query='INSERT INTO propuesta_polizas (estado, tipo_propuesta, rut_proponente,  dv_proponente,  rut_asegurado,  dv_asegurado,  compania,  ramo,  vigencia_inicial,  vigencia_final,  numero_propuesta,  cobertura,  materia_asegurada,  patente_ubicacion, moneda_poliza,  deducible,  prima_afecta,  prima_exenta,  prima_neta,  prima_bruta_anual,  monto_asegurado,item)                     
VALUES ("Activo", "WEB", "'.$rut_prop.'","'.$dv_prop.'","'.$rut_aseg.'","'.$dv_aseg.'","'.$selcompania.'","'.$ramo.'","'.$fechainicio.'","'.$fechavenc.'","'.$nro_propuesta.'","'.$cobertura.'","'.$materia.'","'.$detalle_materia.'","'.$moneda_poliza.'","'.$deducible.'","'.$prima_afecta.'","'.$prima_exenta.'","'.$prima_neta.'","'.$prima_bruta.'","'.$monto_aseg.'","'.$fechaprop.'","'.$item.'");';
mysqli_query($link, $query);
mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Agrega propuesta póliza', '".str_replace("'","**",$query)."','propuesta poliza',null, '".$_SERVER['PHP_SELF']."')");


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
alert("Póliza Registrada Correctamente");
var nro_propuesta= '<?php echo $nro_propuesta; ?>';
  $.redirect('/bambooQA/listado_propuesta_polizas.php', {
 'busqueda': nro_propuesta
}, 'post');

</script>
</body>
</html>