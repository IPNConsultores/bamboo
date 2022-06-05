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
$nro_propuesta=estandariza_info($_POST["nro_propuesta"]);
$cobertura=estandariza_info($_POST["cobertura"]);
$materia=estandariza_info($_POST["materia"]);
$detalle_materia=estandariza_info($_POST["detalle_materia"]);
$moneda_poliza=estandariza_info($_POST["moneda_poliza"]);
$deducible=cambia_puntos_por_coma(estandariza_info($_POST["deducible"]));
$prima_afecta=cambia_puntos_por_coma(estandariza_info($_POST["prima_afecta"]));
$prima_exenta=cambia_puntos_por_coma(estandariza_info($_POST["prima_exenta"]));
$prima_neta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta"]));
$prima_bruta=cambia_puntos_por_coma(estandariza_info($_POST["prima_bruta"]));
$monto_aseg=estandariza_info($_POST["monto_aseg"]);
$nro_propuesta=estandariza_info($_POST["nro_propuesta"]);
$fechaprop=estandariza_info($_POST["fechaprop"]);
$item  = estandariza_info($_POST["item"]);

mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_prePAP');
switch ($_POST["accion"]) {
    case 'elimina':
        $query="delete from propuesta_polizas where id=".$_POST["id_propuesta"];
        mysqli_query($link, $query);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Elimina propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza',".$_POST["id_propuesta"].", '".$_SERVER['PHP_SELF']."')");
        break;
    case 'cancelar':
        $query= "update propuesta_polizas set estado='Cancelado', fech_cancela='".$_POST["datofecha_cancelacion"]."',motivo_cancela ='".$_POST["datomotivo_cancela"]."' where id=".$_POST["id_propuesta"];
        mysqli_query($link, $query);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Cancela propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza',".$_POST["id_propuesta"].", '".$_SERVER['PHP_SELF']."')");
        break;
    case 'anular':
        $query= "update polizas set estado='Anulado' where id=".$_POST["id_propuesta"];
        mysqli_query($link, $query);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Anula propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza',".$_POST["id_propuesta"].", '".$_SERVER['PHP_SELF']."')");
        break;
    default:
        //edición de campos
        $query="UPDATE propuesta_polizas SET rut_proponente='".$rut_prop."',  dv_proponente='".$dv_prop."',  rut_asegurado='".$rut_aseg."',  dv_asegurado='".$dv_aseg."',  compania='".$selcompania."', ramo='".$ramo."',  vigencia_inicial='".$fechainicio."',  vigencia_final='".$fechavenc."',  cobertura='".$cobertura."',  materia_asegurada='".$materia."',  patente_ubicacion='".$detalle_materia."', moneda_poliza='".$moneda_poliza."',  deducible='".$deducible."',  prima_afecta='".$prima_afecta."',  prima_exenta='".$prima_exenta."',  prima_neta='".$prima_neta."', prima_bruta_anual='".$prima_bruta."',  monto_asegurado='".$monto_aseg."',  numero_propuesta='".$nro_propuesta."',  fecha_envio_propuesta='".$fechaprop."', item = '".$item."'   WHERE id=".$id_poliza.";";
        mysqli_query($link, $query);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza',".$_POST["id_propuesta"].", '".$_SERVER['PHP_SELF']."')");
        break;
 echo $query;
}
mysqli_close($link);

function estandariza_info($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function cambia_puntos_por_coma($data){
   // $data=str_replace('.','',$data);
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
alert("Póliza Modificada Correctamente");
var nro_propuesta= '<?php echo $nro_propuesta; ?>';
 $.redirect('/bamboo_prePAP/listado_propuesta_polizas.php', {
 'busqueda': nro_propuesta
}, 'post');


</script>

</body>
</html>