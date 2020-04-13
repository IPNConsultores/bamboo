<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$template=$resultado_template=$instancia=$producto='';
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
 
    switch ( $_POST[ "tipo" ] ) {
      case "probar":
        $template = estandariza_info( $_POST[ "template" ] );
        $instancia = $_POST[ "instancia" ];
        $producto = $_POST[ "seguro" ];
        break;
      case "guardar":
        $template = estandariza_info( $_POST[ "template" ] );
        $instancia = $_POST[ "instancia" ];
        $producto = $_POST[ "seguro" ];
        $verif_combi = mysqli_query( $link, 'SELECT COUNT(*) AS contador FROM template_correos WHERE producto="' . $producto . '" and instancia="' . $instancia . '"' );
        While( $row = mysqli_fetch_object( $verif_combi ) ) {
          $verif = estandariza_info( $row->contador );
        }
        if (!$verif==0){
          mysqli_query( $link, 'UPDATE template_correos SET template="' . $template . '" where producto="' . $producto . '" and instancia="' . $instancia . '"' );
        }
        else{
          mysqli_query( $link, 'INSERT INTO template_correos(template, producto, instancia) values ("' . $template . '","' . $producto . '", "' . $instancia . '");' );
        }
        break;
        case "buscar":
            $instancia = $_POST[ "instancia" ];
            $producto = $_POST[ "seguro" ];
            $resultado_template = mysqli_query( $link, 'SELECT template FROM template_correos where producto="' . $producto . '" and instancia="' . $instancia . '"' );
            While( $row = mysqli_fetch_object( $resultado_template ) ) {
              $template = estandariza_info( $row->template );
            }
            break;
    }


  $template_ejemplo = $template;
  $template_ejemplo = str_replace( '_[NOMBRE_CLIENTE]_', 'Juan Pérez', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NRO_POLIZA]_', '1923898', $template_ejemplo );
  $template_ejemplo = str_replace( '_[RAMO]_', 'VEH', $template_ejemplo );
  $template_ejemplo = str_replace( '_[COMPANIA]_', 'Sura', $template_ejemplo );
  $template_ejemplo = str_replace( '_[VIGENCIA_INICIAL]_', '2020-04-01', $template_ejemplo );
  $template_ejemplo = str_replace( '_[VIGENCIA_FINAL]_', '2021-04-01', $template_ejemplo );
  $template_ejemplo = str_replace( '_[COBERTURA]_', 'Auto Premium', $template_ejemplo );
  $template_ejemplo = str_replace( '_[DEDUCIBLE]_', '10', $template_ejemplo );
  $template_ejemplo = str_replace( '_[PRIMERA_CUOTA]_', '2020-04-01', $template_ejemplo );
  $template_ejemplo = str_replace( '_[FORMA_PAGO]_', '11 cuotas PAT', $template_ejemplo );
  $template_ejemplo = str_replace( '_[PRIMA_ANUAL]_', '31.54', $template_ejemplo );
  $template_ejemplo = str_replace( '_[VEHICULO]_', 'Mercedes Benz E200 año 2014', $template_ejemplo );
  
  $template_ejemplo = str_replace( '_[SALTO_LINEA]_', '<br>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NEG_ini]_', '<b>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NEG_fin]_', '</b>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[SUB_ini]_', '<u>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[SUB_fin]_', '</u>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[CUR_ini]_', '<em>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[CUR_fin]_', '</em>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[LINEA]_', '<hr>', $template_ejemplo );
}


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
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name='editor_template'>

                    <div id="auxiliar" style="display: none;">
            <input name="tipo" id="tipo">
        </div>
            <div class="row">
                <div class="col">
                    <label><b>Instancia</b></label>
                    <select class="form-control" name="instancia" id="instancia">
                        <option value="envio_poliza" <?php if ($instancia == "envio_poliza") echo "selected" ?>>Informar póliza</option>
                        <option value="renovacion" <?php if ($instancia == "renovacion") echo "selected" ?> >Renovación</option>
                        <option value="otro" <?php if ($instancia == "otro") echo "selected" ?> >Otro</option>
                    </select>
                </div>
                <div class="col">
                    <label><b>Producto</b></label>
                    <select class="form-control" name="seguro" id="seguro">
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
                    <br>
                </div>
                <div class="col" style="align-self: center">
                    <button name="buscar" class="btn" type="submit" onclick="envio_data(this.name)"
                        style="background-color: #536656; color: white; height: 45; align-self: center">Buscar
                        template</button>
                </div>

    </div>
    <div class="row">
        <div class="col-6 col-md-4">
            
                <h6>Diccionario de Campos</h6>
                <div class="row"
                    style="height: 200px;margin-bottom: 0px;border-style: solid; border-width: thin;border-color: #D2D8DD">
                    <table class="table" id="formato" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 0px">
                        <thead >
                            <tr>
                                <th>Comando</th>
                                <th>Definición</th>
                            </tr>
                        </thead>
					</table>
						<div style= "height:120px; width:400px; overflow-x:auto;margin-top: 0px;">
					<table class="table">
                        <tbody>
                            <tr>
                                <td>_[NOMBRE_CLIENTE]_</td>
                                <td>Nombre Cliente</td>
                            </tr>
                            <tr>
                                <td>_[NRO_POLIZA]_</td>
                                <td>Número Póliza</td>
                            </tr>
                            <tr>
                                <td>_[RAMO]_</td>
                                <td>Ramo</td>
                            </tr>
                            <tr>
                                <td>_[COMPANIA]_</td>
                                <td>Compañía</td>
                            </tr>
                            <tr>
                                <td>_[VIGENCIA_INICIAL]_</td>
                                <td>Fecha vigencia inicial</td>
                            </tr>
                            <tr>
                                <td>_[VIGENCIA_FINAL]_</td>
                                <td>Fecha vigencia Final</td>
                            </tr>
                            <tr>
                                <td>_[COBERTURA]_</td>
                                <td>Cobertura</td>
                            </tr>
                            <tr>
                                <td>_[DEDUCIBLE]_</td>
                                <td>Deducible</td>
                            </tr>
                            <tr>
                                <td>_[PRIMERA_CUOTA]_</td>
                                <td>Fecha primera cuota</td>
                            </tr>
                            <tr>
                                <td>_[FORMA_PAGO]_</td>
                                <td>Forma de Pago</td>
                            </tr>
                            <tr>
                                <td>_[PRIMA_ANUAL]_</td>
                                <td>Prima Anual Bruta</td>
                            </tr>
                            <tr>
                                <td>_[VEHICULO]_</td>
                                <td>Vehiculo</td>
                            </tr>
                            
                        </tbody>
                    </table>
				</div>
                </div>
                <br>
                <h6>Diccionario de Formato</h6>
                <div class="row"
                    style="height: 200px;border: solid; border-width: thin;border-color: #D2D8DD">
                     <table class="table" id="formato" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 0px">
                        <thead >
                            <tr>
                                <th>Comando</th>
                                <th>Definición</th>
                            </tr>
                        </thead>
					</table>
					</table>
					<div style= "height:120px; width:400px; overflow-x:auto;margin-top: 0px;">
					<table class="table" style: "width:400px">
                        <tbody>
                            <tr>
                                <td>_[SALTO_LINEA]_</td>
                                <td>Salto de línea</td>
                            </tr>
                            <tr>
                                <td>_[LINEA]_</td>
                                <td>Línea/separador</td>
                            </tr>
                            <tr>
                                <td>_[NEG_ini]_</td>
                                <td>Negrita inicio</td>
                            </tr>
                            <tr>
                                <td>_[NEG_fin]_</td>
                                <td>Negrita fin</td>
                            </tr>
                            <tr>
                                <td>_[CUR_ini]_</td>
                                <td>Cursiva inicio</td>
                            </tr>
                            <tr>
                                <td>_[CUR_fin]_</td>
                                <td>Cursiva fin</td>
                            </tr>   
                            <tr>
                                <td>_[SUB_ini]_</td>
                                <td>Subrayado inicio</td>
                            </tr> 
                            <tr>
                                <td>_[SUB_fin]_</td>
                                <td>Subrayado fin</td>
                            </tr>                          
                        </tbody>
                    </table>
					</div>
                </div>
                <br>
                <button class="btn" name="probar" type="submit" style="background-color: #536656; color: white"
                    onclick="envio_data(this.name)">Probar</button>
                <button class="btn" name="guardar" type="submit" style="background-color: #536656; color: white"
                    onclick="envio_data(this.name)">Guardar</button>
        </div>
        <br>
        <div class="col">
            <h6>Template</h6>
            <textarea class="form-control" rows="10" style="height: 200px" id='template' name='template'
                style="text-indent:0px";><?php echo $template; ?></textarea>
            <br>
            <h6>Resultado</h6>
            <div class="form-control bg-light text-dark" rows="10"
                style="height: 200px; border-style: solid;overflow-y: scroll"><?php echo $template_ejemplo; ?>
            </div>
            <br>
        </div>

        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</body>

</html>
<script>
function envio_data(boton) {
    document.getElementById("tipo").value = boton;
}

</script>