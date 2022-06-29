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
mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
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
            <script src="/assets/js/bootstrap-notify.js"></script>
        <script src="/assets/js/bootstrap-notify.min.js"></script>
    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
</head>


<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Endosos / Listado de Endosos<br>
        </p>
        <br>
        <div class="container">
            <table class="display" style="width:100%" id="listado_endosos">
                <tr>
                    <th></th>
                    <th>Número Endoso</th>
                    <th>Nro Propuesta Endoso</th>
                    <th>Tipo Endoso</th>
                    <th>Nro Póliza</th>
                    <th>Fecha ingreso</th>
                    <th>Inicio Vigencia</th>
                    <th>Fin Vigencia</th>
                    <th>Fecha Prorroga</th>
                </tr>

            </table>
            <div id="botones_poliza">
            
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
var table_endosos = ''
$(document).ready(function() {
    table_endosos = $('#listado_endosos').DataTable({
        "ajax": "/bamboo/backend/endosos/busqueda_listado_endosos.php",
        "scrollX": true,
        "dom": 'Pfrtip',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            }, //0
            {
                "data": "numero_endoso",
                title: "Número Endoso"
            }, //1
            { 
                data: "numero_propuesta_endoso", 
                title: "Nro Propuesta Endoso",
            }, //2
            {
                "data": "tipo_endoso",
                title: "Tipo Endoso"
            }, //3
            {
                "data": "numero_poliza",
                title: "Número Póliza"
            }, //4
            {
                "data": "fecha_ingreso_endoso",
                title: "Fecha ingreso"
            }, //5
            {
                "data": "vigencia_inicial",
                title: "Inicio Vigencia"
            }, //6
            {
                "data": "vigencia_final",
                title: "Fin Vigencia"
            }, //7
            {
                "data": "fecha_prorroga",
                title: "Fecha Prorroga"
            } //7
        ],
        "columnDefs": 
        [
        {
        targets: [5,6,7],
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
            [1, "desc"],
            [2, "desc"]
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
    $("#listado_endosos_filter input")
    .off()
    .on('keyup change', function (e) {
    if (e.keyCode !== 13 || this.value == "") {
        var texto1=this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");  
        table_endosos.search(texto1)
            .draw();
    }
        
    });
    $('#listado_endosos tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_endosos.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format_endoso(row.data())).show();
            tr.addClass('shown');
        }
    });
    $('#listado_endosos').dataTable().fnFilter(document.getElementById("var1").value);
 
});

function format_endoso(d) {
    // `d` is the original data object for the row
    var ext_cancelado='';
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
            '<td VALIGN=TOP>Primas: </td>' +
            '<td>'+
                 '<table class="table table-striped" style="width:100%">'+
                    '<tr>' +
                        '<td>Total Prima afecta:</td>' +
                        '<td>' + d.prima_neta_afecta + '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td>Total Prima exenta:</td>' +
                        '<td>' + d.prima_neta_exenta + '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td>Total Prima neta anual:</td>' +
                        '<td>' + d.iva + '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td>Total Prima bruta anual:</td>' +
                        '<td>' + d.prima_total + '</td>' +
                    '</tr>' +
                '</table>'+
            '</td>' +
        '</tr>' +
        '<tr>' +
        '<td VALIGN=TOP>Detalle: </td>' +
            '<td>'+
                '<table class="table table-striped" style="padding-left:50px;" cellpadding="5" cellspacing="0" border="0" id="listado_polizas">'+
                    '<tr>'+
                        '<th>Descripción</th>'+
                        '<th>Dice</th>'+
                        '<th>Debe Decir</th>'+
                        '<th>Comentario</th>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>"' + d.descripcion_endoso + '"</td>'+
                    '<td>"' + d.dice + '"</td>'+
                    '<td>"' + d.debe_decir + '"</td>'+
                    '<td>"' + d.comentario_endoso + '"</td>'+
                '</table>'+
            '</td>' +
        '</tr>' +    
        '<tr><td VALIGN=TOP>Acciones</td>' +
        '<td>' +
        '<button title="Editar Endoso" type="button" id="' + d.numero_endoso + '" name="actualiza_endoso" onclick="botones(this.id, this.name, \'endoso\')"><i class="fas fa-edit"></i></button><a> </a>' +
        '<button title="Generar documento" type="button" id="' + d.numero_propuesta_endoso + '" name="generar_documento" onclick="botones(this.id, this.name, \'endoso\')"><i class="fa fa-file-pdf-o"></i></button><a> </a>' +
        '<button title="Buscar información asociada" type="button" id="' + d.numero_endoso + '" name="info" onclick="botones(this.id, this.name, \'endoso\')"><i class="fas fa-search"></i></button><a> </a>' +
        '</td>' +
        '</tr>' +
        '<tr>' +
            '<td> </td>' +
            '<td> </td>' +
        '</tr>' +
        '</table>';
}
function botones(id, accion, base) {
    //alert("ID:" + id + " => acción:" + accion + " => base:"+ base);
    switch (accion) {
        case "rechazar_propuesta": {
                var motivo = window.prompt('Ingresa el motivo del rechazo', '');
                var r2 = confirm("Estás a punto de rechazar esta propuesta de endoso ¿Deseas continuar?");
                
                if (r2 == true) {
                $.redirect('/bamboo/backend/endosos/crea_endosos.php', {
                    'numero_propuesta': id,
                    'accion':accion,
                    'motivo':motivo
                }, 'post');
                }
            break;
        }

        case "actualiza_propuesta": {
            $.redirect('/bamboo/creacion_propuesta_endoso.php', {
            //$.redirect('/bamboo/test_felipe2.php', {    
                'numero_propuesta': id,
                'accion': accion
            }, 'post');
            break;
        }
        case "tarea": {
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_propuesta': id
                }, 'post');
            break;
        }
        case "info": {
           
            $.redirect('/bamboo/resumen2.php', {
                'id': id,
                'base': base
            }, 'post');
            break;
        }
        case "actualiza_endoso": {
            $.redirect('/bamboo/creacion_propuesta_endoso.php', {
                'numero_endoso': id,
                'accion': accion
            }, 'post');
            break;
        }
        case "generar_documento": {
            $.redirect('/bamboo/documento_propuesta_endoso.php', {
                'numero_propuesta': id,
                'accion': accion
            }, 'post');
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
