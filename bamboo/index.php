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
$sql = "SELECT *, concat_ws('-',mes,SUBSTRING(anomes, 3,2)) as anomes_nombre FROM `stock_polizas` WHERE ANOMES BETWEEN ANOMES(DATE_ADD(CURRENT_DATE, INTERVAL -12 MONTH)) AND ANOMES(DATE_ADD(CURRENT_DATE, INTERVAL + 6 MONTH))";
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
  
$resultado2=mysqli_query($link, "SELECT ramo, count(*) as cantidad FROM polizas where estado not in ('Cancelado','Anulado') group by ramo order by count(*) desc");
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
    <link rel="icon" href="/bamboo/bamboo.png">
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
            ,
            {
                "data": "poliza_renovada",
                title: "Póliza renovada"
            }
            ,
            {
                "data": "informacion_adicional",
                title: "Información adicional"
            }
        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "columnDefs": [{
                "targets": [10, 11, 12,13,14,15,16,17,19,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41],
                "visible": false,
            },
            {
                "targets": [10, 11, 12,13,14,15,16,17,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41],
                "searchable": false
            },
            {
        targets: 1,
        render: function (data, type, row, meta) {
             var estado='';
            switch (data) {
                        case 'Activo':
                            estado='<span class="badge badge-primary">'+data+'</span>';
                            break;
                        case 'Vencido':
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
        }},
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
            [6, "asc"]
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
            row.child(detalle_polizas(row.data())).show();
            tr.addClass('shown');
        }
    });
    //$('#listado_polizas').dataTable().fnFilter('Activo');
    
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
                    columns: [1,18,19,20,21,22,3,5,6,14,8,4,2,7,9,17,16,10,11,12,41,13,24,25,26,27,28,29,30,31,33,32,34,35,23,37,38,39,40,42,43]
                }
            },
            {
                orientation: 'landscape',
                extend: 'pdfHtml5',
                filename: 'Listado Pólizas al: ' + fecha,
                exportOptions: {
                    columns: [1,18,19,20,21,22,3,5,6,14,8,4,2,7,9,17,16,10,11,12,41,13,24,25,26,27,28,29,30,31,33,32,34,35,23,37,38,39,40,42,43]
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
        '<td><button title="Buscar información asociada" type="button" id=' + d.id_poliza +
        ' name="info" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button><a> </a><button title="Editar"  type="button" id=' +
        d.id_poliza +
        ' name="modifica" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-edit"></i></button><a> </a><button title="Asignar tarea"  type="button" id=' +
        d.id_poliza +
        ' name="tarea" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-clipboard-list"></i></button><a> </a><button title="Generar correo"  type="button"' +
        'id='+ d.id_poliza +
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
        var iStartDateCol = 6;
        var iEndDateCol = 6;
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
    
</script>
