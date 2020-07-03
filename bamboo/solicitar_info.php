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
  mysqli_select_db( $link, 'gestio10_asesori1_bamboo' );
  //poliza
  
  

  
  if ( $_POST[ "tipo" ] == "buscar"){
      
       $ramo = $_POST["ramo"];
        
       $instancia = $_POST["instancia"];
       
    
  }
  
  else{
       $ramo = "null";
      $instancia = "null";
  }
  
  $ramo_poliza =$ramo;
  
  $query_template =  "SELECT template FROM template_correos where producto='".$ramo_poliza."' and instancia='".$instancia."'";
  
  
  
  
  $resultado_template = mysqli_query( $link, $query_template);
  
  While( $row = mysqli_fetch_object( $resultado_template ) ) {
    $template = $row->template;
  }

 
    $template = str_replace( '_[SALTO_LINEA]_', '<br>', $template );
    $template = str_replace( '_[NEG_ini]_', '<b>', $template );
    $template = str_replace( '_[NEG_fin]_', '</b>', $template );
    $template = str_replace( '_[SUB_ini]_', '<u>', $template );
    $template = str_replace( '_[SUB_fin]_', '</u>', $template );
    $template = str_replace( '_[CUR_ini]_', '<em>', $template );
    $template = str_replace( '_[CUR_fin]_', '</em>', $template );
    $template = str_replace( '_[LINEA]_', '<hr>', $template );

if($template == ''){
    
    $template = "No se ha cargado un template para esta Instancia y/o Ramo, favor seleccione otra opción";
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



$destinatario = '';







$template = str_replace( '_[SU_ini]_', '', $template );
$template = str_replace( '_[SU_fin]_', '', $template );
$url = htmlspecialchars( "https://mail.google.com/mail/?view=cm&fs=1&to=$destinatario&su=$subject&body=$body" );

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<link rel="icon" href="/bamboo/bamboo.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>

<div id="header">
<?php include 'header2.php' ?>
</div>
<div class="container">
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name='enviar_template'>
      <div id="auxiliar" style="display:none" >
      <input name="instancia" id="instancia" >
      <input name="ramo" id="ramo">
      <input name="tipo" id="tipo">
      
    </div>
    
<h4>Envío de Correos</h4> <br>
<div class="form-row" style="display:flex; align-items: flex-end;">
  <div class="col-6">
      
    <label><b>Ramo</b></label>
    <select class="form-control" name="ramo2" id="ramo2" onchange ="copia_ramo()">
        <option value="null">Selecciona un ramo</option>
        <option value="accidentes_personales_ap"<?php if ($producto =="accidentes_personales_ap") echo "selected" ?> >ACCIDENTES PERSONALES - Accidentes Personales</option>
        <option value="accidentes_personales_protección"<?php if ($producto =="accidentes_personales_protección") echo "selected" ?> >ACCIDENTES PERSONALES - Protección Financiera </option>
        <option value="inc_condominio"<?php if ($producto =="inc_condominio") echo "selected" ?> >INCENDIO  - Condominio </option>
        <option value="inc_hogar"<?php if ($producto =="inc_hogar") echo "selected" ?> >INCENDIO  - Hogar</option>
        <option value="inc_miscelaneo"<?php if ($producto =="inc_miscelaneo") echo "selected" ?> >INCENDIO  - Misceláneos</option>
        <option value="inc_perjuicio"<?php if ($producto =="inc_perjuicio") echo "selected" ?> >INCENDIO  - Perjuicio por Paralización</option>
        <option value="inc_pyme"<?php if ($producto =="inc_pyme") echo "selected" ?> >INCENDIO  - Pyme</option>
        <option value="inc_trbf"<?php if ($producto =="inc_trbf") echo "selected" ?> >INCENDIO  - TRBF (Todo Riesgo Bienes Físicos)</option>
        <option value="rc-do"<?php if ($producto =="rc-do") echo "selected" ?> >RESPONSABILIDAD CIVIL  - D&O Condominio </option>
        <option value="rc-rc"<?php if ($producto =="rc-rc") echo "selected" ?> >RESPONSABILIDAD CIVIL  - RC General</option>
        <option value="veh_comerciales"<?php if ($producto =="veh_comerciales") echo "selected" ?> >VEHÍCULOS  - Vehículos Comerciales Livianos</option>
        <option value="veh_particular"<?php if ($producto =="veh_particular") echo "selected" ?> >VEHÍCULOS  - Vehículos Particulares</option>
        <option value="veh_pesados"<?php if ($producto =="veh_pesados") echo "selected" ?> >VEHÍCULOS  - Vehículos Pesados </option>
        <option value="viaje"<?php if ($producto =="viaje") echo "selected" ?> >ASISTENCIA EN VIAJE</option>
        <option value="null">--------------------------------------------------------------</option>
        <option value="averia_maquina"<?php if ($producto =="averia_maquina") echo "selected" ?> >AVERÍA DE MAQUINARIA </option>
        <option value="casco_aeroeo"<?php if ($producto =="casco_aeroeo") echo "selected" ?> >CASCO - Aéreo</option>
        <option value="casco_marítimo"<?php if ($producto =="casco_marítimo") echo "selected" ?> >CASCO - Marítimo </option>
        <option value="garantia"<?php if ($producto =="garantia") echo "selected" ?> >GARANTÍA</option>
        <option value="ing_contratístas"<?php if ($producto =="ing_contratístas") echo "selected" ?> >INGENIERÍA - Equipo Contratistas</option>
        <option value="ing_equipo_movil"<?php if ($producto =="ing_equipo_movil") echo "selected" ?> >INGENIERÍA - Equipo Móvil Agrícola</option>
        <option value="ing_electronicos"<?php if ($producto =="ing_electronicos") echo "selected" ?> >INGENIERÍA - Equipos Electrónicos</option>
        <option value="ing-trc"<?php if ($producto =="ing-trc") echo "selected" ?> >INGENIERÍA - TRC (Todo Riesgo Construcción)</option>
        <option value="remesa"<?php if ($producto =="remesa") echo "selected" ?> >REMESA DE VALORES</option>
        <option value="robo"<?php if ($producto =="robo") echo "selected" ?> >ROBO CON FUERZA EN LAS COSAS Y VIOLENCIA EN LAS PERSONAS</option>
        <option value="cristales"<?php if ($producto =="cristales") echo "selected" ?> >ROTURA DE CRISTALES</option>
        <option value="seguro_arriendo"<?php if ($producto =="seguro_arriendo") echo "selected" ?> >SEGURO ARRIENDO </option>
        <option value="seguro_credito"<?php if ($producto =="seguro_credito") echo "selected" ?> >SEGURO DE CRÉDITO </option>
        <option value="transporte_cabotaje"<?php if ($producto =="transporte_cabotaje") echo "selected" ?> >TRANSPORTE - CABOTAJE</option>
        <option value="transporte_intern"<?php if ($producto =="transporte_intern") echo "selected" ?> >TRANSPORTE - INTERNACIONAL </option>
        <option value="vida_apv"<?php if ($producto =="vida_apv") echo "selected" ?> >VIDA - APV</option>
        <option value="vida_vida"<?php if ($producto =="vida_vida") echo "selected" ?> >VIDA - VIDA</option>
        <option value="vehiculo" <?php if ($producto == "vehiculo") echo "selected" ?> >Vehiculo</option>
        <option value="hogar_persona" <?php if ($producto == "hogar_persona") echo "selected" ?> >Hogar</option>
        <option value="hogar_pyme" <?php if ($producto == "hogar_pyme") echo "selected" ?> >PyME</option>
        <option value="viaje" <?php if ($producto == "viaje") echo "selected" ?> >A. VIAJE</option>
        <option value="rc_do" <?php if ($producto == "rc_do") echo "selected" ?> >RC - D&O</option>
        <option value="inc" <?php if ($producto == "inc") echo "selected" ?> >INC</option>
        <option value="apv" <?php if ($producto == "apv") echo "selected" ?> >APV</option>
        <option value="ap" <?php if ($producto == "ap") echo "selected" ?> >AP</option>
        <option value="vida" <?php if ($producto == "vida") echo "selected" ?> >Vida</option>
        <option value="garantia" <?php if ($producto == "garantia") echo "selected" ?> >Garantía</option>

        </select>
  
  </div>
  
  <div class="col-3">
  <label><b>Instancia</b></label>
     <select class="form-control" name="instancia2" id="instancia2" onchange ="copia_instancia()">
          <option value="null">Selecciona una Instancia</option>
          <option >-------------------------------</option>
          <option value="info_cotizar" <?php if ($instancia == "info_cotizar") echo "selected" ?>>Información para Cotizar</option>
          <option value="envio_cotizacion" <?php if ($instancia == "envio_cotizacion") echo "selected" ?>>Envío de Cotización</option>
 </select>
  </div>
  
    <div class="col">
   <button class="btn" type="submit" name="buscar"
                        style="background-color: #536656; color: white; height: 45; align-self: end" onclick="envio_data(this.name)">Buscar
    template</button>
    
 </div>
 

</div>
<div name='correo'>
 <br>
<br>   
<div class="col-12">
  <h6>Resultado</h6>
  <div id="template_correo" class="form-control bg-light text-dark" rows="10"
                style="height: 300px; width:73vw; border-style: solid;overflow-y: scroll"><?php echo $template; ?></div>
  <br>
  <a class="btn" type="btn"
                        style="background-color: #536656; color: white; height: 45; align-self: center;" href="<?php echo urldecode($url); ?>" target="_blank">Enviar mail</a><br>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
<script src="/assets/js/jquery.redirect.js"></script>

</div>


 </form>
 </div>
</body>


</html>

<script>
function envio_data(boton) {
    document.getElementById("tipo").value = boton;
    
}

function copia_ramo(){
    document.getElementById("ramo").value = document.getElementById("ramo2").value;
}

function copia_instancia(){
    document.getElementById("instancia").value = document.getElementById("instancia2").value;
}

document.addEventListener("DOMContentLoaded", function() {

document.getElementById("instancia").value = '<?php echo $instancia; ?>';
document.getElementById("ramo").value = '<?php echo $ramo_poliza; ?>';
document.getElementById("instancia2").value = '<?php echo $instancia; ?>';
document.getElementById("ramo2").value = '<?php echo $ramo_poliza; ?>';

});

</script>