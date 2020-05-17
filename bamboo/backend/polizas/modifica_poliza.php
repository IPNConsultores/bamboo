<?php
require_once "/home/gestio10/public_html/backend/config.php";
$rut_completo_prop = str_replace("-", "", estandariza_info($_POST["rutprop"]));
$rut_completo_aseg = str_replace("-", "", estandariza_info($_POST["rutaseg"]));
 $rut_prop=estandariza_info(substr($rut_completo_prop, 0, strlen($rut_completo_prop)-1));
 $dv_prop=estandariza_info(substr($rut_completo_prop, -1,1));
 $rut_aseg=estandariza_info(substr($rut_completo_aseg, 0, strlen($rut_completo_aseg)-1));
 $dv_aseg=estandariza_info(substr($rut_completo_aseg, -1,1));
 $selcompania=estandariza_info($_POST["selcompania"]);
 $ramo=estandariza_info($_POST["ramo"]);
 $id_poliza=estandariza_info($_POST["id_poliza"]);
 $fechainicio=estandariza_info($_POST["fechainicio"]);
 $fechavenc=estandariza_info($_POST["fechavenc"]);
 $nro_poliza=estandariza_info($_POST["nro_poliza"]);
 $cobertura=estandariza_info($_POST["cobertura"]);
 $materia=estandariza_info($_POST["materia"]);
 $detalle_materia=estandariza_info($_POST["detalle_materia"]);
 $moneda_poliza=estandariza_info($_POST["moneda_poliza"]);
 $deducible=estandariza_info($_POST["deducible"]);
 $prima_afecta=estandariza_info($_POST["prima_afecta"]);
 $prima_exenta=estandariza_info($_POST["prima_exenta"]);
 $prima_neta=estandariza_info($_POST["prima_neta"]);
 $prima_bruta=estandariza_info($_POST["prima_bruta"]);
 $monto_aseg=estandariza_info($_POST["monto_aseg"]);
 $nro_propuesta=estandariza_info($_POST["nro_propuesta"]);
 $fechaprop=estandariza_info($_POST["fechaprop"]);
 $moneda_comision=estandariza_info($_POST["moneda_comision"]);
 $comision=estandariza_info($_POST["comision"]);
 $porcentaje_comsion=estandariza_info($_POST["porcentaje_comsion"]);
 $comisionbruta=estandariza_info($_POST["comisionbruta"]);
 $comisionneta=estandariza_info($_POST["comisionneta"]);
 $modo_pago=estandariza_info($_POST["modo_pago"]);
 $cuotas=estandariza_info($_POST["cuotas"]);
 $moenda_cuota=estandariza_info($_POST["moneda_cuota"]);
 $valorcuota=estandariza_info($_POST["valorcuota"]);
 $fechaprimer=estandariza_info($_POST["fechaprimer"]);
 $con_vendedor=estandariza_info($_POST["con_vendedor"]);
 $nombre_vendedor=estandariza_info($_POST["nombre_vendedor"]);
 $poliza_renovada=estandariza_info($_POST["poliza_renovada"]);

 $fechadeposito=estandariza_info($_POST["fechadeposito"]);
 $comisionneg=estandariza_info($_POST["comisionneg"]);
 $boletaneg=estandariza_info($_POST["boletaneg"]);
 $boleta=estandariza_info($_POST["boleta"]);

mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
$query='UPDATE polizas SET numero_boleta="'.$boleta.'", comision_negativa="'.$comisionneg.'", boleta_negativa="'.$boletaneg.'", depositado_fecha="'.$fechadeposito.'", moneda_valor_cuota="'.$moenda_cuota.'",  rut_proponente="'.$rut_prop.'",  dv_proponente="'.$dv_prop.'",  rut_asegurado="'.$rut_aseg.'",  dv_asegurado="'.$dv_aseg.'",  compania="'.$selcompania.'",  
ramo="'.$ramo.'",  vigencia_inicial="'.$fechainicio.'",  vigencia_final="'.$fechavenc.'",  numero_poliza="'.$nro_poliza.'",  cobertura="'.$cobertura.'",  materia_asegurada="'.$materia.'",  patente_ubicacion="'.$detalle_materia.'", 
moneda_poliza="'.$moneda_poliza.'",  deducible="'.$deducible.'",  prima_afecta="'.$prima_afecta.'",  prima_exenta="'.$prima_exenta.'",  prima_neta="'.$prima_neta.'",
prima_bruta_anual="'.$prima_bruta.'",  monto_asegurado="'.$monto_aseg.'",  numero_propuesta="'.$nro_propuesta.'",  fecha_envio_propuesta="'.$fechaprop.'",  
moneda_comision="'.$moneda_comision.'",  comision="'.$comision.'",  porcentaje_comision="'.$porcentaje_comsion.'",  comision_bruta="'.$comisionbruta.'",
comision_neta="'.$comisionneta.'",  forma_pago="'.$modo_pago.'", nro_cuotas="'.$cuotas.'",  valor_cuota="'.$valorcuota.'",  fecha_primera_cuota="'.$fechaprimer.'", 
vendedor="'.$con_vendedor.'", nombre_vendedor="'.$nombre_vendedor.'", poliza_renovada="'.$poliza_renovada.'" WHERE id='.$id_poliza.';';

mysqli_query($link, $query);
ECHO $query;


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
/*
var nro_poliza= <?php echo $nro_poliza; ?>;
  $.redirect('/bamboo/listado_polizas.php', {
  'busqueda': nro_poliza
}, 'post');
*/
</script>
</body>
</html>