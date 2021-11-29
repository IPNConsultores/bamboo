<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";

//Ingresar
  //Propuesta
  $rut_completo_prop = str_replace("-", "", estandariza_info($_POST["rutprop"]));
  $rut_prop=estandariza_info(substr($rut_completo_prop, 0, strlen($rut_completo_prop)-1));
  $dv_prop=estandariza_info(substr($rut_completo_prop, -1,1));
  $fechaprop=estandariza_info($_POST["fechaprop"]);
  $fechainicio=estandariza_info($_POST["fechainicio"]);
  $fechavenc=estandariza_info($_POST["fechavenc"]);
  $moneda_poliza=estandariza_info($_POST["moneda_poliza"]);
  $selcompania=estandariza_info($_POST["selcompania"]);
  $ramo=estandariza_info($_POST["ramo"]);
  $comentario=estandariza_info($_POST["comentario"]);
  $vendedor=estandariza_info($_POST["nombre_vendedor"]);


  /*item
  $rut_completo_aseg = $_POST["rutaseg"];
  echo $_POST["rutaseg"]."<br>";
  $rut_aseg=estandariza_info(substr($rut_completo_aseg, 0, strlen($rut_completo_aseg)-1));
  $dv_aseg=estandariza_info(substr($rut_completo_aseg, -1,1));
  $materia=estandariza_info($_POST["materia"]);
  $detalle_materia=estandariza_info($_POST["detalle_materia"]);
  $cobertura=estandariza_info($_POST["cobertura"]);
  $deducible=cambia_puntos_por_coma(estandariza_info($_POST["deducible"]));
  $prima_afecta=cambia_puntos_por_coma(estandariza_info($_POST["prima_afecta"]));
  $prima_exenta=cambia_puntos_por_coma(estandariza_info($_POST["prima_exenta"]));
  $prima_neta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta"]));
  $prima_bruta=cambia_puntos_por_coma(estandariza_info($_POST["prima_bruta"]));
  $monto_aseg=cambia_puntos_por_coma(estandariza_info($_POST["monto_aseg"]));
  $venc_gtia=estandariza_info($_POST["venc_gtia"]);
    */


//Modificar
  $nro_propuesta=estandariza_info($_POST["nro_propuesta"]);


mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_QA');
echo "Acción: ->".$_POST["accion"]."<-<br>";
switch ($_POST["accion"]) {

  case 'rechazar':
      $query= "update propuesta_polizas_2 set estado='Rechazado', fecha_cambio_estado=CURRENT_TIMESTAMP  where numero_propuesta='".$nro_propuesta."';";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Rechaza propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza',".$nro_propuesta.", '".$_SERVER['PHP_SELF']."')");
      break;
  case 'modificar': 
      //pendiente update
      break;
  case 'crear_propuesta':
    // creación propuesta
        $id_propuesta='';
        $nro_propuesta='';
        //crea token
        $largo = 6;
        $token = bin2hex(random_bytes($largo));
        $query= "INSERT INTO propuesta_polizas_2 (estado, token, rut_proponente,dv_proponente,fecha_propuesta, vigencia_inicial, vigencia_final, moneda_poliza, compania, ramo, comentarios, vendedor) VALUES ('Pendiente', '".$token."', '".$rut_prop."', '".$dv_prop."', '".$fechaprop."', '".$fechainicio."', '".$fechavenc."',  '".$moneda_poliza."', '".$selcompania."', '".$ramo."', '".$comentario."', '".$vendedor."' )";
        mysqli_query($link, $query);
        mysqli_query($link, 'update propuesta_polizas_2 set numero_propuesta=CONCAT(\'P\', LPAD(id,6,0)) where token=\'' . $token . '\';');
        $resultado = mysqli_query($link, 'select id, numero_propuesta from propuesta_polizas_2 where token=\'' . $token . '\';');
        
        while ($fila = mysqli_fetch_object($resultado))
        {
            // printf ("%s (%s)\n", $fila->id);
            $id_propuesta = $fila->id;
            $nro_propuesta = $fila->numero_propuesta;
        }
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Creación propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza', '".$nro_propuesta."' , '".$_SERVER['PHP_SELF']."')");
    // Incorporar ítems
    
      foreach ($_POST["rutaseg"] as $key => $valor) 
      {
        $nombrecontact = str_replace("-", "", estandariza_info($_POST['nombrecontact'][$key]));

        //item
        $rut_completo_aseg = str_replace("-", "", estandariza_info($_POST["rutaseg"][$key]));
        $rut_aseg=estandariza_info(substr($rut_completo_aseg, 0, strlen($rut_completo_aseg)-1));
        $dv_aseg=estandariza_info(substr($rut_completo_aseg, -1,1));
        $materia=estandariza_info($_POST["materia"][$key]);
        $detalle_materia=estandariza_info($_POST["detalle_materia"][$key]);
        $cobertura=estandariza_info($_POST["cobertura"][$key]);
        $deducible=cambia_puntos_por_coma(estandariza_info($_POST["deducible"][$key]));
        $prima_afecta=cambia_puntos_por_coma(estandariza_info($_POST["prima_afecta"][$key]));
        $prima_exenta=cambia_puntos_por_coma(estandariza_info($_POST["prima_exenta"][$key]));
        $prima_neta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta"][$key]));
        $prima_bruta=cambia_puntos_por_coma(estandariza_info($_POST["prima_bruta"][$key]));
        $monto_aseg=cambia_puntos_por_coma(estandariza_info($_POST["monto_aseg"][$key]));
        $venc_gtia=estandariza_info($_POST["venc_gtia"][$key]);
        $query_items="INSERT INTO items(numero_propuesta, numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado, venc_gtia) VALUES ('".$nro_propuesta."', '".(intval($key)+1)."','".$rut_aseg."','".$dv_aseg."','".$materia."','".$detalle_materia."','".$cobertura."','".$deducible."','".$prima_afecta."','".$prima_exenta."','".$prima_neta."','".$prima_bruta."','".$monto_aseg."','".$venc_gtia."')";
        mysqli_query($link, $query_items);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Agrega ítems', '".str_replace("'","**",$query_items)."','Ítems', CONCAT('".$nro_propuesta."','[','".(intval($key)+1)."', ']') , '".$_SERVER['PHP_SELF']."')");
      }
        break;
  case 'crea_poliza':
        // creación poliza
          //poliza
          $nro_poliza= estandariza_info($_POST["nro_poliza"]);
          $comision= cambia_puntos_por_coma(estandariza_info($_POST["comision"]));
          $porcentaje_comsion= cambia_puntos_por_coma(estandariza_info($_POST["porcentaje_comsion"]));
          $comisionbruta= cambia_puntos_por_coma(estandariza_info($_POST["comisionbruta"]));
          $comisionneta= cambia_puntos_por_coma(estandariza_info($_POST["comisionneta"]));
          $fechadeposito= estandariza_info($_POST["fechadeposito"]);
          $comisionneg= cambia_puntos_por_coma(estandariza_info($_POST["comisionneg"]));
          $boletaneg= estandariza_info($_POST["boletaneg"]);
          $boleta= estandariza_info($_POST["boleta"]);
          $cuotas= estandariza_info($_POST["cuotas"]);
          $valorcuota= cambia_puntos_por_coma(estandariza_info($_POST["valorcuota"]));
          $fechaprimer= estandariza_info($_POST["fechaprimer"]);

          //Aprueba propuesta póliza
          $query= "update propuesta_polizas_2 set estado='Aprobada', fecha_cambio_estado=CURRENT_TIMESTAMP  where numero_propuesta=".$nro_propuesta;
          mysqli_query($link, $query);
          mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Aprueba propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza',".$nro_propuesta.", '".$_SERVER['PHP_SELF']."')");
  
        //crea token
        $largo = 6;
        $token = bin2hex(random_bytes($largo));
        $query= "INSERT INTO polizas_2(rut_proponente, dv_proponente, numero_propuesta, vigencia_inicial,vigencia_final, moneda_poliza, compania, ramo, nombre_vendedor, numero_poliza, comision, porcentaje_comision, comision_bruta, comision_neta, depositado_fecha, comision_negativa, boleta_negativa, numero_boleta, nro_cuotas, valor_cuota, fecha_primera_cuota) VALUES (,,,,,,,,,,,,,,,,,,,,)";
        mysqli_query($link, $query);
        $resultado = mysqli_query($link, 'select id, numero_propuesta from propuesta_polizas_2 where token=\'' . $token . '\';');
        while ($fila = mysqli_fetch_object($resultado))
        {
            // printf ("%s (%s)\n", $fila->id);
            $id_propuesta = $fila->id;
            $nro_propuesta = $fila->numero_propuesta;
        }
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Creación propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza', '".$nro_propuesta."' , '".$_SERVER['PHP_SELF']."')");
    // Incorporar ítems
    break;
//echo $query;
}
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