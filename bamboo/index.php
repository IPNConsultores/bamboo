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
mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
$num=0;

mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
$sql = "SELECT *, concat_ws('-',mes,SUBSTRING(anomes, 3,2)) as anomes_nombre FROM `stock_polizas` WHERE ANOMES BETWEEN ANOMES(DATE_ADD(CURRENT_DATE, INTERVAL -12 MONTH)) AND ANOMES(DATE_ADD(CURRENT_DATE, INTERVAL + 6 MONTH))";
    $resultado=mysqli_query($link, $sql);

    $leyendas = $stock=$salidas=$entradas=$ramo=$porcentaje=$cantidad=array();
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
  
$resultado2=mysqli_query($link, "SELECT b.ramo_agrupado AS ramo, COUNT(a.ramo) AS cantidad, CONCAT(FORMAT((COUNT(a.ramo) / (SELECT COUNT(*) FROM polizas_2 WHERE estado NOT IN ('Cancelado', 'Anulado'))) * 100, 1), '%') AS porcentaje_total FROM polizas_2 AS a LEFT JOIN ramos_agrupados AS b ON a.ramo = b.ramo WHERE estado NOT IN ('Cancelado', 'Anulado') GROUP BY b.ramo_agrupado ORDER BY COUNT(a.ramo) DESC");
While($row2=mysqli_fetch_object($resultado2))
  {
      array_push($ramo,$row2->ramo );
      array_push($cantidad,$row2->cantidad );
      array_push($porcentaje,$row2->porcentaje_total );
  }
  mysqli_close($link);
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>


<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <canvas id="myChart" width="400" height="100"></canvas><br>
        <hr>
        <canvas id="myChart2" width="400" height="100"></canvas><br>
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
                            compromisos activos</button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <table class="display" id="listado_tareas" style="width:100%">
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
                        <div id="botones_tareas"></div>
                                
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo" style="background-color:whitesmoke">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"
                            style="color:#536656">Pólizas con pronto vencimiento</button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="form-inline">
                            <label> Revisar vencimientos de los próximos</label>
                            <div class="col-1">
                                <select class="form-control" name="busqueda_dias" id="busqueda_dias">
                                    <option value=5>5 días</option>
                                    <option value=10>10 días</option>
                                    <option value=20>20 días</option>
                                    <option value=30>30 días</option>
                                    <option value=45 selected>45 días</option>
                                    <option value=60>60 días</option>
                                    <option value=90>90 días</option>
                                    
                                </select>
                            </div>
                        </div>
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
                    </tr>

            </table>
            <div id="botones_poliza">
            <button title="Descargar_excel_polizas" id="boton_descarga_excel" type="button"  onclick="descarga_excel();">Descargar Excel <i class="fas fa-file-excel"></i></button>
            </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- <div id="auxiliar" style="display:none" > 
    -->
    <div id="auxiliar" style="display:none">
      <input name="fec_min" id="fec_min"  >
      <input name="fec_max" id="fec_max">
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
 
    <br>
    <br>
</body>

</html>
<script>
function formateoFechas(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year,month,day].join('-');
}

$(document).ready(function() {
    var inicio=new Date();
    var fin=inicio.setDate(inicio.getDate() + 45);
    document.getElementById("fec_min").value=formateoFechas(new Date());
    document.getElementById("fec_max").value=formateoFechas(fin);
  var   table_tareas = $('#listado_tareas').DataTable({

        "ajax": "/bamboo/backend/actividades/busqueda_listado_tareas.php",
        "scrollX": false,
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
                "data":"procedimiento",
                title: "Tipo creación"
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

        "columnDefs": [{
                "targets": [6],
                "visible": false
            },
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
            }
        },
        {
        targets: [5,6],
         render: function(data, type, full)
         {
             if (type == 'display')
                 return moment(data).format('DD/MM/YYYY');
             else
                 return moment(data).format('YYYY/MM/DD');
         }}
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
    .on('keyup change', function (e) {
    if (e.keyCode !== 13 || this.value == "") {
        var texto2=this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
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
    var dd = new Date();
    var fecha = '' + dd.getFullYear() + '-' + (("0" + (dd.getMonth() + 1)).slice(-2)) + '-' + (("0" + (dd
        .getDate() + 1)).slice(-2)) + ' (' + dd.getHours() + dd.getMinutes() + dd.getSeconds() + ')';

        var buttons = new $.fn.dataTable.Buttons(table_tareas, {
        buttons: [{
                sheetName: 'Tareas',
                orientation: 'landscape',
                extend: 'excelHtml5',
                filename: 'Listado tareas al: ' + fecha,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6,7,8,9]
                }
            },
            {
                orientation: 'landscape',
                extend: 'pdfHtml5',
                filename: 'Listado tareas al: ' + fecha,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6,7,8,9]
                }
            }
        ]
    }).container().appendTo($('#botones_tareas'));

     table = $('#listado_polizas').DataTable({
"ajax": "/bamboo/backend/polizas/busqueda_listado_polizas.php",
        "scrollX": false,
        "searchPanes":{
            "columns":[2],
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
            }, //10
            {
                "data": "rut_clienteP",
                title: "Rut Proponente"
            }, //11
            {
                "data": "grupo",
                title: "Grupo"
            }, //12
            {
                "data": "referido",
                title: "Referido"
            } // 13
        ],
        "columnDefs": [
            {
                "targets": [7,8],
                "visible": false,
            },
        {
        targets: 1,
        render: function (data, type, row, meta) {
             var estado='';
            switch (data) {
                        case 'Activo':
                            estado='<span class="badge badge-primary">'+data+'</span>';
                            break;
                        case 'Renovado':
                                estado='<span class="badge badge-warning">'+data+'</span>';
                                break;
                        case 'Vencido':
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
        targets: [3,4],
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
            
            [4, "desc"]
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
    $("#listado_polizas_filter input")
    .off()
    .on('keyup change', function (e) {
    if (e.keyCode !== 13 || this.value == "") {
        var texto1=this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");  
         table.search(texto1)
            .draw();
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
            row.child(format_poliza(row.data())).show();
            tr.addClass('shown');
        }
    });

});

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
        '<td>'+
        '<button title="Buscar información asociada" type="button" id=' + d.id_tarea +' name="info" onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-search"></i></button><a> </a>'+
        '<button title="Completar tarea"  type="button" id=' + d.id_tarea +' name="cerrar_tarea" onclick="botones(this.id, this.name, \'tarea\')"><i class="fas fa-check-circle"></i></i></button></td>' +
        '</tr>' +
        '<tr><td>Clientes:</td>'+
        '<td>'+ $tabla_clientes+'</td></tr>'+
        '<tr><td>Pólizas:</td>'+
        '<td>'+$tabla_polizas+'</td></tr>'+
        '<tr><td>Propuestas de Pólizas:</td>'+
        '<td>'+$tabla_propuestas+'</td></tr>'+
        '</table>';
}

function format_poliza(d) {
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
            if (base == 'poliza') {
                var r2 = confirm("Estás a punto de eliminar está póliza ¿Deseas continuar?");
                if (r2 == true) {
                $.redirect('/bamboo/backend/polizas/modifica_poliza.php', {
                    'id_poliza': id,
                    'accion':accion,
                }, 'post');
                }
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
                'tipo_tarea':'individual'
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
                $.ajax({
                    type: "POST",
                    url: "/bamboo/backend/actividades/cierra_tarea.php",
                    data: {
                        id_tarea: id,
                        accion:accion,
                    },
                });
               // table_tareas.clear();
               // table_tareas.ajax.reload(null, false );
               // table_tareas.draw();
                //$('#tareas_completas').DataTable().ajax.reload(null, false );
                alert('Tarea cerrada correctamente');
                $('#listado_tareas').DataTable().clear();
                $('#listado_tareas').DataTable().ajax.reload(null, false );
                $('#listado_tareas').DataTable().draw();
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
var ctx2 = document.getElementById('myChart2').getContext('2d');
var chart2 = new Chart(ctx2, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: genera_data('leyendas'),
        datasets: [{
            label: 'Pólizas que inician su vigencia',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            borderColor: 'rgb(54, 162, 235)',
            data: genera_data('entradas')
        },
        {
            label: 'Pólizas que finalizan su vigencia',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            borderColor: 'rgb(255, 99, 132)',
            data: genera_data('salidas')
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
            backgroundColor : ["rgb(54, 162, 235)",
                "rgb(255, 99, 132)",
                "rgb(255, 205, 86)",
                "rgb(200, 205, 86)", 
                "rgb(155, 205, 86)", 
                "rgb(105, 205, 86)", 
                "rgb(55, 205, 86)",
                "rgb(0, 205, 86)", 
                "rgb(0, 155, 86)", 
                "rgb(0, 105, 86)"
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
(function(){

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
 $.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
        if(oSettings.nTable.id!=='listado_polizas'){
        return true;
        }
        var iFini = document.getElementById("fec_min").value;
        var iFfin = document.getElementById('fec_max').value;
        var iStartDateCol = 4;
        var iEndDateCol = 4;
        iFini=iFini.substring(0,4) + iFini.substring(5,7)+ iFini.substring(8,10);
        iFfin=iFfin.substring(0,4) + iFfin.substring(5,7)+ iFfin.substring(8,10);

        var dato=aData[iEndDateCol].substring(0,4) + aData[iEndDateCol].substring(5,7)+ aData[iEndDateCol].substring(8,10); 
        if ( iFini === "" && iFfin === "" )
        {
            return true;
        }
        else if ( iFini <= dato && iFfin === "")
        {
            return true;
        }
        else if ( iFfin >= dato && iFini === "")
        {
            return true;
        }
        else if (iFini <= dato && iFfin >= dato)
        {
            return true;
        }
        return false;
    }
);
    $('#busqueda_dias').change(function () {
    var dias =parseInt(document.getElementById("busqueda_dias").value);
    console.log(dias);
    var inicio=new Date();
    var fin=inicio.setDate(inicio.getDate() + dias);
    document.getElementById("fec_min").value=formateoFechas(new Date());
    document.getElementById("fec_max").value=formateoFechas(fin);
    table.draw();
    });

    function descarga_excel(){
    var dias=document.getElementById("busqueda_dias").value;
     $.redirect('/bamboo/backend/polizas/genera_excel_polizas_filtradas.php', {
    'filtro_dias': dias
    }, 'get');
}
</script>
