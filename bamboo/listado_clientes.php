<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
require_once "/home/gestio10/public_html/backend/config.php";
$num=0;
 $busqueda=$busqueda_err=$data='';
 $rut=$nombre=$telefono=$correo=$lista='';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["buscacliente"])) and empty(trim($_POST["busqueda"]))){
        $busqueda_err = "Favor realiza una busqueda. Puedes buscar por rut, nombre o apellido";
        mysqli_set_charset( $link, 'utf8');
        mysqli_select_db($link, 'gestio10_asesori1_bamboo');
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
                $lista=$lista.'<tr><td>'.$num.'</td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td><td><button title="Busca toda la información asociada a este cliente" type="button" id="'.$id.'" name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id="'.$id.'" name="modifica" onclick="botones(this.id, this.name)"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina este cliente"  type="button" id="'.$id.'" name="elimina" onclick="botones(this.id, this.name)"><i class="fas fa-trash-alt"></i></button><a> </a><button title="Asigna una tarea o comentario"  type="button" id="'.$id.'" name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button>
            </td></tr>'."<br>";        
            }
        mysqli_close($link);
    } else{
    //inicio feabarcas
    if (!empty(trim($_POST["buscacliente"]))){$busqueda=estandariza_info($_POST["buscacliente"]);}
    if (!empty(trim($_POST["busqueda"]))){$busqueda=estandariza_info($_POST["busqueda"]);}
   // if (!empty(trim($_POST["dato"]))){$busqueda=estandariza_info($_POST["dato"]);}
    $numero=$trozos=0;

    mysqli_set_charset( $link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');

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
        $lista=$lista.'<tr><td>'.$num.'</td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td><td><button title="Busca toda la información asociada a este cliente" type="button" id="'.$id.'" name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id="'.$id.'" name="modifica" onclick="botones(this.id, this.name)"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina este cliente"  type="button" id="'.$id.'" name="elimina" onclick="botones(this.id, this.name)"><i class="fas fa-trash-alt"></i></button><a> </a><button title="Asigna una tarea o comentario"  type="button" id="'.$id.'" name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button>
            </td></tr>'."<br>";   }

    //fin feabarcas
    }

    // Close connection
    mysqli_close($link);

}
else
{
    mysqli_set_charset( $link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
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
            $lista=$lista.'<tr><td>'.$num.'</td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td><td><button title="Busca toda la información asociada a este cliente" type="button" id="'.$id.'" name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id="'.$id.'" name="modifica" onclick="botones(this.id, this.name)"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina este cliente"  type="button" id="'.$id.'" name="elimina" onclick="botones(this.id, this.name)"><i class="fas fa-trash-alt"></i></button><a> </a><button title="Asigna una tarea o comentario"  type="button" id="'.$id.'" name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button>
            </td></tr>'."<br>";
            //$lista=$lista.'<tr><td>'.$num.'</td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td><td><a class="fas fa-edit" name="boton-modificar" id="'.$id.'" href="http://gestionipn.cl/bamboo/modificacion_cliente.php?cliente='.$id.'">modificar</a><a> </a><a class="fas fa-trash-alt" name="boton-elimina-cliente" id="'.$id.'" href="http://gestionipn.cl/bamboo/backend/clientes/elimina_cliente.php?cliente='.$id.'">eliminar</a></td></tr>'. "<br>";
 
                //<button title="Busca toda la información asociada a este cliente"  type="button" id="'.$id.'" name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id="'.$id.'" name="modifica" onclick="botones(this.id, this.name)"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina este cliente"  type="button" id="'.$id.'" name="elimina" onclick="botones(this.id, this.name)"><i class="fas fa-trash-alt"></i></button><a> </a><button title="Asigna una tarea o comentario"  type="button" id="'.$id.'" name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list">></i></button>
       
        }
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clientes</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
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
                        type="submit" onclick="<?php $_SESSION["auxiliar"]="buscador_listado";?>">Buscar</button>
                    <div class="invalid-feedback"> No puedes dejar este campo en blanco
                    </div>
                </div>
            </div>
        </form>
        <br>
        <form class="needs-validation" novalidate>
            <h5 class="form-row">&nbsp;Datos personales</h5>
            <br>
            <div class="table-responsive">

                <table class="table table-hover" id="listado">
                    <tr>
                        <thead>
                            <th>#</th>
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>Acción</th>
                        </thead>
                    </tr>
                    <tbody>
                        <?php echo $lista; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="/assets/js/jquery.redirect.js"></script>
    <script src="/assets/js/bootstrap-notify.js"></script>
    <script src="/assets/js/bootstrap-notify.min.js"></script>
</body>

</html>
<script>
//<a class="fas fa-edit" name="boton-modificar" id="'.$id.'" href="http://gestionipn.cl/bamboo/modificacion_cliente.php?cliente='.$id.'">modificar</a>
//<a> </a>
//<a class="fas fa-trash-alt" name="boton-elimina-cliente" id="'.$id.'" href="http://gestionipn.cl/bamboo/backend/clientes/elimina_cliente.php?cliente='.$id.'">eliminar</a>
function botones(id, accion) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "elimina": {
            console.log("Cliente eliminado con ID:" + id);
            var r = confirm(
                "Estás a punto de eliminar los datos de un cliente. ¿Estás seguro de eliminarlo?"
            );
            if (r == true) {
                $.ajax({
                    type: "POST",
                    url: "/bamboo/backend/clientes/elimina_cliente.php",
                    data: {
                        cliente: id
                    },
                });
                $.notify({
                    // options
                    message: 'Cliente eliminado con éxito'
                }, {
                    // settings
                    type: 'success'
                });
                //location
                break;

            } else {
                $.notify({
                    // options
                    message: 'Proceso de eliminación de cliente cancelado'
                }, {
                    // settings
                    type: 'info'
                });
                break;
            }
        }
        case "modifica": {
            $.redirect('/bamboo/modificacion_cliente.php', {
                'cliente': id
            }, 'post');
            break;
        }
        case "tarea": {
            console.log("Asignar tarea a ID:" + id);
            $.notify({
                // options
                message: 'Tarea Asignada'
            }, {
                // settings
                type: 'success'
            });
            break;
        }
        case "info": {
            console.log("Busqueda de ID:" + id);
            $.notify({
                // options
                message: 'Recopilando información del cliente'
            }, {
                // settings
                type: 'info'

            });
            break;
        }
    }
}
</script>