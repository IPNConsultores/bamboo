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
                <table class="display" width="100%" id="listado_polizas">
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
    table_tareas = $('#listado_tareas').DataTable({

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
                "data": "numero_poliza", title:"Nro Póliza" 
            },
            {
                "data": "compania", title:"Compañía" 
            },
            {
                "data": "cobertura", title:"Cobertura" 
            },
            {
                "data": "vigencia_final" , title:"Vigencia Final" 
            },
            {
                "data": "materia_asegurada", title:"Materia asegurada" 
            },
            {
                "data": "patente_ubicacion", title:"Observaciones materia asegurada" 
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
function test(d) {
    // `d` is the original data object for the row
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Rut Proponiente:</td>' +
        '<td>' + d.rut_clienteP+ '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Correo electrónico:</td>' +
        '<td>' + d.correop+ '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Teléfono:</td>' +
        '<td>' + d.telefonop + '</td>' +
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
        ' name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button>'+
        '</td>' +

        '</tr>' +
        '</table>';
}
function detalle_polizas(d){
  return '  <table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">'+
        '<tr><th></th><th>Proponiente</th><th>Asegurado</th></tr>'+
        '<tr><td>Nombre</td><td>'+d.nom_clienteP+'</td><td>'+d.nom_clienteA+'</td></tr>'+
        '<tr><td >Rut</td><td>'+d.rut_clienteP+'</td><td>'+d.rut_clienteA+'</td></tr>'+
        '<tr><td>Teléfono</td><td>'+d.telefonoP+'</td><td>'+d.telefonoA+'</td></tr>'+
        '<tr><td>Correo</td><td>'+d.correoP+'</td><td>'+d.correoA+'</td></tr>'+
        '<tr><td>Acciones por cliente</td><td>'+
        '<button title="Busca toda la información asociada a este cliente" type="button" id=' + d.idP +
        ' name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a>'+
        '<a> </a><button title="Asigna una tarea o comentario"  type="button" id=' +
        d.idP +
        ' name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button>'+
        '</td><td>'+
        '<button title="Busca toda la información asociada a este cliente" type="button" id=' + d.idA +
        ' name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a>'+
        '<a> </a><button title="Asigna una tarea o comentario"  type="button" id=' +
        d.idA +
        ' name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button>'+
        '</td></tr>'+
        '<tr><td>Acciones por póliza</td><td colspan="2" >'+
        '<button title="Busca toda la información asociada a este cliente" type="button" id=' + d.id_poliza +
        ' name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id=' +
        d.id_poliza +
        ' name="modifica" onclick="botones(this.id, this.name)"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina este cliente"  type="button" id=' +
        d.id_poliza +
        ' name="elimina" onclick="botones(this.id, this.name)"><i class="fas fa-trash-alt"></i></button><a> </a><button title="Asigna una tarea o comentario"  type="button" id=' +
        d.id_poliza +
        ' name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button>'+
        '</td></tr>'+
        '</table>'
}
function botones(id, accion) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "elimina": {
            console.log("Cliente/poliza eliminado con ID:" + id);
            $.notify({
                // options
                message: 'Cliente/poliza modificado'
            }, {
                // settings
                type: 'danger'
            });
            break;
        }
        case "modifica": {
            console.log("Cliente/poliza modificado con ID:" + id);
            $.notify({
                // options
                message: 'Cliente/poliza modificado'
            }, {
                // settings
                type: 'success'
            });
            break;
        }
        case "tarea": {
            console.log("Asignar tarea a ID:" + id);
            $.notify({
                // options
                message: 'Tarea Asignada'
            }, {
                // settings
                type: 'warning'
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