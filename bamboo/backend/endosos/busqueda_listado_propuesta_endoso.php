<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$resultado =$codigo=$conta='';

require_once "/home/gestio10/public_html/backend/config.php";

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    $sql = "SELECT comentario_endoso, fecha_prorroga, estado, tipo_endoso, compania,fecha_ingreso_endoso, ramo, vigencia_inicial, vigencia_final, numero_poliza, numero_propuesta_endoso, CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(prima_neta_afecta, 2, 'de_DE')) as prima_neta_afecta, CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(iva, 2, 'de_DE')) as iva, CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(prima_neta_exenta, 2, 'de_DE')) as prima_neta_exenta, CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(prima_total, 2, 'de_DE')) as prima_total, CONCAT_WS(' ',moneda_poliza_endoso,FORMAT(prima_neta, 2, 'de_DE')) as prima_neta, dice, debe_decir, descripcion_endoso, CONCAT_WS('-',rut_proponente,dv_proponente) AS rut_proponente, nombre_proponente, motivo_rechazo FROM propuesta_endosos as a;";
    $resultado=mysqli_query($link, $sql);
    $codigo='{
      "data": [';
    $conta=0;
    While($row=mysqli_fetch_object($resultado))
    {
        $conta=$conta+1;
        if ($conta==1){
            $codigo.= json_encode(array(
            "estado" =>& $row->estado,
            "rut_proponente" =>& $row->rut_proponente,
            "nombre_proponente" =>& $row->nombre_proponente,
            "fecha_ingreso_endoso"=>& $row->fecha_ingreso_endoso,
            "tipo_endoso"=>& $row->tipo_endoso,
            "compania"=>& $row->compania,
            "ramo" =>& $row->ramo,
            "vigencia_inicial" =>& $row->vigencia_inicial,
            "vigencia_final" =>& $row->vigencia_final,
            "numero_poliza" =>& $row->numero_poliza,
            "numero_propuesta_endoso" =>& $row->numero_propuesta_endoso,
            "prima_neta_afecta" =>& $row->prima_neta_afecta,
            "prima_neta_exenta" =>& $row->prima_neta_exenta,
            "prima_neta" =>& $row->prima_neta,
            "prima_total" =>& $row->prima_total,
            "iva" =>& $row->iva,
            "dice" =>& $row->dice,
            "debe_decir" =>& $row->debe_decir,
            "fecha_prorroga" =>& $row->fecha_prorroga,
            "comentario_endoso" =>& $row->comentario_endoso,
            "motivo_rechazo" =>& $row->motivo_rechazo,
            "descripcion_endoso" =>& $row->descripcion_endoso));
        } else {
            $codigo.= ', '.json_encode(array(
            "estado" =>& $row->estado,
            "rut_proponente" =>& $row->rut_proponente,
            "nombre_proponente" =>& $row->nombre_proponente,
            "fecha_ingreso_endoso"=>& $row->fecha_ingreso_endoso,
            "tipo_endoso"=>& $row->tipo_endoso,
            "compania"=>& $row->compania,
            "ramo" =>& $row->ramo,
            "vigencia_inicial" =>& $row->vigencia_inicial,
            "vigencia_final" =>& $row->vigencia_final,
            "numero_poliza" =>& $row->numero_poliza,
            "numero_propuesta_endoso" =>& $row->numero_propuesta_endoso,
            "prima_neta_afecta" =>& $row->prima_neta_afecta,
            "prima_neta_exenta" =>& $row->prima_neta_exenta,
            "prima_neta" =>& $row->prima_neta,
            "prima_total" =>& $row->prima_total,
            "iva" =>& $row->iva,
            "dice" =>& $row->dice,
            "debe_decir" =>& $row->debe_decir,
            "fecha_prorroga" =>& $row->fecha_prorroga,
            "comentario_endoso" =>& $row->comentario_endoso,
            "motivo_rechazo" =>& $row->motivo_rechazo,
            "descripcion_endoso" =>& $row->descripcion_endoso));
        }
    }
  $codigo.=']}';
  mysqli_close($link);
  echo $codigo;

?>