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
        <p> Pólizas / Listado de Pólizas <br>
        </p>
        <br>
        <div class="container">
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
            <button title="Descargar_excel_propuestas" type="button"  onclick="window.location.href='/bamboo/backend/polizas/genera_excel_polizas.php'">Descargar Excel <i class="fas fa-file-excel"></i></button>
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
    table = $('#listado_polizas').DataTable({
        "ajax": "/bamboo/backend/polizas/busqueda_listado_polizas.php",
        "scrollX": true,
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
    $('#listado_polizas').dataTable().fnFilter(document.getElementById("var1").value);
    var dd = new Date();
    var fecha = '' + dd.getFullYear() + '-' + (("0" + (dd.getMonth() + 1)).slice(-2)) + '-' + (("0" + (dd
        .getDate() + 1)).slice(-2)) + ' (' + dd.getHours() + dd.getMinutes() + dd.getSeconds() + ')';


});

function format_poliza(d) {
    // `d` is the original data object for the row
    var ext_cancelado='';
    var items='';
    var endosos='';  
    var listado_items='';
    var listado_endosos='';
    if (d.estado=='Cancelado'){
        ext_cancelado='<tr>' +
        '<td>Fecha CANCELACIÓN:</td>' +
        '<td>' + d.fecha_cancelacion + '</td>' +
        '</tr>'+
        '<tr>' +
        '<td>motivo CANCELACIÓN:</td>' +
        '<td>' + d.motivo_cancelacion + '</td>' +
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
                '<td>' + (i+1) + '</td>'+
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
            '<th></th>'+
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
            '<td>' + d.items[i].numero_item + '</td>'+
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
        '<button title="Generar propuesta de endoso"  type="button"' + 'id='+ d.id_poliza + ' name="crea_propuesta_endoso" onclick="botones(this.id, this.name, \'poliza\')"><i>E</i></button><a> - </a>' +
        '<button style="background-color: #FF0000" title="Cancelar póliza"  type="button" id=' + d.id_poliza + ' name="cancelar_poliza" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-backspace"></i></button><a> </a>' +
        '<button style="background-color: #FF0000" title="Anular póliza"  type="button" id=' + d.id_poliza + ' name="anular_poliza" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-ban"></i></button><a> </a>' +
        '<button style="background-color: #FF0000" title="Eliminar póliza"  type="button" id=' + d.id_poliza + ' name="eliminar_poliza" onclick="botones(this.id, this.name, \'poliza\')"><i class="fas fa-trash"></i></button>' +
        '</td>' +
        '</tr>' +
        '</table>';
}
function estandariza_fecha(fecha){
    let partes = (fecha || '').split('/'), fechaGenerada = (partes[2] + '-' + partes[1] + '-' + partes[0]);
        return fechaGenerada;
}
function botones(id, accion, base) {
    console.log("ID:" + id + " => acción:" + accion);
    switch (accion) {
        case "eliminar_poliza": {
                var r2 = confirm("Estás a punto de eliminar esta póliza ¿Deseas continuar?");
                if (r2 == true) {
                $.redirect('/bamboo/backend/propuesta_polizas/crea_propuesta_polizas.php', {
                    'numero_poliza': id,
                    'accion':accion
                }, 'post');
                }
            break;
        }
        case "cancelar_poliza": {
                var motivo = window.prompt('Ingresa el motivo de cancelación de póliza', '');
                var fecha_motivo = window.prompt('Ingresa la fecha de la cancelación en el siguiente formato dd/mm/aaaa. Por ejemplo: 31/07/2022', '');
                var r2 = confirm("Estás a punto de cancelar esta póliza ¿Deseas continuar?");
                
                if (r2 == true) {
                $.redirect('/bamboo/backend/propuesta_polizas/crea_propuesta_polizas.php', {
                    'numero_poliza': id,
                    'accion':accion,
                    'motivo':motivo,
                    'fecha_motivo':estandariza_fecha(fecha_motivo)
                }, 'post');
                }
                
            break;
        }
        case "anular_poliza": {
                var motivo = window.prompt('Ingresa el motivo de anulación de póliza', '');
                var fecha_motivo = window.prompt('Ingresa la fecha de la cancelación en el siguiente formato dd/mm/aaaa. Por ejemplo: 31/07/2022', '');
                var r2 = confirm("Estás a punto de anular esta póliza ¿Deseas continuar?");
                if (r2 == true) {
                $.redirect('/bamboo/backend/propuesta_polizas/crea_propuesta_polizas.php', {
                    'numero_poliza': id,
                    'accion':accion,
                    'motivo':motivo,
                    'fecha_motivo':estandariza_fecha(fecha_motivo)
                }, 'post');
                }
            break;
        }
        case "modifica_poliza": {
            $.redirect('/bamboo/creacion_propuesta_poliza.php', {
                'numero_poliza': id,
                'accion': accion
            }, 'post');
            break;
        }
        case "crea_propuesta_endoso": {
            var motivo = window.prompt('Ingresa la vía por donde quieres crear el endoso:\r\n 1) Vía Propuesta WEB\r\n 2) Vía Propuesta manual', 'digita 1 o 2');
            switch (motivo){
                case "1":
                    //alert('Renovación vía propuesta WEB');
                    $.redirect('/bamboo/creacion_propuesta_endoso.php', {
                        'numero_poliza': id,
                        'accion': 'crea_propuesta_endoso_web'
                    }, 'post');
                    break;
                case "2":
                    $.redirect('/bamboo/creacion_propuesta_endoso.php', {
                        'numero_poliza': id,
                        'accion': 'crea_propuesta_endoso_manual'
                    }, 'post');
                    break;
                default:
                    alert('Número ingresado no válido. Debes ingresar 1 o 2');
                    break;
            }
            break;
        }
        case "tarea": {
            if (base == 'poliza') {
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_poliza': id
                }, 'post');
            }
            if (base == 'cliente') {
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_cliente': id
                }, 'post');
            }
            if (base == 'propuesta'){
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_propuesta': id
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
        case "crear_poliza": {
            $.redirect('/bamboo/creacion_propuesta_poliza.php', {
                'numero_poliza': id,
                'accion': accion
            }, 'post');
            break;
        }
        case "generar": {
            $.redirect('/bamboo/resumen2.php', {
                'id': id,
                'base': base
            }, 'post');
            break;
        }
        case "correo": {
                $.redirect('/bamboo/template_poliza.php', {
                    'id_poliza': id
                }, 'post');
            break;
        }
        case "renovar":{
            var motivo = window.prompt('Ingresa la vía por donde quieres renovar esta póliza:\r\n 1) Vía Propuesta WEB\r\n 2) Vía Propuesta tradicional', 'digita 1 o 2');
            switch (motivo){
                case "1":
                    //alert('Renovación vía propuesta WEB');
                    $.redirect('/bamboo/creacion_propuesta_poliza.php', {
                        'numero_poliza': id,
                        'accion': 'modifica_poliza',
                        'accion_secundaria': 'renovar'
                    }, 'post');
                    break;
                case "2":
                    $.redirect('/bamboo/creacion_propuesta_poliza.php', {
                        'numero_poliza': id,
                        'accion': 'actualiza_propuesta',
                        'accion_secundaria': 'renovar'
                    }, 'post');
                    break;
                default:
                    alert('Número ingresado no válido. Debes ingresar 1 o 2');
                    break;
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