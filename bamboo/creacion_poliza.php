<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Creación Poliza</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
<!-- body code goes here -->
<div id="header">
<?php include 'header2.php' ?>
</div>
<div class="container">
<p>Póliza / Creación<br>
</p>
<h5 class="form-row">&nbsp;Datos Póliza</h5>
<div class="accordion" id="accordionExample">
  <div class="card" >
    <div class="card-header" id="headingOne" style="background-color:whitesmoke">
      <h5 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#536656">Asegurado y Proponente</button>
      </h5>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <p>Datos Proponente<br>
        <div class="form-row">
          <div class="col-md-4 mb-3 col-lg-3" style= "align:left">
            <label for="RUT" style= "align:left">RUT</label>
            <input type="text" class="form-control" name="rutprop" placeholder="11111111" required>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
          <div class="col-md-2 mb-3 col-xl-3">
            <label for="RUT">&nbsp;</label>
            <input type="text" class="form-control" name="dvprop" placeholder="K" required>
            <div class="invalid-feedback"></div>
          </div>
          <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
            <label for="prop">&nbsp;</label>
            <br>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="background-color:#536656;color:#A5CCAB;position:inherit">Buscar</button>
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="Nombre">Nombre</label>
              <input type="text" class="form-control" name="nombre" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoP">Apellido Paterno</label>
              <input type="text" class="form-control" name="apellidop" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoM">Apellido Materno</label>
              <input type="text" class="form-control" name="apellidom" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
          </div>
        </div>
        <p>Datos Asegurado<br>
        <div class="form-row">
          <div class="col-md-4 mb-3 col-lg-3" style= "align:left">
            <label for="RUT" style= "align:left">RUT</label>
            <input type="text" class="form-control" name="rutaseg" placeholder="11111111" required>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
          <div class="col-md-2 mb-3 col-xl-3">
            <label for="RUT">&nbsp;</label>
            <input type="text" class="form-control" name="dvaseg" placeholder="K" required>
            <div class="invalid-feedback"></div>
          </div>
          <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
            <label for="prop">&nbsp;</label>
            <br>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="background-color:#536656;color:#A5CCAB;position:inherit">Buscar</button>
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="Nombre">Nombre</label>
              <input type="text" class="form-control" name="nombreaseg" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoP">Apellido Paterno</label>
              <input type="text" class="form-control" name="apellidopaseg" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoM">Apellido Materno</label>
              <input type="text" class="form-control" name="apellidomaseg" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
          </div>
          <div class="Form-row"></div>
          <div class="col col-lg-12">
            <label for="Nombre">Grupo</label>
            <input type="text" class="form-control" name="grupo" required>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
        </div>
      </div>
    </div>
    <div class="card" >
      <div class="card-header" id="headingTwo" style="background-color:whitesmoke">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="color:#536656">Compañía, Vigencia y Materia</button>
        </h5>
      </div>
      <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body">
          <p>Compañía<br>
          <div class="form-row">
            <div class="form-inline">
              <label for="sel1">Selecionar Compañía:&nbsp;</label>
              <select class="form-control" id="selcompania">
                <option>BCI Seguros</option>
                <option>Chilena Consolidada</option>
                <option>CHUBB</option>
                <option>Confuturo</option>
                <option>Consorcio</option>
                <option>Continental</option>
                <option>HDI Seguros</option>
                <option>Maphre</option>
                <option>Ohio National Financial Group</option>
                <option>Orsan</option>
                <option>Reale Seguros</option>
                <option>Renta Nacional</option>
                <option>Southbridge</option>
                <option>Sura</option>
                <option>Unnio</option>
              </select>
            </div>
          </div>
          <br>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="Nombre">Vigencia Inicial</label>
              <div class="md-form">
  <input placeholder="Selected date" type="date" id="date-picker-example" class="form-control">
</div>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
			  <div class="col-md-4 mb-3">
              <label for="Nombre">Vigencia Final</label>
              <div class="md-form">
  <input placeholder="Selected date" type="date" id="date-picker-example" class="form-control">
</div>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoP">Apellido Paterno</label>
              <input type="text" class="form-control" name="apellidop" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoM">Apellido Materno</label>
              <input type="text" class="form-control" name="apellidom" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
          </div>
        </div>
        <p>Datos Asegurado<br>
        <div class="form-row">
          <div class="col-md-4 mb-3 col-lg-3" style= "align:left">
            <label for="RUT" style= "align:left">RUT</label>
            <input type="text" class="form-control" name="rutprop" placeholder="11111111" required>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
          <div class="col-md-2 mb-3 col-xl-3">
            <label for="RUT">&nbsp;</label>
            <input type="text" class="form-control" name="dvprop" placeholder="K" required>
            <div class="invalid-feedback"></div>
          </div>
          <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
            <label for="prop">&nbsp;</label>
            <br>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="background-color:#536656;color:#A5CCAB;position:inherit">Buscar</button>
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="Nombre">Nombre</label>
              <input type="text" class="form-control" name="nombre" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoP">Apellido Paterno</label>
              <input type="text" class="form-control" name="apellidop" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoM">Apellido Materno</label>
              <input type="text" class="form-control" name="apellidom" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <form action="backend/clientes/crea_cliente.php" class="needs-validation" method="POST" novalidate>
    <h5 class="form-row">&nbsp;Datos Póliza</h5>
    <br>
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <label for="Nombre">Nombre</label>
        <input type="text" class="form-control" name="nombre" required>
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="ApellidoP">Apellido Paterno</label>
        <input type="text" class="form-control" name="apellidop" required>
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="ApellidoM">Apellido Materno</label>
        <input type="text" class="form-control" name="apellidom" required>
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="form-row">
          <div class="col-md-8 mb-3">
            <label for="RUT">RUT</label>
            <input type="text" class="form-control" name="rut" placeholder="11111111" required>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
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
          <div class="input-group-prepend"><span class="input-group-text" id="mail">@</span></div>
          <input type="email" class="form-control" name="correo_electronico" required>
          <div class="invalid-feedback">Campo en blanco o sin formato mail (aaa@bbb.xxx)</div>
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
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustomUsername">Dirección Laboral</label>
        <div class="input-group">
          <input type="text" class="form-control" name="direccionl" required>
          <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>