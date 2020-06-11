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

if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {

  mysqli_set_charset( $link, 'utf8' );
  mysqli_select_db( $link, 'gestio10_asesori1_bamboo' );
  //poliza
  $resultado_template = mysqli_query( $link, 'SELECT template FROM template_correos where producto="vehiculo" and instancia="envio_poliza"' );
  While( $row = mysqli_fetch_object( $resultado_template ) ) {
    $template = $row->template;
  }

  // Viene desde póliza
  if ( !empty( trim( $_POST[ "id_poliza" ] ) ) ) {
    $busqueda = $_POST[ "id_poliza" ];

    $resultado_poliza = mysqli_query( $link, "SELECT fecha_primera_cuota, forma_pago, moneda_poliza, deducible, prima_afecta, prima_exenta, prima_bruta_anual, a.id, ramo, compania, vigencia_inicial, vigencia_final, numero_poliza, materia_asegurada, patente_ubicacion,cobertura, rut_proponente, rut_asegurado, concat(b.nombre_cliente, ' ', b.apellido_paterno) as nombre_asegurado FROM polizas as a left join clientes as b on a.rut_asegurado=b.rut_sin_dv where a.id=" . $busqueda . " order by compania, numero_poliza;" );

    While( $row = mysqli_fetch_object( $resultado_poliza ) ) {
      $moneda_poliza = $row->moneda_poliza;
      $deducible = $row->deducible;
      $fecha_primera_cuota = $row->fecha_primera_cuota;
      $forma_pago = $row->forma_pago;
      $prima_bruta_anual = $row->prima_bruta_anual;
      $id = $row->id;
      $ramo = $row->ramo;
      $numero_poliza = $row->numero_poliza;
      $compania = $row->compania;
      $vigencia_final = $row->vigencia_final;
      $vigencia_inicial = $row->vigencia_inicial;
      $materia_asegurada = $row->materia_asegurada;
      $patente_ubicacion = $row->patente_ubicacion;
      $cobertura = $row->cobertura;
      $rut_proponente = $row->rut_proponente;
      $rut_asegurado = $row->rut_asegurado;
      $nombre_asegurado = $row->nombre_asegurado;
    }

    $template = str_replace( '_[NRO_POLIZA]_', $numero_poliza, $template );
    $template = str_replace( '_[RAMO]_', $ramo, $template );
    $template = str_replace( '_[COMPANIA]_', $compania, $template );
    $template = str_replace( '_[NOMBRE_CLIENTE]_', $nombre_asegurado, $template );
    $template = str_replace( '_[VIGENCIA_INICIAL]_', $vigencia_inicial, $template );
    $template = str_replace( '_[VIGENCIA_FINAL]_', $vigencia_final, $template );
    $template = str_replace( '_[COBERTURA]_', $cobertura, $template );
    $template = str_replace( '_[DEDUCIBLE]_', $deducible, $template );
    $template = str_replace( '_[PRIMERA_CUOTA]_', $fecha_primera_cuota, $template );
    $template = str_replace( '_[FORMA_PAGO]_', $forma_pago, $template );
    $template = str_replace( '_[PRIMA_ANUAL]_', $prima_bruta_anual, $template );
    $template = str_replace( '_[VEHICULO]_', $materia_asegurada, $template );


    $template = str_replace( '_[SALTO_LINEA]_', '<br>', $template );
    $template = str_replace( '_[NEG_ini]_', '<b>', $template );
    $template = str_replace( '_[NEG_fin]_', '</b>', $template );
    $template = str_replace( '_[SUB_ini]_', '<u>', $template );
    $template = str_replace( '_[SUB_fin]_', '</u>', $template );
    $template = str_replace( '_[CUR_ini]_', '<em>', $template );
    $template = str_replace( '_[CUR_fin]_', '</em>', $template );
    $template = str_replace( '_[LINEA]_', '<hr>', $template );


  }
}


$body = $template;

$body = str_replace( '_[SU_ini]_', '_[SU]_', $body );
$body = str_replace( '_[SU_fin]_', '_[SU]_', $body );

$array = explode( '_[SU]_', $body );
$subject = $array[ 1 ];
$body = $array[ 2 ];

$subject = str_replace( 'ASUNTO:', '', $subject );
$subject = str_replace( '<br>', '%0A', $subject );
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
$body = str_replace( '%0A%0AEstimado(a)', 'Estimado(a)', $body );
$body = str_replace( '<u>', '', $body );
$body = str_replace( '</u>', '', $body );
$body = str_replace( '•', '• ', $body );
$body = urlencode( $body );


mysqli_set_charset( $link, 'utf8' );
mysqli_select_db( $link, 'gestio10_asesori1_bamboo' );
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
<title>Generador de correo - Informar póliza creada</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<div id="header">
<?php include 'header2.php' ?>
</div>
<div class="container">
<div class="row">
  <div class="col-4">
    <label><b>Instancia</b></label>
    <select class="form-control" name="instancia" id="instancia">
      <option value="envio_poliza" <?php if ($instancia == "envio_poliza") echo "selected" ?>>Informar póliza</option>
      <option value="renovacion" <?php if ($instancia == "renovacion") echo "selected" ?> >Renovación</option>
      <option value="otro" <?php if ($instancia == "otro") echo "selected" ?> >Otro</option>
    </select>
  </div>
  <div class="col" style="align-self:flex-end">
    <button class="btn" type="submit"
                        style="background-color: #536656; color: white; height: 45; align-self: center">Buscar
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
</html>