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

</head>


<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Resumen de tareas <br>
        </p>
        <br>
    </div>

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
                    <table class="display" width="100%" id="listado_tareas">
                        <tr>
                            <th></th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Tarea</th>
                            <th>Fecha vencimiento</th>
                            <th>póliza asociada</th>
                            <th>Cliente asociado</th>
                            <th>Rut Cliente</th>
                            <th>Teléfono</th>
                            <th>e-Mail</th>
                            <th>id tarea</th>
                        </tr>
                    </table>
                    <div id="botones"></div>
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
                    <table class="table" id="listado_tareas1">
                        <tr>
                            <th></th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Tarea</th>
                            <th>Fecha vencimiento</th>
                            <th>póliza asociada</th>
                            <th>Cliente asociado</th>
                            <th>Rut Cliente</th>
                            <th>Teléfono</th>
                            <th>e-Mail</th>
                            <th>id tarea</th>
                        </tr>
                    </table>
                    <div id="botones"></div>
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
</body>

</html>
<script>
$(document).ready(function() {
    table = $('#listado_tareas').DataTable({

        "ajax": "/bamboo/backend/actividades/busqueda_listado_tareas.php",
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            },
            {
                "data": "prioridad", title:"Prioridad" 
            },
            {
                "data": "estado", title:"Estado" 
            },
            {
                "data": "tarea", title:"Tarea o Actividad" 
            },
            {
                "data": "fecha_vencimiento" , title:"Fecha vencimiento" 
            },
            {
                "data": "poliza", title:"Nro Póliza" 
            },
            {
                "data": "nom_cliente", title:"Nombre cliente" 
            },
            {
                "data": "rut_cliente", title:"Rut cliente" 
            },
            {
                "data": "telefono", title:"Teléfono" 
            },
            {
                "data": "correo", title:"e-Mail" 
            },
            {
                "data": "id_tarea"
            }

        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "columnDefs": [{
            "targets": [7, 8, 9, 10],
            "visible": false,
        }],
        "order": [

            [2, "desc"],
            [4, "asc"],
            [1, "asc"]
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
    var dd = new Date();
    var fecha = '' + dd.getFullYear() + '-' + (("0" + (dd.getMonth() + 1)).slice(-2)) + '-' + (("0" + (dd
        .getDate() + 1)).slice(-2)) + ' (' + dd.getHours() + dd.getMinutes() + dd.getSeconds() + ')';

    var buttons = new $.fn.dataTable.Buttons(table, {
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
    }).container().appendTo($('#botones'));
});

function format(d) {
    // `d` is the original data object for the row
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Rut:</td>' +
        '<td>' + d.rut_cliente+ '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Correo electrónico:</td>' +
        '<td>' + d.correo+ '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Teléfono:</td>' +
        '<td>' + d.telefono + '</td>' +
        '</tr>' +

        '<tr>' +
        '<td>Acciones</td>' +
        '<td><button title="Busca toda la información asociada a este cliente" type="button" id=' + d.id +
        ' name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id=' +
        d.id +
        ' name="modifica" onclick="botones(this.id, this.name)"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina este cliente"  type="button" id=' +
        d.id +
        ' name="elimina" onclick="botones(this.id, this.name)"><i class="fas fa-trash-alt"></i></button><a> </a><button title="Asigna una tarea o comentario"  type="button" id=' +
        d.id +
        ' name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button></td>' +

        '</tr>' +
        '</table>';
}
</script>