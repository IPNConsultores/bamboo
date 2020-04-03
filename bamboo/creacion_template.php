<?php
function estandariza_info($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
require_once "/home/gestio10/public_html/backend/config.php";
$instancia=$_POST["instancia"];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $instancia=$_POST["instancia"];
    $producto=$_POST["seguro"];
    mysqli_set_charset( $link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
        //poliza
$resultado_template=mysqli_query($link, 'SELECT template FROM template_correos where producto="'.$producto.'" and instancia="'.$instancia.'"');
        While($row=mysqli_fetch_object($resultado_template))
            {
                $template=$row->template;
            }
            $template_ejemplo=$template;
    $template_ejemplo=str_replace('_[NRO_POLIZA]_','1923898', $template_ejemplo);
    $template_ejemplo=str_replace('_[RAMO]_','VEH', $template_ejemplo);
    $template_ejemplo=str_replace('_[COMPANIA]_','Sura', $template_ejemplo);
    $template_ejemplo=str_replace('_[NOMBRE_CLIENTE]_','Juan Pérez', $template_ejemplo);
    $template_ejemplo=str_replace('_[VIGENCIA_INICIAL]_','2020-04-01', $template_ejemplo);
    $template_ejemplo=str_replace('_[VIGENCIA_FINAL]_','2021-04-01', $template_ejemplo);
    $template_ejemplo=str_replace('_[COBERTURA]_','Auto Premium', $template_ejemplo);
    $template_ejemplo=str_replace('_[DEDUCIBLE]_','10', $template_ejemplo);
    $template_ejemplo=str_replace('_[PRIMERA_CUOTA]_','2020-04-01', $template_ejemplo);
    $template_ejemplo=str_replace('_[FORMA_PAGO]_','11 cuotas PAT', $template_ejemplo);
    $template_ejemplo=str_replace('_[PRIMA_ANUAL]_','31.54', $template_ejemplo);
    $template_ejemplo=str_replace('_[VEHICULO]_','Mercedes Benz E200 año 2014', $template_ejemplo);
    $template_ejemplo=str_replace('_[SALTO_LINEA]_','<br>', $template_ejemplo);
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

    <div class="container" >
        <div class="form-row">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name="solicita_template">
                <div class="col-md-4 mb-3">
                    <label ><b>Instancia</b></label>
                    <br>
                    <div class="form-row">
                        <div class="form-inline">
                            <select class="form-control" name="instancia" id="instancia">
                                <option value="envio_poliza">Informar seguro</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label><b>Producto</b></label>
                    <br>
                    <div class="form-row">
                        <div class="form-inline">
                            <select class="form-control" name="seguro" id="seguro">
                                <option value="vehiculo">Vehiculo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <button class="btn" type="submit" style="background-color: #536656; color: white">Buscar template</button>
            </form>
        </div>

<div class="form-row">
    <div class="col-md-4 mb-3">
<textarea rows="30" cols="55">
<?php echo $template; ?>
</textarea>
</div>
<div class="col-md-2" width: 5px> 
</div>    
<div class="col-md-6 bg-light text-dark" border-style: solid;>
<?php echo $template_ejemplo; ?>
        </div>
</div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</body>

</html>