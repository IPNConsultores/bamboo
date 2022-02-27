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
    <link rel="icon" href="/bambooQA/images/bamboo.png">
    <!-- Bootstrap -->
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" />
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
</head>


<body>

    <!-- body code goes here  -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Tareas / Listado de tareas recurrentes <br>
        </p>
        <br>
    <div id="acciones_multiples" style="background-color:#E9D6EC; display:none;">
    <table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
    <tr><td>Selección múltiple de tareas / Acciones:</td>
        <td>
<!-- Button trigger modal -->
<button id="boton_finaliza_tareas_multiples" title="Completar tarea" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#finalizar_tareas_multiples" onclick="listado_tareas_multiples()">
  <i class="fas fa-check-circle"> Finalizar Tareas</i>
</button>

<!-- Modal -->
<div class="modal fade" id="finalizar_tareas_multiples" tabindex="-1" role="dialog" aria-labelledby="ModalOpcionesMultiples" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  id="exampleModalLabel" >Finalizar múltiples tareas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body">
        <table class="table" id="tabla_tareas_multiples" style="width:100%">
            <tr><th>#</th><th>Tarea</th><th>Estado</th></tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
        </td>
    </tr>
        </table>
        </div>
        

        
        <br>
        <div class="container">
  <table class="table" id="tareas_completas" style="width:100%">
                            <tr>
                                <th></th>
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



    <!-- <div id="auxiliar" style="display: none;"> -->
        <div id="auxiliar" style="display: none;">
        <input id="var1" value="<?php echo htmlspecialchars($buscar);?>">
        <input id="id_tareas_multiples" onchange="listado_tareas_multiples()">
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>

</body>

</html>
<script>

$(document).ready(function() {
    $(".dropdown-toggle").dropdown();
    $('#finalizar_tareas_multiples').on('shown.bs.modal', function () {console.log('APERTURA');actualiza_multitarea()});
    $('#finalizar_tareas_multiples').on('hide.bs.modal', function () {
        table_tareas.column(0).checkboxes.deselectAll();
        document.getElementById("acciones_multiples").style.display = "none";
    });
    table_tareas = $('#tareas_completas').DataTable({

        "ajax": "/bambooQA/backend/actividades/busqueda_listado_tareas_completas.php",
        "scrollX": true,

//        "columns": [{
//            "className": 'checkbox_multiples',
//            "data": "id_tarea",
//            'checkboxes': {
//            'selectRow': true
//         }
//         },{
        "columns": [{
            "className": 'checkbox_multiples',
            "data": "id_tarea"
         },{
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
                title: "Procedimiento"
            },
            {
                "data":"feccierre",
                title: "Fecha cierre"
            },
            {
                "data":"nombre[]",
                title: "Clientes asociados"
            },
            {
                "data":"numero_poliza[]",
                title: "Pólizas asociadas"
            },
            {
                "data":"numero_propuesta[]",
                title: "Propuestas asociadas"
            }
        ],
        "columnDefs": [{
                "targets": [7, 10, 11,12],
                "visible": false,
            },
        {
            targets: 0,
            render: function(data, type, row, meta){
            data = '<input type="checkbox" class="dt-checkboxes">'
            if(row.estado === 'Cerrado'){
            
              data = '';
            }
            return data;
        },
            createdCell:  function (td, cellData, rowData, row, col){
             if(row.estado === 'Cerrado'){
                  this.api().cell(td).checkboxes.disable();
               }
            }, 
            checkboxes: {
               'selectRow': true,
               'selectAll': false
            }
        },
        {
        targets: 4,
        render: function (data, type, row, meta) {
             var estado='';
            switch (data) {
                        case 'Activo':
                            estado='<span class="badge badge-warning">'+data+'</span>';
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
        }},
        {
        targets: [6,7,9],
         render: function(data, type, full)
         {
             if (type == 'display')
                 return moment(data).format('DD/MM/YYYY');
             else
                 return moment(data).format('YYYY/MM/DD');
         }}],
        "order": [
            [4, "asc"],
            [6, "asc"]
        ],
        'select': {
         'style': 'multi'
      },
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
        $('#tareas_completas tbody').on('change', 'td.checkbox_multiples', function() {
        var rows_seleccionadas = table_tareas.column(0).checkboxes.selected();
        var tareas_seleccionadas=[];
        $.each(rows_seleccionadas, function(index, rowId){
        tareas_seleccionadas.push(rowId);
      });
      console.log(tareas_seleccionadas.length + " -> " + tareas_seleccionadas);
      if (tareas_seleccionadas.length==0){ 
      document.getElementById("acciones_multiples").style.display = "none";
      document.getElementById("id_tareas_multiples").value ="";
      }
      else {
      document.getElementById("acciones_multiples").style.display = "block";
      document.getElementById("id_tareas_multiples").value = tareas_seleccionadas;
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
                    columns: [ 2, 3, 4, 5, 6,7,8,9,10,11]
                }
            },
            {
                orientation: 'landscape',
                extend: 'pdfHtml5',
                filename: 'Listado tareas al: ' + fecha,
                exportOptions: {
                    columns: [ 2, 3, 4, 5, 6,7,8,9,10,11]
                }
            }
        ]
    }).container().appendTo($('#botones_tareas'));
    var busqueda_tarea= '<?php echo $id_tarea;?>';
    console.log(busqueda_tarea);
    if (busqueda_tarea==''){}
    else{
     table_tareas.column(2).search(busqueda_tarea).draw();
    }
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


function botones(id, accion, base) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "elimina": {            
            if (base == 'tarea') {
                $.redirect('/bambooQA/backend/actividades/cierra_tarea.php', {
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
                $.redirect('/bambooQA/creacion_poliza.php', {
                'id_poliza': id
                }, 'post');
            }
            if (base == 'tarea') {
                $.redirect('/bambooQA/creacion_actividades.php', {
                'id_tarea': id,
                'tipo_tarea':'individual'
                }, 'post');
            }
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
        case "cerrar_tarea": {
            if (base == 'tarea') {
                $.ajax({
                    type: "POST",
                    url: "/bambooQA/backend/actividades/cierra_tarea.php",
                    data: {
                        id_tarea: id,
                        accion:accion,
                    },
                });
                //table_tareas.clear();
                //table_tareas.ajax.reload(null, false );
                //table_tareas.draw();
                //$('#tareas_completas').DataTable().ajax.reload(null, false );
                alert('Tarea cerrada correctamente');
                table_tareas.clear();
                table_tareas.ajax.reload(null, false );
                table_tareas.draw();
            }
            break;
        }
        case "cerrar_tarea_multiple": {
            if (base == 'tarea') {
                $.ajax({
                    type: "POST",
                    url: "/bambooQA/backend/actividades/cierra_tarea.php",
                    data: {
                        id_tarea: id,
                        accion:'cerrar_tarea',
                    },
                });
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
 
 function listado_tareas_multiples(){
     for(var i = 1;i<tabla_tareas_multiples.rows.length;){
            tabla_tareas_multiples.deleteRow(i);
        }
     var contador =0;
     var listado_tareas_multiples = document.getElementById("id_tareas_multiples").value;
    var arreglo_tareas = listado_tareas_multiples.split(",");
    var contador =arreglo_tareas.length;
  var fila = '';
  arreglo_tareas.forEach(agrega_fila);
function agrega_fila(item, index) {
    var fila = '<tr id="row' + index + '"><td>' + contador + '</td><td>' + item + '</td><td><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></td></tr>'; //esto seria lo que contendria la fila
$('#tabla_tareas_multiples tr:first').after(fila);
contador=contador-1;}
}

function actualiza_multitarea(){
    console.log('inicia el ok redireccionado');
         var listado_tareas_multiples = document.getElementById("id_tareas_multiples").value;
    var arreglo_tareas = listado_tareas_multiples.split(",");
    arreglo_tareas.forEach(actualiza);
        async function actualiza(item, index) {
        botones(item, 'cerrar_tarea_multiple', 'tarea');
        tabla_tareas_multiples.rows[index+1].cells[2].innerHTML = '<i class="fas fa-check-circle"> Tarea Finalizada</i>';
        console.log('cerrando tarea ' + item);
        wait(500);
        }
    
    table_tareas.clear();
    table_tareas.ajax.reload(null, false );
    table_tareas.draw();
}
 
 function wait(ms){
   var start = new Date().getTime();
   var end = start;
   while(end < start + ms) {
     end = new Date().getTime();
  }
}



</script>