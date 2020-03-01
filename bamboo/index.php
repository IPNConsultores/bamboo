<?php
session_start();
$lista='';
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
require_once "/home/gestio10/public_html/backend/config.php";
$num=0;

    mysqli_set_charset( $link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    $resultado=mysqli_query($link, 'SELECT * FROM tareas where estado =\'activo\'order by fecha_vencimiento desc, prioridad asc;');
    While($row=mysqli_fetch_object($resultado))
        {
        //Mostramos los titulos de los articulos o lo que deseemos...
            $id=$row->id;
            $id_cliente=$row->id_cliente;
            $id_poliza=$row->id_poliza;
            $fecha_ingreso=$row->fecha_ingreso;
            $fecha_vencimiento=$row->fecha_vencimiento;
            $tarea=$row->tarea;
            $estado=$row->estado;
            $prioridad=$row->prioridad;
            $num=$num+1;
            $lista=$lista.'<tr><td>'.$num.'</td><td>'.$prioridad.'</td><td>'.$estado.'</td><td>'.$tarea.'</td><td>'.$fecha_vencimiento.'</td><td>'.$id_poliza.'</td><td>'.$fecha_vencimiento.'</td><td><a class="button" name="boton-modificar" href="#">Marcar como completada</a><a> </a><a class="button" name="boton-elimina-cliente" href="#">Eliminar</a></td><tr>'. "<br>";
               
        }
    mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bamboo Seguros</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</head>


<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Resumen de tareas <br>
        </p>
        <br>
        <form class="needs-validation" novalidate>
            <h5 class="form-row">&nbsp;Tareas pendientes</h5>
            <br>
            <div class="form-row">
                <table class="table" id="listado_tareas">
                    <tr>
                        <th>#</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Tarea</th>
                        <th>Fecha vencimiento</th>
                        <th>póliza asociada</th>
                        <th>Cliente asociado</th>
                        <th>Acción</th>
                    </tr>
                    <?php echo $lista; ?>
                </table>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
</body>

</html>