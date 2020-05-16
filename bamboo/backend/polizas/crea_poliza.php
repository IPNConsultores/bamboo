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
 $valorcuota=estandariza_info($_POST["moneda_cuota"]);
 $valorcuota=estandariza_info($_POST["valorcuota"]);
 $fechaprimer=estandariza_info($_POST["fechaprimer"]);
 $con_vendedor=estandariza_info($_POST["con_vendedor"]);
 $nombre_vendedor=estandariza_info($_POST["nombre_vendedor"]);
 $poliza_renovada=estandariza_info($_POST["poliza_renovada"]);

mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
$query='INSERT INTO polizas (  estado, tipo_poliza, moneda_valor_cuota,  rut_proponente,  dv_proponente,  rut_asegurado,  dv_asegurado,  compania,  ramo,  vigencia_inicial,  vigencia_final,  numero_poliza,  cobertura,  materia_asegurada,  patente_ubicacion, moneda_poliza,  deducible,  prima_afecta,  prima_exenta,  prima_neta,  prima_bruta_anual,  monto_asegurado,  numero_propuesta,  fecha_envio_propuesta,  moneda_comision,  comision,  porcentaje_comision,  comision_bruta,  comision_neta,  forma_pago, nro_cuotas,  valor_cuota,  fecha_primera_cuota,  vendedor, nombre_vendedor, poliza_renovada) VALUES ( "Activo", "Nuevo", "UF","'.$rut_prop.'","'.$dv_prop.'","'.$rut_aseg.'","'.$dv_aseg.'","'.$selcompania.'","'.$ramo.'","'.$fechainicio.'","'.$fechavenc.'","'.$nro_poliza.'","'.$cobertura.'","'.$materia.'","'.$detalle_materia.'","'.$moneda_poliza.'","'.$deducible.'","'.$prima_afecta.'","'.$prima_exenta.'","'.$prima_neta.'","'.$prima_bruta.'","'.$monto_aseg.'","'.$nro_propuesta.'","'.$fechaprop.'","'.$moneda_comision.'","'.$comision.'","'.$porcentaje_comsion.'","'.$comisionbruta.'","'.$comisionneta.'","'.$modo_pago.'","'.$cuotas.'","'.$valorcuota.'","'.$fechaprimer.'","'.$con_vendedor.'","'.$nombre_vendedor.'","'.$poliza_renovada.'");';
mysqli_query($link, $query);
//ECHO $query;


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

var nro_poliza= <?php echo $nro_poliza; ?>;
  $.redirect('/bamboo/listado_polizas.php', {
  'busqueda': nro_poliza
}, 'post');

</script>
</body>
</html>