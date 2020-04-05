<?php
$template=$resultado_template='';
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
  if ( isset( $_POST[ "template" ] ) ) {
    switch ( $_POST[ "tipo" ] ) {
      case "probar":
        $template = estandariza_info( $_POST[ "template" ] );
        break;
      case "guardar":
        $template = estandariza_info( $_POST[ "template" ] );
        $instancia = $_POST[ "instancia_aux" ];
        $producto = $_POST[ "seguro_aux" ];
        mysqli_query( $link, 'UPDATE template_correos SET template="' . $template . '" where producto="' . $producto . '" and instancia="' . $instancia . '"' );
        break;
    }

  } else {
    $instancia = $_POST[ "instancia" ];
    $producto = $_POST[ "seguro" ];
    $resultado_template = mysqli_query( $link, 'SELECT template FROM template_correos where producto="' . $producto . '" and instancia="' . $instancia . '"' );
    While( $row = mysqli_fetch_object( $resultado_template ) ) {
      $template = estandariza_info( $row->template );
    }
  }

  $template_ejemplo = $template;
  $template_ejemplo = str_replace( '_[NRO_POLIZA]_', '1923898', $template_ejemplo );
  $template_ejemplo = str_replace( '_[RAMO]_', 'VEH', $template_ejemplo );
  $template_ejemplo = str_replace( '_[COMPANIA]_', 'Sura', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NOMBRE_CLIENTE]_', 'Juan Pérez', $template_ejemplo );
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
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name="solicita_template">
            <div class="row">
                <div class="col">
                    <label><b>Instancia</b></label>
                    <select class="form-control" name="instancia" id="instancia">
                        <option value="envio_poliza">Informar seguro</option>
                        <option value="renovacion">Renovación</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="col">
                    <label><b>Producto</b></label>
                    <select class="form-control" name="seguro" id="seguro">
                        <option value="vehiculo">Vehiculo</option>
                        <option value="hogar">Hogar</option>
                        <option value="viaje">A. VIAJE</option>
                        <option value="rc_do">RC - D&O</option>
                        <option value="inc">INC</option>
                        <option value="apv">APV</option>
                        <option value="ap">AP</option>
                        <option value="vida">Vida</option>
                        <option value="garantia">Garantía</option>
                        <option value="otro">Otro</option>
                    </select>
                    <br>
                </div>
                <div class="col" style="align-self: center">
                    <button class="btn" type="submit"
                        style="background-color: #536656; color: white; height: 45; align-self: center">Buscar
                        template</button>
                </div>
        </form>
    </div>
    <div class="row">
        <div class="col-6 col-md-4">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name='editor_template'>
                <h6>Diccionario de Campos</h6>
                <div class="row"
                    style="overflow-y: scroll;height: 200px;border-style: solid; border-width: thin;border-color: #D2D8DD">
                    <table class="table" id="formato">
                        <thead >
                            <tr>
                                <th>Comando</th>
                                <th>Definición</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>_[NRO_POLIZA]_</td>
                                <td>Número Póliza</td>
                            </tr>
                            <tr>
                                <td>_[RAMO]_</td>
                                <td>Ramo</td>
                            </tr>
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
                                <td>_[NOMBRE_CLIENTE]_</td>
                                <td>Nombre Cliente</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <h6>Diccionario de Formato</h6>
                <div class="row"
                    style="overflow-y:scroll;height: 200px;border: solid; border-width: thin;border-color: #D2D8DD">
                    <table class="table" id="formato">
                        <thead>
                            <tr>
                                <th>Comando</th>
                                <th>Definición</th>
                            </tr>
                        </thead>
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
        <div id="auxiliar" style="display: none;">
            <input name="tipo" id="tipo">
            <input name="seguro_aux" id="seguro_aux">
            <input name="instancia_aux" id="instancia_aux">
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
    if (boton == "guardar") {
        document.getElementById("seguro_aux").value = document.getElementById("seguro").value;
        document.getElementById("instancia_aux").value = document.getElementById("instancia").value;
    }

}
</script>