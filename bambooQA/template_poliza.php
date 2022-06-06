<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
function estandariza_info( $data ) {
  $data = trim( $data );
  $data = stripslashes( $data );
  $data = htmlspecialchars( $data );
  return $data;
}
require_once "/home/gestio10/public_html/backend/config.php";

//if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {

  mysqli_set_charset( $link, 'utf8' );
  mysqli_select_db( $link, 'gestio10_asesori1_bamboo_prePAP' );
  //poliza
  
  $instancia = "envio_poliza";
 if ( $_POST[ "tipo" ] == "buscar"){
      
     $instancia = $_POST[ "instancia" ];
     $busqueda = $_POST["id"];
     $ramo = $POST["ramo"];
 
      

  }
  else
  {
  $busqueda = $_POST[ "id_poliza" ];
  }
  $query_ramo = "SELECT ramo from polizas_2 where id=". $busqueda ." ;";
  $resultado_ramo_poliza = mysqli_query($link,$query_ramo);
  
   While( $row = mysqli_fetch_object( $resultado_ramo_poliza ) ) {
    $ramo_poliza = $row->ramo;
  }
  
  
  $ramo_poliza = str_replace('VEH','vehiculo',$ramo_poliza);
  $ramo_poliza = str_replace('vehiculo -','VEH -',$ramo_poliza);
  $ramo_poliza = str_replace('Hogar','hogar_persona',$ramo_poliza);
  $ramo_poliza = str_replace('- hogar_persona','- Hogar',$ramo_poliza);
  $ramo_poliza = str_replace('Hogar_Persona','hogar_persona',$ramo_poliza);
  $ramo_poliza = str_replace('Hogar_pyme','hogar_pyme',$ramo_poliza);
  $ramo_poliza = str_replace('A. VIAJE','viaje',$ramo_poliza);
  $ramo_poliza = str_replace('RC','rc_do',$ramo_poliza);
$ramo_poliza = str_replace('rc_do General','RC General',$ramo_poliza);
  $ramo_poliza = str_replace('INC','inc',$ramo_poliza);
$ramo_poliza = str_replace('inc -','INC -',$ramo_poliza);
  $ramo_poliza = str_replace('APV','apv',$ramo_poliza);
  $ramo_poliza = str_replace('D&O','rc_do',$ramo_poliza);
 $ramo_poliza = str_replace('rc_do Condominio','D&O Condominio',$ramo_poliza);
  $ramo_poliza = str_replace('AP','ap',$ramo_poliza);
  $ramo_poliza = str_replace('Vida','vida',$ramo_poliza);
  $ramo_poliza = str_replace('Garantia','garantia',$ramo_poliza);
  
  

  $query_template =  "SELECT template FROM template_correos where producto='".$ramo_poliza."' and instancia='".$instancia."'";
  
  
  
  
  $resultado_template = mysqli_query( $link, $query_template);
  
  While( $row = mysqli_fetch_object( $resultado_template ) ) {
    $template = $row->template;
  }

  // Viene desde póliza
  //if ( !empty( trim( $_POST[ "id_poliza" ] ) ) ) {

    $query =  "SELECT   a.id, estado, tipo_poliza, rut_proponente, dv_proponente, rut_asegurado, dv_asegurado, a.grupo, compania, DATE_FORMAT(vigencia_inicial,'%d-%m-%Y') as vigencia_inicial, DATE_FORMAT(vigencia_final,'%d-%m-%Y') as vigencia_final, mes_vencimiento, ano_vencimiento, poliza_renovada, ramo, numero_poliza, materia_asegurada, patente_ubicacion, cobertura, deducible, moneda_poliza, FORMAT(prima_bruta_anual, 2, 'de_DE') as prima_bruta_anual, FORMAT(prima_afecta, 2, 'de_DE') as prima_afecta, moneda_comision, FORMAT(prima_exenta, 2, 'de_DE') as prima_exenta, FORMAT(prima_neta, 2, 'de_DE') as prima_neta, FORMAT(prima_bruta_anual, 2, 'de_DE') as prima_bruta_anual, monto_asegurado, numero_propuesta, DATE_FORMAT(fecha_envio_propuesta,'%d-%m-%Y') as fecha_envio_propuesta, endoso, FORMAT(comision, 2, 'de_DE') as comision, FORMAT(porcentaje_comision, 2, 'de_DE') as porcentaje_comision, FORMAT(comision_bruta, 2, 'de_DE') as comision_bruta, FORMAT(comision_neta, 2, 'de_DE') as comision_neta, numero_boleta, moneda_comision_negativa, FORMAT(comision_negativa, 2, 'de_DE') as comision_negativa, boleta_negativa, DATE_FORMAT(depositado_fecha,'%d-%m-%Y') as depositado_fecha, vendedor, nombre_vendedor, forma_pago, moneda_valor_cuota, FORMAT(valor_cuota, 2, 'de_DE') as valor_cuota, DATE_FORMAT(fecha_primera_cuota,'%d-%m-%Y') as fecha_primera_cuota, nro_cuotas, informacion_adicional, concat_ws(' ',b.nombre_cliente, b.apellido_paterno) as nombre_asegurado FROM polizas as a left join clientes as b on a.rut_asegurado=b.rut_sin_dv where a.id=" . $busqueda . " order by compania, numero_poliza;"; 
    $resultado_poliza = mysqli_query( $link,$query);


    While( $row = mysqli_fetch_object( $resultado_poliza ) ) {
     $estado= $row->estado;
      $tipo_poliza= $row->tipo_poliza;
      $rut_proponente= $row->rut_proponente;
      $dv_proponente= $row->dv_proponente;
      $rut_asegurado= $row->rut_asegurado;
      $dv_asegurado= $row->dv_asegurado;
      $grupo= $row->grupo;
      $compania= $row->compania;
      $vigencia_inicial= $row->vigencia_inicial;
      $vigencia_final= $row->vigencia_final;
      $mes_vencimiento= $row->mes_vencimiento;
      $ano_vencimiento= $row->ano_vencimiento;
      $poliza_renovada= $row->poliza_renovada;
      $ramo= $row->ramo;
      $numero_poliza= $row->numero_poliza;
      $materia_asegurada= $row->materia_asegurada;
      $patente_ubicacion= $row->patente_ubicacion;
      $cobertura= $row->cobertura;
      $deducible= $row->deducible;
      $moneda_poliza= $row->moneda_poliza;
      $prima_afecta= $row->prima_afecta;
      $moneda_comision= $row->moneda_comision;
      $prima_exenta= $row->prima_exenta;
      $prima_neta= $row->prima_neta;
      $prima_bruta_anual= $row->prima_bruta_anual;
      $monto_asegurado= $row->monto_asegurado;
      $numero_propuesta= $row->numero_propuesta;
      $fecha_envio_propuesta= $row->fecha_envio_propuesta;
      $endoso= $row->endoso;
      $comision= $row->comision;
      $porcentaje_comision= $row->porcentaje_comision;
      $comision_bruta= $row->comision_bruta;
      $comision_neta= $row->comision_neta;
      $numero_boleta= $row->numero_boleta;
      $moneda_comision_negativa= $row->moneda_comision_negativa;
      $comision_negativa= $row->comision_negativa;
      $boleta_negativa= $row->boleta_negativa;
      $depositado_fecha= $row->depositado_fecha;
      $vendedor= $row->vendedor;
      $nombre_vendedor= $row->nombre_vendedor;
      $forma_pago= $row->forma_pago;
      $moneda_valor_cuota= $row->moneda_valor_cuota;
      $valor_cuota= $row->valor_cuota;
      $fecha_primera_cuota= $row->fecha_primera_cuota;
      $nro_cuotas= $row->nro_cuotas;
      $informacion_adicional= $row->informacion_adicional;
      $id = $row->id;
      $nombre_asegurado = $row->nombre_asegurado;
    
    
      
      
    }
    
    $template = str_replace( '_[NRO_POLIZA]_', $numero_poliza, $template );
    $template = str_replace( '_[NOMBRE_CLIENTE]_', $nombre_asegurado, $template );
    $template= str_replace( '_[ESTADO]_',$estado, $template );
 $template= str_replace( '_[TIPO_POLIZA]_',$tipo_poliza, $template );
 $template= str_replace( '_[RUT_PROP]_',$rut_proponente, $template );
 $template= str_replace( '_[DV_PROP]_',$dv_proponente, $template );
 $template= str_replace( '_[RUT_ASEG]_',$rut_asegurado, $template );
 $template= str_replace( '_[DV_ASEG]_',$dv_asegurado, $template );
 $template= str_replace( '_[GRUPO]_',$grupo, $template );
 $template= str_replace( '_[COMPANIA]_',$compania, $template );
 $template= str_replace( '_[VIGENCIA_INICIAL]_',$vigencia_inicial, $template );
 $template= str_replace( '_[VIGENCIA_FINAL]_',$vigencia_final, $template );
 $template= str_replace( '_[MES_VENCIMIENTO]_',$mes_vencimiento, $template );
 $template= str_replace( '_[ANO_VENCIMIENTO]_',$ano_vencimiento, $template );
 $template= str_replace( '_[POLIZA_RENOVADA]_',$poliza_renovada, $template );
 $template= str_replace( '_[RAMO]_',$ramo, $template );
 $template= str_replace( '_[NUMERO_POLIZA]_',$numero_poliza, $template );
 $template= str_replace( '_[MATERIA_ASEGURADA]_',$materia_asegurada, $template );
 $template= str_replace( '_[PATENTE_UBICACION]_',$patente_ubicacion, $template );
 $template= str_replace( '_[COBERTURA]_',$cobertura, $template );
 $template= str_replace( '_[DEDUCIBLE]_',$deducible, $template );
 $template= str_replace( '_[MONEDA_POLIZA]_',$moneda_poliza, $template );
 $template= str_replace( '_[PRIMA_AFECTA]_',$prima_afecta, $template );
 $template= str_replace( '_[MONEDA_COMISION]_',$moneda_comision, $template );
 $template= str_replace( '_[PRIMA_EXENTA]_',$prima_exenta, $template );
 $template= str_replace( '_[PRIMA_NETA]_',$prima_neta, $template );
  $template= str_replace( '_[PRIMA_ANUAL]_',$prima_bruta_anual, $template );
 $template= str_replace( '_[PRIMA_BRUTA_ANUAL]_',$prima_bruta_anual, $template );
 $template= str_replace( '_[MONTO_ASEGURADO]_',$monto_asegurado, $template );
 $template= str_replace( '_[NUMERO_PROPUESTA]_',$numero_propuesta, $template );
 $template= str_replace( '_[FECHA_ENVIO_PROPUESTA]_',$fecha_envio_propuesta, $template );
 $template= str_replace( '_[ENDOSO]_',$endoso, $template );
 $template= str_replace( '_[COMISION]_',$comision, $template );
 $template= str_replace( '_[PORCENTAJE_COMISION]_',$porcentaje_comision, $template );
 $template= str_replace( '_[COMISION_BRUTA]_',$comision_bruta, $template );
 $template= str_replace( '_[COMISION_NETA]_',$comision_neta, $template );
 $template= str_replace( '_[NUMERO_BOLETA]_',$numero_boleta, $template );
 $template= str_replace( '_[MONEDA_COM_NEG]_',$moneda_comision_negativa, $template );
 $template= str_replace( '_[COMISION_NEGATIVA]_',$comision_negativa, $template );
 $template= str_replace( '_[BOLETA_NEGATIVA]_',$boleta_negativa, $template );
 $template= str_replace( '_[DEPOSITADO_FECHA]_',$depositado_fecha, $template );
 $template= str_replace( '_[VENDEDOR]_',$vendedor, $template );
 $template= str_replace( '_[NOMBRE_VENDEDOR]_',$nombre_vendedor, $template );
 $template= str_replace( '_[FORMA_PAGO]_',$forma_pago, $template );
 $template= str_replace( '_[MONEDA_VALOR_CUOTA]_',$moneda_valor_cuota, $template );
 $template= str_replace( '_[VALOR_CUOTA]_',$valor_cuota, $template );
  $template= str_replace( '_[PRIMERA_CUOTA]_',$fecha_primera_cuota, $template );
 $template= str_replace( '_[FECHA_PRIMERA_CUOTA]_',$fecha_primera_cuota, $template );
 $template= str_replace( '_[NRO_CUOTAS]_',$nro_cuotas, $template );
 $template= str_replace( '_[INFO_ADICIONAL]_',$informacion_adicional, $template );



    $template = str_replace( '_[SALTO_LINEA]_', '<br>', $template );
    $template = str_replace( '_[NEG_ini]_', '<b>', $template );
    $template = str_replace( '_[NEG_fin]_', '</b>', $template );
    $template = str_replace( '_[SUB_ini]_', '<u>', $template );
    $template = str_replace( '_[SUB_fin]_', '</u>', $template );
    $template = str_replace( '_[CUR_ini]_', '<em>', $template );
    $template = str_replace( '_[CUR_fin]_', '</em>', $template );
    $template = str_replace( '_[LINEA]_', '<hr>', $template );


 // }
//}


$body = $template;

$body = str_replace( '_[SU_ini]_', '_[SU]_', $body );
$body = str_replace( '_[SU_fin]_', '_[SU]_', $body );

$array = explode( '_[SU]_', $body );
$subject = $array[ 1 ];
$body = $array[ 2 ];

$subject = str_replace( 'ASUNTO:', '', $subject );
$subject = str_replace( '<br>', '%0A', $subject );
$subject = str_replace( '% ', '%25', $subject );
$subject = str_replace( '<b>', '', $subject );
$subject = str_replace( '</b>', '', $subject );
$subject = str_replace( '<hr>', '%0A%0A', $subject );
$subject = str_replace( '<u>', '', $subject );
$subject = str_replace( '</u>', '', $subject );
$subject = str_replace( '•', '• ', $subject );

$subject = urlencode( $subject );

$body = str_replace( '<br>', '%0A', $body );
$body = str_replace( '<b>', '', $body );
$body = str_replace( '</b>', '', $body );
$body = str_replace( '<hr>', '%0A%0A', $body );
$body = str_replace( '% ', '%25 ', $body );
$body = str_replace( '%0A%0AEstimado(a)', 'Estimado(a)', $body );
$body = str_replace( '<u>', '', $body );
$body = str_replace( '</u>', '', $body );
$body = str_replace( '•', '• ', $body );

$body = urlencode( $body );


mysqli_set_charset( $link, 'utf8' );
mysqli_select_db( $link, 'gestio10_asesori1_bamboo_prePAP' );
//correo_Cliente
$resultado_correo_cliente = mysqli_query( $link, 'SELECT a.correo, a.rut_sin_dv, a.id , count(b.correo) cuenta_contacto FROM clientes a LEFT JOIN clientes_contactos b on a.id = b.id_cliente where a.rut_sin_dv =' . $rut_proponente . ' or a.rut_sin_dv =' . $rut_asegurado . ' group by a.correo, a.rut_sin_dv, a.id order by cuenta_contacto desc;' );

$destinatario = '';

While( $row = mysqli_fetch_object( $resultado_correo_cliente ) ) {

  $correo = $row->correo;
  $destinatario = $destinatario . ";" . $correo;
  $id = $row->id;
  $cuenta_contacto = $row->cuenta_contacto;


  if ( $cuenta_contacto !== 0 ) {
    //correo_contacto
    $resultado_correo_contacto = mysqli_query( $link, "select correo ,id_cliente as id, null as cuenta_contacto from clientes_contactos where id_cliente =" . $id . ";" );

    While( $row2 = mysqli_fetch_object( $resultado_correo_contacto ) ) {

      $correo_contact = $row2->correo;
      $id_cliente = $row2->id;
      $cuenta_contacto_contact = $row2->cuenta_contacto;
      $destinatario = $destinatario . ";" . $correo_contact;


    }


  }


}




mysqli_close( $link );

$template = str_replace( '_[SU_ini]_', '', $template );
$template = str_replace( '_[SU_fin]_', '', $template );
$url = htmlspecialchars( "https://mail.google.com/mail/?view=cm&fs=1&to=$destinatario&su=$subject&body=$body" );

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<link rel="icon" href="/bambooQA/images/bamboo.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>



<div id="header">
<?php include 'header2.php' ?>
</div>
<div class="container">
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name='eviar_template'>
      <div id="auxiliar" style="display: none" >
      <input name="tipo" id="tipo">
      <input name="id" id="id">
      <input name="ramo" id="ramo">
      
    </div>
<div class="row">
  <div class="col-4">
    <label><b>Instancia</b></label>
    <select class="form-control" name="instancia" id="instancia">
      
          <option value="envio_poliza" <?php if ($instancia == "envio_poliza") echo "selected" ?>>Enviar póliza</option>
          <option value="reenvio_poliza" <?php if ($instancia == "reenvio_poliza") echo "selected" ?>>Reenviar póliza</option>
          
    </select>
  </div>
  <div class="col" style="align-self:flex-end">
    <button class="btn" type="submit" name="buscar"
                        style="background-color: #536656; color: white; height: 45; align-self: center" onclick="envio_data(this.name)">Buscar
    template</button>
  </div>
  </form>
</div>
<br>
<div name='correo'>
<div class=col>
  <h6>Resultado</h6>
  <div id="template_correo" class="form-control bg-light text-dark" rows="10"
                style="height: 400px; border-style: solid;overflow-y: scroll"><?php echo $template; ?></div>
  <br>
  <a class="btn" type="btn"
                        style="background-color: #536656; color: white; height: 45; align-self: center;" href="<?php echo urldecode($url); ?>" target="_blank">Enviar mail</a><br>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
<script src="/assets/js/jquery.redirect.js"></script>

</body>

<script>


function envio_data(boton) {
    document.getElementById("tipo").value = boton;
}



</script>
</html>

<script>

document.addEventListener("DOMContentLoaded", function() {


document.getElementById("id").value = '<?php echo $busqueda; ?>';
document.getElementById("ramo").value = '<?php echo $ramo_poliza; ?>';

});
</script>