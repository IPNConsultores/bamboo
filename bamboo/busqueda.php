<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$buscar='';

require_once "/home/gestio10/public_html/backend/config.php";
require_once "/home/gestio10/public_html/bamboo/backend/funciones.php";
$num=0;
 $busqueda=$busqueda_err=$data='';
 $rut=$nombre=$telefono=$correo=$lista='';

if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["busqueda"])==true){
    // Check if username is empty
//$('#listado_clientes').dataTable().fnFilter(\"".estandariza_info($_POST["busqueda"])."\")
$buscar= eliminar_acentos(estandariza_info($_POST["busqueda"]));
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
</head>


<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Clientes / Listado de clientes <br>
        </p>
        <br>
        <div class="container">
            <table id="listado_clientes" class="display" width="100%">
                <tr>
                    <thead>
                        <th></th>
                        <th>Rut</th>
                        <th>Nombre</th>
                        <th>Referido por</th>
                        <th>Grupo</th>
                        <th>Teléfono</th>
                        <th>e-mail</th>
                        <th>Dirección Privada</th>
                        <th>Dirección Laboral</th>
                        <th>id</th>
                        <th>apellidop</th>
                    </thead>
                </tr>
            </table>
            <div id="botones"></div>
        </div>
        
    </div>
    <div class="container">
                <p><br><br> Pólizas / Listado de pólizas </p>
        <div class="container">
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
    var table = ''
    $(document).ready(function () {
        table = $('#listado_clientes').DataTable({

            "ajax": "/bamboo/backend/clientes/busqueda_listado_clientes.php",
            "scrollX": true,
            "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
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
                "data": "telefono"
            },
            {
                "data": "correo_electronico"
            },
            {
                "data": "direccionp"
            },
            {
                "data": "direccionl"
            },
            {
                "data": "id"
            },
            {
                "data": "apellidop"
            }

            ],
            //          "search": {
            //          "search": "abarca"
            //          },
            "columnDefs": [{
                "targets": [6, 7, 8, 9, 10],
                "visible": false,
            },
            {
                "targets": [6, 7, 8, 9, 10],
                "searchable": false
            }
            ],
            "order": [
                [10, "asc"]
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
        $("#listado_clientes_filter input")
    .off()
    .on('keyup change', function (e) {
    if (e.keyCode !== 13 || this.value == "") {
        var texto1=this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");  
        table.search(texto1)
            .draw();
    }
    });
        $('#listado_clientes tbody').on('click', 'td.details-control', function () {
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
        $('#listado_clientes').dataTable().fnFilter(document.getElementById("var1").value);

//fin clientes        
//inicio pólizas
        
            table_polizas = $('#listado_polizas').DataTable({
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
                        case 'Renovado':
                                estado='<span class="badge badge-dark">'+data+'</span>';
                                break;
                        case 'Vencido':
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
        table_polizas.search(texto1)
            .draw();
    }
    });
    $('#listado_polizas tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_polizas.row(tr);

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

    
//fin pólizas
        
        
    });

    function format(d) {
        // `d` is the original data object for the row
        $conf_tabla = '<table  background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">';
        $contactos = '';
        switch (d.contactos) {
            case "1": {
                $contactos = $conf_tabla + '<tr><th></th><th>Contacto 1</th></tr>' +
                    '<tr><td>Nombre</td><td>' + d.nombre1 + '</td></tr>' +
                    '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td></tr>' +
                    '<tr><td>Correo</td><td>' + d.correo1 + '</td></tr></table>'
                break
            }
            case "2": {
                $contactos = $conf_tabla + '<tr><th></th><th>Contacto 1</th><th>Contacto 2</th></tr>' +
                    '<tr><td>Nombre</td><td>' + d.nombre1 + '</td><td>' + d.nombre2 + '</td></tr>' +
                    '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td><td>' + d.telefono2 + '</td></tr>' +
                    '<tr><td>Correo</td><td>' + d.correo1 + '</td><td>' + d.correo2 + '</td></tr></table>'
                break
                }
            case "3": {
                $contactos = $conf_tabla + '<tr><th></th><th>Contacto 1</th><th>Contacto 2</th><th>Contacto 3</th></tr>' +
                    '<tr><td>Nombre</td><td>' + d.nombre1 + '</td><td>' + d.nombre2 + '</td><td>' + d.nombre3 + '</td></tr>' +
                    '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td><td>' + d.telefono2 + '</td><td>' + d.telefono3 + '</td></tr>' +
                    '<tr><td>Correo</td><td>' + d.correo1 + '</td><td>' + d.correo2 + '</td><td>' + d.correo3 + '</td></tr></table>'
                break
                }
            case "4": {
                $contactos = $conf_tabla + '<tr><th></th><th>Contacto 1</th><th>Contacto 2</th><th>Contacto 3</th><th>Contacto 4</th></tr>' +
                    '<tr><td>Nombre</td><td>' + d.nombre1 + '</td><td>' + d.nombre2 + '</td><td>' + d.nombre3 + '</td><td>' + d.nombre4 + '</td></tr>' +
                    '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td><td>' + d.telefono2 + '</td><td>' + d.telefono3 + '</td><td>' + d.telefono4 + '</td></tr>' +
                    '<tr><td>Correo</td><td>' + d.correo1 + '</td><td>' + d.correo2 + '</td><td>' + d.correo3 + '</td><td>' + d.correo4 + '</td></tr></table>'
                break
                }
            case "5": {
                $contactos = $conf_tabla + '<tr><th></th><th>Contacto 1</th><th>Contacto 2</th><th>Contacto 3</th><th>Contacto 4</th><th>Contacto 5</th></tr>' +
                    '<tr><td>Nombre</td><td>' + d.nombre1 + '</td><td>' + d.nombre2 + '</td><td>' + d.nombre3 + '</td><td>' + d.nombre4 + '</td><td>' + d.nombre5 + '</td></tr>' +
                    '<tr><td>Teléfono</td><td>' + d.telefono1 + '</td><td>' + d.telefono2 + '</td><td>' + d.telefono3 + '</td><td>' + d.telefono4 + '</td><td>' + d.telefono5 + '</td></tr>' +
                    '<tr><td>Correo</td><td>' + d.correo1 + '</td><td>' + d.correo2 + '</td><td>' + d.correo3 + '</td><td>' + d.correo4 + '</td><td>' + d.correo5 + '</td></tr></table>'
                break
            }
            default: {
                $contactos = 'Cliente sin contactos registrados';
                break
            }
        }
        return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr>' +
            '<td>Correo electrónico:</td>' +
            '<td>' + d.correo_electronico + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Dirección particular:</td>' +
            '<td>' + d.direccionp + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Dirección laboral:</td>' +
            '<td>' + d.direccionl + '</td>' +
            '</tr>' +
            '</tr>' +
            '<tr>' +
            '<td>Acciones</td>' +
            '<td><button title="Buscar información asociada" type="button" id=' + d.id +
            ' name="info" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-search"></i></button><a> </a><button title="Editar"  type="button" id=' +
            d.id +
            ' name="modifica" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-edit"></i></button><a> </a><button title="Agregar tarea"  type="button" id=' +
            d.id +
            ' name="tarea" onclick="botones(this.id, this.name, \'cliente\')"><i class="fas fa-clipboard-list"></i></button></td>' +
            '</tr>' +
            '</table><br>' +
            $contactos + '<br>';
    }
    function format_poliza(d) {
    // `d` is the original data object for the row
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

            if (base == 'poliza') {
                var r2 = confirm("Estás a punto de eliminar está póliza ¿Deseas continuar?");
                if (r2 == true) {
                $.redirect('/bamboo/backend/polizas/modifica_poliza.php', {
                    'id_poliza': id,
                    'accion':accion,
                }, 'post');
                }
            }
            if(base=='cliente'){
                console.log("Cliente eliminado con ID:" + id);
                var r = confirm(
                    "Estás a punto de eliminar los datos de un cliente. ¿Estás seguro de eliminarlo?"
                );
                if (r == true) {
                    $.ajax({
                        type: "POST",
                        url: "/bamboo/backend/clientes/elimina_cliente.php",
                        data: {
                            cliente: id
                        },
                    });
                    $.notify({
                        // options
                        message: 'Cliente eliminado con éxito'
                    }, {
                        // settings
                        type: 'success'
                    });
                    table.ajax.reload();
                    //location
                    break;

                } else {
                    $.notify({
                        // options
                        message: 'Proceso de eliminación de cliente cancelado'
                    }, {
                        // settings
                        type: 'info'
                    });
                    break;
                }
            }
            break;
        }
        case "modifica": {
            if (base == 'poliza') {
                $.redirect('/bamboo/creacion_poliza.php', {
                'id_poliza': id,
                }, 'post');
            }
            if (base == 'cliente') {
                $.redirect('/bamboo/creacion_cliente.php', {
                    'id_cliente': id
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
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_cliente': id
                }, 'post');
            }
            if (base == 'poliza'){
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
            if (base == 'poliza'){
                $.redirect('/bamboo/resumen.php', {
                    'id_poliza': id
                }, 'post');
            }
            break;
        }
        case "correo": {
            if (base == 'poliza'){
                $.redirect('/bamboo/template_poliza.php', {
                    'id_poliza': id
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