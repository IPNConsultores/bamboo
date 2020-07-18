<?php
if ( !isset( $_SESSION ) ) {
  session_start();
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

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/assets/css/datatables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
<script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>

<body>
<!-- body code goes here -->

<?php include 'header2.php' ?>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<div class="container">
 
 <p> Resumen / Busqueda:  <br>
 <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="clientes" data-toggle="tab" href="#nav-cliente" role="tab" aria-controls="nav-cliente" aria-selected="true" style="color: white;background-color:#536656 " onclick="cambiacolor(this.id)">Cliente</a>
    <a class="nav-item nav-link" id="poliza" data-toggle="tab" href="#nav-poliza" role="tab" aria-controls="nav-poliza" aria-selected="false" style="color: grey" onclick="cambiacolor(this.id)">Póliza</a>
    <a class="nav-item nav-link" id="tarea" data-toggle="tab" href="#nav-tarea" role="tab" aria-controls="nav-tarea" aria-selected="false" style="color: grey" onclick="cambiacolor(this.id)">Tarea</a>
     <a class="nav-item nav-link" id="tarea_rec" data-toggle="tab" href="#nav-tarea_rec" role="tab" aria-controls="nav-tarea_rec" aria-selected="false"style="color: grey" onclick="cambiacolor(this.id)">Tarea Recurrente</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-cliente" role="tabpanel" aria-labelledby="nav-cliente-tab">
      <br>
      <br>
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
  <div class="tab-pane fade" id="nav-poliza" role="tabpanel" aria-labelledby="nav-poliza-tab">
      <br>
      <table class="displat" style="width:100%" id="listado_polizas">
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
  <div class="tab-pane fade" id="nav-tarea" role="tabpanel" aria-labelledby="nav-tarea-tab">
      <br>
      <table class="table" id="tareas_completas" style="width:100%">
                            <tr>
                                <th></th>
                                <th>id</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Tarea</th>
                               <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </table>
                        <div id="botones_tareas"></div>
  </div>
  <div class="tab-pane fade" id="nav-tarea_rec" role="tabpanel" aria-labelledby="nav-tarea_rec-tab">
      <br>
      <table class="table" id="tareas_completas" style="width:100%">
                            <tr>
                                <th></th>
                                <th>id</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Tarea</th>
                               <th></th>
                                <th></th>
                            </tr>
                        </table>
                        <div id="botones_tareas"></div>
      
  </div>
</div>
 
 </div>
 </body>
 
 <script>
     
     function cambiacolor(id){
         
         document.getElementById("clientes").style.backgroundColor = "white"
         document.getElementById("clientes").style.color = "grey"
         document.getElementById("poliza").style.backgroundColor = "white"
         document.getElementById("poliza").style.color = "grey"
          document.getElementById("tarea").style.backgroundColor = "white"
         document.getElementById("tarea").style.color = "grey"
           document.getElementById("tarea_rec").style.backgroundColor = "white"
         document.getElementById("tarea_rec").style.color = "grey"
         
         
        document.getElementById(id).style.backgroundColor = "#536656"
        document.getElementById(id).style.color = "white"
     }
     
 </script>
 
 