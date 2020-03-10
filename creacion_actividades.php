<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Creación Actividades</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</head>

<body>
<div id="header">
  <?php include 'header2.php' ?>
</div>
<div class="container">
  <p> Actividad / Creación <br>
  </p>
  <h5 class="form-row">&nbsp;Datos Actividad</h5>
  <br>
  <label> Datos Cliente Asociado <em>(Opcional)</em></label>
  <div class= "form-row">
    <div class="col-md-8 mb-3 col-lg-3">
      <div class= "form-row col-lg-12">
        <label for="RUT">RUT</label>
        <input type="text" class="form-control" id="rut" name="rut" placeholder="1111111-1">
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <label for="Nombre">Nombre</label>
        <input type="text" class="form-control" name="nombre">
      </div>
      <div class="col-md-4 mb-3">
        <label for="ApellidoP">Apellido Paterno</label>
        <input type="text" class="form-control" name="apellidop">
      </div>
      <div class="col-md-4 mb-3">
        <label for="ApellidoM">Apellido Materno</label>
        <input type="text" class="form-control" name="apellidom">
      </div>
    </div>
  </div>
  <br>
  <label> Datos Póliza Asociada <em>(Opcional)</em></label>
  <div Class="form-row">
    <div class="col-md-4 mb-3">
      <label for="poliza">Número de Poliza</label>
      <input type="text" class="form-control" name="poliza">
    </div>
    <div class="col-md-4 mb-3">
      <label for="poliza">Compañía</label>
      <input type="text" class="form-control" name="compania">
    </div>
  </div>
  <br>
  <label> Datos Actividad</label>
  <div class="form-row">
    <div class="col-md-2 mb-3">
      <label for="sel1">Prioridad:&nbsp;</label>
      <select class="form-control" id="ramo">
        <option style= "color:darkred">Urgente</option>
        <option style= "color:red">Alta</option>
        <option style= "color:orange">Media</option>
        <option style= "color:darkgreen">Baja</option>
      </select>
    </div>
    <div class="col-md-4 mb-3">
      <label for="Nombre">Fecha de Vencimiento</label>
      <div class="md-form">
        <input placeholder="Selected date" type="date" id="fechainicio"
                                        class="form-control" required>
      </div>
      <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
    </div>
	  </div>
	
	<div class= "form-row">
	  <div class="col">
	   <label for="poliza">Tarea a Realizar</label>
      <textarea class="form-control" id="tarea" rows="3"></textarea>
	  </div>
	
  </div>
	<br>
            <form action="" class="needs-validation" method="POST" novalidate>
                <button class="btn" type="submit" style="background-color: #536656; color: white">Registrar</button>
            </form>
            <br>
</div>
	    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="/assets/js/jquery.redirect.js"></script>
    <script src="/assets/js/validarRUT.js"></script>
    <script src="/assets/js/bootstrap-notify.js"></script>
    <script src="/assets/js/bootstrap-notify.min.js"></script>
</body>
</html>
