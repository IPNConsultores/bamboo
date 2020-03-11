<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

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
//$('#listado_clientes').dataTable().fnFilter('".estandariza_info($_POST["busqueda"])."')
echo "<script type= text/javascript> alert('".estandariza_info($_POST["busqueda"])."'); </script>";
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
</head>


<body>

    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Clientes / Modificación <br>
        </p>
        <br>
        <table id="listado_clientes" class="display" width="100%">
            <tr>
                <thead>
                    <th></th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Apellido paterno</th>
                    <th>Apellido materno</th>
                    <th>Teléfono</th>
                    <th>e-mail</th>
                    <th>Dirección Privada</th>
                    <th>Dirección Laboral</th>
                    <th>id</th>
                </thead>
            </tr>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="/assets/js/jquery.redirect.js"></script>
    <script src="/assets/js/bootstrap-notify.js"></script>
    <script src="/assets/js/bootstrap-notify.min.js"></script>
    <script src="/assets/js/datatables.min.js"></script>
</body>

</html>
<script>
$(document).ready(function() {
    var table = $('#listado_clientes').DataTable({
        "ajax": "/bamboo/backend/clientes/busqueda_listado_clientes.php",
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
                "data": "apellidop"
            },
            {
                "data": "apellidom"
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
            }

        ],
        //          "search": {
        //          "search": "abarca"
        //          },
        "columnDefs": [{
                "targets": [6, 7, 8, 9],
                "visible": false,
            },
            {
                "targets": [5, 6, 7, 8, 9],
                "searchable": false
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
    $('#listado_clientes tbody').on('click', 'td.details-control', function() {
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
});

function format(d) {
    // `d` is the original data object for the row
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Nombre completo:</td>' +
        '<td>' + d.nombre + ' ' + d.apellidop + ' ' + d.apellidom + '</td>' +
        '</tr>' +
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
        '<td><button title="Busca toda la información asociada a este cliente" type="button" id="+d.id+" name="info" onclick="botones(this.id, this.name)"><i class="fas fa-search"></i></button><a> </a><button title="Modifica la información de este cliente"  type="button" id="+d.id+" name="modifica" onclick="botones(this.id, this.name)"><i class="fas fa-edit"></i></button><a> </a><button title="Elimina este cliente"  type="button" id="+d.id+" name="elimina" onclick="botones(this.id, this.name)"><i class="fas fa-trash-alt"></i></button><a> </a><button title="Asigna una tarea o comentario"  type="button" id="+d.id+" name="tarea" onclick="botones(this.id, this.name)"><i class="fas fa-clipboard-list"></i></button></td>' +

        '</tr>' +
        '</table>';
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
            $.redirect('/bamboo/modificacion_cliente.php', {
                'cliente': id
            }, 'post');
            break;
        }
        case "tarea": {
            console.log("Asignar tarea a ID:" + id);
            $.notify({
                // options
                message: 'Tarea Asignada'
            }, {
                // settings
                type: 'success'
            });
            break;
        }
        case "info": {
            console.log("Busqueda de ID:" + id);
            $.notify({
                // options
                message: 'Recopilando información del cliente'
            }, {
                // settings
                type: 'info'

            });
            break;
        }
    }
}
</script>