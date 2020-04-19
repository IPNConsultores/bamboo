<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
   
$lista='';
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
require_once "/home/gestio10/public_html/backend/config.php";
$num=0;

mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
$sql = "SELECT *, concat(mes,'-',SUBSTRING(anomes, 3,2)) as anomes_nombre FROM `stock_polizas` WHERE ANOMES BETWEEN ANOMES(DATE_ADD(CURRENT_DATE, INTERVAL -12 MONTH)) AND ANOMES(DATE_ADD(CURRENT_DATE, INTERVAL + 6 MONTH))";
    $resultado=mysqli_query($link, $sql);

    $leyendas = $stock=$salidas=$entradas=$ramo=$cantidad=array();
While($row=mysqli_fetch_object($resultado))
  {
      if($row->anomes==date("Ym")){
      array_push($leyendas," (actual) --> ".$row->anomes_nombre);          
      }else{
      array_push($leyendas,$row->anomes_nombre );
      }
      
      array_push($stock,$row->stock );
      array_push($entradas,$row->entradas );
      array_push($salidas,$row->salidas );
  }
  
$resultado2=mysqli_query($link, "SELECT ramo, count(*) as cantidad FROM `polizas` where estado='Abierto' group by ramo order by count(*) desc");
While($row2=mysqli_fetch_object($resultado2))
  {
      array_push($ramo,$row2->ramo );
      array_push($cantidad,$row2->cantidad );
  }







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
    <link rel="stylesheet" href="/assets/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" />

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>


<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <canvas id="myChart" width="400" height="100"></canvas><br>
        <hr>
        <canvas id="torta" width="400" height="100" class="chartjs-render-monitor"></canvas>
        <hr><br>
        <p> Resumen de tareas <br></p>
        <br>
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne" style="background-color:whitesmoke">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne" style="color:#536656">Tareas y
                            compromisos</button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <table class="display" id="listado_tareas" style="width:100%">
                            <tr>
                                <th></th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Tarea</th>
                                <th>Fecha vencimiento</th>
                                <th>Fecha creación tarea</th>
                                <th>id tarea</th>
                            </tr>
                        </table>
                        <div id="botones_tareas"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo" style="background-color:whitesmoke">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"
                            style="color:#536656">Pólizas próximas a vencer</button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <table class="display" style="width:100%" id="listado_polizas">
                            <tr>
                                <th></th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Tarea</th>
                                <th>Fecha vencimiento</th>
                                <th>póliza asociada</th>
                                <th>Cliente asociado</th>
                            </tr>
                        </table>
                        <div id="botones_poliza"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    </script>
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
    <br>
    <br>
</body>

</html>
<script>
$(document).ready(function() {
    table_tareas = $('#listado_tareas').DataTable({

        "ajax": "/bamboo/backend/actividades/busqueda_listado_tareas.php",
        "scrollX": true,
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
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
                "data": "id_tarea"
            }

        ],
        //          "search": {
        //          "search": "abarca"
        //          },

        "columnDefs": [{
            "targets": [6],
            "visible": false,
        }],
        "order": [
            [1, "asc"],
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
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
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
    var dd = new Date();
    var fecha = '' + dd.getFullYear() + '-' + (("0" + (dd.getMonth() + 1)).slice(-2)) + '-' + (("0" + (dd
        .getDate() + 1)).slice(-2)) + ' (' + dd.getHours() + dd.getMinutes() + dd.getSeconds() + ')';

    var buttons = new $.fn.dataTable.Buttons(table_tareas, {
        buttons: [{
                sheetName: 'Clientes',
                orientation: 'landscape',
                extend: 'excelHtml5',
                filename: 'Listado clientes al: ' + fecha,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8]
                }
            },
            {
                orientation: 'landscape',
                extend: 'pdfHtml5',
                filename: 'Listado clientes al: ' + fecha,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8]
                }
            }
        ]
    }).container().appendTo($('#botones_tareas'));

    table_poliza = $('#listado_polizas').DataTable({
        "ajax": "/bamboo/backend/polizas/busqueda_listado_polizas.php",
        "scrollX": true,
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            },

            /*
            compania: "Renta"
vigencia_final: "2020-10-15"
numero_poliza: "1013134-2"
materia_asegurada: "Unidades (comercial)"
poliza: null
patente_ubicacion: "Diagonal pje Matte 956 -957 Santiago"
cobertura: "INC + SISMO "
nom_clienteP: "Comunidad Edificio Diagonal Pje Matte  "
rut_clienteP: "56005300-2"
telefonoP: "5699876639"
correoP: "correodeprueba@bamboo.cl"
nom_clienteA: "Comunidad Edificio Diagonal Pje Matte  "
rut_clienteA: "56005300-2"
telefonoA: "5699876639"
correoA: "correodeprueba@bamboo.cl"
            */
            {
                "data": "numero_poliza",
                title: "Nro Póliza"
            },
            {
                "data": "compania",
                title: "Compañía"
            },
            {
                "data": "cobertura",
                title: "Cobertura"
            },
            {
                "data": "vigencia_final",
                title: "Vigencia Final"
            },
            {
                "data": "materia_asegurada",
                title: "Materia asegurada"
            },
            {
                "data": "patente_ubicacion",
                title: "Observaciones materia asegurada"
            }

        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "order": [

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
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
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
    $('#listado_polizas tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_poliza.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detalle_polizas(row.data())).show();
            tr.addClass('shown');
        }
    });
    var dd = new Date();
    var fecha = '' + dd.getFullYear() + '-' + (("0" + (dd.getMonth() + 1)).slice(-2)) + '-' + (("0" + (dd
        .getDate() + 1)).slice(-2)) + ' (' + dd.getHours() + dd.getMinutes() + dd.getSeconds() + ')';

    var buttons = new $.fn.dataTable.Buttons(table_poliza, {
        buttons: [{
                sheetName: 'Clientes',
                orientation: 'landscape',
                extend: 'excelHtml5',
                filename: 'Listado clientes al: ' + fecha,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                orientation: 'landscape',
                extend: 'pdfHtml5',
                filename: 'Listado clientes al: ' + fecha,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7]
                }
            }
        ]
    }).container().appendTo($('#botones_poliza'));
});

function detalle_tareas(d) {
    $sin_rel=$tabla_clientes=$tabla_polizas='';
    if (d.relaciones == 0) {
        $sin_rel= '<div><span>Tarea sin asociar a clientes  o pólizas</span></div>';
    } else {
        if (d.clientes == 0) {
            $tabla_clientes = '<div><span>Tarea sin asociar a clientes</span></div>';
        } else {
            $tabla_clientes =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Clientes</th><th>Nombre</th><th>Telefono</th><th>Correo Electrónico</th><th>Acciones</th></tr>';
            for (i = 0; i < d.clientes; i++) {
                $tabla_clientes = $tabla_clientes + '<tr><td>' + i+1 + '</td><td>' + d.nombre[i] + '</td><td>' + d
                    .telefono[i] + '</td><td>' + d.correo[i] +
                    '</td><td><button title="Busca toda la información asociada a este cliente" type="button" id=' + d
                    .id_cliente[i] +
                    ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_clientes = $tabla_clientes + '</table>';
        }
        if (d.polizas == 0) {
            $tabla_polizas = '<div><span>Tarea sin asociar a pólizas</span></div>';
        } else {
            $tabla_polizas =
                '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
                '<tr><th># Pólizas</th><th>Estado</th><th>Nro Póliza</th><th>Compañia</th><th>Ramo</th><th>Inicio Vigencia</th><th>Vigencia Final</th><th>Materia asegurada</th><th>Acciones</th></tr>';
            for (j = 0; j < d.polizas; j++) {
                $tabla_polizas = $tabla_polizas + '<tr><td>' + j+1 + '</td><td>' + d.estado_poliza[j] + '</td><td>' + d
                    .numero_poliza[j] + '</td><td>' + d.compania[j] +
                    '</td><td>' + d.ramo[j] +
                    '</td><td>' + d.vigencia_inicial[j] +
                    '</td><td>' + d.vigencia_final[j] +
                    '</td><td>' + d.materia_asegurada[j] +
                    '</td><td><button title="Busca toda la información asociada a esta póliza" type="button" id=' + d
                    .id_poliza[j] +
                    ' name="info" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_polizas = $tabla_polizas + '</table>';
        }
    }

    // `d` is the original data object for the row
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Acciones:</td>' +
        '<td><button title="Busca toda la información asociada a esta tarea" type="button" id=' + d.id_tarea +
        ' name="info" onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id=' +
        d.id_tarea +
        ' name="modifica" onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina este cliente"  type="button" id=' +
        d.id_tarea +
        ' name="elimina" onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-trash-alt"></i></button><a> </a><button title="Marca tarea como completada"  type="button" id=' +
        d.id_tarea +
        ' name="cerrar_tarea" id=' + d.id_tarea +
        ' onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-check-circle"></i></i></button></td>' +
        '</tr>' +
        '<tr><td>Clientes:</td>'+
        '<td>'+ $tabla_clientes+'</td></tr>'+
        '<tr><td>Pólizas:</td>'+
        '<td>'+$tabla_polizas+'</td></tr>'+
        '</table>';
}

function detalle_polizas(d) {
    return '  <table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">' +
        '<tr><th></th><th>Proponiente</th><th>Asegurado</th></tr>' +
        '<tr><td>Nombre</td><td>' + d.nom_clienteP + '</td><td>' + d.nom_clienteA + '</td></tr>' +
        '<tr><td >Rut</td><td>' + d.rut_clienteP + '</td><td>' + d.rut_clienteA + '</td></tr>' +
        '<tr><td>Teléfono</td><td>' + d.telefonoP + '</td><td>' + d.telefonoA + '</td></tr>' +
        '<tr><td>Correo</td><td>' + d.correoP + '</td><td>' + d.correoA + '</td></tr>' +
        '<tr><td>Acciones por cliente</td><td>' +
        '<button title="Busca toda la información asociada a este cliente" type="button" id=' + d.idP +
        ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-search"></i></button><a> </a>' +
        '<a> </a><button title="Asigna una tarea o comentario"  type="button" id=' +
        d.idP +
        ' name="tarea" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-clipboard-list"></i></button>' +
        '</td><td>' +
        '<button title="Busca toda la información asociada a este cliente" type="button" id=' + d.idA +
        ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-search"></i></button><a> </a>' +
        '<a> </a><button title="Asigna una tarea o comentario"  type="button" id=' +
        d.idA +
        ' name="tarea" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-clipboard-list"></i></button>' +
        '</td></tr>' +
        '<tr><td>Acciones por póliza</td><td colspan="2" >' +
        '<button title="Busca toda la información asociada a este cliente" type="button" id=' + d.id_poliza +
        ' name="info" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id=' +
        d.id_poliza +
        ' name="modifica" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina este cliente"  type="button" id=' +
        d.id_poliza +
        ' name="elimina" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-trash-alt"></i></button><a> </a><button title="Asigna una tarea o comentario"  type="button"' +
        'id=' + d.id_poliza +
        ' name="tarea" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-clipboard-list"></i></button><a> </a><button title="genera correo"  type="button"' +
        'id=' + d.id_poliza +
        ' name="correo" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-envelope-open-text"></i></button>' +
        '</td></tr>' +
        '</table>'
}

function botones(id, accion, base) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "elimina": {
            console.log(base + " eliminado con ID:" + id);
            $.notify({
                // options
                message: base + ' modificado'
            }, {
                // settings
                type: 'danger'
            });
            break;
        }
        case "modifica": {
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
            if (base == 'cliente') {
                $.redirect('/bamboo/resumen.php', {
                    'id_cliente': id
                }, 'post');
            }
            if (base == 'poliza') {
                $.redirect('/bamboo/resumen.php', {
                    'id_poliza': id
                }, 'post');
            }
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
            if (base == 'tarea') {
            }
            break;
        }
    }
}

var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: genera_data('leyendas'),
        datasets: [{
            label: 'Pólizas activas',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            borderColor: 'rgb(255, 99, 132)',
            data: genera_data('stock')
        }]
    },

    // Configuration options go here
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    min: 0
                }
            }]
        }
    }
});

var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};
var ctx2 = document.getElementById('torta').getContext('2d');
var myDoughnutChart = new Chart(ctx2, {
    type: 'pie',
    data: {
        datasets: [{
            data: <?php echo json_encode($cantidad);?> ,
            backgroundColor : ["rgb(255, 99, 132)",
                "rgb(54, 162, 235)",
                "rgb(255, 205, 86)",
                "rgb(200, 205, 86)", "rgb(155, 205, 86)", "rgb(105, 205, 86)", "rgb(55, 205, 86)",
                "rgb(0, 205, 86)", "rgb(0, 155, 86)", "rgb(0, 105, 86)"
            ],

            label: 'Ramo'
        }],
        labels: <?php echo json_encode($ramo);?>
    },
    options: {
        responsive: true,
        legend: {
            position: 'left',
        },
        title: {
            display: true,
            text: 'Distribución de pólizas por ramo'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
});

function genera_data(data) {
    switch (data) {
        case 'stock': {
            var arreglo = <?php echo json_encode($stock);?>;
            return arreglo;
            break;
        }
        case 'salidas': {
            var arreglo = <?php echo json_encode($salidas);?>;
            return arreglo;
            break;
        }
        case 'entradas': {
            var arreglo = <?php echo json_encode($entradas);?>;
            return arreglo;
            break;
        }
        case 'leyendas': {
            var arreglo = <?php echo json_encode($leyendas);?>;
            return arreglo;
            break;
        }
    }
}
</script>