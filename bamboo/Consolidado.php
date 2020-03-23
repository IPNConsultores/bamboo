<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

?>
<!DOCTYPE html>
<html lang ="es">
<head>
<meta charset="utf-8">
<title>consolidado</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div id="header">
  <?php include 'header2.php' ?>
</div>

  <div class="container">
	
	<h4>Consolidado</h4>
	  <div class="card">
  <div class="card-body">
    <h5 class="card-title">Información de Clientes</h5>
    <p class="card-text">Muestra el detalle del cliente </p>
  <table id="listado_clientes" class="table" width="100%">
            <tr>
                <thead>
                    
					<th>Rut</th>
                    <th>Nombre</th>
                    <th>Apellido paterno</th>
                    <th>Apellido materno</th>
                    <th>Teléfono</th>
                    <th>E-Mail</th>
                    <th>Dirección Privada</th>
                    <th>Dirección Laboral</th>
                  </thead>
            </tr>
        </table>
  </div>
</div>
	  <br>
	<div class="card">
  <div class="card-body">
    <h5 class="card-title">Información de Póliza</h5>
    <p class="card-text">Muestra Todas las pólizas asociadas</p>
  <table id="listado_clientes" class="table" width="100%">
            <tr>
                <thead>
                    
                    <th>N° Póliza</th>
                    <th>Compañía</th>
                    <th>Materia Asegurada</th>
                    <th>Asegurado</th>
                    <th>Proponente</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Deducible</th>
                  </thead>
            </tr>
        </table>
  </div>
</div>  
	  <br>
	<div class="card">
  <div class="card-body">
    <h5 class="card-title">Tareas Asociadas</h5>
    <p class="card-text">Todas las Tareas asociadas al cliente o pólizas</p>
  <table id="listado_clientes" class="table" width="100%">
            <tr>
                <thead>
                   
                    <th>Prioridad</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Número de Póliza</th>
                    <th>Asegurado</th>
                    <th>Proponente</th>
                    <th>Tarea a Realizar</th>
                    
                  </thead>
            </tr>
        </table>
  </div>
</div>  
	
	
	</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>
</html>
