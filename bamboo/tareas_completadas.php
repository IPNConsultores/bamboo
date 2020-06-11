<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tareas Completadas</title>
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
  <p>Tareas / Tareas Completadas<br>
  </p>
  <h5 class="form-row">&nbsp;Tareas Completadas</h5>
  <br>
  <br>
  <div class="form">
  
  <table class="table" id="tareas_completas" style="width:100%">
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
<br>
<br>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
<script src="/assets/js/jquery.redirect.js"></script>
<script src="/assets/js/validarRUT.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>
</html>
<script>

$(document).ready(function() {
    table_tareas = $('#tareas_completas').DataTable({

        "ajax": "/bamboo/backend/actividades/busqueda_listado_tareas_completas.php",
        "scrollX": true,
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
            }

        ],
        //          "search": {
        //          "search": "abarca"
        //          },

        "columnDefs": [
        {
        targets: 3,
        render: function (data, type, row, meta) {
             var estado='';
            switch (data) {
                        case 'Activo':
                            estado='<span class="badge badge-warning">'+data+'</span>';
                            break;
                        case 'Completado':
                                estado='<span class="badge badge-dark">'+data+'</span>';
                                break;
                        case 'Atrasado':
                            estado='<span class="badge badge-danger">'+data+'</span>';
                            break;
                        default:
                            estado='<span class="badge badge-light">'+data+'</span>';
                            break;
                    }
          return estado;  //render link in cell
        }}],
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
    $('#tareas_completas tbody').on('click', 'td.details-control', function() {
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
                    columns: [1, 2, 3, 4, 5, 6]
                }
            },
            {
                orientation: 'landscape',
                extend: 'pdfHtml5',
                filename: 'Listado clientes al: ' + fecha,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                }
            }
        ]
    }).container().appendTo($('#botones_tareas'));

     table = $('#listado_polizas').DataTable({
        "ajax": "/bamboo/backend/polizas/busqueda_listado_polizas.php",
        "scrollX": true,
        "searchPanes":{
            "columns":[2,3,13,14],
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
            }


        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "columnDefs": [{
                "targets": [10, 11, 12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41],
                "visible": false,
            },
            {
                "targets": [10, 11, 12,13,14,15,16,17,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41],
                "searchable": false
            },
            {
                "searchPanes": {
                    "preSelect":['Activo'],
                },
                "targets":[1],
            },
            {
        targets: 1,
        render: function (data, type, row, meta) {
             var estado='';
            switch (data) {
                        case 'Activo':
                            estado='<span class="badge badge-primary">'+data+'</span>';
                            break;
                        case 'Cerrado':
                                estado='<span class="badge badge-dark">'+data+'</span>';
                                break;
                        case 'Atrasado':
                            estado='<span class="badge badge-danger">'+data+'</span>';
                            break;
                        default:
                            estado='<span class="badge badge-light">'+data+'</span>';
                            break;
                    }
          return estado;  //render link in cell
        }}
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
    $('#listado_polizas tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

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
    //$('#listado_polizas').dataTable().fnFilter('Activo');
    table.search( 'Activo').draw();
    
    var dd = new Date();
    var fecha = '' + dd.getFullYear() + '-' + (("0" + (dd.getMonth() + 1)).slice(-2)) + '-' + (("0" + (dd
        .getDate() + 1)).slice(-2)) + ' (' + dd.getHours() + dd.getMinutes() + dd.getSeconds() + ')';

    var buttons2 = new $.fn.dataTable.Buttons(table, {
        buttons2: [{
                sheetName: 'Pólizas',
                orientation: 'landscape',
                extend: 'excelHtml5',
                filename: 'Listado Pólizas al: ' + fecha,
                exportOptions: {
                    columns: [1,18,19,20,21,22,3,5,6,14,8,4,2,7,9,17,16,10,11,12,41,13,24,25,26,27,28,29,30,31,33,32,34,35,23,37,38,39,40]
                }
            },
            {
                orientation: 'landscape',
                extend: 'pdfHtml5',
                filename: 'Listado Pólizas al: ' + fecha,
                exportOptions: {
                    columns: [1,18,19,20,21,22,3,5,6,14,8,4,2,7,9,17,16,10,11,12,41,13,24,25,26,27,28,29,30,31,33,32,34,35,23,37,38,39,40]
                }
            }
        ]
    }).container().appendTo($('#botones_poliza'));
});

function detalle_tareas(d) {
    $sin_rel=$tabla_clientes=$tabla_polizas='';
    if (d.relaciones == 0) {
        $sin_rel= 'Tarea sin asociar a clientes  o pólizas';
        $tabla_clientes = 'Sin clientes asociados';
        $tabla_polizas = 'Sin pólizas asociadas';
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
                $tabla_clientes = $tabla_clientes + '<tr><td>' + $cont_i + '</td><td>' + d.nombre[i] + '</td><td>' + d
                    .telefono[i] + '</td><td>' + d.correo[i] +
                    '</td><td><button title="Busca toda la información asociada a este cliente" type="button" id=' + d
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
                $cont_j=0;
            for (j = 0; j < d.polizas; j++) {
                $cont_j=$cont_j+1;
                $tabla_polizas = $tabla_polizas + '<tr><td>' + $cont_j + '</td><td><span class="'+d.estado_poliza_alerta[j]+'">'+d.estado_poliza[j]+'</span></td><td>' + d
                    .numero_poliza[j] + '</td><td>' + d.compania[j] +
                    '</td><td>' + d.ramo[j] +
                    '</td><td>' + d.vigencia_inicial[j] +
                    '</td><td>' + d.vigencia_final[j] +
                    '</td><td>' + d.materia_asegurada[j] +
                    '</td><td><button title="Busca toda la información asociada a esta póliza" type="button" id=' + d
                    .id_poliza[j] +
                    ' name="modifica" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button></td></tr>';
            }
            $tabla_polizas = $tabla_polizas + '</table>';
        }
    }

    // `d` is the original data object for the row
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Acciones:</td>' +
        '<td><button title="Busca toda la información asociada a esta tarea" type="button" id=' + d.id_tarea +
        ' name="info" onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de esta tarea"  type="button" id=' +
        d.id_tarea +
        ' name="modifica" onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina esta tarea"  type="button" id=' +
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
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Deducible:</td>' +
        '<td>' + d.deducible +'</td>' +
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
        '<td><button title="Busca toda la información asociada a esta póliza" type="button" id=' + d.id_poliza +
        ' name="info" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de esta póliza"  type="button" id=' +
        d.id_poliza +
        ' name="modifica" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-edit"></i></button><a> </a><button title="Asigna una tarea a esta póliza"  type="button" id=' +
        d.id_poliza +
        ' name="tarea" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-clipboard-list"></i></button><a> </a><button title="genera correo"  type="button"' +
        'id='+ d.id_poliza +
        ' name="correo" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-envelope-open-text"></i></button></td>' +

        '</tr>' +
        '</table>';
}

function botones(id, accion, base) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "elimina": {            
            if (base == 'tarea') {
                $.redirect('/bamboo/backend/actividades/cierra_tarea.php', {
                    'id_tarea': id,
                    'accion':accion,
                }, 'post');
            }
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
            if (base == 'poliza') {
                $.redirect('/bamboo/creacion_poliza.php', {
                'id_poliza': id,
                }, 'post');
            }
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
            if (base == 'tarea') {
                $.redirect('/bamboo/resumen.php', {
                    'id_tarea': id
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
                $.redirect('/bamboo/backend/actividades/cierra_tarea.php', {
                    'id_tarea': id,
                    'accion':accion,
                }, 'post');
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

function valida_rut_duplicado_prop() {
    var dato = $('#rutprop').val();
    var rut_sin_dv = dato.replace('-', '');
    rut_sin_dv = rut_sin_dv.slice(0, -1);
    $.ajax({
        type: "POST",
        url: "/bamboo/backend/clientes/busqueda_nombre.php",
        data: {
            rut: rut_sin_dv
        },
        dataType: 'JSON',
        success: function(response) {
            if (response.resultado == 'antiguo') {
                document.getElementById("nombre_prop").value = response.nombre;
                document.getElementById("apellidop_prop").value = response.apellidop;
                document.getElementById("apellidom_prop").value = response.apellidom;
            }
        }

    });


}

function valida_rut_duplicado_aseg() {

    var dato = $('#rutaseg').val();
    var rut_sin_dv = dato.replace('-', '');
    rut_sin_dv = rut_sin_dv.slice(0, -1);
    $.ajax({
        type: "POST",
        url: "/bamboo/backend/clientes/busqueda_nombre.php",
        data: {
            rut: rut_sin_dv
        },
        dataType: 'JSON',
        success: function(response) {
            if (response.resultado == 'antiguo') {
                document.getElementById("nombre_seg").value = response.nombre;
                document.getElementById("apellidop_seg").value = response.apellidop;
                document.getElementById("apellidom_seg").value = response.apellidom;
            }
        }

    });
}


var table = $('#listado_polizas').DataTable({
    "ajax": "/bamboo/backend/polizas/busqueda_listado_polizas.php",
    "scrollX": true,
    "searchPanes": {
        "columns": [2, 3, 8,9],
    },
    "dom": 'Pfrtip',
    "columns": [{
            "className": 'details-control',
            "orderable": false,
            "data": "id_poliza",
            "render": function(data, type, full, meta) {
                return '<button type="button" id="' + data +
                    '" onclick="renovar_poliza(this.id)" class="btn btn-outline-primary">Crear Endoso</button>';
            }
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
            "data": "patente_ubicacion",
            title: "Observaciones materia asegurada"
        },
        {
            "data": "nom_clienteP",
            title: "Nombre proponente"
        },
        {
            "data": "nom_clienteA",
            title: "Nombre asegurado"
        }    
    ],
    //          "search": {
    //          "search": "abarca"
    //          },
    "columnDefs": [{
            "targets": [9, 10],
            "visible": false,
        },
        {
            "targets": [5,6],
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
                    case 'Cerrado':
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
        "sInfoFiltered": "(_TOTAL_ registros de _MAX_ registros totales)",
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
var tabla_clientes = $('#listado_clientes').DataTable({

    "ajax": "/bamboo/backend/clientes/busqueda_listado_clientes.php",
    "scrollX": true,
    "columns": [{
            "className": 'details-control',
            "orderable": false,
            "data": "rut",
            "render": function(data, type, full, meta) {
                return '<button type="button" id="' + data +
                    '" onclick="seleccion_rut(this.id)" class="btn btn-outline-primary">Seleccionar</button>';
            }
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
            "data": "apellidop"
        }

    ],
    "columnDefs": [{
            "targets": [5],
            "visible": false,
        },
        {
            "targets": [5],
            "searchable": false
        }
    ],
    "order": [
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
var origen = '';

function origen_busqueda(origen_boton) {
    origen = origen_boton;
}


function renovar_poliza(poliza) {
    console.log(poliza);
    $('#modal_poliza').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
      $.redirect('/bamboo/test2_cesar.php', {
  'id_poliza': poliza,
  'renovar':true
}, 'post');
}
document.addEventListener("DOMContentLoaded", function(event) {
    var orgn='<?php echo $camino; ?>';
    switch  (orgn){
        case 'modificar':{
            break;
        }
            case 'renovar':{
            
            document.getElementById("poliza_seleccionada").value =  '<?php echo $nro_poliza; ?>';
        
            break;
        }
    }
  });


</script>