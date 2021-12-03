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
 $busqueda=$busqueda_err=$data='';
 $rut=$nombre=$telefono=$correo=$lista='';

if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["busqueda"])==true){
    // Check if username is empty
//$('#listado_polizas').dataTable().fnFilter(\"".estandariza_info($_POST["busqueda"])."\")
$buscar= estandariza_info($_POST["busqueda"]);
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
        

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
            <script src="/assets/js/bootstrap-notify.js"></script>
        <script src="/assets/js/bootstrap-notify.min.js"></script>
    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
</head>


<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Propuesta de Pólizas / Listado de Propuestas <br>
        </p>
        <br>
        <div class="container">
            <table class="display" style="width:100%" id="listado_propuesta_polizas">
                   <tr>
                    <th></th>
                    <th>Estado</th>
                    <th>N° Propuesta</th>
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

                    </tr>

            </table>
            <div id="botones_poliza"></div>
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

        <script src="/assets/js/datatables.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js">
        </script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js">
        </script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js">
        </script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>

</body>

</html>
<script>
var table = ''
$(document).ready(function() {
    table = $('#listado_propuesta_polizas').DataTable({
        "ajax": "/bambooQA/backend/propuesta_polizas/busqueda_listado_propuesta_polizas.php",
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
                "data": "tipo_propuesta",
                title: "Tipo propuesta"
            }, //3
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
                title: "Tipo Propuesta"
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
            } // 14
        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "columnDefs": 
        [
            {
                "targets": [8, 9 , 10],
                "visible": false,
            },
         {
        targets: 1,
        render: function (data, type, row, meta) {
             var estado='';
            switch (data) {
                        case 'Aceptado':
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
        targets: [4,5,6],
         render: function(data, type, full)
         {
            if (data==null || data=="0000-00-00")
            {
                return '';
            }
            else
            {
                 if (type == 'display')
                     return moment(data).format('DD/MM/YYYY');
                 else
                     return moment(data).format('YYYY/MM/DD');
            }
         }}
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
    $("#listado_propuesta_polizas_filter input")
    .off()
    .on('keyup change', function (e) {
    if (e.keyCode !== 13 || this.value == "") {
        var texto1=this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");  
         table.search(texto1)
            .draw();
    }
        
    });
    $('#listado_propuesta_polizas tbody').on('click', 'td.details-control', function() {
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
    $('#listado_propuesta_polizas').dataTable().fnFilter(document.getElementById("var1").value);
    var dd = new Date();
    var fecha = '' + dd.getFullYear() + '-' + (("0" + (dd.getMonth() + 1)).slice(-2)) + '-' + (("0" + (dd
        .getDate() + 1)).slice(-2)) + ' (' + dd.getHours() + dd.getMinutes() + dd.getSeconds() + ')';

    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [{
                sheetName: 'Propuestas de Pólizas',
                orientation: 'landscape',
                extend: 'excelHtml5',
                filename: 'Listado Propuestas de Pólizas al: ' + fecha,
                exportOptions: {
                    columns: [1,18,19,20,21,22,3,5,6,14,8,4,2,7,9,17,16,10,11,12,13,24,25,26,27,28,29,30,31,33,32,23]
                }
            },
            {
                orientation: 'landscape',
                extend: 'pdfHtml5',
                filename: 'Listado Propuestas de Pólizas al: ' + fecha,
                exportOptions: {
                    columns: [1,18,19,20,21,22,3,5,6,14,8,4,2,7,9,17,16,10,11,12,13,24,25,26,27,28,29,30,31,33,32,23]
                }
            }
        ]
    }).container().appendTo($('#botones_poliza'));

});

function format(d) {
    // `d` is the original data object for the row
    var ext_cancelado='';
    var items='';
    var listado_items='';
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
        '<td>Acciones</td>' +
        '<td>' +
        '<button title="Aprobar Propuesta" type="button" id=' + d.id_poliza + ' name="aprobar" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-check"></i></button><a> </a>' +
        '<button title="Generar Propuesta" type="button" id=' + d.id_poliza + ' name="generar" onclick="botones(this.id, this.name, \'poliza\')"><i class="fa fa-file-pdf-o"></i></button><a> </a>' +
        '<button title="Buscar información asociada" type="button" id=' + d.id_poliza + ' name="info" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-search"></i></button><a> </a>' +
        '<button title="Editar"  type="button" id=' + d.id_poliza + ' name="modifica" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-edit"></i></button><a> </a>' +
        '<button title="Asignar tarea"  type="button" id=' + d.id_poliza +' name="tarea" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-clipboard-list"></i></button><a> </a>' +
        '<button title="Generar correo"  type="button"' + 'id='+ d.id_poliza + ' name="correo" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-envelope-open-text"></i></button><a> </a>' +
        '<button style="background-color: #FF0000" title="Eliminar"  type="button" id=' + d.id_poliza + ' name="elimina" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-trash-alt"></i></button>' +
        '</td>' +
        '</tr>' +
        '</table>';
}

function botones(id, accion, base) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "elimina": {

            if (base == 'propuesta') {
                var r2 = confirm("Estás a punto de eliminar está póliza ¿Deseas continuar?");
                if (r2 == true) {
                $.redirect('/bambooQA/backend/propuesta_polizas/modifica_propuesta_poliza.php', {
                    'id_propuesta': id,
                    'accion':accion,
                }, 'post');
                }
            }
            break;
        }
        case "modifica": {
            if (base == 'propuesta') {
                $.redirect('/bambooQA/creacion_propuesta_poliza.php', {
                'id_propuesta': id,
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
            if (base == 'propuesta'){
                $.redirect('/bambooQA/creacion_actividades.php', {
                    'id_propuesta': id
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
        case "aprobar": {
            $.redirect('/bambooQA/creacion_propuesta_poliza.php', {
                'id': id,
                'base': base
            }, 'post');
            break;
        }
        case "generar": {
            $.redirect('/bambooQA/resumen2.php', {
                'id': id,
                'base': base
            }, 'post');
            break;
        }
        case "correo": {
            if (base == 'propuesta'){
                $.redirect('/bambooQA/template_poliza.php', {
                    'id_propuesta': id
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