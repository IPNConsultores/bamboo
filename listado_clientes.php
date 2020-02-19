<?php
session_start();
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

require_once "/home/asesori1/public_html/bamboo/backend/config.php";
$num=0;
 $busqueda=$busqueda_err='';
 $rut=$nombre=$telefono=$correo=$lista='';
//inicio feabarcas v1.96

if($_SESSION["auxiliar"]==true){
    $_SESSION["auxiliar"]=false;
    mysqli_set_charset( $link, 'utf8');
    mysqli_select_db($link, 'asesori1_bamboo');
    $resultado=mysqli_query($link, 'SELECT id, CONCAT(rut_sin_dv, \'-\',dv) as rut, CONCAT(nombre_cliente, \' \', apellido_paterno, \' \', apellido_materno) as nombre , telefono, correo FROM clientes ORDER BY apellido_paterno ASC, apellido_materno ASC;');
    While($row=mysqli_fetch_object($resultado))
        {
        //Mostramos los titulos de los articulos o lo que deseemos...
            $rut=$row->rut;
            $id=$row->id;
            $nombre=$row->nombre;
            $telefono=$row->telefono;
            $correo=$row->correo;
            $num=$num+1;
            $lista=$lista.'<tr><td>'.$num.'</td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td><td><a class="button" name="boton-modificar" id="'.$id.'" href="http://ipnconsultores.cl/bamboo/modificacion_cliente.php?cliente='.$id.'">modificar</a></td><tr>'. "<br>";
               
        }
    mysqli_close($link);
}

//fin feabarcas v1.96

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["buscacliente"])) and empty(trim($_POST["busqueda"]))){
        $busqueda_err = "Favor realiza una busqueda. Puedes buscar por rut, nombre o apellido";
    } else{
    //inicio feabarcas
    if (!empty(trim($_POST["buscacliente"]))){$busqueda=estandariza_info($_POST["buscacliente"]);}

    if (!empty(trim($_POST["busqueda"]))){$busqueda=estandariza_info($_POST["busqueda"]);}
 
    $numero=$trozos=0;

    mysqli_set_charset( $link, 'utf8');
    mysqli_select_db($link, 'asesori1_bamboo');

    if ($busqueda<>''){
    //CUENTA EL NUMERO DE PALABRAS
        $trozos=explode(" ",$busqueda);
        $numero=count($trozos);
        if ($numero==1) {
        //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
            $resultado=mysqli_query($link, 'SELECT id, CONCAT(rut_sin_dv, \'-\',dv) as rut, CONCAT(nombre_cliente, \' \', apellido_paterno, \' \', apellido_materno) as nombre , telefono, correo FROM clientes WHERE  nombre_cliente like \'%'.$busqueda.'%\' or apellido_paterno like \'%'.$busqueda.'%\' or rut_sin_dv like \'%'.$busqueda.'%\';');
        } elseif ($numero>1) {
        //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
        //busqueda de frases con mas de una palabra y un algoritmo especializado
            $resultado=mysqli_query($link, 'SELECT id, CONCAT(rut_sin_dv, \'-\',dv) as rut, CONCAT(nombre_cliente, \' \', apellido_paterno, \' \', apellido_materno) as nombre , telefono, correo , MATCH(nombre_cliente, apellido_paterno ,apellido_materno , rut_sin_dv) AGAINST ( \''.$busqueda.'\' ) AS Score FROM clientes WHERE MATCH(nombre_cliente, apellido_paterno ,apellido_materno , rut_sin_dv) AGAINST ( \''.$busqueda.'\' ) ORDER BY Score DESC LIMIT 50;');
        }
    }
        While($row=mysqli_fetch_object($resultado))
    {
    //Mostramos los titulos de los articulos o lo que deseemos...
        $rut=$row->rut;
        $id=$row->id;
        $nombre=$row->nombre;
        $telefono=$row->telefono;
        $correo=$row->correo;
        $num=$num+1;
        $lista=$lista.'<tr><td>'.$num.'</td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td><td><a class="button" name="boton-modificar-cliente" id="'.$id.'" href="http://ipnconsultores.cl/bamboo/modificacion_cliente.php?cliente='.$id.'">modificar</a><a> </a><a class="button" name="boton-elimina-cliente" id="'.$id.'" href="http://ipnconsultores.cl/bamboo/backend/elimina_cliente.php?cliente='.$id.'">eliminar</a></td><tr>'. "<br>";
    }

    //fin feabarcas
    }

    // Close connection
    mysqli_close($link);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
    <title>Modificación Cliente</title>
    <!-- Bootstrap -->
</head>

<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Clientes / Modificación <br>
        </p>
        <form class="needs-validation" novalidate method="POST"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h5 class="form-row">&nbsp;Buscador de Clientes</h5>
            <br>
            <label for="Buscador">Nombre o Rut sin dígito verificador</label>
            <div class="form-row; needs-validation">
                <div class="col-md-4; form-inline">
                    <input class="form-control" type="text" name="buscacliente" id="buscacliente"
                        value="<?php echo $data; ?>" required>
                    <button class="btn my-sm-0" style="background-color: #536656; color: white; margin-left:5px;"
                        type="submit">Buscar</button>
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
                <table class="table" id="listado">
                    <tr>
                        <th>#</th>
                        <th>Rut</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Acción</th>
                    </tr>
                    <?php echo $lista; ?>
                </table>
            </div>
        </form>
    </div>
</body>

</html>