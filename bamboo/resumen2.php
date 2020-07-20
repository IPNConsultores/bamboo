<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$buscar=$base=$id=$nombre_base='';
$id_clientes=$id_polizas='busqueda dummy';
require_once "/home/gestio10/public_html/backend/config.php";
require_once "/home/gestio10/public_html/bamboo/backend/funciones.php";
mysqli_set_charset( $link, 'utf8');
$num=0;
 $busqueda=$busqueda_err=$data='';
 $rut=$nombre=$telefono=$correo=$lista='';
 
 

 $query = "SELECT a.id as id_poliza, b.id as idP, c.id as idA FROM polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join clientes as c on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null where a.id=".$id;
$resultado_poliza=mysqli_query($link, $query);

if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["busqueda"])==true and isset($_POST["id"])!==true){
$buscar= eliminar_acentos(estandariza_info($_POST["busqueda"]));
$base="header";
}
if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["busqueda"])!==true and isset($_POST["id"])==true){
$id= estandariza_info($_POST["id"]);
$base= estandariza_info($_POST["base"]);
switch ($base) {
    case 'poliza':
            $query = "SELECT numero_poliza, a.id as id_poliza, b.id as idP, c.id as idA  FROM polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv and b.rut_sin_dv is not null left join clientes as c on a.rut_asegurado=c.rut_sin_dv and c.rut_sin_dv is not null where a.id=".$id;
            $resultado_poliza=mysqli_query($link, $query);
            While($row=mysqli_fetch_object($resultado_poliza))
                {
                    if($row->idA==$row->idP){
                        $id_clientes="^".$row->idA."$";   
                    }else{
                        $id_clientes= "^".$row->idA."$"."|"."^".$row->idP."$";
                    }
                        $nombre_base= $row->numero_poliza;
                } 
        break;
    case 'cliente':
            $query = "SELECT nombre_cliente FROM clientes where id=".$id;
            $resultado_poliza=mysqli_query($link, $query);
            While($row=mysqli_fetch_object($resultado_poliza))
                {
                        $nombre_base= $row->nombre_cliente;
                } 
        break;
    case 'tarea':
        $nombre_base=$id;
         $query = "SELECT id_relacion FROM tareas_relaciones  where base='clientes' and id_tarea=".$id;
         $resultado_poliza=mysqli_query($link, $query);
            While($row=mysqli_fetch_object($resultado_poliza))
                {
                    if($id_clientes=='busqueda dummy'){
                        $id_clientes='';
                    }
                        $id_clientes=$id_clientes."^".$row->id_relacion."$ | ";   
                } 
         $query2 = "SELECT id_relacion FROM tareas_relaciones  where base='polizas' and id_tarea=".$id;
         $resultado_poliza2=mysqli_query($link, $query2);
            While($row=mysqli_fetch_object($resultado_poliza2))
                {
                    if($id_polizas=='busqueda dummy'){
                        $id_polizas='';
                    }
                        $id_polizas=$id_polizas."^".$row->id_relacion."$ | ";   
                } 
        break;
    case 'tarea recurrente':
        $nombre_base=$id;
         $query = "SELECT id_relacion FROM tareas_relaciones  where base='clientes' and id_tarea_recurrente=".$id;
         $resultado_poliza=mysqli_query($link, $query);
            While($row=mysqli_fetch_object($resultado_poliza))
                {
                   if($id_clientes=='busqueda dummy'){
                        $id_clientes='';
                    }
                        $id_clientes=$id_clientes."^".$row->id_relacion."$ | ";   
                } 
         $query2 = "SELECT id_relacion FROM tareas_relaciones  where base='polizas' and id_tarea_recurrente=".$id;
         $resultado_poliza2=mysqli_query($link, $query2);
            While($row=mysqli_fetch_object($resultado_poliza2))
                {
                    if($id_polizas=='busqueda dummy'){
                        $id_polizas='';
                    }
                        $id_polizas=$id_polizas."^".$row->id_relacion."$ | ";   
                } 
        break;
}

}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/bamboo/bamboo.png">
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


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <div class="container">

        <p id="titulo"> Resumen / Búsqueda:</p> <br>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="clientes" data-toggle="tab" href="#nav-cliente" role="tab"
                    aria-controls="nav-cliente" aria-selected="true"
                    style="color: white;background-color:#536656;border-color:#dee2e6"
                    onclick="cambiacolor(this.id)">Cliente</a>
                <a class="nav-item nav-link" id="poliza" data-toggle="tab" href="#nav-poliza" role="tab"
                    aria-controls="nav-poliza" aria-selected="false" style="color: grey;border-color:#dee2e6"
                    onclick="cambiacolor(this.id)">Póliza</a>
                <a class="nav-item nav-link" id="tarea" data-toggle="tab" href="#nav-tarea" role="tab"
                    aria-controls="nav-tarea" aria-selected="false" style="color: grey;border-color:#dee2e6"
                    onclick="cambiacolor(this.id)">Tarea</a>
                <a class="nav-item nav-link" id="tarea_rec" data-toggle="tab" href="#nav-tarea_rec" role="tab"
                    aria-controls="nav-tarea_rec" aria-selected="false" style="color: grey;border-color:#dee2e6"
                    onclick="cambiacolor(this.id)">Tarea Recurrente</a>
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
                        <table class="display" style="width:100%" id="listado_polizas">
                            <tr>
                                <th></th>
                                <th>Estado</th>
                                <th>Póliza</th>
                                <th>Compañia</th>
                                <th>Ramo</th>
                                <th>Inicio Vigencia</th>
                                <th>Fin Vigencia</th>
                                <th>Materia Asegurada</th>
                                <th>Tipo póliza</th>
                                <th>Observaciones</th>
                                <th>Deducible</th>
                                <th>Prima afecta</th>
                                <th>Prima exenta</th>
                                <th>Prima bruta anual</th>
                                <th>Añomes final</th>
                                <th>Añomes inicial</th>
                                <th>Moneda póliza</th>
                                <th>Cobertura</th>
                                <th>Proponente</th>
                                <th>Rut Proponente</th>
                                <th>Asegurado</th>
                                <th>Rut Asegurado</th>
                                <th>grupo</th>
                                <th>referido</th>
                                <th>monto_asegurado</th>
                                <th>numero_propuesta</th>
                                <th>fecha_envio_propuesta</th>
                                <th>comision</th>
                                <th>porcentaje_comision</th>
                                <th>comision_bruta</th>
                                <th>comision_neta</th>
                                <th>numero_boleta</th>
                                <th>boleta_negativa</th>
                                <th>comision_negativa</th>
                                <th>depositado_fecha</th>
                                <th>vendedor</th>
                                <th>nombre_vendedor</th>
                                <th>forma_pago</th>
                                <th>nro_cuotas</th>
                                <th>valor_cuota</th>
                                <th>fecha_primera_cuota</th>
                                <th>Prima neta</th>
                            </tr>
                        </table>
                        <div id="botones_poliza"></div>
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
                            </tr>
                        </table>
                        <div id="botones_tareas_recurrentes"></div>
                    </div>
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
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
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
    document.getElementById(id).style.backgroundColor = "#536656"
    document.getElementById(id).style.color = "white"
}

$(document).ready(function() {
    var table = $('#listado_clientes').DataTable({

        "ajax": "/bamboo/backend/clientes/busqueda_listado_clientes.php",
        "scrollX": true,
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
            "sZeroRecords": "No hay registros asociados",
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
                table.search(texto1)
                    .draw();
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
        "ajax": "/bamboo/backend/polizas/busqueda_listado_polizas.php",
        "scrollX": true,
        "initComplete": function(settings, json) {
            document.getElementById("poliza").innerHTML = "Pólizas (" + $('#listado_polizas')
                .DataTable().page.info().recordsDisplay + ")";
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
            },
            {
                "data": "estado",
                title: "Estado"
            },
            {
                "data": "numero_poliza",
                title: "Nro Póliza"
            },
            {
                "data": "compania",
                title: "Compañía"
            },
            {
                "data": "ramo",
                title: "Ramo"
            },
            {
                "data": "vigencia_inicial",
                title: "Vigencia Inicio"
            },
            {
                "data": "vigencia_final",
                title: "Vigencia Término"
            },
            {
                "data": "materia_asegurada",
                title: "Materia asegurada"
            },
            {
                "data": "tipo_poliza",
                title: "Tipo póliza"
            },
            {
                "data": "patente_ubicacion",
                title: "Observaciones materia asegurada"
            },
            {
                "data": "deducible",
                title: "Deducible"
            },
            {
                "data": "prima_afecta",
                title: "Prima afecta"
            },
            {
                "data": "prima_exenta",
                title: "Prima exenta"
            },
            {
                "data": "prima_bruta_anual",
                title: "Prima bruta anual"
            },
            {
                "data": "anomes_final",
                title: "Añomes final"
            },
            {
                "data": "anomes_inicial",
                title: "Añomes inicial"
            },
            {
                "data": "moneda_poliza",
                title: "Moneda póliza"
            },
            {
                "data": "cobertura",
                title: "Cobertura"
            },
            {
                "data": "nom_clienteP",
                title: "Proponente"
            },
            {
                "data": "rut_clienteP",
                title: "Rut Proponente"
            },
            {
                "data": "nom_clienteA",
                title: "Asegurado"
            },
            {
                "data": "rut_clienteA",
                title: "Rut Asegurado"
            },
            {
                "data": "grupo",
                title: "Grupo"
            },
            {
                "data": "referido",
                title: "Referido"
            },
            {
                "data": "monto_asegurado",
                title: "Monto Asegurado"
            },
            {
                "data": "numero_propuesta",
                title: "Propuesta"
            },
            {
                "data": "fecha_envio_propuesta",
                title: "Fecha envío propuesto"
            },
            {
                "data": "comision",
                title: "Comisión"
            },
            {
                "data": "porcentaje_comision",
                title: "% Comisión"
            },
            {
                "data": "comision_bruta",
                title: "Comisión Bruta"
            },
            {
                "data": "comision_neta",
                title: "Comisión Neta"
            },
            {
                "data": "numero_boleta",
                title: "Número boleta"
            },
            {
                "data": "boleta_negativa",
                title: "Boleta negativa"
            },
            {
                "data": "comision_negativa",
                title: "Comisión negativa"
            },
            {
                "data": "depositado_fecha",
                title: "Fecha depósito"
            },
            {
                "data": "vendedor",
                title: "vendedor"
            },
            {
                "data": "nombre_vendedor",
                title: "Nombre vendedor"
            },
            {
                "data": "forma_pago",
                title: "Forma de pago"
            },
            {
                "data": "nro_cuotas",
                title: "Número de cuotas"
            },
            {
                "data": "valor_cuota",
                title: "Valor cuota"
            },
            {
                "data": "fecha_primera_cuota",
                title: "Fecha primera cuota"
            },
            {
                "data": "prima_neta",
                title: "Prima neta"
            },
            {
                "data": "poliza_renovada",
                title: "Póliza renovada"
            },
            {
                "data": "informacion_adicional",
                title: "Información adicional"
            },
            {
                "data": "idA",
                title: "id asegurado"
            },
            {
                "data": "idP",
                title: "id proponente"
            },
            {
                "data": "id_poliza",
                title: "id poliza"
            }
        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "columnDefs": [{
                "targets": [10, 11, 12, 13, 14, 15, 16, 17, 19, 21, 22, 23, 24, 25, 26, 27, 28, 29,
                    30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 44, 45, 46
                ],
                "visible": false,
            },
            {
                "targets": [10, 11, 12, 13, 14, 15, 16, 17, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33,
                    34, 35, 36, 37, 38, 39, 40, 41
                ],
                "searchable": false
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
                            estado = '<span class="badge badge-dark">' + data + '</span>';
                            break;
                        case 'Vencido':
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
            [3, "asc"],
            [4, "asc"]
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
            "sZeroRecords": "No hay registros asociados",
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

        "ajax": "/bamboo/backend/actividades/busqueda_listado_tareas_completas.php",
        "scrollX": true,
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
            }

        ],
        //          "search": {
        //          "search": "abarca"
        //          },

        "columnDefs": [{
                "targets": [6, 8, 11, 12, 13],
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
            "sZeroRecords": "No hay registros asociados",
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

        "ajax": "/bamboo/backend/actividades/busqueda_listado_tareas_recurrentes.php",
        "scrollX": true,
        "initComplete": function(settings, json) {
            document.getElementById("tarea_rec").innerHTML = "Tareas recurrentes (" + $(
                '#listado_tareas_recurrentes').DataTable().page.info().recordsDisplay + ")";
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
                "data": "dia_recordatorio",
                title: "Día activación"
            },
            {
                "data": "fecha_fin",
                title: "Fecha fin"
            },
            {
                "data": "fecingreso",
                title: "Fecha creación tarea"
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
                "data": "id_cliente[]",
                title: "id cliente"
            },
            {
                "data": "id_poliza[]",
                title: "id poliza"
            }

        ],
        //          "search": {
        //          "search": "abarca"
        //          },

        "columnDefs": [{
                "targets": [10, 11],
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
            "sZeroRecords": "No hay registros asociados",
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
    switch (document.getElementById("aux_base").value) {
        case 'cliente': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a cliente: ".concat(
                "<b>" + document.getElementById("var4_titulo").value + "</b>");
            document.getElementById("clientes").click();
            //cliente
            table.column(9).search(document.getElementById("aux_id").value, true).draw();
            //poliza
            table_polizas.columns([44, 45]).search(document.getElementById("aux_id").value, true).draw();
            //tarea
            table_tareas.columns([11, 12]).search(document.getElementById("aux_id").value, true).draw();
            //tarea recurrente
            table_tareas_recurrentes.column(10).search(document.getElementById("aux_id").value, true).draw();
            break;
        }
        case 'poliza': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a póliza número: "
                .concat("<b>" + document.getElementById("var4_titulo").value + "</b>");
            document.getElementById("poliza").click();
            //cliente
            table.column(9).search(document.getElementById("var2_cliente").value, true).draw();
            //poliza
            table_polizas.column(46).search(document.getElementById("aux_id").value, true).draw();
            //tarea
            table_tareas.column(13).search(document.getElementById("aux_id").value, true).draw();
            //tarea recurrente
            table_tareas_recurrentes.column(11).search(document.getElementById("aux_id").value, true).draw();
            break;
        }
        case 'tarea': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a tarea número: "
                .concat("<b>" + document.getElementById("var4_titulo").value + "</b>");
            document.getElementById("tarea").click();
            //cliente
            table.column(9).search(document.getElementById("var2_cliente").value, true).draw();
            //poliza
            table_polizas.column(46).search(document.getElementById("var3_poliza").value, true).draw();
            //tarea
            table_tareas.column(1).search(document.getElementById("aux_id").value, true).draw();
            //tarea recurrente
            table_tareas_recurrentes.column(9).search("busqueda dummy").draw();
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
            table_polizas.column(46).search(document.getElementById("var3_poliza").value, true).draw();
            //tarea
            table_tareas.column(1).search("busqueda dummy").draw();
            //tarea recurrente
            table_tareas_recurrentes.column(1).search(document.getElementById("aux_id").value, true).draw();
            break;
        }
        case 'header': {
            document.getElementById("titulo").innerHTML = " Resumen / Búsqueda asociada a: ".concat("<b>" +
                document.getElementById("var1").value + "</b>");

            break;
        }
    }
    //fin tareas recurrents
});

function detalle_tareas_recurrentes(d) {
    $sin_rel = $tabla_clientes = $tabla_polizas = '';
    if (d.relaciones == 0) {
        $sin_rel = 'Tarea sin asociar a clientes  o pólizas';
        $tabla_clientes = 'Sin clientes asociados';
        $tabla_polizas = 'Sin pólizas asociadas';
    } else {
        if (d.clientes == 0) {
            $tabla_clientes = 'Sin clientes asociados';
        } else {
            $tabla_clientes =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Clientes</th><th>Nombre</th><th>Telefono</th><th>Correo Electrónico</th><th>Acciones</th></tr>';
            $cont_i = 0;
            for (i = 0; i < d.clientes; i++) {
                $cont_i = $cont_i + 1;
                $tabla_clientes = $tabla_clientes + '<tr><td>' + $cont_i + '</td><td>' + d.nombre[i] + '</td><td>' + d
                    .telefono[i] + '</td><td>' + d.correo[i] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d
                    .id_cliente[i] +
                    ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_clientes = $tabla_clientes + '</table>';
        }
        if (d.polizas == 0) {
            $tabla_polizas = 'Sin pólizas asociadas';
        } else {
            $tabla_polizas =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Pólizas</th><th>Estado</th><th>Nro Póliza</th><th>Compañia</th><th>Ramo</th><th>Inicio Vigencia</th><th>Vigencia Final</th><th>Materia asegurada</th><th>Acciones</th></tr>';
            $cont_j = 0;
            for (j = 0; j < d.polizas; j++) {
                $cont_j = $cont_j + 1;
                $tabla_polizas = $tabla_polizas + '<tr><td>' + $cont_j + '</td><td><span class="' + d
                    .estado_poliza_alerta[j] + '">' + d.estado_poliza[j] + '</span></td><td>' + d
                    .numero_poliza[j] + '</td><td>' + d.compania[j] +
                    '</td><td>' + d.ramo[j] +
                    '</td><td>' + d.vigencia_inicial[j] +
                    '</td><td>' + d.vigencia_final[j] +
                    '</td><td>' + d.materia_asegurada[j] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d
                    .id_poliza[j] +
                    ' name="modifica" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-edit"></i></button></td></tr>';
            }
            $tabla_polizas = $tabla_polizas + '</table>';
        }
    }

    // `d` is the original data object for the row
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Acciones:</td>' +
        '<td><button title="Buscar información asociada" type="button" id=' + d.id_tarea +
        ' name="info" onclick="botones(this.id, this.name, \'tarea recurrente\')"><i class="fas fa-search"></i></button><a> </a><button title="Editar"  type="button" id=' +
        d.id_tarea +
        ' name="modifica" onclick="botones(this.id, this.name, \'tarea recurrente\')"><i class="fas fa-edit"></i></button><a> </a><button title="Completar tarea"  type="button" id=' +
        d.id_tarea +
        ' name="cerrar_tarea" id=' + d.id_tarea +
        ' onclick="botones(this.id, this.name, \'tarea recurrente\')"><i class="fas fa-check-circle"></i></i></button></td>' +
        '</tr>' +
        '<tr><td>Clientes:</td>' +
        '<td>' + $tabla_clientes + '</td></tr>' +
        '<tr><td>Pólizas:</td>' +
        '<td>' + $tabla_polizas + '</td></tr>' +
        '</table>';
}

function detalle_tareas(d) {
    $sin_rel = $tabla_clientes = $tabla_polizas = '';
    if (d.relaciones == 0) {
        $sin_rel = 'Tarea sin asociar a clientes  o pólizas';
        $tabla_clientes = 'Sin clientes asociados';
        $tabla_polizas = 'Sin pólizas asociadas';
    } else {
        if (d.clientes == 0) {
            $tabla_clientes = 'Sin clientes asociados';
        } else {
            $tabla_clientes =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Clientes</th><th>Nombre</th><th>Telefono</th><th>Correo Electrónico</th><th>Acciones</th></tr>';
            $cont_i = 0;
            for (i = 0; i < d.clientes; i++) {
                $cont_i = $cont_i + 1;
                $tabla_clientes = $tabla_clientes + '<tr><td>' + $cont_i + '</td><td>' + d.nombre[i] + '</td><td>' + d
                    .telefono[i] + '</td><td>' + d.correo[i] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d
                    .id_cliente[i] +
                    ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_clientes = $tabla_clientes + '</table>';
        }
        if (d.polizas == 0) {
            $tabla_polizas = 'Sin pólizas asociadas';
        } else {
            $tabla_polizas =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Pólizas</th><th>Estado</th><th>Nro Póliza</th><th>Compañia</th><th>Ramo</th><th>Inicio Vigencia</th><th>Vigencia Final</th><th>Materia asegurada</th><th>Acciones</th></tr>';
            $cont_j = 0;
            for (j = 0; j < d.polizas; j++) {
                $cont_j = $cont_j + 1;
                $tabla_polizas = $tabla_polizas + '<tr><td>' + $cont_j + '</td><td><span class="' + d
                    .estado_poliza_alerta[j] + '">' + d.estado_poliza[j] + '</span></td><td>' + d
                    .numero_poliza[j] + '</td><td>' + d.compania[j] +
                    '</td><td>' + d.ramo[j] +
                    '</td><td>' + d.vigencia_inicial[j] +
                    '</td><td>' + d.vigencia_final[j] +
                    '</td><td>' + d.materia_asegurada[j] +
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d
                    .id_poliza[j] +
                    ' name="modifica" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-edit"></i></button></td></tr>';
            }
            $tabla_polizas = $tabla_polizas + '</table>';
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
        '<tr><td>Clientes:</td>' +
        '<td>' + $tabla_clientes + '</td></tr>' +
        '<tr><td>Pólizas:</td>' +
        '<td>' + $tabla_polizas + '</td></tr>' +
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
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Deducible:</td>' +
        '<td>' + d.deducible + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Prima afecta:</td>' +
        '<td>' + d.prima_afecta + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Prima exenta:</td>' +
        '<td>' + d.prima_exenta + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Prima bruta anual:</td>' +
        '<td>' + d.prima_bruta_anual + '</td>' +
        '</tr>' +
        '</tr>' +

        '<tr>' +
        '<td>Acciones</td>' +
        '<td><button title="Buscar información asociada" type="button" id=' + d.id_poliza +
        ' name="info" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button><a> </a><button title="Editar"  type="button" id=' +
        d.id_poliza +
        ' name="modifica" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-edit"></i></button><a> </a><button title="Asignar tarea"  type="button" id=' +
        d.id_poliza +
        ' name="tarea" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-clipboard-list"></i></button><a> </a><button title="Generar correo"  type="button"' +
        'id=' + d.id_poliza +
        ' name="correo" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-envelope-open-text"></i></button><a> </a><button style="background-color: #FF0000" title="Eliminar"  type="button" id=' +
        d.id_poliza +
        ' name="elimina" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-trash-alt"></i></button></td>' +

        '</tr>' +
        '</table>';
}

function botones(id, accion, base) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "elimina": {
            if (base == 'tarea' || base == 'tarea recurrente') {
                $.redirect('/bamboo/backend/actividades/cierra_tarea.php', {
                    'id_tarea': id,
                    'accion': accion,
                }, 'post');
            }
            if (base == 'poliza') {
                var r2 = confirm("Estás a punto de eliminar está póliza ¿Deseas continuar?");
                if (r2 == true) {
                    $.redirect('/bamboo/backend/polizas/modifica_poliza.php', {
                        'id_poliza': id,
                        'accion': accion,
                    }, 'post');
                }
            }
            if (base == 'cliente') {
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
        case "modifica": {
            if (base == 'poliza') {
                $.redirect('/bamboo/creacion_poliza.php', {
                    'id_poliza': id,
                }, 'post');
            }
            if (base == 'tarea recurrente') {
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_tarea': id,
                    'tipo_tarea': 'recurrente'
                }, 'post');
            }
            if (base == 'tarea') {
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_tarea': id,
                    'tipo_tarea': 'individual'
                }, 'post');
            }
            if (base == 'cliente') {
                $.redirect('/bamboo/creacion_cliente.php', {
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
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_cliente': id
                }, 'post');
            }
            if (base == 'poliza') {
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_poliza': id
                }, 'post');
            }
            break;
        }
        case "info": {
            $.redirect('/bamboo/resumen2.php', {
                'id': id,
                'base': base
            }, 'post');
            break;
        }
        case "correo": {
            if (base == 'poliza') {
                $.redirect('/bamboo/template_poliza.php', {
                    'id_poliza': id
                }, 'post');
            }
            break;
        }
        case "cerrar_tarea": {
            if (base == 'tarea' || base == 'tarea recurrente') {
                $.redirect('/bamboo/backend/actividades/cierra_tarea.php', {
                    'id_tarea': id,
                    'accion': accion
                }, 'post');
            }
            break;
        }
    }
}
</script>