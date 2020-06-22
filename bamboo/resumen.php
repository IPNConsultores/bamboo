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
$num_cliente=$num_poliza=$num_tareas=0;
 $busqueda=$busqueda_err=$data=$resultado_poliza=$resultado_tareas='';
 $rut=$nombre=$telefono=$correo=$tabla_clientes=$tabla_tareas=$tabla_poliza='';

if($_SERVER["REQUEST_METHOD"] == "POST"){
// Viene desde cliente
    if(!empty(trim($_POST["id_cliente"]))){
        $busqueda=$_POST["id_cliente"];
        mysqli_set_charset( $link, 'utf8');
        mysqli_select_db($link, 'gestio10_asesori1_bamboo');
        //cliente
        $resultado=mysqli_query($link, 'SELECT id, CONCAT(rut_sin_dv, \'-\',dv) as rut, concat_ws(\' \', nombre_cliente,  apellido_paterno, apellido_materno) as nombre , telefono, correo FROM clientes where  id='.$busqueda.' ORDER BY apellido_paterno ASC, apellido_materno ASC;');
        While($row=mysqli_fetch_object($resultado))
            {
                $rut=$row->rut;
                $id=$row->id;
                $nombre=$row->nombre;
                $telefono=$row->telefono;
                $correo=$row->correo;
                $num_cliente=$num_cliente+1;
                $rutsindv=estandariza_info(substr(str_replace("-", "", $rut), 0, strlen(substr(str_replace("-", "", $rut)))-1));
                $tabla_clientes=$tabla_clientes.'<tr><td>'.$num_cliente.'</td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td></tr>'."<br>";        
            }
            //poliza
            $resultado_poliza=mysqli_query($link, 'SELECT id, compania, vigencia_final, numero_poliza, materia_asegurada, patente_ubicacion,cobertura FROM polizas where rut_proponente="'.$rutsindv.'" or rut_asegurado="'.$rutsindv.'"  order by compania, numero_poliza;');

            While($row=mysqli_fetch_object($resultado_poliza))
                {
                    $id= $row ->id;
                    $compania = $row->compania;
                    $vigencia_final= $row->vigencia_final;
                    $poliza= $row->numero_poliza;
                    $materia_asegurada= $row->materia_asegurada;
                    $patente_ubicacion = $row->patente_ubicacion;
                    $cobertura = $row->cobertura;
                    $num_poliza=$num_poliza+1;
                    $tabla_poliza=$tabla_poliza.'<tr><td>'.$num_poliza.'</td><td>'.$poliza.'</td><td>'.$compania.'</td><td>'.$cobertura.'</td><td>'.$vigencia_final.'</td><td>'.$materia_asegurada.'</td><td>'.$patente_ubicacion.'</td></tr>'."<br>";        
                }            
            //tareas
            $resultado_tareas=mysqli_query($link, 'select a.id, fecha_ingreso, fecha_vencimiento, tarea, estado, prioridad from tareas as a left join tareas_relaciones as b on a.id=b.id_tarea and b.id is not null where base="clientes" and id_relacion="'.$busqueda.'"  order by estado, prioridad asc, fecha_vencimiento desc;');

            While($row=mysqli_fetch_object($resultado_tareas))
                {
                    $id= $row ->id;
                    $fecha_ingreso = $row->fecha_ingreso;
                    $fecha_vencimiento= $row->fecha_vencimiento;
                    $tarea= $row->tarea;
                    $prioridad = $row->prioridad;
                    $num_tareas=$num_tareas+1;

                    switch ($row->estado) {
                        case 'Pendiente':
                            $estado='<span class="badge badge-primary">'.$row->estado.'</span>';
                            break;
                        case 'Completado':
                                $estado='<span class="badge badge-secondary">'.$row->estado.'</span>';
                                break;
                        case 'Atrasado':
                            $estado='<span class="badge badge-danger">'.$row->estado.'</span>';
                            break;
                        case 'Próximo a vencer':
                            $estado='<span class="badge badge-warning">'.$row->estado.'</span>';
                            break;
                        default:
                            $estado='<span class="badge badge-light">'.$row->estado.'</span>';
                            break;
                    }

                    $tabla_tareas=$tabla_tareas.'<tr><td>'.$num_tareas.'</td><td>'.$prioridad.'</td><td>'.$estado.'</td><td>'.$tarea.'</td><td>'.$fecha_ingreso.'</td><td>'.$fecha_vencimiento.'</td></tr>'."<br>";        
                }            
                    
          mysqli_close($link);
    } 
// Viene desde póliza
    if(!empty(trim($_POST["id_poliza"]))){
        $busqueda=$_POST["id_poliza"];
        mysqli_set_charset( $link, 'utf8');
        mysqli_select_db($link, 'gestio10_asesori1_bamboo');
            //poliza
            $resultado_poliza=mysqli_query($link, 'SELECT id, compania, vigencia_final, numero_poliza, materia_asegurada, patente_ubicacion,cobertura, rut_proponente, rut_asegurado FROM polizas where id='.$busqueda.' order by compania, numero_poliza;');

            While($row=mysqli_fetch_object($resultado_poliza))
                {
                    $id= $row ->id;
                    $compania = $row->compania;
                    $vigencia_final= $row->vigencia_final;
                    $poliza= $row->numero_poliza;
                    $materia_asegurada= $row->materia_asegurada;
                    $patente_ubicacion = $row->patente_ubicacion;
                    $cobertura = $row->cobertura;
                    $rut_proponente = $row->rut_proponente;
                    $rut_asegurado = $row->rut_asegurado;
                    $num_poliza=$num_poliza+1;
                    $tabla_poliza=$tabla_poliza.'<tr><td>'.$num_poliza.'</td><td>'.$poliza.'</td><td>'.$compania.'</td><td>'.$cobertura.'</td><td>'.$vigencia_final.'</td><td>'.$materia_asegurada.'</td><td>'.$patente_ubicacion.'</td></tr>'."<br>";        
                }     
        //cliente
        $resultado=mysqli_query($link, 'SELECT id, CONCAT(rut_sin_dv, \'-\',dv) as rut, concat_ws(\' \',nombre_cliente,  apellido_paterno,  apellido_materno) as nombre , telefono, correo FROM clientes where  rut_sin_dv in ('.$rut_proponente.' , '.$rut_asegurado.') ORDER BY apellido_paterno ASC, apellido_materno ASC;');
        While($row=mysqli_fetch_object($resultado))
            {
                $rut=$row->rut;
                $id=$row->id;
                $nombre=$row->nombre;
                $telefono=$row->telefono;
                $correo=$row->correo;
                $num_cliente=$num_cliente+1;
                $rutsindv=estandariza_info(substr(str_replace("-", "", $rut), 0, strlen(substr(str_replace("-", "", $rut)))-1));
                $tabla_clientes=$tabla_clientes.'<tr><td>'.$num_cliente.'</td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td></tr>'."<br>";        
            }       
            $resultado_tareas=mysqli_query($link, 'select a.id, fecha_ingreso, fecha_vencimiento, tarea, estado, prioridad from tareas as a left join tareas_relaciones as b on a.id=b.id_tarea and b.id is not null where base="polizas" and id_relacion="'.$busqueda.'"  order by estado, prioridad asc, fecha_vencimiento desc;');
        //tareas
            While($row=mysqli_fetch_object($resultado_tareas))
                {
                    $id= $row ->id;
                    $fecha_ingreso = $row->fecha_ingreso;
                    $fecha_vencimiento= $row->fecha_vencimiento;
                    $tarea= $row->tarea;
                    $prioridad = $row->prioridad;
                    $num_tareas=$num_tareas+1;

                    switch ($row->estado) {
                        case 'Pendiente':
                            $estado='<span class="badge badge-primary">Pendiente</span>';
                            break;
                        case 'Completado':
                                $estado='<span class="badge badge-secondary">Completado</span>';
                                break;
                        case 'Atrasado':
                            $estado='<span class="badge badge-danger">Atrasado</span>';
                            break;
                        case 'Próximo a vencer':
                            $estado='<span class="badge badge-warning">Próximo a vencer</span>';
                            break;
                        default:
                            $estado='<span class="badge badge-light">'.$row->estado.'</span>';
                            break;
                    }

                    $tabla_tareas=$tabla_tareas.'<tr><td>'.$num_tareas.'</td><td>'.$prioridad.'</td><td>'.$estado.'</td><td>'.$tarea.'</td><td>'.$fecha_ingreso.'</td><td>'.$fecha_vencimiento.'</td></tr>'."<br>";        
                }

        mysqli_close($link);
    } 
    // Viene desde tarea
    if(!empty(trim($_POST["id_tarea"]))){
        $busqueda=$_POST["id_tarea"];
        mysqli_set_charset( $link, 'utf8');
        mysqli_select_db($link, 'gestio10_asesori1_bamboo');
        //tareas
        $resultado_tareas=mysqli_query($link, 'select id, fecha_ingreso, fecha_vencimiento, tarea, estado, prioridad from tareas where id="'.$busqueda.'";');
        
        While($row=mysqli_fetch_object($resultado_tareas))
            {
                $id= $row ->id;
                $fecha_ingreso = $row->fecha_ingreso;
                $fecha_vencimiento= $row->fecha_vencimiento;
                $tarea= $row->tarea;
                $prioridad = $row->prioridad;
                $num_tareas=$num_tareas+1;

                switch ($row->estado) {
                    case 'Pendiente':
                        $estado='<span class="badge badge-primary">'.$row->estado.'</span>';
                        break;
                    case 'Completado':
                            $estado='<span class="badge badge-secondary">'.$row->estado.'</span>';
                            break;
                    case 'Atrasado':
                        $estado='<span class="badge badge-danger">'.$row->estado.'</span>';
                        break;
                    case 'Próximo a vencer':
                        $estado='<span class="badge badge-warning">'.$row->estado.'</span>';
                        break;
                    default:
                        $estado='<span class="badge badge-light">'.$row->estado.'</span>';
                        break;
                }

                $tabla_tareas=$tabla_tareas.'<tr><td>'.$num_tareas.'</td><td>'.$prioridad.'</td><td>'.$estado.'</td><td>'.$tarea.'</td><td>'.$fecha_ingreso.'</td><td>'.$fecha_vencimiento.'</td></tr>'."<br>";        
            }   
        //cliente
        $resultado=mysqli_query($link, 'SELECT a.id, CONCAT(rut_sin_dv, \'-\',dv) as rut, concat_ws(\' \', nombre_cliente,  apellido_paterno, apellido_materno) as nombre , telefono, correo FROM clientes as a left join tareas_relaciones as b on a.id=b.id_relacion and b.base=\'clientes\' where b.id_tarea='.$busqueda.' ORDER BY apellido_paterno ASC, apellido_materno ASC;');
        While($row=mysqli_fetch_object($resultado))
            {
                $rut=$row->rut;
                $id=$row->id;
                $nombre=$row->nombre;
                $telefono=$row->telefono;
                $correo=$row->correo;
                $num_cliente=$num_cliente+1;
                $rutsindv=estandariza_info(substr(str_replace("-", "", $rut), 0, strlen(substr(str_replace("-", "", $rut)))-1));
                $tabla_clientes=$tabla_clientes.'<tr><td>'.$num_cliente.'</td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td></tr>'."<br>";        
            }
            //poliza
            $resultado_poliza=mysqli_query($link, 'SELECT a.id, compania, vigencia_final, numero_poliza, materia_asegurada, patente_ubicacion,cobertura FROM polizas as a left join tareas_relaciones as b on a.id=b.id_relacion and b.base=\'polizas\' where b.id_tarea='.$busqueda.' order by compania, numero_poliza');

            While($row=mysqli_fetch_object($resultado_poliza))
                {
                    $id= $row ->id;
                    $compania = $row->compania;
                    $vigencia_final= $row->vigencia_final;
                    $poliza= $row->numero_poliza;
                    $materia_asegurada= $row->materia_asegurada;
                    $patente_ubicacion = $row->patente_ubicacion;
                    $cobertura = $row->cobertura;
                    $num_poliza=$num_poliza+1;
                    $tabla_poliza=$tabla_poliza.'<tr><td>'.$num_poliza.'</td><td>'.$poliza.'</td><td>'.$compania.'</td><td>'.$cobertura.'</td><td>'.$vigencia_final.'</td><td>'.$materia_asegurada.'</td><td>'.$patente_ubicacion.'</td></tr>'."<br>";        
                }                     
          mysqli_close($link);
    } 
  }
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

        <h4>Consolidado</h4>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información de Clientes</h5>
                <p class="card-text">Muestra el detalle del cliente </p>
                <table name="tabla_clientes" class="table table-striped">
                    <tr>
                        <thead>
                            <th>#</th>
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                        </thead>
                    </tr>
                    <tbody>
                        <?php echo $tabla_clientes; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información de Póliza</h5>
                <p class="card-text">Muestra Todas las pólizas asociadas</p>
                <table name="tabla_polizas" class="table table-striped">
                    <tr>
                        <thead>
                            <th>#</th>
                            <th>Número Póliza</th>
                            <th>Compañia</th>
                            <th>Cobertura</th>
                            <th>Vigencia Final</th>
                            <th>Materia Asegurada</th>
                            <th>Observaciones materia asegurada</th>
                        </thead>
                    </tr>
                    <tbody>
                        <?php echo $tabla_poliza; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tareas Asociadas</h5>
                <p class="card-text">Todas las Tareas asociadas al cliente o pólizas</p>
                <table id="listado_tareas" class="table table-striped">
                    <tr>
                        <thead>
                            <th>#</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Tarea o Actividad</th>
                            <th>Fecha creación tarea</th>
                            <th>Fecha vencimiento</th>
                        </thead>
                    </tr>
                    <tbody>
                        <?php echo $tabla_tareas; ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
     <script src="/assets/js/jquery.redirect.js"></script>
</body>
</html>