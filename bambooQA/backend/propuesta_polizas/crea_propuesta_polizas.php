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
  $comentarios_ext=estandariza_info($_POST["comentarios_ext"]);
  $comentarios_int=estandariza_info($_POST["comentarios_int"]);
  $vendedor=estandariza_info($_POST["nombre_vendedor"]);
  $forma_pago=estandariza_info($_POST["forma_pago"]);
  $valor_cuota=estandariza_info($_POST["valor_cuota"]);
  $cuotas=estandariza_info($_POST["nro_cuotas"]);
  $moneda_cuota=estandariza_info($_POST["moneda_valor_cuota"]);
  $fechaprimer=estandariza_info($_POST["fecha_primera_cuota"]);


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
  $nro_propuesta=estandariza_info($_POST["numero_propuesta"]);


mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_QA');
//echo "Acción: ->".$_POST["accion"]."<-<br>";
switch ($_POST["accion"]) {

  case 'rechazar_propuesta':
      $query= "update propuesta_polizas_2 set estado='Rechazado', fecha_cambio_estado=CURRENT_TIMESTAMP  where numero_propuesta='".$nro_propuesta."';";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Rechaza propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
      break;
      
  case 'actualiza_propuesta': 
      //pendiente update
      $query='UPDATE propuesta_polizas_2 SET fecha_propuesta=\'' . $fechaprop . '\', rut_proponente=\'' . $rut_prop . '\', dv_proponente=\'' . $dv_prop . '\', compania=\'' . $selcompania . '\',vigencia_inicial=\'' . $fechainicio . '\',vigencia_final=\'' . $fechavenc . '\',ramo=\'' . $ramo . '\',moneda_poliza=\'' . $moneda_poliza . '\',vendedor=\'' . $vendedor . '\',forma_pago=\'' . $forma_pago . '\',moneda_valor_cuota=\'' . $moneda_cuota . '\',valor_cuota=\'' . $valor_cuota . '\',fecha_primera_cuota=\'' . $fechaprimer . '\',nro_cuotas=\'' . $cuotas . '\',comentarios_int=\'' . $comentarios_int . '\',comentarios_ext=\'' . $comentarios_ext . '\' WHERE numero_propuesta=\'' . $nro_propuesta . '\'';
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");


      foreach ($_POST["rutaseg"] as $key => $valor) 
      {
        $rut_completo_aseg = str_replace("-", "", estandariza_info($_POST["rutaseg"][$key]));
        $rut_aseg=estandariza_info(substr($rut_completo_aseg, 0, strlen($rut_completo_aseg)-1));
        $dv_aseg=estandariza_info(substr($rut_completo_aseg, -1,1));
        $materia=estandariza_info($_POST["materia"][$key]);
        $detalle_materia=estandariza_info($_POST["detalle_materia"][$key]);
        $cobertura=estandariza_info($_POST["cobertura"][$key]);
        $deducible=cambia_puntos_por_coma(estandariza_info($_POST["deducible"][$key]));
        $tasa_afecta=cambia_puntos_por_coma(estandariza_info($_POST["tasa_afecta"][$key]));
        $tasa_exenta=cambia_puntos_por_coma(estandariza_info($_POST["tasa_exenta"][$key]));
        $prima_afecta=cambia_puntos_por_coma(estandariza_info($_POST["prima_afecta"][$key]));
        $prima_exenta=cambia_puntos_por_coma(estandariza_info($_POST["prima_exenta"][$key]));
        $prima_neta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta"][$key]));
        $prima_bruta=cambia_puntos_por_coma(estandariza_info($_POST["prima_bruta"][$key]));
        $monto_aseg=cambia_puntos_por_coma(estandariza_info($_POST["monto_aseg"][$key]));
        $venc_gtia=estandariza_info($_POST["venc_gtia"][$key]);
        $numero_item=estandariza_info($_POST["numero_item"][$key]);

        $query='UPDATE items SET rut_asegurado=\'' . $rut_aseg . '\',dv_asegurado=\'' . $dv_aseg . '\',materia_asegurada=\'' . $materia . '\',patente_ubicacion=\'' . $detalle_materia . '\',cobertura=\'' . $cobertura . '\',deducible=\'' . $deducible . '\', tasa_afecta=\'' . $tasa_afecta . '\', tasa_exenta=\'' . $tasa_exenta . '\', prima_afecta=\'' . $prima_afecta . '\', prima_exenta=\'' . $prima_exenta . '\', prima_neta=\'' . $prima_neta . '\', prima_bruta_anual=\'' . $prima_bruta . '\', monto_asegurado=\'' . $monto_aseg . '\', venc_gtia=\'' . $venc_gtia . '\' , fecha_ultima_modificacion=CURRENT_TIMESTAMP WHERE numero_propuesta=\'' . $nro_propuesta . '\' and numero_item=\'' . $numero_item . '\';';
        mysqli_query($link, $query);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza ítem', '".str_replace("'","**",$query)."','Ítems','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
      }
      break;

  case 'crear_propuesta':
    // creación propuesta
        $id_propuesta='';
        $nro_propuesta='';
        //crea token
        $largo = 6;
        $token = bin2hex(random_bytes($largo));
        $query= "INSERT INTO propuesta_polizas_2 (estado, token, rut_proponente,dv_proponente,fecha_propuesta, vigencia_inicial, vigencia_final, moneda_poliza, compania, ramo, comentarios_int, comentarios_ext, vendedor, tipo_propuesta, forma_pago, valor_cuota, nro_cuotas, moneda_valor_cuota, fecha_primera_cuota) VALUES ('Pendiente', '".$token."', '".$rut_prop."', '".$dv_prop."', '".$fechaprop."', '".$fechainicio."', '".$fechavenc."',  '".$moneda_poliza."', '".$selcompania."', '".$ramo."', '".$comentarios_int."','".$comentarios_ext."', '".$vendedor."' , 'Estándar', '".$forma_pago."', '".$valor_cuota."', '".$cuotas."', '".$moneda_cuota."', '".$fechaprimer."')";
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
        $tasa_afecta=cambia_puntos_por_coma(estandariza_info($_POST["tasa_afecta"][$key]));
        $tasa_exenta=cambia_puntos_por_coma(estandariza_info($_POST["tasa_exenta"][$key]));
        $prima_afecta=cambia_puntos_por_coma(estandariza_info($_POST["prima_afecta"][$key]));
        $prima_exenta=cambia_puntos_por_coma(estandariza_info($_POST["prima_exenta"][$key]));
        $prima_neta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta"][$key]));
        $prima_bruta=cambia_puntos_por_coma(estandariza_info($_POST["prima_bruta"][$key]));
        $monto_aseg=cambia_puntos_por_coma(estandariza_info($_POST["monto_aseg"][$key]));
        $venc_gtia=estandariza_info($_POST["venc_gtia"][$key]);
        $query_items="INSERT INTO items(numero_propuesta, numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado, venc_gtia) VALUES ('".$nro_propuesta."', '".(intval($key)+1)."','".$rut_aseg."','".$dv_aseg."','".$materia."','".$detalle_materia."','".$cobertura."','".$deducible."','".$tasa_afecta."','".$tasa_exenta."','".$prima_afecta."','".$prima_exenta."','".$prima_neta."','".$prima_bruta."','".$monto_aseg."','".$venc_gtia."')";
        mysqli_query($link, $query_items);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Agrega ítems', '".str_replace("'","**",$query_items)."','Ítems', CONCAT('".$nro_propuesta."','[','".(intval($key)+1)."', ']') , '".$_SERVER['PHP_SELF']."')");
      }
        break;
  case 'crea_poliza':
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

        // creación poliza
          // Actualiza ítems y asigna nro propuesta
            foreach ($_POST["rutaseg"] as $key => $valor) 
            {
              $rut_completo_aseg = str_replace("-", "", estandariza_info($_POST["rutaseg"][$key]));
              $rut_aseg=estandariza_info(substr($rut_completo_aseg, 0, strlen($rut_completo_aseg)-1));
              $dv_aseg=estandariza_info(substr($rut_completo_aseg, -1,1));
              $materia=estandariza_info($_POST["materia"][$key]);
              $detalle_materia=estandariza_info($_POST["detalle_materia"][$key]);
              $cobertura=estandariza_info($_POST["cobertura"][$key]);
              $deducible=cambia_puntos_por_coma(estandariza_info($_POST["deducible"][$key]));
              $tasa_afecta=cambia_puntos_por_coma(estandariza_info($_POST["tasa_afecta"][$key]));
              $tasa_exenta=cambia_puntos_por_coma(estandariza_info($_POST["tasa_exenta"][$key]));
              $prima_afecta=cambia_puntos_por_coma(estandariza_info($_POST["prima_afecta"][$key]));
              $prima_exenta=cambia_puntos_por_coma(estandariza_info($_POST["prima_exenta"][$key]));
              $prima_neta=cambia_puntos_por_coma(estandariza_info($_POST["prima_neta"][$key]));
              $prima_bruta=cambia_puntos_por_coma(estandariza_info($_POST["prima_bruta"][$key]));
              $monto_aseg=cambia_puntos_por_coma(estandariza_info($_POST["monto_aseg"][$key]));
              $venc_gtia=estandariza_info($_POST["venc_gtia"][$key]);
              $numero_item=estandariza_info($_POST["numero_item"][$key]);
      
              $query='UPDATE items SET numero_poliza=\'' . $nro_poliza . '\', rut_asegurado=\'' . $rut_aseg . '\',dv_asegurado=\'' . $dv_aseg . '\',materia_asegurada=\'' . $materia . '\',patente_ubicacion=\'' . $detalle_materia . '\',cobertura=\'' . $cobertura . '\',deducible=\'' . $deducible . '\', tasa_afecta=\'' . $tasa_afecta . '\', tasa_exenta=\'' . $tasa_exenta . '\', prima_afecta=\'' . $prima_afecta . '\', prima_exenta=\'' . $prima_exenta . '\', prima_neta=\'' . $prima_neta . '\', prima_bruta_anual=\'' . $prima_bruta . '\', monto_asegurado=\'' . $monto_aseg . '\', venc_gtia=\'' . $venc_gtia . '\', fecha_ultima_modificacion=CURRENT_TIMESTAMP WHERE numero_propuesta=\'' . $nro_propuesta . '\' and numero_item=\'' . $numero_item . '\';';
              mysqli_query($link, $query);
              mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza ítem', '".str_replace("'","**",$query)."','Ítems','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
            }


          //Aprueba propuesta póliza
          $query= "update propuesta_polizas_2 set estado='Aprobada', fecha_cambio_estado=CURRENT_TIMESTAMP  where numero_propuesta=".$nro_propuesta;
          mysqli_query($link, $query);
          mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Aprueba propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
  
        //crea token
        $largo = 6;
        $token = bin2hex(random_bytes($largo));
        $query= "INSERT INTO polizas_2(estado, token, rut_proponente,dv_proponente,fecha_propuesta, vigencia_inicial, vigencia_final, moneda_poliza, compania, ramo, comentarios_int, comentarios_ext, vendedor, tipo_propuesta, forma_pago, valor_cuota, nro_cuotas, moneda_valor_cuota, fecha_primera_cuota, numero_propuesta, numero_poliza, comision, porcentaje_comision, comision_bruta, comision_neta, depositado_fecha, comision_negativa, boleta_negativa, numero_boleta) VALUES ('Pendiente', '".$token."', '".$rut_prop."', '".$dv_prop."', '".$fechaprop."', '".$fechainicio."', '".$fechavenc."',  '".$moneda_poliza."', '".$selcompania."', '".$ramo."', '".$comentarios_int."','".$comentarios_ext."', '".$vendedor."' , 'Estándar', '".$forma_pago."', '".$valor_cuota."', '".$cuotas."', '".$moneda_cuota."', '".$fechaprimer."' , '".$nro_propuesta."', '".$nro_poliza."', '".$comision."', '".$porcentaje_comsion."', '".$comisionbruta."', '".$comisionneta."', '".$fechadeposito."', '".$comisionneg."', '".$boletaneg."', '".$boleta."');";
        mysqli_query($link, $query);
        $resultado = mysqli_query($link, 'select id from polizas_2 where token=\'' . $token . '\';');
        while ($fila = mysqli_fetch_object($resultado))
        {
            // printf ("%s (%s)\n", $fila->id);
            $id_propuesta = $fila->id;
        }
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Creación póliza', '".str_replace("'","**",$query)."','poliza', '".$id_propuesta."' , '".$_SERVER['PHP_SELF']."')");
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

alert("Propuesta Póliza registrada correctamente");
var nro_propuesta= '<?php echo $nro_propuesta; ?>';
  $.redirect('/bambooQA/listado_propuesta_polizas.php', {
 'busqueda': nro_propuesta
}, 'post');

</script>
</body>
</html>