<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$buscar='';
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
require_once "/home/gestio10/public_html/backend/config.php";
$num=0;
 $busqueda=$busqueda_err=$data=$id_tarea='';
 $rut=$nombre=$telefono=$correo=$lista='';

 if($_SERVER["REQUEST_METHOD"] == "GET" and isset($_GET["tarea"])==true){
    // Check if username is empty
//$('#listado_clientes').dataTable().fnFilter(\"".estandariza_info($_POST["busqueda"])."\")
$id_tarea= estandariza_info($_GET["tarea"]);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/bamboo/images/bamboo.png">
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
</head>


<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header.php' ?></div>
    <div class="container">
        <p> Tareas / Listado de tareas recurrentes <br>
        </p>
        <br>
        <div class="container">
  <table class="table" id="tareas_completas" style="width:100%">
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
                        <div id="botones_tareas"></div>
        </div>
    </div>


    <div id="auxiliar" style="display: none;">
        <input id="var1" value="<?php 
        echo htmlspecialchars($buscar);?>">
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
</body>

</html>
<script>

$(document).ready(function() {
    table_tareas = $('#tareas_completas').DataTable({

        "ajax": "/bamboo/backend/actividades/busqueda_listado_tareas_recurrentes.php",
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
                "data":"dia_recordatorio",
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
                "data":"nombre[]",
                title: "Clientes asociados"
            },
                        {
                "data":"numero_poliza[]",
                title: "Pólizas asociados"
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
    $("#tareas_completas_filter input")
    .off()
    .on('keyup change', function (e) {
    if (e.keyCode !== 13 || this.value == "") {
        var texto2=this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
         table_tareas.search(texto2).draw();
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
                sheetName: 'Tareas recurrente',
                orientation: 'landscape',
                extend: 'excelHtml5',
                filename: 'Listado tareas recurrentes al: ' + fecha,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6,7,8,9]
                }
            },
            {
                orientation: 'landscape',
                extend: 'pdfHtml5',
                filename: 'Listado tareas recurrentes al: ' + fecha,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6,7,8,9]
                }
            }
        ]
    }).container().appendTo($('#botones_tareas'));
    var busqueda_tarea= '<?php echo $id_tarea;?>';
    if (busqueda_tarea==''){}
    else{
     table_tareas.column(1).search(busqueda_tarea).draw();
    }
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
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d
                    .id_cliente[i] +
                    ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-edit"></i></button></td></tr>';
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
                    '</td><td><button title="Buscar información asociada" type="button" id=' + d
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
        '</table>';
}


function botones(id, accion, base) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "elimina": {            
            if (base == 'tarea') {
                $.redirect('/bamboo/backend/actividades/cierra_tarea.php', {
                    'id_tarea': id,
                    'accion':accion
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
                'id_poliza': id
                }, 'post');
            }
            if (base == 'tarea') {
                $.redirect('/bamboo/creacion_actividades.php', {
                'id_tarea': id,
                'tipo_tarea':'recurrente'
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
            if (base == 'tarea') {
                $.redirect('/bamboo/backend/actividades/cierra_tarea.php', {
                    'id_tarea': id,
                    'accion':accion
                }, 'post');
            }
            break;
        }
    }
}
(function(){
 
 function removeAccents ( data ) {
     if ( data.normalize ) {
         // Use I18n API if avaiable to split characters and accents, then remove
         // the accents wholesale. Note that we use the original data as well as
         // the new to allow for searching of either form.
         return data +' '+ data
             .normalize('NFD')
             .replace(/[\u0300-\u036f]/g, '');
     }
  
     return data;
 }
  
 var searchType = jQuery.fn.DataTable.ext.type.search;
  
 searchType.string = function ( data ) {
     return ! data ?
         '' :
         typeof data === 'string' ?
             removeAccents( data ) :
             data;
 };
  
 searchType.html = function ( data ) {
     return ! data ?
         '' :
         typeof data === 'string' ?
             removeAccents( data.replace( /<.*?>/g, '' ) ) :
             data;
 };
  
 }());
</script>