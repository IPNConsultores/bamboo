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
//$('#listado_clientes').dataTable().fnFilter(\"".estandariza_info($_POST["busqueda"])."\")
$buscar= estandariza_info($_POST["busqueda"]);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clientes</title>
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
        var dd = new Date();
        var fecha = '' + dd.getFullYear() + '-' + (("0" + (dd.getMonth() + 1)).slice(-2)) + '-' + (("0" + (dd
            .getDate() + 1)).slice(-2)) + ' (' + dd.getHours() + dd.getMinutes() + dd.getSeconds() + ')';

        var buttons = new $.fn.dataTable.Buttons(table, {
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
        }).container().appendTo($('#botones'));
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
            '<td><button title="Busca toda la información asociada a este cliente" type="button" id=' + d.id +
            ' name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id=' +
            d.id +
            ' name="modifica" onclick="botones(this.id, this.name)"><i class="fas fa-edit"></i></button><a> </a><button title="Agregar tarea"  type="button" id=' +
            d.id +
            ' name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button></td>' +
            '</tr>' +
            '</table><br>' +
            $contactos + '<br>';
    }

    function botones(id, accion) {
        console.log("ID:" + id + " => acción:" + accion);
        switch (accion) {
            case "elimina": {
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
            case "modifica": {
                $.redirect('/bamboo/creacion_cliente.php', {
                    'id_cliente': id
                }, 'post');
                break;
            }
            case "tarea": {
                $.redirect('/bamboo/creacion_actividades.php', {
                    'id_cliente': id
                }, 'post');
                break;
            }
            case "info": {
                $.redirect('/bamboo/resumen.php', {
                    'id_cliente': id
                }, 'post');
                break;
            }
        }
    }
</script>