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
  
  $instancia = "solicitar_info";

  
  if ( $_POST[ "tipo" ] == "buscar"){
      
       $ramo = $_POST["ramo"];
  }
  
  else{
       $ramo = "vehiculo";
      
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
      <div id="auxiliar"  >
      <input name="tipo" id="tipo" style="display: none;">
    
      
    </div>
<div class="row">
  <div class="col-4">
    <label><b>Ramo</b></label>
    <select class="form-control" name="ramo" id="ramo" onchange ="copia_ramo()">
          <option value="vehiculo" <?php if ($producto == "vehiculo") echo "selected" ?> >Vehiculo</option>
          <option value="hogar_persona" <?php if ($producto == "hogar_persona") echo "selected" ?> >Hogar persona</option>
          <option value="hogar_pyme" <?php if ($producto == "hogar_pyme") echo "selected" ?> >Hogar PyME</option>
          <option value="viaje" <?php if ($producto == "viaje") echo "selected" ?> >A. VIAJE</option>
          <option value="rc_do" <?php if ($producto == "rc_do") echo "selected" ?> >RC - D&O</option>
          <option value="inc" <?php if ($producto == "inc") echo "selected" ?> >INC</option>
          <option value="apv" <?php if ($producto == "apv") echo "selected" ?> >APV</option>
          <option value="ap" <?php if ($producto == "ap") echo "selected" ?> >AP</option>
          <option value="vida" <?php if ($producto == "vida") echo "selected" ?> >Vida</option>
          <option value="garantia" <?php if ($producto == "garantia") echo "selected" ?> >Garantía</option>
          <option value="otro" <?php if ($producto == "otro") echo "selected" ?> >Otro</option>
        </select>
  </div>
  <div class="col" style="align-self:flex-end">
   <button class="btn" type="submit" name="buscar"
                        style="background-color: #536656; color: white; height: 45; align-self: center" onclick="envio_data(this.name)">Buscar
    template</button>
  </div>
 
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

function copia_ramo(){
    document.getElementById("ramo2").value = document.getElementById("ramo").value;
}

document.addEventListener("DOMContentLoaded", function() {



document.getElementById("ramo").value = '<?php echo $ramo_poliza; ?>';

});

</script>
</div>
 </form>
 </div>
</html>

<script>

</script>