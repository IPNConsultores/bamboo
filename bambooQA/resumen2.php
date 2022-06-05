<?php
if (!isset($_SESSION))
{
    session_start();
}
//$_POST["busqueda"]='test poliza 14 may 1346';
//$_POST["id"]='Endoso 6';
//$_POST["base"]='endoso';
//$_SERVER["REQUEST_METHOD"]="POST";

require_once "/home/gestio10/public_html/backend/config.php";
require_once "/home/gestio10/public_html/bambooQA/backend/funciones.php";
mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_QA');
$buscar = $base = $id = $nombre_base = '';
$id_clientes = $id_polizas = $endosos = $propuestas =$propuestas_endosos= 'busqueda dummy';
$num = 0;
$busqueda = $busqueda_err = $data = $query= $resultado_poliza= '';
$rut = $nombre = $telefono = $correo = $lista = '';
//$query = "SELECT a.id as id_poliza, b.id as idP, c.id as idA FROM polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join clientes as c on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null where a.id=".$id;
//$resultado_poliza=mysqli_query($link, $query);
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["busqueda"]) == true and isset($_POST["id"]) !== true)
{
    $buscar = eliminar_acentos(estandariza_info($_POST["busqueda"]));
    $base = "header";
}
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["busqueda"]) !== true and isset($_POST["id"]) == true)
{
    $id = estandariza_info($_POST["id"]);
    $base = estandariza_info($_POST["base"]);

    switch ($base)
    {
        case 'poliza':
            $query = "select distinct a.numero_poliza, a.id as id_poliza, b.id as idP, d.id as idA from polizas_2 as a left join clientes as b on a.rut_proponente=b.rut_sin_dv left join items as c on a.numero_poliza=c.numero_poliza left join clientes as d on c.rut_asegurado= d.rut_sin_dv where a.id=" . $id;
            $resultado_poliza = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_poliza))
            {
                if ($row->idA == $row->idP)
                {
                    $id_clientes = "^" . $row->idA . "$";
                }
                else
                {
                    $id_clientes = "^" . $row->idA . "$" . "|" . "^" . $row->idP . "$";
                }
                $nombre_base = $row->numero_poliza;
            }

            $query = "select distinct b.numero_propuesta from polizas_2 as a left join propuesta_polizas as b on a.numero_propuesta=b.numero_propuesta where a.id=" . $id;
            $resultado_poliza = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_poliza))
            {   if($row->numero_propuesta!==null){
                $propuestas = $row->numero_propuesta;}
            }
            $query = "select numero_endoso from endosos where id_poliza=" . $id;
            $resultado_poliza = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_poliza))
            {   if($row->numero_endoso!==null){
                $endoso = $row->numero_endoso;}
            }
            
        break;
        case 'propuesta':
            $query = "select distinct a.numero_propuesta, b.id as idP, d.id as idA from propuesta_polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv left join items as c on a.numero_propuesta=c.numero_propuesta left join clientes as d on c.rut_asegurado= d.rut_sin_dv where a.numero_propuesta='" . $id . "';";

            $resultado_poliza = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_poliza))
            {
                if ($row->idA == $row->idP)
                {
                    $id_clientes = "^" . $row->idA . "$";
                }
                else
                {
                    $id_clientes = "^" . $row->idA . "$" . "|" . "^" . $row->idP . "$";
                }
                $nombre_base = $row->numero_propuesta;
            }

            $query = "select distinct b.id as id_poliza from propuesta_polizas as a left join polizas_2 as b on a.numero_propuesta=b.numero_propuesta where a.numero_propuesta='" . $id . "';";
            $resultado_poliza = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_poliza))
            {   if($row->id_poliza!==null){
                    $id_polizas = $row->id_poliza;
                }
            }
        break;
        case 'cliente':
            $query = "SELECT nombre_cliente FROM clientes where id=" . $id;
            $resultado_poliza = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_poliza))
            {
                $nombre_base = $row->nombre_cliente;
            }
            $propuestas=$nombre_base;
            $id_polizas=$nombre_base;
            /* funciona para 0 y 1 póliza. cuando hay más de 1 se debe armar array
            $query = "select distinct a.numero_poliza, a.id as id_poliza, b.id as idP, d.id as idA from polizas_2 as a left join clientes as b on a.rut_proponente=b.rut_sin_dv left join items as c on a.numero_poliza=c.numero_poliza left join clientes as d on c.rut_asegurado= d.rut_sin_dv where d.id=" . $id;
            $resultado_poliza = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_poliza))
            {   if($row->id_poliza!==null){
                $endoso = $row->id_poliza;}
            }
            */
        break;
        case 'tarea':
            $nombre_base = $id;
            $query = "SELECT id_relacion FROM tareas_relaciones  where base='clientes' and id_tarea=" . $id;
            $resultado_poliza = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_poliza))
            {
                if ($id_clientes == 'busqueda dummy')
                {
                    $id_clientes = '';
                }
                $id_clientes = $id_clientes . "^" . $row->id_relacion . "$ | ";
            }
            $query2 = "SELECT id_relacion FROM tareas_relaciones  where base='polizas' and id_tarea=" . $id;
            $resultado_poliza2 = mysqli_query($link, $query2);
            while ($row = mysqli_fetch_object($resultado_poliza2))
            {
                if ($id_polizas == 'busqueda dummy')
                {
                    $id_polizas = '';
                }
                $id_polizas = $id_polizas . "^" . $row->id_relacion . "$ | ";
            }
        break;
        case 'tarea recurrente':
            $nombre_base = $id;
            $query = "SELECT id_relacion FROM tareas_relaciones  where base='clientes' and id_tarea_recurrente=" . $id;
            $resultado_poliza = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_poliza))
            {
                if ($id_clientes == 'busqueda dummy')
                {
                    $id_clientes = '';
                }
                $id_clientes = $id_clientes . "^" . $row->id_relacion . "$ | ";
            }
            $query2 = "SELECT id_relacion FROM tareas_relaciones  where base='polizas' and id_tarea_recurrente=" . $id;
            $resultado_poliza2 = mysqli_query($link, $query2);
            while ($row = mysqli_fetch_object($resultado_poliza2))
            {
                if ($id_polizas == 'busqueda dummy')
                {
                    $id_polizas = '';
                }
                $id_polizas = $id_polizas . "^" . $row->id_relacion . "$ | ";
            }
            break;
        case 'endoso':
            $query = "select id_poliza, numero_endoso, numero_propuesta_endoso, numero_poliza, nombre_proponente from endosos where numero_endoso='" . $id."'";
            $resultado_endoso = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_endoso))
            {   
                if($row->id_poliza!==null)
                {
                    $id_polizas = $row->numero_poliza;
                    $nombre_base=$row->numero_endoso;
                    $propuestas_endosos=$row->numero_propuesta_endoso;
                    $id_clientes=$row->nombre_proponente;
                }
            }
            break;
        case 'propuesta_endoso':
            $query = "select a.id_poliza, a.numero_propuesta_endoso, a.numero_poliza, a.nombre_proponente, b.numero_endoso from propuesta_endosos as a left join endosos as b on a.numero_propuesta_endoso=b.numero_propuesta_endoso where a.numero_propuesta_endoso='" . $id."'";
            $resultado_endoso = mysqli_query($link, $query);
            while ($row = mysqli_fetch_object($resultado_endoso))
            {   
                if($row->id_poliza!==null)
                {
                    $id_polizas = $row->numero_poliza;
                    if($row->numero_endoso!==null)
                    {
                        $endosos=$row->numero_endoso;
                    }
                    $nombre_base=$row->numero_propuesta_endoso;
                    $id_clientes=$row->nombre_proponente;
                }
            }
            break;
    }

}
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/bambooQA/images/bamboo.png">
    <!-- Bootstrap -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/assets/css/datatables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
<script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>


<body>
    <!-- body code goes here -->

    <?php include 'header2.php' ?>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <div class="container">

        <p id="titulo"> Resumen / Búsqueda:</p> <br>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="clientes" data-toggle="tab" href="#nav-cliente" role="tab" aria-controls="nav-cliente" aria-selected="true" style="color: white;background-color:#536656;border-color:#dee2e6" onclick="cambiacolor(this.id)">Cliente</a>
                <a class="nav-item nav-link" id="poliza" data-toggle="tab" href="#nav-poliza" role="tab" aria-controls="nav-poliza" aria-selected="false" style="color: grey;border-color:#dee2e6" onclick="cambiacolor(this.id)">Póliza</a>
                <a class="nav-item nav-link" id="endosos" data-toggle="tab" href="#nav-endosos" role="tab" aria-controls="nav-endosos" aria-selected="false" style="color: grey;border-color:#dee2e6" onclick="cambiacolor(this.id)">Endosos</a>
                <a class="nav-item nav-link" id="tarea" data-toggle="tab" href="#nav-tarea" role="tab" aria-controls="nav-tarea" aria-selected="false" style="color: grey;border-color:#dee2e6" onclick="cambiacolor(this.id)">Tarea</a>
                <a class="nav-item nav-link" id="tarea_rec" data-toggle="tab" href="#nav-tarea_rec" role="tab" aria-controls="nav-tarea_rec" aria-selected="false" style="color: grey;border-color:#dee2e6" onclick="cambiacolor(this.id)">Tarea Recurrente</a>
                <a class="nav-item nav-link" id="propuestas" data-toggle="tab" href="#nav-propuestas" role="tab" aria-controls="nav-propuestas" aria-selected="false" style="color: grey;border-color:#dee2e6" onclick="cambiacolor(this.id)">Propuestas póliza</a>
                <a class="nav-item nav-link" id="propuestas_endosos" data-toggle="tab" href="#nav-propuestas_endosos" role="tab" aria-controls="nav-propuestas_endosos" aria-selected="false" style="color: grey;border-color:#dee2e6" onclick="cambiacolor(this.id)">Propuestas endosos</a>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-cliente" role="tabpanel" aria-labelledby="nav-cliente-tab">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <br>
                        <table id="listado_clientes" width="100%" class="table table-striped">
                            <tr>
                                <thead>
                                    <th></th>
                                    <th>Rut</th>
                                    <th>Nombre</th>
                                    <th>Referido por</th>
                                    <th>Grupo</th>
                                    <th>Teléfono</th>
                                    <th>e-mail</th>
                                    <th>Dirección Privada</th>
                                    <th>Dirección Laboral</th>
                                    <th>id</th>
                                    <th>apellidop</th>
                                </thead>
                            </tr>
                        </table>
                        <div id="botones"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-poliza" role="tabpanel" aria-labelledby="nav-poliza-tab">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <br>
                        <div class="container">
                            <table class="display" style="width:100%" id="listado_polizas">
                                <tr>
                                    <th></th>
                                    <th>Estado</th>
                                    <th>N° Póliza</th>
                                    <th>Inicio Vigencia</th>
                                    <th>Fin Vigencia</th>
                                    <th>Compañia</th>
                                    <th>Ramo</th>
                                    <th>Añomes final</th>
                                    <th>Añomes inicial</th>
                                    <th>Proponente</th>
                                    <th>Rut Proponente</th>
                                    <th>grupo</th>
                                    <th>referido</th>
                                    <th>id</th>
                                </tr>

                            </table>
                            <div id="botones_poliza"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-tarea" role="tabpanel" aria-labelledby="nav-tarea-tab">
                    <div class="card">
                        <div class="card-body">
                            <br>
                            <br>
                            <table class="table" id="listado_tareas" style="width:100%">
                                <tr>
                                    <th></th>
                                    <th>id</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <th>Tarea</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </table>
                            <div id="botones_tareas"></div>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade" id="nav-tarea_rec" role="tabpanel" aria-labelledby="nav-tarea_rec-tab">
                    <div class="card">
                        <div class="card-body">
                            <br>
                            <br>
                            <table class="table" id="listado_tareas_recurrentes" style="width:100%">
                            <tr>
                                <th></th>
                                <th>id</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Tarea</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </table>
                            <div id="botones_tareas_recurrentes"></div>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade" id="nav-propuestas" role="tabpanel" aria-labelledby="nav-propuestas-tab">
                    <div class="card">
                        <div class="card-body">
                            <br>
                            <br>
                            <table class="table" style="width:100%" id="listado_propuesta_polizas">
                                <tr>
                                    <th></th>
                                    <th>Estado</th>
                                    <th>Tipo propuesta</th>
                                    <th>Fecha Envío Propuesta</th>
                                    <th>Inicio Vigencia</th>
                                    <th>Fin Vigencia</th>
                                    <th>Compañia</th>
                                    <th>Ramo</th>
                                    <th>Añomes final</th>
                                    <th>Añomes inicial</th>
                                    <th>Moneda póliza</th>
                                    <th>Proponente</th>
                                    <th>Rut Proponente</th>
                                    <th>grupo</th>
                                    <th>referido</th>
                                    <th>id</th>

                                </tr>

                            </table>
                            <div id="botones_tareas_recurrentes"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-endosos" role="tabpanel" aria-labelledby="nav-endosos-tab">
                    <div class="card">
                        <div class="card-body">
                            <br>
                            <br>
                            <table class="display" style="width:100%" id="listado_endosos">
                                <tr>
                                    <th></th>
                                    <th>Número Endoso</th>
                                    <th>Nro Propuesta Endoso</th>
                                    <th>Tipo Endoso</th>
                                    <th>Nro Póliza</th>
                                    <th>Fecha ingreso</th>
                                    <th>Inicio Vigencia</th>
                                    <th>Fin Vigencia</th>
                                    
                                </tr>
                
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-propuestas_endosos" role="tabpanel" aria-labelledby="nav-propuestas_endosos-tab">
                    <div class="card">
                        <div class="card-body">
                            <br>
                            <br>
                            <table class="display" style="width:100%" id="listado_propuesta_endosos">
                                <tr>
                                    <th></th>
                                    <th>Número Endoso</th>
                                    <th>Nro Propuesta Endoso</th>
                                    <th>Tipo Endoso</th>
                                    <th>Nro Póliza</th>
                                    <th>Fecha ingreso</th>
                                    <th>Inicio Vigencia</th>
                                    <th>Fin Vigencia</th>
                                </tr>
                
                            </table>
                        </div>
                    </div>
                </div>
            <div>
                <br>
            </div>
            <!--<div id="auxiliar" style="display: none;">-->
            <div id="auxiliar" style="display: none;">
                <input id="var1" value="<?php echo htmlspecialchars($buscar);?>">
                <input id="aux_id" value="<?php echo htmlspecialchars("^".$id."$");?>">
                <input id="aux_base" value="<?php echo htmlspecialchars($base);?>">
                <input id="var2_cliente" value="<?php echo htmlspecialchars($id_clientes);?>">
                <input id="var3_poliza" value="<?php echo htmlspecialchars($id_polizas);?>">
                <input id="var4_titulo" value="<?php echo $nombre_base;?>">
                <input id="var5_propuesta" value="<?php echo htmlspecialchars($propuestas);?>">
                <input id="var6_endoso" value="<?php echo htmlspecialchars($endosos);?>">
                <input id="var7_propuesta_endoso" value="<?php echo htmlspecialchars($propuestas_endosos);?>">
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="/assets/js/jquery.redirect.js"></script>
        <script src="/assets/js/bootstrap-notify.js"></script>
        <script src="/assets/js/bootstrap-notify.min.js"></script>
        <script src="/assets/js/datatables.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

<script>
function cambiacolor(id) {

    document.getElementById("clientes").style.backgroundColor = "white"
    document.getElementById("clientes").style.color = "grey"
    document.getElementById("clientes").style.borderColor = "#dee2e6"
    document.getElementById("poliza").style.backgroundColor = "white"
    document.getElementById("poliza").style.color = "grey"
    document.getElementById("poliza").style.borderColor = "#dee2e6"
    document.getElementById("tarea").style.backgroundColor = "white"
    document.getElementById("tarea").style.color = "grey"
    document.getElementById("tarea").style.borderColor = "#dee2e6"
    document.getElementById("tarea_rec").style.backgroundColor = "white"
    document.getElementById("tarea_rec").style.color = "grey"
    document.getElementById("tarea_rec").style.borderColor = "#dee2e6"
    document.getElementById("propuestas").style.backgroundColor = "white"
    document.getElementById("propuestas").style.color = "grey"
    document.getElementById("propuestas").style.borderColor = "#dee2e6"
    document.getElementById("endosos").style.backgroundColor = "white"
    document.getElementById("endosos").style.color = "grey"
    document.getElementById("endosos").style.borderColor = "#dee2e6"
    document.getElementById("propuestas_endosos").style.backgroundColor = "white"
    document.getElementById("propuestas_endosos").style.color = "grey"
    document.getElementById("propuestas_endosos").style.borderColor = "#dee2e6"
    
    document.getElementById(id).style.backgroundColor = "#536656"
    document.getElementById(id).style.color = "white"
}

$(document).ready(function() {
    var table = $('#listado_clientes').DataTable({

        "ajax": "/bambooQA/backend/clientes/busqueda_listado_clientes.php",
        
        "initComplete": function(settings, json) {
            document.getElementById("clientes").innerHTML = "Clientes (" + $('#listado_clientes')
                .DataTable().page.info().recordsDisplay + ")";
        },
        "columns": [{
                "className": 'details-control',

                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            },
            {
                "data": "rut"
            },
            {
                "data": "nombre"
            },
            {
                "data": "referido"
            },
            {
                "data": "grupo"
            },
            {
                "data": "telefono"
            },
            {
                "data": "correo_electronico"
            },
            {
                "data": "direccionp"
            },
            {
                "data": "direccionl"
            },
            {
                "data": "id"
            },
            {
                "data": "apellidop"
            }

        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "columnDefs": [{
                "targets": [6, 7, 8, 9, 10],
                "visible": false,
            },
            {
                "targets": [6, 7, 8, 10],
                "searchable": false
            }
        ],
        "order": [
            [10, "asc"]
        ],
        "oLanguage": {
            "sSearch": "Búsqueda rápida",
            "sLengthMenu": 'Mostrar <select>' +
                '<option value="10">10</option>' +
                '<option value="25">30</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">todos</option>' +
                '</select> registros',
            "sInfoFiltered": "(Resultado búsqueda: _TOTAL_ de _MAX_ registros totales)",
            "sLengthMenu": "Muestra _MENU_ registros por página",
            "sZeroRecords": "Se están cargando los registros. Espera unos segundos más.",
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sInfoEmpty": "No hay registros disponibles",
            "oPaginate": {
                "sNext": "Siguiente",
                "sPrevious": "Anterior",
                "sLast": "Última"
            }
        }
    });
    $("#listado_clientes_filter input")
        .off()
        .on('keyup change', function(e) {
            if (e.keyCode !== 13 || this.value == "") {
                var texto1 = this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                table.search(texto1).draw();
            }
        });
    $('#listado_clientes tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
    $('#listado_clientes').dataTable().fnFilter(document.getElementById("var1").value);

    //fin clientes        
    //inicio pólizas

    var table_polizas = $('#listado_polizas').DataTable({
        "ajax": "/bambooQA/backend/polizas/busqueda_listado_polizas.php",
        "initComplete": function(settings, json) {
            document.getElementById("poliza").innerHTML = "Pólizas (" + $('#listado_polizas')
                .DataTable().page.info().recordsDisplay + ")";
        },
        "searchPanes": {
            "columns": [2],
        },
        "dom": 'Pfrtip',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            }, //0
            {
                "data": "estado",
                title: "Estado"
            }, //1
            {
                data: "numero_poliza",
                title: "Nro Póliza",
            }, //2
            {
                "data": "vigencia_inicial",
                title: "Vigencia Inicio"
            }, //3
            {
                "data": "vigencia_final",
                title: "Vigencia Término"
            }, //4
            {
                "data": "compania",
                title: "Compañia"
            }, //5
            {
                "data": "ramo",
                title: "Ramo"
            }, //6
            {
                "data": "anomes_final",
                title: "Añomes final"
            }, //7
            {
                "data": "anomes_inicial",
                title: "Añomes inicial"
            }, //8

            {
                "data": "nom_clienteP",
                title: "Proponente"
            }, //9
            {
                "data": "rut_clienteP",
                title: "Rut Proponente"
            }, //10
            {
                "data": "grupo",
                title: "Grupo"
            }, //11
            {
                "data": "referido",
                title: "Referido"
            }, // 12
            {
                "data":"id_poliza",
                tittle:"ID"
            }//13
        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "columnDefs": [{
                "targets": [7, 8,13],
                "visible": false,
            },
            {
                targets: 1,
                render: function(data, type, row, meta) {
                    var estado = '';
                    switch (data) {
                        case 'Activo':
                            estado = '<span class="badge badge-primary">' + data + '</span>';
                            break;
                        case 'Renovado':
                            estado = '<span class="badge badge-warning">' + data + '</span>';
                            break;
                        case 'Vencido':
                            estado = '<span class="badge badge-danger">' + data + '</span>';
                            break;
                        case 'Cancelado':
                            estado = '<span class="badge badge-dark">' + data + '</span>';
                            break;
                        default:
                            estado = '<span class="badge badge-light">' + data + '</span>';
                            break;
                    }
                    return estado; //render link in cell
                }
            },
            {
                targets: [3, 4],
                render: function(data, type, full) {
                    if (data == null || data == "0000-00-00") {
                        return '';
                    } else {
                        return moment(data).format('YYYY/MM/DD');
                    }
                }
            }
        ],
        "order": [
            [1, "asc"],
            [3, "desc"]
        ],
        "oLanguage": {
            "sSearch": "Búsqueda rápida",
            "sLengthMenu": 'Mostrar <select>' +
                '<option value="10">10</option>' +
                '<option value="25">30</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">todos</option>' +
                '</select> registros',
            "sInfoFiltered": "(Resultado búsqueda: _TOTAL_ de _MAX_ registros totales)",
            "sLengthMenu": "Muestra _MENU_ registros por página",
            "sZeroRecords": "Se están cargando los registros. Espera unos segundos más.",
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sInfoEmpty": "No hay registros disponibles",
            "oPaginate": {
                "sNext": "Siguiente",
                "sPrevious": "Anterior",
                "sLast": "Última"
            }
        },
        "language": {
            "searchPanes": {
                "title": {
                    _: 'Filtros seleccionados - %d',
                    0: 'Sin Filtros Seleccionados',
                    1: '1 Filtro Seleccionado',
                }
            }
        }
    });
    $("#listado_polizas_filter input")
        .off()
        .on('keyup change', function(e) {
            if (e.keyCode !== 13 || this.value == "") {
                var texto1 = this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                table_polizas.search(texto1)
                    .draw();
            }

        });
    $('#listado_polizas tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_polizas.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format_poliza(row.data())).show();
            tr.addClass('shown');
        }
    });
    $('#listado_polizas').dataTable().fnFilter(document.getElementById("var1").value);




    //fin pólizas

    // inicio tareas
    var table_tareas = $('#listado_tareas').DataTable({

        "ajax": "/bambooQA/backend/actividades/busqueda_listado_tareas_completas.php",
        "initComplete": function(settings, json) {
            document.getElementById("tarea").innerHTML = "Tareas (" + $('#listado_tareas')
                .DataTable().page.info().recordsDisplay + ")";
        },
        "columns": [{
                "className": 'details-control',
                "orderable": false,

                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            },
            {
                "data": "id_tarea",
                title: "Tarea"
            },
            {
                "data": "prioridad",
                title: "Prioridad"
            },
            {
                "data": "estado",
                title: "Estado"
            },
            {
                "data": "tarea",
                title: "Tarea o Actividad"
            },
            {
                "data": "fecvencimiento",
                title: "Fecha vencimiento"
            },
            {
                "data": "fecingreso",
                title: "Fecha creación tarea"
            },
            {
                "data": "procedimiento",
                title: "Procedimiento"
            },
            {
                "data": "feccierre",
                title: "Fecha cierre"
            },
            {
                "data": "nombre[]",
                title: "Clientes asociados"
            },
            {
                "data": "numero_poliza[]",
                title: "Pólizas asociados"
            },
            {
                "data": "id_proponente[]",
                title: "id proponente"
            },
            {
                "data": "id_asegurado[]",
                title: "id asegurado"
            },
            {
                "data": "id_poliza[]",
                title: "id poliza"
            },
            {
                data: null,
                title: "AllID",
                render: function(data, type, row) {
                    return '_' + data.id_proponente + '_ , _' + data.id_asegurado + '_';
                }
            }

        ],
        //          "search": {
        //          "search": "abarca"
        //          },

        "columnDefs": [{
                "targets": [6, 8, 11, 12, 13, 14],
                "visible": false,
            },
            {
                targets: 3,
                render: function(data, type, row, meta) {
                    var estado = '';
                    switch (data) {
                        case 'Activo':
                            estado = '<span class="badge badge-warning">' + data + '</span>';
                            break;
                        case 'Completado':
                            estado = '<span class="badge badge-dark">' + data + '</span>';
                            break;
                        case 'Atrasado':
                            estado = '<span class="badge badge-danger">' + data + '</span>';
                            break;
                        default:
                            estado = '<span class="badge badge-light">' + data + '</span>';
                            break;
                    }
                    return estado; //render link in cell
                }
            },
            {
                targets: [5, 6, 8],
                render: function(data, type, full) {
                    if (type == 'display')
                        return moment(data).format('DD/MM/YYYY');
                    else
                        return moment(data).format('YYYY/MM/DD');
                }
            }
        ],
        "order": [
            [2, "asc"],
            [5, "asc"]
        ],
        "oLanguage": {
            "sSearch": "Búsqueda rápida",
            "sLengthMenu": 'Mostrar <select>' +
                '<option value="10">10</option>' +
                '<option value="25">30</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">todos</option>' +
                '</select> registros',
            "sInfoFiltered": "(Resultado búsqueda: _TOTAL_ de _MAX_ registros totales)",
            "sLengthMenu": "Muestra _MENU_ registros por página",
            "sZeroRecords": "Se están cargando los registros. Espera unos segundos más.",
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sInfoEmpty": "No hay registros disponibles",
            "oPaginate": {
                "sNext": "Siguiente",
                "sPrevious": "Anterior",
                "sLast": "Última"
            }
        }
    });
    $("#listado_tareas_filter input")
        .off()
        .on('keyup change', function(e) {
            if (e.keyCode !== 13 || this.value == "") {
                var texto2 = this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                table_tareas.search(texto2).draw();
            }
        });
    $('#listado_tareas tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_tareas.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detalle_tareas(row.data())).show();
            tr.addClass('shown');
        }
    });
    $('#listado_tareas').dataTable().fnFilter(document.getElementById("var1").value);

    //fin tareas
    // inicio tareas_recurrentes
    var table_tareas_recurrentes = $('#listado_tareas_recurrentes').DataTable({

        "ajax": "/bambooQA/backend/actividades/busqueda_listado_tareas_recurrentes.php",
        
        "initComplete": function(settings, json) {
            document.getElementById("tarea_rec").innerHTML = "Tareas recurrentes (" + $(
                '#listado_tareas_recurrentes').DataTable().page.info().recordsDisplay + ")";
        },
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            }, //1
            {
                "data": "id_tarea",
                title: "Tarea"
            }, //2
            {
                "data": "prioridad",
                title: "Prioridad"
            }, //3
            {
                "data": "estado",
                title: "Estado"
            }, //4
            {
                "data": "tarea",
                title: "Tarea o Actividad"
            }, //5
            {
                "data": "fecingreso",
                title: "Fecha creación tarea"
            }, //6
            {
                "data":"dia_recordatorio",
                title: "Día recordatorio"
            }, //7
            {
                "data":"nombre[]",
                title: "Clientes asociados"
            }, //8
            {
                "data":"numero_poliza[]",
                title: "Pólizas asociadas"
            }, //9
            {
                "data":"numero_propuesta[]",
                title: "Propuestas asociadas"
            } //10
        ],
        "columnDefs": [{
                "targets": [7,8,9],
                "visible": false,
            },
            {
                targets: 3,
                render: function(data, type, row, meta) {
                    var estado = '';
                    switch (data) {
                        case 'Activo':
                            estado = '<span class="badge badge-warning">' + data + '</span>';
                            break;
                        case 'Completado':
                            estado = '<span class="badge badge-dark">' + data + '</span>';
                            break;
                        case 'Atrasado':
                            estado = '<span class="badge badge-danger">' + data + '</span>';
                            break;
                        default:
                            estado = '<span class="badge badge-light">' + data + '</span>';
                            break;
                    }
                    return estado; //render link in cell
                }
            }
        ],
        "order": [
            [2, "asc"],
            [5, "asc"]
        ],
        "oLanguage": {
            "sSearch": "Búsqueda rápida",
            "sLengthMenu": 'Mostrar <select>' +
                '<option value="10">10</option>' +
                '<option value="25">30</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">todos</option>' +
                '</select> registros',
            "sInfoFiltered": "(Resultado búsqueda: _TOTAL_ de _MAX_ registros totales)",
            "sLengthMenu": "Muestra _MENU_ registros por página",
            "sZeroRecords": "Se están cargando los registros. Espera unos segundos más.",
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sInfoEmpty": "No hay registros disponibles",
            "oPaginate": {
                "sNext": "Siguiente",
                "sPrevious": "Anterior",
                "sLast": "Última"
            }
        }
    });
    $("#listado_tareas_recurrentes_filter input")
        .off()
        .on('keyup change', function(e) {
            if (e.keyCode !== 13 || this.value == "") {
                var texto2 = this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                table_tareas_recurrentes.search(texto2).draw();
            }
        });
    $('#listado_tareas_recurrentes tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_tareas_recurrentes.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detalle_tareas_recurrentes(row.data())).show();
            tr.addClass('shown');
        }
    });
    $('#listado_tareas_recurrentes').dataTable().fnFilter(document.getElementById("var1").value);
    //fin tareas recurrents
    //inicio propuestas
    var table_propuesta_poliza = $('#listado_propuesta_polizas').DataTable({
        "ajax": "/bambooQA/backend/propuesta_polizas/busqueda_listado_propuesta_polizas.php",
        
        "initComplete": function(settings, json) {
            document.getElementById("propuestas").innerHTML = "Prop. Póliza (" + $(
                '#listado_propuesta_polizas').DataTable().page.info().recordsDisplay + ")";
        },
        "searchPanes": {
            "columns": [2, 3, 13, 14],
        },
        "dom": 'Pfrtip',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            }, //0
            {
                "data": "estado",
                title: "Estado"
            }, //1
            {
                data: "numero_propuesta",
                title: "Nro Propuesta",
            }, //2
            {
                "data": "fecha_envio_propuesta",
                title: "Fecha Envío Propuesta"
            }, //3
            {
                "data": "vigencia_inicial",
                title: "Vigencia Inicio"
            }, //4
            {
                "data": "vigencia_final",
                title: "Vigencia Término"
            }, //5
            {
                "data": "compania",
                title: "Compañia"
            }, //6
            {
                "data": "ramo",
                title: "Ramo"
            }, //7
            {
                "data": "anomes_final",
                title: "Añomes final"
            }, //8
            {
                "data": "anomes_inicial",
                title: "Añomes inicial"
            }, //9
            {
                "data": "moneda_poliza",
                title: "Moneda póliza"
            }, //10
            {
                "data": "nom_clienteP",
                title: "Proponente"
            }, //11
            {
                "data": "rut_clienteP",
                title: "Rut Proponente"
            }, //12
            {
                "data": "grupo",
                title: "Grupo"
            }, //13
            {
                "data": "referido",
                title: "Referido"
            }, // 14
            {
                "data": "id_propuesta",
                title: "id propuesta"
            } //15
        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "columnDefs": [{
                "targets": [8, 9, 10,15],
                "visible": false,
            },
            {
                targets: 1,
                render: function(data, type, row, meta) {
                    var estado = '';
                    switch (data) {
                        case 'Aprobado':
                            estado = '<span class="badge badge-primary">' + data + '</span>';
                            break;
                        case 'Rechazado':
                            estado = '<span class="badge badge-danger">' + data + '</span>';
                            break;
                        case 'Cancelado':
                            estado = '<span class="badge badge-dark">' + data + '</span>';
                            break;
                        default:
                            estado = '<span class="badge badge-light">' + data + '</span>';
                            break;
                    }
                    return estado; //render link in cell
                }
            },
            {
                targets: [4, 5, 3],
                render: function(data, type, full) {
                    if (data == null || data == "0000-00-00") {
                        return '';
                    } else {
                        return moment(data).format('YYYY/MM/DD');
                    }
                }
            }
        ],
        "order": [
            [1, "asc"],
            [2, "desc"]
        ],
        "oLanguage": {
            "sSearch": "Búsqueda rápida",
            "sLengthMenu": 'Mostrar <select>' +
                '<option value="10">10</option>' +
                '<option value="25">30</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">todos</option>' +
                '</select> registros',
            "sInfoFiltered": "(Resultado búsqueda: _TOTAL_ de _MAX_ registros totales)",
            "sLengthMenu": "Muestra _MENU_ registros por página",
            "sZeroRecords": "Se están cargando los registros. Espera unos segundos más.",
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sInfoEmpty": "No hay registros disponibles",
            "oPaginate": {
                "sNext": "Siguiente",
                "sPrevious": "Anterior",
                "sLast": "Última"
            }
        },
        "language": {
            "searchPanes": {
                "title": {
                    _: 'Filtros seleccionados - %d',
                    0: 'Sin Filtros Seleccionados',
                    1: '1 Filtro Seleccionado',
                }
            }
        }
    });
    $("#listado_propuesta_polizas_filter input")
        .off()
        .on('keyup change', function(e) {
            if (e.keyCode !== 13 || this.value == "") {
                var texto1 = this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                table_propuesta_poliza.search(texto1)
                    .draw();
            }

        });
    $('#listado_propuesta_polizas tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_propuesta_poliza.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format_propuesta(row.data())).show();
            tr.addClass('shown');
        }
    });
    $('#listado_propuesta_polizas').dataTable().fnFilter(document.getElementById("var1").value);
    //fin propuestas
    //inicio endosos
         var   table_endosos = $('#listado_endosos').DataTable({
        "ajax": "/bambooQA/backend/endosos/busqueda_listado_endosos.php",
        
        "initComplete": function(settings, json) {
                document.getElementById("endosos").innerHTML = "Endosos (" + $(
                    '#listado_endosos').DataTable().page.info().recordsDisplay + ")";
            },
        "dom": 'Pfrtip',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            }, //0
            {
                "data": "numero_endoso",
                title: "Número Endoso"
            }, //1
            { 
                data: "numero_propuesta_endoso", 
                title: "Nro Propuesta Endoso",
            }, //2
            {
                "data": "tipo_endoso",
                title: "Tipo Endoso"
            }, //3
            {
                "data": "numero_poliza",
                title: "Número Póliza"
            }, //4
            {
                "data": "fecha_ingreso_endoso",
                title: "Fecha ingreso"
            }, //5
            {
                "data": "vigencia_inicial",
                title: "Inicio Vigencia"
            }, //6
            {
                "data": "vigencia_final",
                title: "Fin Vigencia"
            } //7
        ],
        "columnDefs": 
        [
        {
        targets: [5,6,7],
         render: function(data, type, full)
         {
            if (data==null || data=="0000-00-00")
            {
                return '';
            }
            else
            {
                return moment(data).format('YYYY/MM/DD');
            }
         }}
        ],
        "order": [
            [1, "desc"],
            [2, "desc"]
        ],
        "oLanguage": {
            "sSearch": "Búsqueda rápida",
            "sLengthMenu": 'Mostrar <select>' +
                '<option value="10">10</option>' +
                '<option value="25">30</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">todos</option>' +
                '</select> registros',
                "sInfoFiltered": "(Resultado búsqueda: _TOTAL_ de _MAX_ registros totales)",
            "sLengthMenu": "Muestra _MENU_ registros por página",
            "sZeroRecords": "Se están cargando los registros. Espera unos segundos más.",
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sInfoEmpty": "No hay registros disponibles",
            "oPaginate": {
                "sNext": "Siguiente",
                "sPrevious": "Anterior",
                "sLast": "Última"
            }
        },
        "language": {
            "searchPanes": {
                "title":{
                    _: 'Filtros seleccionados - %d',
                    0: 'Sin Filtros Seleccionados',
                    1: '1 Filtro Seleccionado',
                }
            }
        }
    });
    $("#listado_endosos_filter input")
    .off()
    .on('keyup change', function (e) {
    if (e.keyCode !== 13 || this.value == "") {
        var texto1=this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");  
        table_endosos.search(texto1)
            .draw();
    }
        
    });
    $('#listado_endosos tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_endosos.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format_endoso(row.data())).show();
            tr.addClass('shown');
        }
    });
    $('#listado_endosos').dataTable().fnFilter(document.getElementById("var1").value);
 
    //fin endosos
    // inicio propuesta_endosos
        var table_propuestas_endosos = $('#listado_propuesta_endosos').DataTable({
        "ajax": "/bambooQA/backend/endosos/busqueda_listado_propuesta_endoso.php",
        "initComplete": function(settings, json) {
                document.getElementById("propuestas_endosos").innerHTML = "Prop. Endosos (" + $(
                    '#listado_propuesta_endosos').DataTable().page.info().recordsDisplay + ")";
            },
        
        "dom": 'Pfrtip',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            }, //0
            {
                "data": "estado",
                title: "Estado"
            }, //1
            { 
                data: "numero_propuesta_endoso", 
                title: "Nro Propuesta Endoso",
            }, //2
            {
                "data": "tipo_endoso",
                title: "Tipo Endoso"
            }, //3
            {
                "data": "numero_poliza",
                title: "Número Póliza"
            }, //4
            {
                "data": "fecha_ingreso_endoso",
                title: "Fecha ingreso"
            }, //5
            {
                "data": "vigencia_inicial",
                title: "Inicio Vigencia"
            }, //6
            {
                "data": "vigencia_final",
                title: "Fin Vigencia"
            } //7
        ],
        "columnDefs": 
        [
         {
        targets: 1,
        render: function (data, type, row, meta) {
             var estado='';
            switch (data) {
                        case 'Emitido':
                            estado='<span class="badge badge-primary">'+data+'</span>';
                            break;
                        case 'Rechazado':
                            estado='<span class="badge badge-danger">'+data+'</span>';
                            break;
                        case 'Cancelado':
                            estado='<span class="badge badge-dark">'+data+'</span>';
                            break;
                        default:
                            estado='<span class="badge badge-light">'+data+'</span>';
                            break;
                    }
          return estado;  //render link in cell
        }},
        {
        targets: [5,6,7],
         render: function(data, type, full)
         {
            if (data==null || data=="0000-00-00")
            {
                return '';
            }
            else
            {
                return moment(data).format('YYYY/MM/DD');
            }
         }}
        ],
        "order": [
            [1, "desc"],
            [2, "desc"]
        ],
        "oLanguage": {
            "sSearch": "Búsqueda rápida",
            "sLengthMenu": 'Mostrar <select>' +
                '<option value="10">10</option>' +
                '<option value="25">30</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">todos</option>' +
                '</select> registros',
                "sInfoFiltered": "(Resultado búsqueda: _TOTAL_ de _MAX_ registros totales)",
            "sLengthMenu": "Muestra _MENU_ registros por página",
            "sZeroRecords": "Se están cargando los registros. Espera unos segundos más.",
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sInfoEmpty": "No hay registros disponibles",
            "oPaginate": {
                "sNext": "Siguiente",
                "sPrevious": "Anterior",
                "sLast": "Última"
            }
        },
        "language": {
            "searchPanes": {
                "title":{
                    _: 'Filtros seleccionados - %d',
                    0: 'Sin Filtros Seleccionados',
                    1: '1 Filtro Seleccionado',
                }
            }
        }
    });
    $("#listado_propuesta_endosos_filter input")
    .off()
    .on('keyup change', function (e) {
    if (e.keyCode !== 13 || this.value == "") {
        var texto1=this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");  
        table_propuestas_endosos.search(texto1)
            .draw();
    }
        
    });
    $('#listado_propuesta_endosos tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_propuestas_endosos.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format_propuesta_endoso(row.data())).show();
            tr.addClass('shown');
        }
    });
    $('#listado_propuesta_endosos').dataTable().fnFilter(document.getElementById("var1").value);
 
    // fin propuesta endosos
    
switch (document.getElementById("aux_base").value) {
        case 'propuesta_endoso': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a Propuesta Endoso número: ".concat("<b>" + document.getElementById("var4_titulo").value + "</b>");
            document.getElementById("propuestas_endosos").click();
            
                //cliente
            table.column(2).search(document.getElementById("var2_cliente").value, true).draw();
                //poliza
    
            table_polizas.column(2).search(document.getElementById("var3_poliza").value, true).draw();
                table_propuesta_poliza.column(2).search(document.getElementById("var5_propuesta").value, true).draw();
                //tarea
                table_tareas.column(13).search(document.getElementById("aux_id").value, true).draw();
                //tarea recurrente
                table_tareas_recurrentes.column(9).search(document.getElementById("aux_id").value, true).draw();
                //endosos
                table_endosos.column(1).search(document.getElementById("var6_endoso").value, true).draw();
                table_propuestas_endosos.column(2).search(document.getElementById("var4_titulo").value, true).draw();
                break;
        }
        case 'endoso': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a Endoso número: ".concat("<b>" + document.getElementById("var4_titulo").value + "</b>");
            document.getElementById("endosos").click();
            
                //cliente
            table.column(2).search(document.getElementById("var2_cliente").value, true).draw();
                //poliza
    
            table_polizas.column(2).search(document.getElementById("var3_poliza").value, true).draw();
                table_propuesta_poliza.column(2).search(document.getElementById("var5_propuesta").value, true).draw();
                //tarea
                table_tareas.column(13).search(document.getElementById("aux_id").value, true).draw();
                //tarea recurrente
                table_tareas_recurrentes.column(9).search(document.getElementById("aux_id").value, true).draw();
                //endosos
            table_endosos.column(1).search(document.getElementById("var4_titulo").value, true).draw();
            table_propuestas_endosos.column(2).search(document.getElementById("var7_propuesta_endoso").value, true).draw();
                break;
        }
        case 'cliente': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a cliente: ".concat("<b>" + document.getElementById("var4_titulo").value + "</b>");
            document.getElementById("clientes").click();

            table.column(9).search(document.getElementById("aux_id").value, true).draw();
            table_polizas.search(document.getElementById("var3_poliza").value.replaceAll('$', '_').replaceAll('^', '_'), true).draw()
            table_propuesta_poliza.search(document.getElementById("var5_propuesta").value.replaceAll('$', '_').replaceAll('^', '_'), true).draw()
            table_tareas.search(document.getElementById("var3_poliza").value.replaceAll('$', '_').replaceAll('^', '_'), true).draw();
            table_tareas_recurrentes.search(document.getElementById("var3_poliza").value, true).draw();
            break;
        }
        case 'poliza': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a póliza número: "
                .concat("<b>" + document.getElementById("var4_titulo").value + "</b>");
            document.getElementById("poliza").click();
            //cliente
            table.column(9).search(document.getElementById("var2_cliente").value, true).draw();
            //poliza

            table_polizas.column(2).search(document.getElementById("var4_titulo").value, true).draw();
            table_propuesta_poliza.column(2).search(document.getElementById("var5_propuesta").value, true).draw();
            //tarea
            table_tareas.column(13).search(document.getElementById("aux_id").value, true).draw();
            //tarea recurrente
            table_tareas_recurrentes.column(9).search(document.getElementById("aux_id").value, true).draw();
            //endosos
            table_endosos.column(4).search(document.getElementById("var4_titulo").value, true).draw();
            table_propuestas_endosos.column(4).search(document.getElementById("var4_titulo").value, true).draw();
            break;
        }
        case 'propuesta': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a propuesta póliza número: "
                .concat("<b>" + document.getElementById("var4_titulo").value + "</b>");
            document.getElementById("propuestas").click();
            //cliente
            table.column(9).search(document.getElementById("var2_cliente").value, true).draw();
            //poliza
            table_polizas.column(13).search(document.getElementById("var3_poliza").value, true).draw();
            console.log(document.getElementById("var3_poliza").value)
            table_propuesta_poliza.column(2).search(document.getElementById("var4_titulo").value, true).draw();
            //tarea
            table_tareas.column(13).search(document.getElementById("aux_id").value, true).draw();
            //tarea recurrente
            table_tareas_recurrentes.column(9).search(document.getElementById("aux_id").value, true).draw();
                        //endosos
            table_endosos.column(4).search("busqueda", true).draw();
            table_propuestas_endosos.column(4).search("busqueda", true).draw();
            break;
        }
        case 'tarea': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a tarea número: "
                .concat("<b>" + document.getElementById("var4_titulo").value + "</b>");
            document.getElementById("tarea").click();
            //cliente
            table.column(9).search(document.getElementById("var2_cliente").value, true).draw();
            //poliza
            table_polizas.column(13).search(document.getElementById("var3_poliza").value, true).draw();
            table_propuesta_poliza.column(2).search(document.getElementById("var5_propuesta").value, true).draw();
            //tarea
            table_tareas.column(1).search(document.getElementById("aux_id").value, true).draw();
            //tarea recurrente
            table_tareas_recurrentes.column(9).search("busqueda dummy").draw();
            table_endosos.column(4).search("busqueda", true).draw();
            table_propuestas_endosos.column(4).search("busqueda", true).draw();
            break;
        }
        case 'tarea recurrente': {
            document.getElementById("titulo").innerHTML =
                " Resumen / Búsqueda asociada a tarea recurrente número: ".concat("<b>" + document
                    .getElementById("var4_titulo").value + "</b>");
            document.getElementById("tarea_rec").click();
            //cliente
            table.column(9).search(document.getElementById("var2_cliente").value, true).draw();
            //poliza
            table_polizas.column(13).search(document.getElementById("var3_poliza").value, true).draw();
            table_propuesta_poliza.column(2).search(document.getElementById("var5_propuesta").value, true).draw();
            //tarea
            table_tareas.column(1).search("busqueda dummy").draw();
            //tarea recurrente
            table_tareas_recurrentes.column(1).search(document.getElementById("aux_id").value, true).draw();
            table_endosos.column(4).search("busqueda", true).draw();
            table_propuestas_endosos.column(4).search("busqueda", true).draw();
            break;
        }
        case 'header': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a: ".concat("<b>" +
                document.getElementById("var1").value + "</b>");

            break;
        }
    }

    
});
function format_propuesta(d) {
    // `d` is the original data object for the row
    var ext_cancelado='';
    var items='';
    var listado_items='';
    var botones='';
    if (d.estado=='Pendiente'){
        botones='<td>Acciones</td>' +
        '<td>' +
        '<button title="Aprobar Propuesta" type="button" id=' + d.numero_propuesta + ' name="crear_poliza" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fa fa-thumbs-up"></i></button><a> </a>' +
        '<button title="Rechazar propuesta"  type="button" id=' + d.numero_propuesta + ' name="rechazar_propuesta" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fa fa-thumbs-down"></i></button>' +
        '<button title="Generar Propuesta" type="button" id=' + d.numero_propuesta + ' name="generar_documento" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fa fa-file-pdf-o"></i></button><a> </a>' +
        '<button title="WIP Buscar información asociada" type="button" id=' + d.numero_propuesta + ' name="info" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fas fa-search"></i></button><a> </a>' +
        '<button title="Editar Propuesta"  type="button" id=' + d.numero_propuesta + ' name="actualiza_propuesta" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fas fa-edit"></i></button><a> </a>' +
        '<button title="Asignar tarea"  type="button" id=' + d.id_propuesta +' name="tarea" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fas fa-clipboard-list"></i></button><a> </a>' +
        '<button title="WIP Generar correo"  type="button"' + 'id='+ d.id_propuesta + ' name="correo" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fas fa-envelope-open-text"></i></button><a> </a>' +
        '<button style="background-color: #FF0000" title="Eliminar propuesta"  type="button" id=' + d.numero_propuesta + ' name="eliminar_propuesta" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fas fa-trash-alt"></i></button>' +
        '</td>' +
        '</tr>' +
        '</table>';
    }
    else{
        botones='<td>Acciones</td>' +
        '<td>' +
        '<button title="Generar Propuesta" type="button" id=' + d.numero_propuesta + ' name="generar_documento" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fa fa-file-pdf-o"></i></button><a> </a>' +
        '<button title="WIP Buscar información asociada" type="button" id=' + d.numero_propuesta + ' name="info" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fas fa-search"></i></button><a> </a>' +
        '</td>' +
        '</tr>' +
        '</table>';
    }
    if (d.estado=='Cancelado'){
        ext_cancelado='<tr>' +
        '<td>Fecha CANCELACIÓN:</td>' +
        '<td>' + d.fech_cancela + '</td>' +
        '</tr>'+
        '<tr>' +
        '<td>motivo CANCELACIÓN:</td>' +
        '<td>' + d.motivo_cancela + '</td>' +
        '</tr>';
    }
    console.log(d.total_items);
    if(d.total_items=="0"){
            items=
            '<tr>' +
            '<td>Sin ítems registrados</td>' +
            '</tr>';   
        }
        else {
            
            for (var i=0; i<d.total_items; i++){
            listado_items+= '<tr>'+
            '<td>' + (i+1) + '</td>'+
            '<td>' + d.items[i].rut_clienteA + '</td>'+
            '<td>' + d.items[i].nom_clienteA + '</td>'+
            '<td>' + d.items[i].materia_asegurada + '</td>'+
            '<td>' + d.items[i].patente_ubicacion + '</td>'+
            '<td>' + d.items[i].cobertura + '</td>'+
            '<td>' + d.items[i].deducible + '</td>'+
            '<td>' + d.items[i].monto_asegurado + '</td>'+
            '<td>' + d.items[i].prima_afecta + '</td>'+
            '<td>' + d.items[i].prima_exenta + '</td>'+
            '<td>' + d.items[i].prima_neta + '</td>'+
            '<td>' + d.items[i].prima_bruta + '</td>'+
            '<td>' + d.items[i].venc_gtia + '</td>'
            '</tr>';
  
            }
            items='<table class="table table-striped" style="width:100%" id="listado_propuesta_polizas">'+
            '<tr>'+
            '<th></th>'+
            '<th>Rut Asegurado</th>'+
            '<th>Nombre Asegurado</th>'+
            '<th>Materia Asegurada</th>'+
            '<th>Patente o Ubicación</th>'+
            '<th>Cobertura</th>'+
            '<th>Deducible</th>'+
            '<th>Monto asegurado</th>'+
            '<th>Prima Afecta</th>'+
            '<th>Prima Exenta</th>'+
            '<th>Prima Neta</th>'+
            '<th>Prima Bruta</th>'+

            '<th>Vencimiento Garantía</th>'+
            
            '</tr>'+
            listado_items+
            '</table>' ;

    }
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
            ext_cancelado + 
            '<td>Total Prima afecta:</td>' +
            '<td>' + d.total_prima_afecta + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td>Total Prima exenta:</td>' +
            '<td>' + d.total_prima_exenta + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td>Total Prima neta anual:</td>' +
            '<td>' + d.total_prima_neta + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td>Total Prima bruta anual:</td>' +
            '<td>' + d.total_prima_bruta + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td></td>' +
        '<tr>' +
        items +
        '<tr>' +
        botones;
}
function detalle_tareas_recurrentes(d) {
    $sin_rel=$tabla_clientes=$tabla_polizas=$tabla_propuestas='';
    if (d.relaciones == 0) {
        $sin_rel= 'Tarea sin asociar a clientes  o pólizas';
        $tabla_clientes = 'Sin clientes asociados';
        $tabla_polizas = 'Sin pólizas asociadas';
        $tabla_propuestas = 'Sin propuestas de póliza asociadas';
    } else {
        if (d.clientes == 0) {
            $tabla_clientes = 'Sin clientes asociados';
        } else {
            $tabla_clientes =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Clientes</th><th>Nombre</th><th>Telefono</th><th>Correo Electrónico</th><th>Acciones</th></tr>';
                $cont_i=0;
            for (i = 0; i < d.clientes; i++) {
                $cont_i=$cont_i+1;
                $tabla_clientes = $tabla_clientes + '<tr><td>' + $cont_i + '</td><td>' + d.nombre[i] + '</td><td>' + d.telefono[i] + '</td><td>' + d.correo[i] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d.id_cliente[i] +
                    ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_clientes = $tabla_clientes + '</table>';
        }
        if (d.polizas == 0) {
            $tabla_polizas = 'Sin pólizas asociadas';
        } else {
            $tabla_polizas =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Pólizas</th><th>Estado</th><th>Nro Póliza</th><th>Inicio Vigencia</th><th>Vigencia Final</th><th>Acciones</th></tr>';
                $cont_j=0;
            for (j = 0; j < d.polizas; j++) {
                $cont_j=$cont_j+1;
                $tabla_polizas = $tabla_polizas + '<tr><td>' + $cont_j + 
                    '</td><td><span class="'+d.estado_poliza_alerta[j]+'">'+d.estado_poliza[j]+
                    '</span></td><td>' + d.numero_poliza[j] + 
                    '</td><td>' + d.vigencia_inicial[j] +
                    '</td><td>' + d.vigencia_final[j] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d.id_poliza[j] +
                    ' name="info" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_polizas = $tabla_polizas + '</table>';
        }
        if (d.propuestas == 0) {
            $tabla_propuestas = 'Sin propuestas de pólizas asociadas';
        } else {
            $tabla_propuestas =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Propuestas</th><th>Estado</th><th>Nro propuesta</th><th>Inicio Vigencia</th><th>Vigencia Final</th><th>Acciones</th></tr>';
                $cont_j=0;
            for (j = 0; j < d.propuestas; j++) {
                $cont_j=$cont_j+1;
                $tabla_propuestas = $tabla_propuestas + '<tr><td>' + $cont_j + '</td><td><span class="'+d.estado_propuesta_alerta[j]+'">'+d.estado_propuesta[j]+'</span></td><td>' + d.numero_propuesta[j] + '</td><td>' + d.vigencia_inicial[j] +
                    '</td><td>' + d.vigencia_final[j] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d.numero_propuesta[j] +
                    ' name="info" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_propuestas = $tabla_propuestas + '</table>';
        }
    }

    // `d` is the original data object for the row
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Acciones:</td>' +
        '<td><button title="Buscar información asociada" type="button" id=' + d.id_tarea +
        ' name="info" onclick="botones(this.id, this.name, \'tarea recurrente\')"><i class="fas fa-search"></i></button><a> </a><button title="Editar"  type="button" id=' + d.id_tarea +
        ' name="modifica" onclick="botones(this.id, this.name, \'tarea recurrente\')"><i class="fas fa-edit"></i></button><a> </a><button title="Completar tarea"  type="button" id=' +d.id_tarea +
        ' name="cerrar_tarea_recurrente" onclick="botones(this.id, this.name, \'tarea recurrente\')"><i class="fas fa-check-circle"></i></i></button></td>' +
        '</tr>' +
        '<tr><td>Clientes:</td>'+
        '<td>'+ $tabla_clientes+'</td></tr>'+
        '<tr><td>Pólizas:</td>'+
        '<td>'+$tabla_polizas+'</td></tr>'+
        '<tr><td>Propuestas de Pólizas:</td>'+
        '<td>'+$tabla_propuestas+'</td></tr>'+
        '</table>';
}
function detalle_tareas(d) {
    $sin_rel=$tabla_clientes=$tabla_polizas=$tabla_propuestas='';
    if (d.relaciones == 0) {
        $sin_rel= 'Tarea sin asociar a clientes  o pólizas';
        $tabla_clientes = 'Sin clientes asociados';
        $tabla_polizas = 'Sin pólizas asociadas';
        $tabla_propuestas = 'Sin propuestas de póliza asociadas';
    } else {
        if (d.clientes == 0) {
            $tabla_clientes = 'Sin clientes asociados';
        } else {
            $tabla_clientes =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Clientes</th><th>Nombre</th><th>Telefono</th><th>Correo Electrónico</th><th>Acciones</th></tr>';
                $cont_i=0;
            for (i = 0; i < d.clientes; i++) {
                $cont_i=$cont_i+1;
                $tabla_clientes = $tabla_clientes + '<tr><td>' + $cont_i + '</td><td>' + d.nombre[i] + '</td><td>' + d.telefono[i] + '</td><td>' + d.correo[i] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d.id_cliente[i] +
                    ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_clientes = $tabla_clientes + '</table>';
        }
        if (d.polizas == 0) {
            $tabla_polizas = 'Sin pólizas asociadas';
        } else {
            $tabla_polizas =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Pólizas</th><th>Estado</th><th>Nro Póliza</th><th>Inicio Vigencia</th><th>Vigencia Final</th><th>Acciones</th></tr>';
                $cont_j=0;
            for (j = 0; j < d.polizas; j++) {
                $cont_j=$cont_j+1;
                $tabla_polizas = $tabla_polizas + '<tr><td>' + $cont_j + 
                    '</td><td><span class="'+d.estado_poliza_alerta[j]+'">'+d.estado_poliza[j]+
                    '</span></td><td>' + d.numero_poliza[j] + 
                    '</td><td>' + d.vigencia_inicial[j] +
                    '</td><td>' + d.vigencia_final[j] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d.id_poliza[j] +
                    ' name="info" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_polizas = $tabla_polizas + '</table>';
        }
        if (d.propuestas == 0) {
            $tabla_propuestas = 'Sin propuestas de pólizas asociadas';
        } else {
            $tabla_propuestas =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Propuestas</th><th>Estado</th><th>Nro propuesta</th><th>Inicio Vigencia</th><th>Vigencia Final</th><th>Acciones</th></tr>';
                $cont_j=0;
            for (j = 0; j < d.propuestas; j++) {
                $cont_j=$cont_j+1;
                $tabla_propuestas = $tabla_propuestas + '<tr><td>' + $cont_j + '</td><td><span class="'+d.estado_propuesta_alerta[j]+'">'+d.estado_propuesta[j]+'</span></td><td>' + d.numero_propuesta[j] + '</td><td>' + d.vigencia_inicial[j] +
                    '</td><td>' + d.vigencia_final[j] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d.numero_propuesta[j] +
                    ' name="info" onclick="botones(this.id, this.name, \'propuesta\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_propuestas = $tabla_propuestas + '</table>';
        }
    }

    // `d` is the original data object for the row
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Acciones:</td>' +
        '<td><button title="Buscar información asociada" type="button" id=' + d.id_tarea +
        ' name="info" onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-search"></i></button><a> </a><button title="Editar"  type="button" id=' +
        d.id_tarea +
        ' name="modifica" onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-edit"></i></button><a> </a><button title="Completar tarea"  type="button" id=' +
        d.id_tarea +
        ' name="cerrar_tarea" id=' + d.id_tarea +
        ' onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-check-circle"></i></i></button></td>' +
        '</tr>' +
        '<tr><td>Clientes:</td>'+
        '<td>'+ $tabla_clientes+'</td></tr>'+
        '<tr><td>Pólizas:</td>'+
        '<td>'+$tabla_polizas+'</td></tr>'+
        '<tr><td>Propuestas de Pólizas:</td>'+
        '<td>'+$tabla_propuestas+'</td></tr>'+
        '</table>';
}
function format(d) {
    // `d` is the original data object for the row
    $conf_tabla =
        '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">';
    $contactos = '';
    switch (d.contactos) {
        case "1": {
            $contactos = $conf_tabla + '<tr><th></th><th>Contacto 1</th></tr>' +
                '<tr><td>Nombre</td><td>' + d.nombre1 + '</td></tr>' +
                '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td></tr>' +
                '<tr><td>Correo</td><td>' + d.correo1 + '</td></tr></table>'
            break
        }
        case "2": {
            $contactos = $conf_tabla + '<tr><th></th><th>Contacto 1</th><th>Contacto 2</th></tr>' +
                '<tr><td>Nombre</td><td>' + d.nombre1 + '</td><td>' + d.nombre2 + '</td></tr>' +
                '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td><td>' + d.telefono2 + '</td></tr>' +
                '<tr><td>Correo</td><td>' + d.correo1 + '</td><td>' + d.correo2 + '</td></tr></table>'
            break
        }
        case "3": {
            $contactos = $conf_tabla + '<tr><th></th><th>Contacto 1</th><th>Contacto 2</th><th>Contacto 3</th></tr>' +
                '<tr><td>Nombre</td><td>' + d.nombre1 + '</td><td>' + d.nombre2 + '</td><td>' + d.nombre3 +
                '</td></tr>' +
                '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td><td>' + d.telefono2 + '</td><td>' + d.telefono3 +
                '</td></tr>' +
                '<tr><td>Correo</td><td>' + d.correo1 + '</td><td>' + d.correo2 + '</td><td>' + d.correo3 +
                '</td></tr></table>'
            break
        }
        case "4": {
            $contactos = $conf_tabla +
                '<tr><th></th><th>Contacto 1</th><th>Contacto 2</th><th>Contacto 3</th><th>Contacto 4</th></tr>' +
                '<tr><td>Nombre</td><td>' + d.nombre1 + '</td><td>' + d.nombre2 + '</td><td>' + d.nombre3 +
                '</td><td>' + d.nombre4 + '</td></tr>' +
                '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td><td>' + d.telefono2 + '</td><td>' + d.telefono3 +
                '</td><td>' + d.telefono4 + '</td></tr>' +
                '<tr><td>Correo</td><td>' + d.correo1 + '</td><td>' + d.correo2 + '</td><td>' + d.correo3 +
                '</td><td>' + d.correo4 + '</td></tr></table>'
            break
        }
        case "5": {
            $contactos = $conf_tabla +
                '<tr><th></th><th>Contacto 1</th><th>Contacto 2</th><th>Contacto 3</th><th>Contacto 4</th><th>Contacto 5</th></tr>' +
                '<tr><td>Nombre</td><td>' + d.nombre1 + '</td><td>' + d.nombre2 + '</td><td>' + d.nombre3 +
                '</td><td>' + d.nombre4 + '</td><td>' + d.nombre5 + '</td></tr>' +
                '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td><td>' + d.telefono2 + '</td><td>' + d.telefono3 +
                '</td><td>' + d.telefono4 + '</td><td>' + d.telefono5 + '</td></tr>' +
                '<tr><td>Correo</td><td>' + d.correo1 + '</td><td>' + d.correo2 + '</td><td>' + d.correo3 +
                '</td><td>' + d.correo4 + '</td><td>' + d.correo5 + '</td></tr></table>'
            break
        }
        default: {
            $contactos = 'Cliente sin contactos registrados';
            break
        }
    }
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Correo electrónico:</td>' +
        '<td>' + d.correo_electronico + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Dirección particular:</td>' +
        '<td>' + d.direccionp + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Dirección laboral:</td>' +
        '<td>' + d.direccionl + '</td>' +
        '</tr>' +
        '</tr>' +
        '<tr>' +
        '<td>Acciones</td>' +
        '<td><button title="Buscar información asociada" type="button" id=' + d.id +
        ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-search"></i></button><a> </a><button title="Editar"  type="button" id=' +
        d.id +
        ' name="modifica" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-edit"></i></button><a> </a><button title="Agregar tarea"  type="button" id=' +
        d.id +
        ' name="tarea" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-clipboard-list"></i></button></td>' +
        '</tr>' +
        '</table><br>' +
        $contactos + '<br>';
}
function format_poliza(d) {
    // `d` is the original data object for the row
 var ext_cancelado='';
    var items='';
    var endosos='';  
    var listado_items='';
    var listado_endosos='';
    if (d.estado=='Cancelado'){
        ext_cancelado='<tr>' +
        '<td>Fecha CANCELACIÓN:</td>' +
        '<td>' + d.fech_cancela + '</td>' +
        '</tr>'+
        '<tr>' +
        '<td>motivo CANCELACIÓN:</td>' +
        '<td>' + d.motivo_cancela + '</td>' +
        '</tr>';
    }
    //inicio endosos
    console.log('nro de endosos: '+ d.nro_endosos);
        if(d.nro_endosos=="0"){
            endosos=
            '<tr>' +
                '<td></td>' +
                '<td></td>' +
            '</tr>';   
            
        }
        else {
            for (var i=0; i< d.nro_endosos; i++){
                listado_endosos+= '<tr>'+
                '<td>' + (i+1) + '</td>'+
                '<td>' + d.endosos[i].numero_endoso + '</td>'+
                '<td>' + d.endosos[i].tipo_endoso + '</td>'+
                '<td>' + d.endosos[i].descripcion_endoso + '</td>'+
                '<td>' + d.endosos[i].dice + '</td>'+
                '<td>' + d.endosos[i].debe_decir + '</td>'+
                '<td>' + d.endosos[i].vigencia_inicial + '</td>'+
                '<td>' + d.endosos[i].vigencia_final + '</td>'+
                '<td>' + d.endosos[i].fecha_ingreso_endoso + '</td>'+
                '<td>' + d.endosos[i].fecha_prorroga + '</td>'+
                '</tr>';
            }
            endosos='<tr>' +
            '<td VALIGN=TOP>Endosos: </td>' +
            '<td><table class="table table-striped" style="width:100%" id="listado_endosos_1">'+
            '<tr>'+
            '<th></th>'+
            '<th>Número</th>'+
            '<th>Tipo</th>'+
            '<th>Descripción</th>'+
            '<th>Dice</th>'+
            '<th>Debe decir</th>'+
            '<th>Vigencia Inicial</th>'+
            '<th>Vigencia Final</th>'+
            '<th>Fecha ingreso</th>'+
            '<th>Fecha Prorroga</th>'+
            '</tr>'+
            listado_endosos+
            '</table></td>' +
            '</tr>' ;
    }
    
    //fin endosos
    console.log(d.total_items);
    if(d.total_items=="0"){
            items=
            '<tr>' +
            '<td>Sin ítems registrados</td>' +
            '</tr>';   
        }
        else {
            
            for (var i=0; i<d.total_items; i++){
            listado_items+= '<tr>'+
            '<td>' + (i+1) + '</td>'+
            '<td>' + d.items[i].rut_clienteA + '</td>'+
            '<td>' + d.items[i].nom_clienteA + '</td>'+
            '<td>' + d.items[i].materia_asegurada + '</td>'+
            '<td>' + d.items[i].patente_ubicacion + '</td>'+
            '<td>' + d.items[i].cobertura + '</td>'+
            '<td>' + d.items[i].deducible + '</td>'+
            '<td>' + d.items[i].monto_asegurado + '</td>'+
            '<td>' + d.items[i].prima_afecta + '</td>'+
            '<td>' + d.items[i].prima_exenta + '</td>'+
            '<td>' + d.items[i].prima_neta + '</td>'+
            '<td>' + d.items[i].prima_bruta + '</td>'+
            '<td>' + d.items[i].venc_gtia + '</td>'
            '</tr>';
  
            }
            items='<table class="table table-striped" style="width:100%" id="listado_polizas_1">'+
            '<tr>'+
            '<th></th>'+
            '<th>Rut Asegurado</th>'+
            '<th>Nombre Asegurado</th>'+
            '<th>Materia Asegurada</th>'+
            '<th>Patente o Ubicación</th>'+
            '<th>Cobertura</th>'+
            '<th>Deducible</th>'+
            '<th>Monto asegurado</th>'+
            '<th>Prima Afecta</th>'+
            '<th>Prima Exenta</th>'+
            '<th>Prima Neta</th>'+
            '<th>Prima Bruta</th>'+

            '<th>Vencimiento Garantía</th>'+
            
            '</tr>'+
            listado_items+
            '</table>' ;

    }
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +

        '<tr>' +
        ext_cancelado + 
            '<td VALIGN=TOP>Primas: </td>' +
            '<td>'+
                '<table class="table table-striped" style="width:100%">'+
                    '<tr>' +
                        '<td>Total Prima afecta:</td>' +
                        '<td>' + d.total_prima_afecta + '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td>Total Prima exenta:</td>' +
                        '<td>' + d.total_prima_exenta + '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td>Total Prima neta anual:</td>' +
                        '<td>' + d.total_prima_neta + '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td>Total Prima bruta anual:</td>' +
                        '<td>' + d.total_prima_bruta + '</td>' +
                    '</tr>' +
                '</table>'+
            '</td>' +
        '</tr>' +
        '<tr>' +
        '<td></td>' +
        '<td></td>' +
        '<tr>' +
        '<tr>' +
            '<td VALIGN=TOP>Ítems: </td>' +
            '<td>' + items + '</td>' +
        '</tr>' +
         '<tr>' +
        '<td></td>' +
        '<td></td>' +
        '<tr>' + endosos +      
        '<tr>' +
        '<td VALIGN=TOP>Acciones: </td>' +
        '<td>' +
        '<button title="Buscar información asociada" type="button" id="' + d.id_poliza + '" name="info" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button><a> </a>' +
        '<button title="Editar Póliza"  type="button" id="' + d.numero_poliza + '" name="modifica_poliza" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-edit"></i></button><a> </a>' +
        '<button title="Renovar póliza" type="button" id="' + d.numero_poliza + '" name="renovar" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-redo"></i></button><a> - </a>' +
        '<button title="Asignar tarea"  type="button" id=' + d.id_poliza +' name="tarea" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-clipboard-list"></i></button><a> </a>' +
        '<button title="WIP Generar correo"  type="button"' + 'id='+ d.id_poliza + ' name="correo" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-envelope-open-text"></i></button><a> - </a>' +
        '<button title="WIP Generar propuesta de endoso"  type="button"' + 'id='+ d.id_poliza + ' name="crea_propuesta_endoso" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-eraser"></i></button><a> - </a>' +
        '<button style="background-color: #FF0000" title="Cancelar póliza"  type="button" id=' + d.id_poliza + ' name="cancelar_poliza" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-backspace"></i></button><a> </a>' +
        '<button style="background-color: #FF0000" title="Anular póliza"  type="button" id=' + d.id_poliza + ' name="anular_poliza" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-ban"></i></button><a> </a>' +
        '<button style="background-color: #FF0000" title="Eliminar póliza"  type="button" id=' + d.id_poliza + ' name="eliminar_poliza" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-trash"></i></button>' +
        '</td>' +
        '</tr>' +
        '</table>';
}
function format_endoso(d) {
    // `d` is the original data object for the row
    var ext_cancelado='';
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
            '<td>Total Prima afecta:</td>' +
            '<td>' + d.prima_neta_afecta + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td>Total Prima exenta:</td>' +
            '<td>' + d.prima_neta_exenta + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td>Total IVA:</td>' +
            '<td>' + d.iva + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td>Prima total:</td>' +
            '<td>' + d.prima_total + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td> </td>' +
            '<td> </td>' +
        '</tr>' +
        '<tr>' +
        '<td> </td>' +
            '<td>'+
                '<table class="table table-striped" style="padding-left:50px;" cellpadding="5" cellspacing="0" border="0" id="listado_polizas">'+
                    '<tr>'+
                        '<th>Descripción</th>'+
                        '<th>Dice</th>'+
                        '<th>Debe Decir</th>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>' + d.descripcion_endoso + '</td>'+
                    '<td>' + d.dice + '</td>'+
                    '<td>' + d.debe_decir + '</td>'+
                '</table>'+
            '</td>' +
        '</tr>' +    
        '<tr>' +
            '<td> </td>' +
            '<td> </td>' +
        '</tr>' +
        '<tr><td>Acciones</td>' +
        '<td>' +
        '<button title="Generar documento" type="button" id=' + d.numero_propuesta_endoso + ' name="generar_documento" onclick="botones(this.id, this.name, \'endoso\')"><i class="fa fa-file-pdf-o"></i></button><a> </a>' +
        '<button title="Buscar información asociada" type="button" id=' + d.numero_endoso + ' name="info" onclick="botones(this.id, this.name, \'endoso\')"><i class="fas fa-search"></i></button><a> </a>' +
        '</td>' +
        '</tr>' +
        '</table>';
}
function format_propuesta_endoso(d) {
    // `d` is the original data object for the row
    var ext_cancelado='';

    var botones='';
    if (d.estado=='Pendiente'){
        botones='<tr><td>Acciones</td>' +
        '<td>' +
        '<button title="Aprobar Propuesta" type="button" id=' + d.numero_propuesta_endoso + ' name="crear_endoso" onclick="botones(this.id, this.name, \'propuesta_endoso\')"><i class="fa fa-thumbs-up"></i></button><a> </a>' +
        '<button title="Rechazar propuesta"  type="button" id=' + d.numero_propuesta_endoso + ' name="rechazar_propuesta" onclick="botones(this.id, this.name, \'propuesta_endoso\')"><i class="fa fa-thumbs-down"></i></button>' +
        '<button title="Generar documento" type="button" id=' + d.numero_propuesta_endoso + ' name="generar_documento" onclick="botones(this.id, this.name, \'propuesta_endoso\')"><i class="fa fa-file-pdf-o"></i></button><a> </a>' +
        '<button title="Buscar información asociada" type="button" id=' + d.numero_propuesta_endoso + ' name="info" onclick="botones(this.id, this.name, \'propuesta_endoso\')"><i class="fas fa-search"></i></button><a> </a>' +
        '<button title="Editar Propuesta"  type="button" id=' + d.numero_propuesta_endoso + ' name="actualiza_propuesta" onclick="botones(this.id, this.name, \'propuesta_endoso\')"><i class="fas fa-edit"></i></button><a> </a>' +
        '</td>' +
        '</tr>' +
        '</table>';
    }
    else{
        botones='<tr><td>Acciones</td>' +
        '<td>' +
        '<button title="Generar documento" type="button" id=' + d.numero_propuesta_endoso + ' name="generar_documento" onclick="botones(this.id, this.name, \'propuesta_endoso\')"><i class="fa fa-file-pdf-o"></i></button><a> </a>' +
        '<button title="Buscar información asociada" type="button" id=' + d.numero_propuesta_endoso + ' name="info" onclick="botones(this.id, this.name, \'propuesta_endoso\')"><i class="fas fa-search"></i></button><a> </a>' +
        '</td>' +
        '</tr>' +
        '</table>';
    }

    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
            '<td>Total Prima afecta:</td>' +
            '<td>' + d.prima_neta_afecta + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td>Total Prima exenta:</td>' +
            '<td>' + d.prima_neta_exenta + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td>Total IVA:</td>' +
            '<td>' + d.iva + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td>Prima total:</td>' +
            '<td>' + d.prima_total + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td> </td>' +
            '<td> </td>' +
        '</tr>' +
        '<tr>' +
        '<td> </td>' +
            '<td>'+
                '<table class="table table-striped" style="padding-left:50px;" cellpadding="5" cellspacing="0" border="0" id="listado_polizas">'+
                    '<tr>'+
                        '<th>Descripción</th>'+
                        '<th>Dice</th>'+
                        '<th>Debe Decir</th>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>' + d.descripcion_endoso + '</td>'+
                    '<td>' + d.dice + '</td>'+
                    '<td>' + d.debe_decir + '</td>'+
                '</table>'+
            '</td>' +
        '</tr>' +    
        '<tr>' +
            '<td> </td>' +
            '<td> </td>' +
        '</tr>' +

        botones;
}
function botones(id, accion, base) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "cancelar_poliza": {
            var motivo = window.prompt('Ingresa el motivo de cancelación de póliza', '');
            var r2 = confirm("Estás a punto de cancelar esta póliza ¿Deseas continuar?");
            if (r2 == true) {
                $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
                    'numero_poliza': id,
                    'accion': accion,
                    'motivo': motivo
                }, 'post');
            }
            break;
        }
        case "anular_poliza": {
            var motivo = window.prompt('Ingresa el motivo de anulación de póliza', '');
            var r2 = confirm("Estás a punto de anular esta póliza ¿Deseas continuar?");
            if (r2 == true) {
                $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
                    'numero_poliza': id,
                    'accion': accion,
                    'motivo': motivo
                }, 'post');
            }
            break;
        }
        case "eliminar_poliza": {
            var r2 = confirm("Estás a punto de eliminar esta póliza ¿Deseas continuar?");
            if (r2 == true) {
                $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_poliza.php', {
                    'numero_poliza': id,
                    'accion': accion
                }, 'post');
            }
            break;
        }
        case "elimina": {
            if (base == 'tarea' || base == 'tarea recurrente') {
                $.redirect('/bambooQA/backend/actividades/cierra_tarea.php', {
                    'id_tarea': id,
                    'accion': accion,
                }, 'post');
            }
            if (base == 'cliente') {
                console.log("Cliente eliminado con ID:" + id);
                var r = confirm(
                    "Estás a punto de eliminar los datos de un cliente. ¿Estás seguro de eliminarlo?"
                );
                if (r == true) {
                    $.ajax({
                        type: "POST",
                        url: "/bambooQA/backend/clientes/elimina_cliente.php",
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
                    table.ajax.reload();
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
            break;
        }
        case "modifica_poliza": {
            $.redirect('/bambooQA/creacion_propuesta_poliza.php', {
                'numero_poliza': id,
                'accion': accion
            }, 'post');
            break;
        }
        case "modifica": {
            if (base == 'tarea recurrente') {
                $.redirect('/bambooQA/creacion_actividades.php', {
                    'id_tarea': id,
                    'tipo_tarea': 'recurrente'
                }, 'post');
            }
            if (base == 'tarea') {
                $.redirect('/bambooQA/creacion_actividades.php', {
                    'id_tarea': id,
                    'tipo_tarea': 'individual'
                }, 'post');
            }
            if (base == 'cliente') {
                $.redirect('/bambooQA/creacion_cliente.php', {
                    'id_cliente': id
                }, 'post');
            }
            console.log(base + " modificado con ID:" + id);
            $.notify({
                // options
                message: base + ' modificado'
            }, {
                // settings
                type: 'success'
            });

            break;
        }
        case "tarea": {
            if (base == 'cliente') {
                $.redirect('/bambooQA/creacion_actividades.php', {
                    'id_cliente': id
                }, 'post');
            }
            if (base == 'poliza') {
                $.redirect('/bambooQA/creacion_actividades.php', {
                    'id_poliza': id
                }, 'post');
            }
            break;
        }
        case "info": {
            $.redirect('/bambooQA/resumen2.php', {
                'id': id,
                'base': base
            }, 'post');
            break;
        }
        case "correo": {
            if (base == 'poliza') {
                $.redirect('/bambooQA/template_poliza.php', {
                    'id_poliza': id
                }, 'post');
            }
            break;
        }
        case "crear_poliza": {
            $.redirect('/bambooQA/creacion_propuesta_poliza.php', {
                'numero_propuesta': id,
                'accion': accion
            }, 'post');
            break;
        }
        case "rechazar_propuesta": {
                var motivo = window.prompt('Ingresa el motivo del rechazo', '');
                var r2 = confirm("Estás a punto de rechazar esta propuesta de póliza ¿Deseas continuar?");
                
                if (r2 == true) {
                $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
                    'numero_propuesta': id,
                    'accion':accion,
                    'motivo':motivo
                }, 'post');
                }
            break;
        }
        case "eliminar_propuesta": {
                var r2 = confirm("Estás a punto de eliminar esta propuesta de póliza ¿Deseas continuar?");
                //eliminar
                if (r2 == true) {
                $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
                    'numero_propuesta': id,
                    'accion':accion
                }, 'post');
                }
            break;
        }
        case "actualiza_propuesta": {
            $.redirect('/bambooQA/creacion_propuesta_poliza.php', {
                'numero_propuesta': id,
                'accion': accion
            }, 'post');
            break;
        }
        case "crea_propuesta_endoso": {
            $.redirect('/bambooQA/creacion_propuesta_endoso.php', {
                'numero_poliza': id,
                'accion': accion
            }, 'post');
            break;
        }
        case "generar_documento": {
            $.redirect('/bambooQA/documento_propuesta_poliza.php', {
                'numero_propuesta': id,
                'accion': accion
            }, 'post');
            break;
        }
        case "cerrar_tarea": {
            if (base == 'tarea' || base == 'tarea recurrente') {
                $.ajax({
                    type: "POST",
                    url: "/bambooQA/backend/actividades/cierra_tarea.php",
                    data: {
                        id_tarea: id,
                        accion: accion,
                    },
                });

                alert('Tarea cerrada correctamente');
                $('#listado_tareas').DataTable().clear();
                $('#listado_tareas').DataTable().ajax.reload(null, false);
                $('#listado_tareas').DataTable().draw();
                $('#listado_tareas_recurrentes').DataTable().clear();
                $('#listado_tareas_recurrentes').DataTable().ajax.reload(null, false);
                $('#listado_tareas_recurrentes').DataTable().draw();
            }
            break;
        }
        case "renovar":{
            var motivo = window.prompt('Ingresa la vía por donde quieres renovar esta póliza:\r\n 1) Vía Propuesta WEB\r\n 2) Vía Propuesta tradicional', 'digita 1 o 2');
            switch (motivo){
                case "1":
                    //alert('Renovación vía propuesta WEB');
                    $.redirect('/bambooQA/creacion_propuesta_poliza.php', {
                        'numero_poliza': id,
                        'accion': 'modifica_poliza',
                        'accion_secundaria': 'renovar'
                    }, 'post');
                    break;
                case "2":
                    $.redirect('/bambooQA/creacion_propuesta_poliza.php', {
                        'numero_poliza': id,
                        'accion': 'actualiza_propuesta',
                        'accion_secundaria': 'renovar'
                    }, 'post');
                    break;
                default:
                    alert('Número ingresado no válido. Debes ingresar 1 o 2');
                    break;
            }
            break;
        }
    }
}
(function() {

    function removeAccents(data) {
        if (data.normalize) {
            // Use I18n API if avaiable to split characters and accents, then remove
            // the accents wholesale. Note that we use the original data as well as
            // the new to allow for searching of either form.
            return data + ' ' + data
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');
        }

        return data;
    }

    var searchType = jQuery.fn.DataTable.ext.type.search;

    searchType.string = function(data) {
        return !data ?
            '' :
            typeof data === 'string' ?
            removeAccents(data) :
            data;
    };

    searchType.html = function(data) {
        return !data ?
            '' :
            typeof data === 'string' ?
            removeAccents(data.replace(/<.*?>/g, '')) :
            data;
    };

}());
</script>