<?php
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
require_once "/home/asesori1/public_html/bamboo/backend/config.php";

 $busqueda=$busqueda_err='';
 $rut=$nombre='';
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["buscacliente"]))){
        $busqueda_err = "Favor realiza una busqueda. Puedes buscar por rut, nombre o apellido";
    } else{
    //inicio feabarcas
    $busqueda=estandariza_info($_POST["buscacliente"]);
    $numero=$trozos=0;
    mysqli_set_charset( $link, 'utf8');
    mysqli_select_db($link, 'asesori1_bamboo');

    if ($busqueda<>''){
    //CUENTA EL NUMERO DE PALABRAS
        $trozos=explode(" ",$busqueda);
        $numero=count($trozos);
        if ($numero==1) {
        //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
            $resultado=mysqli_query($link, 'SELECT CONTACT(rut_sin_dv, \'-\',dv) as rut, CONCAT(nombre_cliente, \' \', apellido_paterno, \' \', apellido_materno) as nombre  FROM clientes WHERE  where nombre_cliente like \'%'.$busqueda.'%\' or apellido_paterno like \'%'.$busqueda.'%\' or rut_sin_dv like \'%'.$busqueda.'%\';');
        } elseif ($numero>1) {
        //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
        //busqueda de frases con mas de una palabra y un algoritmo especializado
            $resultado=mysqli_query($link, 'SELECT CONTACT(rut_sin_dv, \'-\',dv) as rut, CONCAT(nombre_cliente, \' \', apellido_paterno, \' \', apellido_materno) as nombre , MATCH(nombre_cliente, apellido_paterno ,apellido_materno , rut_sin_dv) AGAINST ( \''.$busqueda.'\' ) AS Score FROM clientes WHERE MATCH(nombre_cliente, apellido_paterno ,apellido_materno , rut_sin_dv) AGAINST ( \''.$busqueda.'\' ) ORDER BY Score DESC LIMIT 50;');
        }
    }
        While($row=mysqli_fetch_object($resultado))
    {
    //Mostramos los titulos de los articulos o lo que deseemos...
        $rut=$row["rut"];
        $nombre=$row["nombre"];
        echo $rut." - ".$nombre."<br>";
    }

    //fin feabarcas
    }

    // Close connection
    mysqli_close($link);
    echo 'SELECT CONTACT(rut_sin_dv, \'-\',dv) as rut, CONCAT(nombre_cliente, \' \', apellido_paterno, \' \', apellido_materno) as nombre  FROM clientes WHERE  where nombre_cliente like \'%'.$busqueda.'%\' or apellido_paterno like \'%'.$busqueda.'%\' or rut_sin_dv like \'%'.$busqueda.'%\';';
}
?>
 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modificación Cliente</title>
<!-- Bootstrap -->
<link href="css/bootstrap-4.3.1.css" rel="stylesheet">
</head>
<body>
<!-- body code goes here -->

  <div class=  "container">
    <p> Clientes / Modificación <br>
    </p>
    <form class="needs-validation" novalidate method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <h5 class="form-row">&nbsp;Buscador Cliente</h5>
      <br>
      <label for="Buscador">Rut sin DV o Nombre</label>
      <div class= "form-row; needs-validation">
        <div class= "col-md-4; form-inline">
          <input class="form-control" type="text" name="buscacliente" id="buscacliente" required>
          <button class="btn my-sm-0" style="background-color: #536656; color: white; margin-left:5px;" type="submit">Buscar</button>
          <div class="invalid-feedback"> No puedes dejar este campo en blanco 
          </div>
        </div>
      </div>
    </form>
            <br>
    <form class="needs-validation" novalidate>
      <h5 class="form-row">&nbsp;Datos personales</h5>
      <br>
      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label for="Nombre">Nombre</label>
          <input type="text" class="form-control" id="Nombre"  required value="<?php echo $nombre; ?>"  >
          <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="ApellidoP">Apellido Paterno</label>
          <input type="text" class="form-control" id="ApellidoP" required>
          <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="ApellidoM">Apellido Materno</label>
          <input type="text" class="form-control" id="ApellidoM" required>
          <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="form-row">
            <div class ="col-md-8 mb-3">
              <label for="RUT">RUT</label>
              <input type="text" class="form-control" id="RUT" placeholder= "11111111" required>
              <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
            </div>
            <div class ="col-md-8 mb-3 col-xl-3">
              <label for="RUT">&nbsp;</label>
              <input type="text" class="form-control" id="DV" placeholder= "K" required>
              <div class="invalid-feedback"></div>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="validationCustomUsername">Mail</label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text" id="EMail">@</span> </div>
            <input type="email" class="form-control" id="Mail"  required>
            <div class="invalid-feedback"> Campo en blanco o sin formato mail (aaa@bbb.xxx) </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="Dirección">Dirección</label>
          <input type="text" class="form-control" id="Dirección" required>
          <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
        </div>
      </div>
      <button class="btn" type="submit" style="background-color: #536656; color: white">Modificar</button>
    </form>
  </div>
</body>
</html>