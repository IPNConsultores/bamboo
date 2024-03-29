<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
$mensaje='';
$busqueda='';
$listado='';
if ($_SERVER[ "REQUEST_METHOD" ] == "POST")
    {
        $tipo_endoso=cambia_puntos_por_coma(estandariza_info($_POST["tipo_endoso"]));
        $ramo=estandariza_info($_POST["ramo"]);
        $compania=estandariza_info($_POST["compania"]);
        $nro_poliza=estandariza_info($_POST["nro_poliza"]);
        $id_poliza=estandariza_info($_POST["id_poliza"]);
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
        $prima_neta_afecta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta_afecta"]));
        $prima_neta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta"]));
        $prima_total=cambia_puntos_por_coma(estandariza_info($_POST["prima_total"]));
        $tasa_afecta=cambia_puntos_por_coma(estandariza_info($_POST["tasa_afecta"]));
        $tasa_exenta=cambia_puntos_por_coma(estandariza_info($_POST["tasa_exenta"]));
        $fecha_prorroga=cambia_puntos_por_coma(estandariza_info($_POST["fecha_prorroga"]));
        $comentario_endoso=cambia_puntos_por_coma(estandariza_info($_POST["comentario_endoso"]));

            
    switch ($_POST["accion"]){
        case 'crea_propuesta_endoso_manual':
            $listado='/bamboo/listado_propuesta_endosos.php';
            $mensaje='Propuesta de endoso creada correctamente';
            $largo = 6;
            $token = bin2hex(random_bytes($largo));
            $query="insert into propuesta_endosos(comentario_endoso, fecha_prorroga, tasa_afecta_endoso, tasa_exenta_endoso, estado, tipo_endoso, ramo, numero_poliza, fecha_ingreso_endoso, vigencia_inicial, vigencia_final, rut_proponente, dv_proponente, nombre_proponente, descripcion_endoso, dice, debe_decir, monto_asegurado_endoso, moneda_poliza_endoso, prima_neta_exenta, IVA, prima_neta_afecta, prima_total, token, id_poliza, compania, prima_neta) values ('".$comentario_endoso."','".$fecha_prorroga."','".$tasa_afecta."','".$tasa_exenta."','Pendiente','".$tipo_endoso."','".$ramo."',  '".$nro_poliza."','".$fecha_ingreso."','".$fecha_vigencia_inicial."','".$fecha_vigencia_final."','".$rut_prop."','".$dv_prop."','".$nombre."','".$descripcion_endoso."','".$dice."','".$debe_decir."','".$monto."','".$moneda_poliza."','".$prima_neta_exenta."','".$iva."','".$prima_neta_afecta."','".$prima_total."','".$token."','".$id_poliza."','".$compania."','".$prima_neta."')";
            mysqli_query($link, $query);
            mysqli_query($link, 'update propuesta_endosos set numero_propuesta_endoso=CONCAT(\'E\', LPAD(id,6,0)) where token=\'' . $token . '\';');
            $resultado = mysqli_query($link, 'select id, numero_propuesta_endoso from propuesta_endosos where token=\'' . $token . '\';');
            while ($fila = mysqli_fetch_object($resultado))
            {
                // printf ("%s (%s)\n", $fila->id);
                $id_poliza = $fila->id;
                $numero_propuesta_endoso = $fila->numero_propuesta_endoso;
            }
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Creación propuesta endoso', '".str_replace("'","**",$query)."','propuesta_endoso', '".$id_poliza."' , '".$_SERVER['PHP_SELF']."')");
            $busqueda=$numero_propuesta_endoso;
            break;
        case 'actualiza_propuesta':
            $id_endoso=cambia_puntos_por_coma(estandariza_info($_POST["id"]));
            $numero_propuesta_endoso=cambia_puntos_por_coma(estandariza_info($_POST["numero_propuesta_endoso"]));
            $listado='/bamboo/listado_propuesta_endosos.php';
            $mensaje='Propuesta de endoso actualizada correctamente';
            $query="UPDATE propuesta_endosos SET comentario_endoso='".$comentario_endoso."',fecha_prorroga='".$fecha_prorroga."', fecha_ingreso_endoso='".$fecha_ingreso."',tipo_endoso='".$tipo_endoso."',ramo='".$ramo."',compania='".$compania."',rut_proponente='".$rut_prop."',dv_proponente='".$dv_prop."',nombre_proponente='".$nombre."',vigencia_inicial='".$fecha_vigencia_inicial."',vigencia_final='".$fecha_vigencia_final."',descripcion_endoso='".$descripcion_endoso."',dice='".$dice."',debe_decir='".$debe_decir."',monto_asegurado_endoso='".$monto."',moneda_poliza_endoso='".$moneda_poliza."',tasa_afecta_endoso='".$tasa_afecta."',tasa_exenta_endoso='".$tasa_exenta."',prima_neta_exenta='".$prima_neta_exenta."',IVA='".$iva."',prima_neta_afecta='".$prima_neta_afecta."',prima_total='".$prima_total."', prima_neta='".$prima_neta."' WHERE id='".$id_endoso."'";
            mysqli_query($link, $query);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Modificación propuesta endoso', '".str_replace("'","**",$query)."','propuesta_endoso', '".$_POST["numero_propuesta_endoso"]."' , '".$_SERVER['PHP_SELF']."')");
            $busqueda=$numero_propuesta_endoso;
            break;
        case 'actualiza_endoso':
            $numero_propuesta_endoso=cambia_puntos_por_coma(estandariza_info($_POST["numero_propuesta_endoso"]));
            $id_endoso=cambia_puntos_por_coma(estandariza_info($_POST["id"]));
            $numero_endoso=cambia_puntos_por_coma(estandariza_info($_POST["numero_endoso"]));
            $fecha_emision=cambia_puntos_por_coma(estandariza_info($_POST["fecha_emision"]));
            $listado='/bamboo/listado_endosos.php';
            $mensaje='Endoso actualizada correctamente';
            $query="UPDATE endosos SET fecha_emision='".$fecha_emision."', numero_endoso='".$numero_endoso."', comentario_endoso='".$comentario_endoso."',fecha_prorroga='".$fecha_prorroga."', fecha_ingreso_endoso='".$fecha_ingreso."',tipo_endoso='".$tipo_endoso."',ramo='".$ramo."',compania='".$compania."',rut_proponente='".$rut_prop."',dv_proponente='".$dv_prop."',nombre_proponente='".$nombre."',vigencia_inicial='".$fecha_vigencia_inicial."',vigencia_final='".$fecha_vigencia_final."',descripcion_endoso='".$descripcion_endoso."',dice='".$dice."',debe_decir='".$debe_decir."',monto_asegurado_endoso='".$monto."',moneda_poliza_endoso='".$moneda_poliza."',tasa_afecta_endoso='".$tasa_afecta."',tasa_exenta_endoso='".$tasa_exenta."',prima_neta_exenta='".$prima_neta_exenta."',IVA='".$iva."',prima_neta_afecta='".$prima_neta_afecta."' ,prima_total='".$prima_total."' ,prima_neta='".$prima_neta."' WHERE id='".$id_endoso."'";
            mysqli_query($link, $query);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Modificación endoso', '".str_replace("'","**",$query)."','endoso', '".$id_endoso."' , '".$_SERVER['PHP_SELF']."')");
            $busqueda=$numero_propuesta_endoso;
            break;
        case 'crear_endoso':
            $numero_propuesta_endoso=cambia_puntos_por_coma(estandariza_info($_POST["numero_propuesta_endoso"]));
            $id_propuesta_endoso=cambia_puntos_por_coma(estandariza_info($_POST["id"]));
            $numero_endoso=cambia_puntos_por_coma(estandariza_info($_POST["numero_endoso"]));
            $fecha_emision=cambia_puntos_por_coma(estandariza_info($_POST["fecha_emision"]));
            $listado='/bamboo/listado_endosos.php';
            $mensaje='Endoso creado correctamente';
            $query="INSERT INTO endosos(fecha_emision, fecha_prorroga, numero_endoso,comentario_endoso,  id_poliza, numero_propuesta_endoso, fecha_ingreso_endoso, tipo_endoso, ramo, compania, numero_poliza, rut_proponente, dv_proponente, nombre_proponente, vigencia_inicial, vigencia_final, descripcion_endoso, dice, debe_decir, monto_asegurado_endoso, moneda_poliza_endoso, tasa_afecta_endoso, tasa_exenta_endoso, prima_neta_exenta, IVA, prima_neta_afecta, prima_total, prima_neta) VALUES ('".$fecha_emision."', '".$fecha_prorroga."','".$numero_endoso."','".$comentario_endoso."','".$id_poliza."','".$numero_propuesta_endoso."','".$fecha_ingreso."','".$tipo_endoso."','".$ramo."','".$compania."','".$nro_poliza."','".$rut_prop."','".$dv_prop."','".$nombre."','".$fecha_vigencia_inicial."','".$fecha_vigencia_final."','".$descripcion_endoso."','".$dice."','".$debe_decir."','".$monto."','".$moneda_poliza."','".$tasa_afecta."','".$tasa_afecta."','".$prima_neta_exenta."','".$iva."','".$prima_neta_afecta."','".$prima_total."','".$prima_neta."')";
            mysqli_query($link, $query);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Creación endoso', '".str_replace("'","**",$query)."','endoso', '".$numero_endoso."' , '".$_SERVER['PHP_SELF']."')");
            $busqueda=$numero_propuesta_endoso;
            
            $query= "update propuesta_endosos set estado='Emitido'  where id='".$id_propuesta_endoso."'";
            mysqli_query($link, $query);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Aprueba propuesta endoso', '".str_replace("'","**",$query)."','propuesta_endoso','".$_POST["numero_propuesta_endoso"]."', '".$_SERVER['PHP_SELF']."')");
   
            break;
            case 'crea_propuesta_endoso_web':
                $numero_propuesta_endoso=cambia_puntos_por_coma(estandariza_info($_POST["numero_propuesta_endoso"]));
                $numero_endoso=cambia_puntos_por_coma(estandariza_info($_POST["numero_endoso"]));
                $fecha_emision=cambia_puntos_por_coma(estandariza_info($_POST["fecha_emision"]));
                $listado='/bamboo/listado_endosos.php';
                $mensaje='Endoso creado correctamente';
                $largo = 6;
                $token = bin2hex(random_bytes($largo));
                $query="INSERT INTO endosos(fecha_emision, fecha_prorroga, numero_endoso,comentario_endoso,  id_poliza, numero_propuesta_endoso, fecha_ingreso_endoso, tipo_endoso, ramo, compania, numero_poliza, rut_proponente, dv_proponente, nombre_proponente, vigencia_inicial, vigencia_final, descripcion_endoso, dice, debe_decir, monto_asegurado_endoso, moneda_poliza_endoso, tasa_afecta_endoso, tasa_exenta_endoso, prima_neta_exenta, IVA, prima_neta_afecta, prima_total, prima_neta, token) VALUES ('".$fecha_emision."', '".$fecha_prorroga."','".$numero_endoso."','".$comentario_endoso."','".$id_poliza."','".$numero_propuesta_endoso."','".$fecha_ingreso."','".$tipo_endoso."','".$ramo."','".$compania."','".$nro_poliza."','".$rut_prop."','".$dv_prop."','".$nombre."','".$fecha_vigencia_inicial."','".$fecha_vigencia_final."','".$descripcion_endoso."','".$dice."','".$debe_decir."','".$monto."','".$moneda_poliza."','".$tasa_afecta."','".$tasa_afecta."','".$prima_neta_exenta."','".$iva."','".$prima_neta_afecta."','".$prima_total."','".$prima_neta."', '".$token."')";
                mysqli_query($link, $query);
                mysqli_query($link, 'update endosos set numero_propuesta_endoso=CONCAT(\'E2\', LPAD(id,5,0)) where token=\'' . $token . '\';');
                $resultado = mysqli_query($link, 'select id, numero_propuesta_endoso from endosos where token=\'' . $token . '\';');
                while ($fila = mysqli_fetch_object($resultado))
                {
                    // printf ("%s (%s)\n", $fila->id);
                    $id= $fila->id;
                    $numero_propuesta_endoso = $fila->numero_propuesta_endoso;
                }
                $busqueda=$numero_propuesta_endoso;
                mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Creación endoso web', '".str_replace("'","**",$query)."','endoso', '".$id."' , '".$_SERVER['PHP_SELF']."')");
                break;
        case 'rechazar_propuesta':
            $id_propuesta_endoso=cambia_puntos_por_coma(estandariza_info($_POST["id"]));
            $nro_propuesta=cambia_puntos_por_coma(estandariza_info($_POST["numero_propuesta"]));
            $listado='/bamboo/listado_propuesta_endosos.php';
            $mensaje='Propuesta Endoso rechazada correctamente';
                $query= "update propuesta_endosos set estado='Rechazado', motivo_rechazo='".estandariza_info($_POST["motivo"])."'  where id='".$id_propuesta_endoso."';";
                mysqli_query($link, $query);
                mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Rechaza propuesta endoso', '".str_replace("'","**",$query)."','propuesta_endoso','".$id_propuesta_endoso."', '".$_SERVER['PHP_SELF']."')");
                break;
    }
    
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

