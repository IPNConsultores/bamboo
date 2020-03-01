<?php
require_once "/home/gestio10/public_html/backend/config.php";
echo 'variable';
function valida_duplicado($rut){
    $valor=$rut;
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');

$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
        
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    
    // Set parameters
    $param_username = estandariza_info($valor);
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        /* store result */
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) == 1){
            $resultado='1';
            //duplicado
        } else{
            $resultado='0'; 
            //éxito
        }
    } else{
            $resultado='3';
        //echo "Oops! Algo salió mal. Favor intentar más tarde.";
    }
}
mysqli_stmt_close($stmt);
echo $resultado;

}
echo valida_duplicado('17029236-7');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creación Clientes</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>


</head>


<body>
    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Clientes / Creación <br>
        </p>
        <form action="/bamboo/backend/clientes/crea_cliente.php" class="needs-validation" method="POST" novalidate>
            <h5 class="form-row">&nbsp;Datos personales</h5>
            <br>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="Nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" required>
                    <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ApellidoP">Apellido Paterno</label>
                    <input type="text" class="form-control" name="apellidop" required>
                    <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ApellidoM">Apellido Materno</label>
                    <input type="text" class="form-control" name="apellidom" required>
                    <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-row">
                        <div class="col-md-8 mb-3">
                            <label for="RUT">RUT</label>
                            <input type="text" class="form-control" id="rut" name="rut" placeholder="1111111-1"
                                oninput="checkRut(this)" onchange="valida_rut()" required>
                            <script>
                            function valida_rut() {
                                var dato = $('#rut').val();
                                alert(dato);
                                var respuesta = <?php echo valida_duplicado('17029236-7'); ?> ;
                                if (respuesta == '1') {
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
                            }
                            </script>


                            <div class="invalid-feedback"> Dígito verificador no válido. Verifica rut ingresado </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustomUsername">E-mail</label>
                    <div class="input-group">
                        <div class="input-group-prepend"> <span class="input-group-text" id="mail">@</span> </div>
                        <input type="email" class="form-control" name="correo_electronico" required>
                        <div class="invalid-feedback"> Campo en blanco o sin formato mail (aaa@bbb.xxx) </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustomUsername">Telefono</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="telefono" placeholder="569XXXXXX" required>
                        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="Dirección">Dirección Particular</label>
                    <input type="text" class="form-control" name="direccionp" required>
                    <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustomUsername">Dirección Laboral</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="direccionl" required>
                        <div class="invalid-feedback"> No puedes dejar este campo en blanco</div>
                    </div>
                </div>
            </div>

            <button class="btn" type="submit" style="background-color: #536656; color: white">Registrar</button>
        </form>
    </div>


    <script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="/bamboo/js/jquery.redirect.js"></script>
    <script src="/bamboo/js/validarRUT.js"></script>
</body>

</html>