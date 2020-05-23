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
$num_cliente=$num_poliza=0;
 $busqueda=$busqueda_err=$data=$resultado_poliza='';
 $rut=$nombre=$telefono=$correo=$tabla_clientes=$tabla_poliza='';

if($_SERVER["REQUEST_METHOD"] == "POST"){
// Viene desde cliente
    if(!empty(trim($_POST["id_cliente"]))){
        $busqueda=$_POST["id_cliente"];
        mysqli_set_charset( $link, 'utf8');
        mysqli_select_db($link, 'gestio10_asesori1_bamboo');
        //cliente
        $resultado=mysqli_query($link, 'SELECT id, CONCAT(rut_sin_dv, \'-\',dv) as rut, CONCAT(nombre_cliente, \' \', apellido_paterno, \' \', apellido_materno) as nombre , telefono, correo FROM clientes where  id='.$busqueda.' ORDER BY apellido_paterno ASC, apellido_materno ASC;');
        While($row=mysqli_fetch_object($resultado))
            {
                $rut=$row->rut;
                $id=$row->id;
                $nombre=$row->nombre;
                $telefono=$row->telefono;
                $correo=$row->correo;
                $num_cliente=$num_cliente+1;
                $rutsindv=estandariza_info(substr(str_replace("-", "", $rut), 0, strlen(substr(str_replace("-", "", $rut)))-1));
                $tabla_clientes=$tabla_clientes.'<tr><td>'.$num_cliente.'</td><td><input type="checkbox" id="'.$id.'" name="check_cliente" checked disabled></td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td></tr>'."<br>";        
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
                    $tabla_poliza=$tabla_poliza.'<tr><td>'.$num_poliza.'</td><td><input type="checkbox" id="'.$id.'" name="check_poliza"></td><td>'.$poliza.'</td><td>'.$compania.'</td><td>'.$cobertura.'</td><td>'.$vigencia_final.'</td><td>'.$materia_asegurada.'</td><td>'.$patente_ubicacion.'</td></tr>'."<br>";        
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
                    $tabla_poliza=$tabla_poliza.'<tr><td>'.$num_poliza.'</td><td><input type="checkbox" id="'.$id.'" name="check_poliza" checked disabled></td><td>'.$poliza.'</td><td>'.$compania.'</td><td>'.$cobertura.'</td><td>'.$vigencia_final.'</td><td>'.$materia_asegurada.'</td><td>'.$patente_ubicacion.'</td></tr>'."<br>";        
                }     
        //cliente
        $resultado=mysqli_query($link, 'SELECT id, CONCAT(rut_sin_dv, \'-\',dv) as rut, CONCAT(nombre_cliente, \' \', apellido_paterno, \' \', apellido_materno) as nombre , telefono, correo FROM clientes where  rut_sin_dv in ('.$rut_proponente.' , '.$rut_asegurado.') ORDER BY apellido_paterno ASC, apellido_materno ASC;');
        While($row=mysqli_fetch_object($resultado))
            {
                $rut=$row->rut;
                $id=$row->id;
                $nombre=$row->nombre;
                $telefono=$row->telefono;
                $correo=$row->correo;
                $num_cliente=$num_cliente+1;
                $rutsindv=estandariza_info(substr(str_replace("-", "", $rut), 0, strlen(substr(str_replace("-", "", $rut)))-1));
                $tabla_clientes=$tabla_clientes.'<tr><td>'.$num_cliente.'</td><td><input type="checkbox" id="'.$id.'" name="check_cliente"></td><td>'.$rut.'</td><td>'.$nombre.'</td><td>'.$telefono.'</td><td>'.$correo.'</td></tr>'."<br>";        
            }       
        mysqli_close($link);
    } 


}
else {    
echo '<style>.info_clientes { display:none;}</style>';
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creación Actividades</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</head>

<body>
    <div id="header">
        <?php include 'header2.php' ?>
    </div>
    <div class="container">
        <p> Actividad / Creación <br>
        </p>
        <h5 class="form-row" >&nbsp;Datos Actividad</h5>
        <br style="<?php if ($_SERVER["REQUEST_METHOD"] <> "POST") { echo 'display:none;'; } ?>"> 

        <label style="<?php if ($_SERVER["REQUEST_METHOD"] <> "POST") { echo 'display:none;'; } ?>"> Datos Cliente Asociado <em>(Opcional)</em></label><br>
        <!--
            <div class="form-row">
                <div class="col-md-8 mb-3 col-lg-3">
                    <div class="form-row col-lg-12">
                        <label for="RUT">RUT</label>
                        <input type="text" class="form-control" id="rut" name="rut" placeholder="1111111-1">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="Nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ApellidoP">Apellido Paterno</label>
                        <input type="text" class="form-control" name="apellidop">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ApellidoM">Apellido Materno</label>
                        <input type="text" class="form-control" name="apellidom">
                    </div>
                </div>
            </div>
            -->
        <div class="form-row" style="<?php if ($_SERVER["REQUEST_METHOD"] <> "POST") { echo 'display:none;'; } ?>">
            <table name="tabla_clientes" id="info_clientes" class="table table-striped">
                <tr>
                    <thead>
                        <th>#</th>
                        <th>Seleccionar cliente</th>
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

        <br style="<?php if ($_SERVER["REQUEST_METHOD"] <> "POST") { echo 'display:none;'; } ?>">
        <label style="<?php if ($_SERVER["REQUEST_METHOD"] <> "POST") { echo 'display:none;'; } ?>"> Datos Póliza Asociada <em>(Opcional)</em></label>
        <br style="<?php if ($_SERVER["REQUEST_METHOD"] <> "POST") { echo 'display:none;'; } ?>">
        <!--
            <div Class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="poliza">Número de Poliza</label>
                    <input type="text" class="form-control" name="poliza">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="poliza">Compañía</label>
                    <input type="text" class="form-control" name="compania">
                </div>
            </div>
            -->
        <div class="form-row" style="<?php if ($_SERVER["REQUEST_METHOD"] <> "POST") { echo 'display:none;'; } ?>">
            <table name="tabla_polizas" class="table table-striped">
                <tr>
                    <thead>
                        <th>#</th>
                        <th>Seleccionar póliza</th>
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
        <br>
        <label style="<?php if ($_SERVER["REQUEST_METHOD"] <> "POST") { echo 'display:none;'; } ?>"> Datos Actividad</label>
        <!-- -->
        <div class="form-row">
            <div class="col-md-2 mb-3">
                <label for="sel1">Prioridad:&nbsp;</label>
                <select class="form-control" name="prioridad" id="prioridad">
                    <option style="color:darkred" value="0.- Urgente">Urgente</option>
                    <option style="color:red" value="1.- Alto" selected>Alto</option>
                    <option style="color:orange" value="2.- Medio">Medio</option>
                    <option style="color:darkgreen" value="3.- Bajo">Bajo</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="Nombre">Fecha de Vencimiento</label>
                <div class="md-form">
                    <input placeholder="Selected date" type="date" id="fechavencimiento" name="fechavencimiento"
                        class="form-control" required>
                </div>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
        </div>

        <div class="form-row">
            <div class="col">
                <label for="poliza">Tarea a Realizar</label>
                <textarea class="form-control" name="tarea" id="tarea" rows="3"></textarea>
            </div>

        </div>
        <br>

        <button class="btn" type="button" onclick="post()"
            style="background-color: #536656; color: white">Registrar</button>

        <br>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="/assets/js/jquery.redirect.js"></script>
    <script src="/assets/js/validarRUT.js"></script>
    <script src="/assets/js/bootstrap-notify.js"></script>
    <script src="/assets/js/bootstrap-notify.min.js"></script>
</body>

</html>
<script>
function post() {
    //console.log("prioridad : "+document.getElementById('prioridad').value);
    //console.log("fechavencimiento : "+document.getElementById('fechavencimiento').value);
    //console.log("tarea : "+document.getElementById('tarea').value);
    var arreglo = '[';
    var num = 0;
    var coma = '';
    var clientes = document.getElementsByName('check_cliente');
    for (var i = 0; i < clientes.length; i++) {
        if (clientes[i].type == 'checkbox' && clientes[i].checked == true)

            arreglo += coma + ' {"id":"' + clientes[i].getAttribute('id') + '","base":"clientes"}';
        if (num == 0) {
            num = 1;
            coma = ',';
        }
    }
    var polizas = document.getElementsByName('check_poliza');
    for (var j = 0; j < polizas.length; j++) {
        if (polizas[j].type == 'checkbox' && polizas[j].checked == true)
            arreglo += coma + ' {"id":"' + polizas[j].getAttribute('id') + '","base":"polizas"}';
        if (num == 0) {
            num = 1;
            coma = ',';
        }
    }
    arreglo += ']';
    $.redirect('/bamboo/backend/actividades/crea_tarea.php', {
        'prioridad': document.getElementById('prioridad').value,
        'fechavencimiento': document.getElementById('fechavencimiento').value,
        'tarea': document.getElementById('tarea').value,
        'relaciones': arreglo
    }, 'post');
}
</script>