<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";

    $listado='/bambooQA/listado_propuesta_polizas.php';
    $mensaje='';
    $busqueda='';
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
  $porcentaje_comision= cambia_puntos_por_coma(estandariza_info($_POST["porcentaje_comsion"]));
  $forma_pago=estandariza_info($_POST["forma_pago"]);
  $valor_cuota=estandariza_info($_POST["valor_cuota"]);
  $cuotas=estandariza_info($_POST["nro_cuotas"]);
  $moneda_cuota=estandariza_info($_POST["moneda_valor_cuota"]);
  $fechaprimer=estandariza_info($_POST["fecha_primera_cuota"]);
  $contador_items=estandariza_info($_POST["contador_items"]);
  

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
  case 'eliminar_poliza':
    $busqueda=estandariza_info($_POST["numero_poliza"]);
    $mensaje='Póliza rechazada correctamente';
      $query= "delete from polizas_2 where id='".$busqueda."';";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Rechaza propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
      break;
  case 'cancelar_poliza':
    $busqueda=estandariza_info($_POST["numero_poliza"]);
    $mensaje='Póliza cancelada correctamente';
      $query= "update polizas_2 set estado='Rechazado', fech_cancela=CURRENT_TIMESTAMP, motivo_cancela='".estandariza_info($_POST["motivo"])."'  where id='".$busqueda."';";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Rechaza propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
      break;
  case 'anular_poliza':
    $busqueda=estandariza_info($_POST["numero_poliza"]);
    $mensaje='Póliza anulada correctamente';
      $query= "update polizas_2 set estado='Rechazado', fech_cancela=CURRENT_TIMESTAMP, motivo_cancela='".estandariza_info($_POST["motivo"])."'  where id='".$busqueda."';";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Rechaza propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
      break;
  case 'rechazar_propuesta':
    $busqueda=$nro_propuesta;
    $mensaje='Propuesta Póliza rechazada correctamente';
      $query= "update propuesta_polizas_2 set estado='Rechazado', fecha_cambio_estado=CURRENT_TIMESTAMP, motivo='".estandariza_info($_POST["motivo"])."'  where numero_propuesta='".$nro_propuesta."';";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Rechaza propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
      break;
  case 'envio_propuesta':
    $busqueda=$nro_propuesta;
    $mensaje='Propuesta Póliza generada correctamente';
      $query= "update propuesta_polizas_2 set fecha_envio_propuesta=CURRENT_TIMESTAMP where numero_propuesta='".$nro_propuesta."';";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Envía propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
      break;
  case 'eliminar_propuesta':
    $busqueda=$nro_propuesta;
    $mensaje='Propuesta Póliza eliminada correctamente';
      $query= "delete from propuesta_polizas_2 where numero_propuesta='".$nro_propuesta."';";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Rechaza propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
      break;      
  case 'actualiza_propuesta': 
    $busqueda=$nro_propuesta;
      //pendiente update
      //delete from items where numero_propuesta='P000700' and numero_item>=4
      $mensaje='Propuesta Póliza actualizada correctamente';      
      $query='UPDATE propuesta_polizas_2 SET fecha_propuesta=\'' . $fechaprop . '\', rut_proponente=\'' . $rut_prop . '\', dv_proponente=\'' . $dv_prop . '\', compania=\'' . $selcompania . '\',vigencia_inicial=\'' . $fechainicio . '\',vigencia_final=\'' . $fechavenc . '\',ramo=\'' . $ramo . '\',moneda_poliza=\'' . $moneda_poliza . '\',vendedor=\'' . $vendedor . '\',forma_pago=\'' . $forma_pago . '\',moneda_valor_cuota=\'' . $moneda_cuota . '\',valor_cuota=\'' . $valor_cuota . '\',fecha_primera_cuota=\'' . $fechaprimer . '\',nro_cuotas=\'' . $cuotas . '\',comentarios_int=\'' . $comentarios_int . '\',comentarios_ext=\'' . $comentarios_ext . '\',porcentaje_comision=\'' . $porcentaje_comision . '\' WHERE numero_propuesta=\'' . $nro_propuesta . '\'';
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
        $query="INSERT INTO items(numero_propuesta, numero_poliza,  numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado, venc_gtia) VALUES ('".$nro_propuesta."', 'TBD' ,  '".(intval($key)+1)."','".$rut_aseg."','".$dv_aseg."','".$materia."','".$detalle_materia."','".$cobertura."','".$deducible."','".$tasa_afecta."','".$tasa_exenta."','".$prima_afecta."','".$prima_exenta."','".$prima_neta."','".$prima_bruta."','".$monto_aseg."','".$venc_gtia."' ) 
        ON DUPLICATE KEY UPDATE rut_asegurado='".$rut_aseg."',dv_asegurado='".$dv_aseg."',materia_asegurada='".$materia."',patente_ubicacion='".$detalle_materia."',cobertura='".$cobertura."',deducible='".$deducible."', tasa_afecta='".$tasa_afecta."', tasa_exenta='".$tasa_exenta."', prima_afecta='".$prima_afecta."', prima_exenta='".$prima_exenta."', prima_neta='".$prima_neta."', prima_bruta_anual='".$prima_bruta."', monto_asegurado='".$monto_aseg."', venc_gtia='".$venc_gtia."' , fecha_ultima_modificacion=CURRENT_TIMESTAMP;";
        //$query='UPDATE items SET rut_asegurado=\'' . $rut_aseg . '\',dv_asegurado=\'' . $dv_aseg . '\',materia_asegurada=\'' . $materia . '\',patente_ubicacion=\'' . $detalle_materia . '\',cobertura=\'' . $cobertura . '\',deducible=\'' . $deducible . '\', tasa_afecta=\'' . $tasa_afecta . '\', tasa_exenta=\'' . $tasa_exenta . '\', prima_afecta=\'' . $prima_afecta . '\', prima_exenta=\'' . $prima_exenta . '\', prima_neta=\'' . $prima_neta . '\', prima_bruta_anual=\'' . $prima_bruta . '\', monto_asegurado=\'' . $monto_aseg . '\', venc_gtia=\'' . $venc_gtia . '\' , fecha_ultima_modificacion=CURRENT_TIMESTAMP WHERE numero_propuesta=\'' . $nro_propuesta . '\' and numero_item=\'' . $numero_item . '\';';
        mysqli_query($link, $query);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza ítem', '".str_replace("'","**",$query)."','Ítems',CONCAT('".$nro_propuesta."','[','".(intval($key)+1)."', ']'), '".$_SERVER['PHP_SELF']."')");
      }
      $query="delete from items where numero_propuesta='".$nro_propuesta."' and numero_item>".$contador_items.";";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Corrige cantidad de ítems', '".str_replace("'","**",$query)."','Ìtems','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
      break;

  case 'crear_propuesta':
    
    // creación propuesta
    $mensaje='Propuesta Póliza registrada correctamente';
    $accion_secundaria= estandariza_info($_POST["accion_secundaria"]);
    $poliza_renovada= estandariza_info($_POST["poliza_renovada"]);
        $id_propuesta='';
        $nro_propuesta='';
        //crea token
        $largo = 6;
        $token = bin2hex(random_bytes($largo));
        $query= "INSERT INTO propuesta_polizas_2 (estado, token, rut_proponente,dv_proponente,fecha_propuesta, vigencia_inicial, vigencia_final, moneda_poliza, compania, ramo, comentarios_int, comentarios_ext, vendedor, tipo_propuesta, forma_pago, valor_cuota, nro_cuotas, moneda_valor_cuota, fecha_primera_cuota, porcentaje_comision) VALUES ('Pendiente', '".$token."', '".$rut_prop."', '".$dv_prop."', '".$fechaprop."', '".$fechainicio."', '".$fechavenc."',  '".$moneda_poliza."', '".$selcompania."', '".$ramo."', '".$comentarios_int."','".$comentarios_ext."', '".$vendedor."' , 'Estándar', '".$forma_pago."', '".$valor_cuota."', '".$cuotas."', '".$moneda_cuota."', '".$fechaprimer."', '".$porcentaje_comision."' )";
        mysqli_query($link, $query);
        mysqli_query($link, 'update propuesta_polizas_2 set numero_propuesta=CONCAT(\'P\', LPAD(id,6,0)) where token=\'' . $token . '\';');
        $resultado = mysqli_query($link, 'select id, numero_propuesta from propuesta_polizas_2 where token=\'' . $token . '\';');
        
        while ($fila = mysqli_fetch_object($resultado))
        {
            // printf ("%s (%s)\n", $fila->id);
            $id_propuesta = $fila->id;
            $nro_propuesta = $fila->numero_propuesta;
            $busqueda=$nro_propuesta;
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
        $query_items="INSERT INTO items(numero_propuesta, numero_poliza,  numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado, venc_gtia) VALUES ('".$nro_propuesta."','TBD',  '".(intval($key)+1)."','".$rut_aseg."','".$dv_aseg."','".$materia."','".$detalle_materia."','".$cobertura."','".$deducible."','".$tasa_afecta."','".$tasa_exenta."','".$prima_afecta."','".$prima_exenta."','".$prima_neta."','".$prima_bruta."','".$monto_aseg."','".$venc_gtia."') 
        ON DUPLICATE KEY UPDATE rut_asegurado='".$rut_aseg."',dv_asegurado='".$dv_aseg."',materia_asegurada='".$materia."',patente_ubicacion='".$detalle_materia."',cobertura='".$cobertura."',deducible='".$deducible."', tasa_afecta='".$tasa_afecta."', tasa_exenta='".$tasa_exenta."', prima_afecta='".$prima_afecta."', prima_exenta='".$prima_exenta."', prima_neta='".$prima_neta."', prima_bruta_anual='".$prima_bruta."', monto_asegurado='".$monto_aseg."', venc_gtia='".$venc_gtia."' , fecha_ultima_modificacion=CURRENT_TIMESTAMP;";
        //$query_items="INSERT INTO items(numero_propuesta, numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado, venc_gtia) VALUES ('".$nro_propuesta."', '".(intval($key)+1)."','".$rut_aseg."','".$dv_aseg."','".$materia."','".$detalle_materia."','".$cobertura."','".$deducible."','".$tasa_afecta."','".$tasa_exenta."','".$prima_afecta."','".$prima_exenta."','".$prima_neta."','".$prima_bruta."','".$monto_aseg."','".$venc_gtia."')";
        mysqli_query($link, $query_items);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Agrega ítems', '".str_replace("'","**",$query_items)."','Ítems', CONCAT('".$nro_propuesta."','[','".(intval($key)+1)."', ']') , '".$_SERVER['PHP_SELF']."')");
      }
              //inicio acciones de renovación
        if ($accion_secundaria=='renovar'){
         //Póliza renovada registra renovación
        $query= "update polizas_2 set estado_renovacion='Renovado', comentarios_int=concat(comentarios_int,'; ', DATE_FORMAT(CURRENT_DATE,'%d/%m/%Y'), ' es renovada por propuesta póliza ".$nro_propuesta."') where numero_poliza='".$poliza_renovada."';";
            mysqli_query($link, $query);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Renovación póliza - antigua', '".str_replace("'","**",$query)."','poliza','".$poliza_renovada."', '".$_SERVER['PHP_SELF']."')");
        $query= "update propuesta_polizas_2 set poliza_renovada='".$poliza_renovada."' , comentarios_int=concat(comentarios_int,'; ', DATE_FORMAT(CURRENT_DATE,'%d/%m/%Y'), ' renueva póliza ".$poliza_renovada."') where id='".$id_propuesta."';";
            mysqli_query($link, $query);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Renovación póliza - nueva', '".str_replace("'","**",$query)."','propuesta poliza','".$id_propuesta."', '".$_SERVER['PHP_SELF']."')");
        }
        
        //fin acciones de renovación
      
      
        break;
  case 'crear_poliza':
  
    $busqueda=estandariza_info($_POST["nro_poliza"]);
        //poliza
        $mensaje='Póliza actualizada correctamente';
        $listado='/bambooQA/listado_polizas.php';

            $nro_poliza= estandariza_info($_POST["nro_poliza"]);
            $fecha_emision_poliza= estandariza_info($_POST["fecha_emision_poliza"]);
            
            $comision= cambia_puntos_por_coma(estandariza_info($_POST["comision"]));
            $comisionbruta= cambia_puntos_por_coma(estandariza_info($_POST["comisionbruta"]));
            $comisionneta= cambia_puntos_por_coma(estandariza_info($_POST["comisionneta"]));
            $fechadeposito= estandariza_info($_POST["fechadeposito"]);
            $comisionneg= cambia_puntos_por_coma(estandariza_info($_POST["comisionneg"]));
            $boletaneg= estandariza_info($_POST["boletaneg"]);
            $boleta= estandariza_info($_POST["boleta"]);
            $query="UPDATE items set numero_poliza='".$nro_poliza."' where numero_propuesta='". $nro_propuesta ."'; ";
            mysqli_query($link, $query);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza ítem', '".str_replace("'","'",$query)."','Ítems',CONCAT('".$nro_propuesta."','[all]'), '".$_SERVER['PHP_SELF']."')");
     
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
      $query="INSERT INTO items(numero_propuesta, numero_poliza,  numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado, venc_gtia) VALUES ('".$nro_propuesta."','".$nro_poliza."',  '".(intval($key)+1)."','".$rut_aseg."','".$dv_aseg."','".$materia."','".$detalle_materia."','".$cobertura."','".$deducible."','".$tasa_afecta."','".$tasa_exenta."','".$prima_afecta."','".$prima_exenta."','".$prima_neta."','".$prima_bruta."','".$monto_aseg."','".$venc_gtia."') 
        ON DUPLICATE KEY UPDATE rut_asegurado='".$rut_aseg."',dv_asegurado='".$dv_aseg."',materia_asegurada='".$materia."',patente_ubicacion='".$detalle_materia."',cobertura='".$cobertura."',deducible='".$deducible."', tasa_afecta='".$tasa_afecta."', tasa_exenta='".$tasa_exenta."', prima_afecta='".$prima_afecta."', prima_exenta='".$prima_exenta."', prima_neta='".$prima_neta."', prima_bruta_anual='".$prima_bruta."', monto_asegurado='".$monto_aseg."', venc_gtia='".$venc_gtia."' , fecha_ultima_modificacion=CURRENT_TIMESTAMP;";
        
              //$query='UPDATE items SET numero_poliza=\'' . $nro_poliza . '\', rut_asegurado=\'' . $rut_aseg . '\',dv_asegurado=\'' . $dv_aseg . '\',materia_asegurada=\'' . $materia . '\',patente_ubicacion=\'' . $detalle_materia . '\',cobertura=\'' . $cobertura . '\',deducible=\'' . $deducible . '\', tasa_afecta=\'' . $tasa_afecta . '\', tasa_exenta=\'' . $tasa_exenta . '\', prima_afecta=\'' . $prima_afecta . '\', prima_exenta=\'' . $prima_exenta . '\', prima_neta=\'' . $prima_neta . '\', prima_bruta_anual=\'' . $prima_bruta . '\', monto_asegurado=\'' . $monto_aseg . '\', venc_gtia=\'' . $venc_gtia . '\', fecha_ultima_modificacion=CURRENT_TIMESTAMP WHERE numero_propuesta=\'' . $nro_propuesta . '\' and numero_item=\'' . $numero_item . '\';';
              mysqli_query($link, $query);
              mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza ítem', '".str_replace("'","**",$query)."','Ítems',CONCAT('".$nro_propuesta."','[','".(intval($key)+1)."', ']'), '".$_SERVER['PHP_SELF']."')");
            }


          //Aprueba propuesta póliza
          $query= "update propuesta_polizas_2 set estado='Aprobado', fecha_cambio_estado=CURRENT_TIMESTAMP  where numero_propuesta='".$nro_propuesta."';";
          mysqli_query($link, $query);
          mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Aprueba propuesta póliza', '".str_replace("'","**",$query)."','propuesta_poliza','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");
  
        //crea token
        $largo = 6;
        $token = bin2hex(random_bytes($largo));
        $query= "INSERT INTO polizas_2(estado, token, rut_proponente,dv_proponente,fecha_propuesta, vigencia_inicial, vigencia_final, moneda_poliza, compania, ramo, comentarios_int, comentarios_ext, vendedor, tipo_propuesta, forma_pago, valor_cuota, nro_cuotas, moneda_valor_cuota, fecha_primera_cuota, numero_propuesta, numero_poliza, comision, porcentaje_comision, comision_bruta, comision_neta, depositado_fecha, comision_negativa, boleta_negativa, numero_boleta, fecha_envio_propuesta, fecha_emision_poliza) VALUES ('Activo', '".$token."', '".$rut_prop."', '".$dv_prop."', '".$fechaprop."', '".$fechainicio."', '".$fechavenc."',  '".$moneda_poliza."', '".$selcompania."', '".$ramo."', '".$comentarios_int."','".$comentarios_ext."', '".$vendedor."' , 'Estándar', '".$forma_pago."', '".$valor_cuota."', '".$cuotas."', '".$moneda_cuota."', '".$fechaprimer."' , '".$nro_propuesta."', '".$nro_poliza."', '".$comision."', '".$porcentaje_comision."', '".$comisionbruta."', '".$comisionneta."', '".$fechadeposito."', '".$comisionneg."', '".$boletaneg."', '".$boleta."','".$fecha_envio_propuesta."','".$fecha_emision_poliza."');";
        mysqli_query($link, $query);
        $resultado = mysqli_query($link, 'select id, numero_poliza from polizas_2 where token=\'' . $token . '\';');
        while ($fila = mysqli_fetch_object($resultado))
        {
            // printf ("%s (%s)\n", $fila->id);
            $id_poliza = $fila->id;
            $nro_propuesta = $fila->numero_poliza;
        }
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Creación póliza', '".str_replace("'","**",$query)."','poliza', '".$id_poliza."' , '".$_SERVER['PHP_SELF']."')");
    // corrige ítems
    $query="delete from items where numero_propuesta='".$nro_propuesta."' and numero_item>".$contador_items.";";
    mysqli_query($link, $query);
    mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Corrige cantidad de ítems', '".str_replace("'","**",$query)."','Ìtems','".$nro_propuesta."', '".$_SERVER['PHP_SELF']."')");

    break;
    case 'crear_poliza_web':
      $busqueda=estandariza_info($_POST["nro_poliza"]);
          //poliza
          $mensaje='Póliza creada correctamente';
          $listado='/bambooQA/listado_polizas.php';
  
              $nro_poliza= estandariza_info($_POST["nro_poliza"]);
              $accion_secundaria= estandariza_info($_POST["accion_secundaria"]);
              $poliza_renovada= estandariza_info($_POST["poliza_renovada"]);
              $fecha_emision_poliza= estandariza_info($_POST["fecha_emision_poliza"]);
              
              $comision= cambia_puntos_por_coma(estandariza_info($_POST["comision"]));
              $comisionbruta= cambia_puntos_por_coma(estandariza_info($_POST["comisionbruta"]));
              $comisionneta= cambia_puntos_por_coma(estandariza_info($_POST["comisionneta"]));
              $fechadeposito= estandariza_info($_POST["fechadeposito"]);
              $comisionneg= cambia_puntos_por_coma(estandariza_info($_POST["comisionneg"]));
              $boletaneg= estandariza_info($_POST["boletaneg"]);
              $boleta= estandariza_info($_POST["boleta"]);
              $query="UPDATE items set numero_poliza='".$nro_poliza."' where numero_propuesta='". $nro_propuesta ."'; ";
              mysqli_query($link, $query);
              mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza ítem', '".str_replace("'","'",$query)."','Ítems',CONCAT('".$nro_propuesta."','[all]'), '".$_SERVER['PHP_SELF']."')");
       
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
        $query="INSERT INTO items(numero_propuesta, numero_poliza,  numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado, venc_gtia) VALUES ('".$nro_propuesta."','".$nro_poliza."',  '".(intval($key)+1)."','".$rut_aseg."','".$dv_aseg."','".$materia."','".$detalle_materia."','".$cobertura."','".$deducible."','".$tasa_afecta."','".$tasa_exenta."','".$prima_afecta."','".$prima_exenta."','".$prima_neta."','".$prima_bruta."','".$monto_aseg."','".$venc_gtia."') 
          ON DUPLICATE KEY UPDATE rut_asegurado='".$rut_aseg."',dv_asegurado='".$dv_aseg."',materia_asegurada='".$materia."',patente_ubicacion='".$detalle_materia."',cobertura='".$cobertura."',deducible='".$deducible."', tasa_afecta='".$tasa_afecta."', tasa_exenta='".$tasa_exenta."', prima_afecta='".$prima_afecta."', prima_exenta='".$prima_exenta."', prima_neta='".$prima_neta."', prima_bruta_anual='".$prima_bruta."', monto_asegurado='".$monto_aseg."', venc_gtia='".$venc_gtia."' , fecha_ultima_modificacion=CURRENT_TIMESTAMP;";
          
                //$query='UPDATE items SET numero_poliza=\'' . $nro_poliza . '\', rut_asegurado=\'' . $rut_aseg . '\',dv_asegurado=\'' . $dv_aseg . '\',materia_asegurada=\'' . $materia . '\',patente_ubicacion=\'' . $detalle_materia . '\',cobertura=\'' . $cobertura . '\',deducible=\'' . $deducible . '\', tasa_afecta=\'' . $tasa_afecta . '\', tasa_exenta=\'' . $tasa_exenta . '\', prima_afecta=\'' . $prima_afecta . '\', prima_exenta=\'' . $prima_exenta . '\', prima_neta=\'' . $prima_neta . '\', prima_bruta_anual=\'' . $prima_bruta . '\', monto_asegurado=\'' . $monto_aseg . '\', venc_gtia=\'' . $venc_gtia . '\', fecha_ultima_modificacion=CURRENT_TIMESTAMP WHERE numero_propuesta=\'' . $nro_propuesta . '\' and numero_item=\'' . $numero_item . '\';';
                mysqli_query($link, $query);
                mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Crea ítem', '".str_replace("'","**",$query)."','Ítems',CONCAT('".$nro_propuesta."','[','".(intval($key)+1)."', ']'), '".$_SERVER['PHP_SELF']."')");
              }
          //crea token
          $largo = 6;
          $token = bin2hex(random_bytes($largo));
          $query= "INSERT INTO polizas_2(estado, token, rut_proponente,dv_proponente,fecha_propuesta, vigencia_inicial, vigencia_final, moneda_poliza, compania, ramo, comentarios_int, comentarios_ext, vendedor, tipo_propuesta, forma_pago, valor_cuota, nro_cuotas, moneda_valor_cuota, fecha_primera_cuota, numero_propuesta, numero_poliza, comision, porcentaje_comision, comision_bruta, comision_neta, depositado_fecha, comision_negativa, boleta_negativa, numero_boleta, fecha_envio_propuesta, fecha_emision_poliza) VALUES ('Activo', '".$token."', '".$rut_prop."', '".$dv_prop."', '".$fechaprop."', '".$fechainicio."', '".$fechavenc."',  '".$moneda_poliza."', '".$selcompania."', '".$ramo."', '".$comentarios_int."','".$comentarios_ext."', '".$vendedor."' , 'Estándar', '".$forma_pago."', '".$valor_cuota."', '".$cuotas."', '".$moneda_cuota."', '".$fechaprimer."' , '".$nro_propuesta."', '".$nro_poliza."', '".$comision."', '".$porcentaje_comision."', '".$comisionbruta."', '".$comisionneta."', '".$fechadeposito."', '".$comisionneg."', '".$boletaneg."', '".$boleta."','".$fecha_envio_propuesta."','".$fecha_emision_poliza."');";
          mysqli_query($link, $query);
          $resultado = mysqli_query($link, 'select id, numero_poliza from polizas_2 where token=\'' . $token . '\';');
          while ($fila = mysqli_fetch_object($resultado))
          {
              // printf ("%s (%s)\n", $fila->id);
              $id_poliza = $fila->id;
              $nro_propuesta = $fila->numero_poliza;
          }
          mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Creación póliza', '".str_replace("'","**",$query)."','poliza', '".$id_poliza."' , '".$_SERVER['PHP_SELF']."')");
     
        //inicio acciones de renovación
        if ($accion_secundaria=='renovar'){
         //Póliza renovada registra renovación
        $query= "update polizas_2 set estado_renovacion='Renovado', comentarios_int=concat(comentarios_int,'; ', DATE_FORMAT(CURRENT_DATE,'%d/%m/%Y'), ' es renovada por póliza ".$nro_propuesta."') where numero_poliza='".$poliza_renovada."';";
            mysqli_query($link, $query);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Renovación póliza - antigua', '".str_replace("'","**",$query)."','poliza','".$poliza_renovada."', '".$_SERVER['PHP_SELF']."')");
        $query= "update polizas_2 set poliza_renovada='".$poliza_renovada."', comentarios_int=concat(comentarios_int,'; ', DATE_FORMAT(CURRENT_DATE,'%d/%m/%Y'), ' renueva póliza ".$poliza_renovada."') where id='".$id_poliza."';";
            mysqli_query($link, $query);
            mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Renovación póliza - nueva', '".str_replace("'","**",$query)."','poliza','".$id_poliza."', '".$_SERVER['PHP_SELF']."')");
 
        
        //fin acciones de renovación
        }
        
      break;
  
  
  case 'modifica_poliza':
    $busqueda=estandariza_info($_POST["nro_poliza"]);
      //pendiente update
      //delete from items where numero_propuesta='P000700' and numero_item>=4
      //fecha_envio_propuesta, comision, comision_bruta, comision_neta, depositado_fecha, comision_negativa, boleta_negativa, numero_boleta
      $mensaje='Póliza actualizada correctamente';   
      $listado='/bambooQA/listado_polizas.php';   
      $nro_poliza= estandariza_info($_POST["nro_poliza"]);
      $fecha_emision_poliza= estandariza_info($_POST["fecha_emision_poliza"]);
      $comision= cambia_puntos_por_coma(estandariza_info($_POST["comision"]));
      $comisionbruta= cambia_puntos_por_coma(estandariza_info($_POST["comisionbruta"]));
      $comisionneta= cambia_puntos_por_coma(estandariza_info($_POST["comisionneta"]));
      $fechadeposito= estandariza_info($_POST["fechadeposito"]);
      $comisionneg= cambia_puntos_por_coma(estandariza_info($_POST["comisionneg"]));
      $boletaneg= estandariza_info($_POST["boletaneg"]);
      $boleta= estandariza_info($_POST["boleta"]);

      $query='UPDATE polizas_2 SET fecha_propuesta=\'' . $fechaprop . '\', rut_proponente=\'' . $rut_prop . '\', dv_proponente=\'' . $dv_prop . '\', compania=\'' . $selcompania . '\',vigencia_inicial=\'' . $fechainicio . '\',vigencia_final=\'' . $fechavenc . '\',ramo=\'' . $ramo . '\',moneda_poliza=\'' . $moneda_poliza . '\',vendedor=\'' . $vendedor . '\',forma_pago=\'' . $forma_pago . '\',moneda_valor_cuota=\'' . $moneda_cuota . '\',valor_cuota=\'' . $valor_cuota . '\',fecha_primera_cuota=\'' . $fechaprimer . '\',nro_cuotas=\'' . $cuotas . '\',comentarios_int=\'' . $comentarios_int . '\',comentarios_ext=\'' . $comentarios_ext . '\',porcentaje_comision=\'' . $porcentaje_comision . '\' , fecha_envio_propuesta=\'' . $fecha_envio_propuesta . '\' , comision=\'' . $comision . '\' , comision_bruta=\'' . $comisionbruta . '\' , comision_neta=\'' . $comisionneta . '\' , depositado_fecha=\'' . $fechadeposito . '\' , comision_negativa=\'' . $comisionneg . '\', boleta_negativa=\'' . $boletaneg . '\' , numero_boleta=\'' . $boleta . '\', fecha_emision_poliza=\'' . $fecha_emision_poliza . '\' WHERE numero_poliza=\'' . $nro_poliza . '\'';
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza Póliza', '".str_replace("'","**",$query)."','poliza','".$nro_poliza."', '".$_SERVER['PHP_SELF']."')");
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
        $query="INSERT INTO items(numero_propuesta, numero_poliza,  numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado, venc_gtia) VALUES ('".$nro_propuesta."', '".$nro_poliza."' ,  '".(intval($key)+1)."','".$rut_aseg."','".$dv_aseg."','".$materia."','".$detalle_materia."','".$cobertura."','".$deducible."','".$tasa_afecta."','".$tasa_exenta."','".$prima_afecta."','".$prima_exenta."','".$prima_neta."','".$prima_bruta."','".$monto_aseg."','".$venc_gtia."' ) 
        ON DUPLICATE KEY UPDATE rut_asegurado='".$rut_aseg."',dv_asegurado='".$dv_aseg."',materia_asegurada='".$materia."',patente_ubicacion='".$detalle_materia."',cobertura='".$cobertura."',deducible='".$deducible."', tasa_afecta='".$tasa_afecta."', tasa_exenta='".$tasa_exenta."', prima_afecta='".$prima_afecta."', prima_exenta='".$prima_exenta."', prima_neta='".$prima_neta."', prima_bruta_anual='".$prima_bruta."', monto_asegurado='".$monto_aseg."', venc_gtia='".$venc_gtia."' , fecha_ultima_modificacion=CURRENT_TIMESTAMP;";

        mysqli_query($link, $query);
        mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Actualiza ítem', '".str_replace("'","**",$query)."','Ítems',CONCAT('".$nro_poliza."','[','".(intval($key)+1)."', ']'), '".$_SERVER['PHP_SELF']."')");
      }
      $query="delete from items where numero_poliza='".$nro_poliza."' and numero_item>".$contador_items.";";
      mysqli_query($link, $query);
      mysqli_query($link, "select trazabilidad('".$_SESSION["username"]."', 'Corrige cantidad de ítems', '".str_replace("'","**",$query)."','Ìtems','".$nro_poliza."', '".$_SERVER['PHP_SELF']."')");
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