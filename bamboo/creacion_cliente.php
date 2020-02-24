
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
    <title>Creación Cliente</title>
    <!-- Bootstrap -->

</head>

<body>
    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Clientes / Creación <br>
        </p>
        <form action="backend/clientes/crea_cliente.php" class="needs-validation" method="POST" novalidate>
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
                            <input type="text" class="form-control" name="rut" placeholder="11111111" required>
                            <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                        </div>
                        <div class="col-md-8 mb-3 col-xl-3">
                            <label for="RUT">&nbsp;</label>
                            <input type="text" class="form-control" name="dv" placeholder="K" required>
                            <div class="invalid-feedback"></div>
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
</body>

</html>