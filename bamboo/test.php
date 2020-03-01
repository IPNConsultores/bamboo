<?php
/*
$indicesServer = array('PHP_SELF',
'argv',
'argc',
'GATEWAY_INTERFACE',
'SERVER_ADDR',
'SERVER_NAME',
'SERVER_SOFTWARE',
'SERVER_PROTOCOL',
'REQUEST_METHOD',
'REQUEST_TIME',
'REQUEST_TIME_FLOAT',
'QUERY_STRING',
'DOCUMENT_ROOT',
'HTTP_ACCEPT',
'HTTP_ACCEPT_CHARSET',
'HTTP_ACCEPT_ENCODING',
'HTTP_ACCEPT_LANGUAGE',
'HTTP_CONNECTION',
'HTTP_HOST',
'HTTP_REFERER',
'HTTP_USER_AGENT',
'HTTPS',
'REMOTE_ADDR',
'REMOTE_HOST',
'REMOTE_PORT',
'REMOTE_USER',
'REDIRECT_REMOTE_USER',
'SCRIPT_FILENAME',
'SERVER_ADMIN',
'SERVER_PORT',
'SERVER_SIGNATURE',
'PATH_TRANSLATED',
'SCRIPT_NAME',
'REQUEST_URI',
'PHP_AUTH_DIGEST',
'PHP_AUTH_USER',
'PHP_AUTH_PW',
'AUTH_TYPE',
'PATH_INFO',
'ORIG_PATH_INFO') ;

echo '<table cellpadding="10">' ;
foreach ($indicesServer as $arg) {
    if (isset($_SERVER[$arg])) {
        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
    }
    else {
        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
    }
}
echo '</table>' ;
*/

//header('Content-type: text/plain');

?>

<script>
/*
    function valida_rut() {

        var dato = $('#rut').val();
        var rut_sin_dv = dato.replace('-', '');
        rut_sin_dv = rut_sin_dv.slice(0, -1);
        alert(dato);
        //var respuesta = ?php echo valida_duplicado('17029236-7'); ? ;
        
        $.ajax({
            url: '/bamboo/backend/clientes/clientes_duplicados.php',
            type: "get",
            data: {
                "rut": rut_sin_dv
            }

            success: function(data) {
                alert(data);
                //jQuery("#container" ).append(data);
            },
            fail: function(error) {
                alert("error" + error);
            }
        });}


        
                if (responseText == 'duplicado') {
                    var r = confirm(
                        "El rut que acabas de ingresar ya se encuentra en la base de datos. ¿Deseas ver la información asociada al rut?"
                    );
                    if (r == true) {
                        $.redirect('/bamboo/listado_clientes.php', {
                            'dato': dato
                        }, 'post');
                    } else {
                        location.href = "http://gestionipn.cl/bamboo/creacion_cliente.php";
                    }
                }
                */
$(document).ready(function() {
    $("#btnsend").click(function() {
        alert("test");
        $.ajax({
            type: "GET",
            url: "/bamboo/backend/clientes/clientes_duplicados.php",
            data: {
                "rut": rut_sin_dv
            }
            success: function() {
                alert("éxito");
            }
            fail: function() {
                alert("fail");
            }
        });
    });
});
</script>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creación Clientes</title>
    <!-- Bootstrap -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


</head>


<body>
    <input type="text" class="form-control" id="rut" name="rut" placeholder="1111111-1" required>
    <button id="btnsend" class="btn" style="background-color: #536656; color: white">Registrar</button>
    <div id="retriever">test</div>

</body>

</html>