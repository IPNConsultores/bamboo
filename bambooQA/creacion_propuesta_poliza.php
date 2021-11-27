<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}
$camino = 'crear_propuesta';
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" and isset( $_POST[ "numero_propuesta" ]) == true ) {
  $camino = $_POST["accion"];
}

function estandariza_info( $data ) {
  $data = trim( $data );
  $data = stripslashes( $data );
  $data = htmlspecialchars( $data );
  return $data;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="/bambooQA/images/bamboo.png">
<!-- Bootstrap --> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
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
<div id=titulo1 style="display:flex">
  <p>Propuesta de Póliza / Creación<br>
  </p>
</div>
<div id=titulo2 style="display:none">
  <p>Propuesta de Póliza / Modificación / N° Póliza :
    <?php  echo $nro_poliza; ?>
    -
    <?php  echo $selcompania; ?>
    <br>
  </p>
</div>
<div class="form-check form-check-inline">
<div class="col align-self-end" id="botones_edicion" style="display:none ;align-items: center;">
  <button type="button" class="btn btn-second" id="edicion1" onclick="habilitaedicion1()"
                    style="background-color: #536656; margin-right: 5px ;color: white; display: flex">Editar</button>
  
</div>

</div>
<!-- --------------------------------------------                -->
 
<!-- --------------------------------------------                -->

<form action="/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php" class="needs-validation" method="POST" id="formulario"  novalidate>
  <div class="form-check form-check-inline">
    <label class="form-check-label">¿Cliente Asegurado y Proponente son la misma
      persona?:&nbsp;&nbsp;</label>
    <input class="form-check-input" type="radio" name="diferentes" id="radio2_no"
                        value="diferentes" onchange="checkRadio2(this.name)">
    <label class="form-check-label">No&nbsp;</label>
    <input class="form-check-input" type="radio" name="iguales" id="radio2_si" value="iguales"
                        onclick="checkRadio2(this.name)" checked="checked" onchange="copiadatos()">
    <label class="form-check-label" for="inlineRadio2">Si&nbsp;&nbsp;</label>
    <input type="text" class="form-control" id="contador" name="contador" value ="0" style="display:none">
    
  </div>
          
  <!-- Datos Cliente -->
  
    <br>
    <br>
    <p><strong>Datos Proponente<br>
      </strong></p>
    <div class="form-row">
      <div class="col-md-3 mb-3">
        <label for="RUT">RUT</label>
        <label style="color: darkred">&nbsp; *</label>
        <input type="text" class="form-control" id="rutprop" name="rutprop"
                              placeholder="1111111-1" oninput="checkRut(this);copiadatos()"
                              onchange="valida_rut_duplicado_prop();copiadatos();"
                               readonly required>
        <div class="invalid-feedback">Dígito verificador no válido. Verifica rut </div>
      </div>
      <button type="button" class="btn btn-secondary" id="busca_rut_prop" data-toggle="modal"
                          onclick="origen_busqueda(this.id,0)" data-target="#modal_cliente"
                          style="background-color: #536656; color: white; margin-top: 30px;margin-left: 5px; height: 40px">Buscar
      RUT</button>
      <div class="modal fade" id="modal_cliente" tabindex="-1" role="dialog"
                          aria-labelledby="modal_text_cliente" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_text_cliente">Buscar RUT</h5>
              <button type="button" class="close" data-dismiss="modal"
                                          aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <table id="listado_clientes" class="display" width="100%">
                  <tr>
                  <thead>
                  <th></th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Referido por</th>
                    <th>Grupo</th>
                    <th>apellidop</th>
                    </thead>
                  </tr></table>
                <div id="botones_cliente"></div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-1 ">
        <label for="prop">&nbsp;</label>
        <br>
      </div>
      <div class="col">
        <label for="Nombre">Nombre</label>
        <label style="color: darkred">&nbsp; *</label>
        <input type="text" id="nombre_prop" class="form-control" name="nombre"
                              oninput="checkRut(this);copiadatos()"
                              onchange="valida_rut_duplicado_prop();copiadatos();"  disabled required>
                              
        <div   style="color:red; font-size: 12px ; visibility: hidden" id="validador10">No puedes dejar este campo
          en blanco</div>
             <br>
      </div>
      <div class="col-md-4 mb-3" style="display:none">
        <label for="ApellidoP">Apellido Paterno</label>
        <input type="text" id="apellidop_prop" class="form-control" onchange="copiadatos()"
                              name="apellidop" disabled>
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3" style="display:none">
        <label for="ApellidoM">Apellido Materno</label>
        <input type="text" id="apellidom_prop" class="form-control" name="apellidom"
                              onchange="copiadatos()" disabled>
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
    </div>
  

    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne" style="background-color:whitesmoke">
          <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                              aria-expanded="true" aria-controls="collapseOne" style="color:#536656">Datos Propuesta de Póliza</button>
          </h5>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body" id="card-body-one">
            <label for = "id_propuesta"><b>Datos Propuesta</b></label>
            <br>
          <div class="form-row">
              <div class="col-4" style= "display:none">
                <label for="seguimiento">N° de Seguimiento:&nbsp;</label>
                <label style="color: darkred">*</label>
                <input type="text" class="form-control" id="nro_propuesta" name="nro_propuesta" >
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
              </div>
          
          <div class="col-4">
                <label for="seguimiento">Fecha Ingreso Propuesta:&nbsp;</label>
                <label style="color: darkred">*</label>
                <div class="md-form">
                  <input placeholder="Selected date" type="date" name="fechaprop" id="fechaprop" value="<?php echo date("Y-m-d");?>"
                      class="form-control"  oninput="valida_vencimiento()" max= "9999-12-31" required>
                      <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                </div>
          </div>
          </div>
          <br>
          <br>
          <label for = "datos_poliza"><b>Datos Póliza</b></label>
            <br>
          <div class ="form-row">
              <div class="col-3">
                <label for="Nombre">Vigencia Inicial</label>
                <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                  <input placeholder="Selected date" type="date" id="fechainicio" name="fechainicio"
                                          class="form-control" onchange="validadorfecha(this.id)" max= "9999-12-31" required>
                                          <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                </div>
                <div style="color:red; visibility: hidden" id="validador5">Debes seleccionar Fecha de
                  Inicio</div>
              </div>
              <div class="col-3">
                <label for="Nombre">Vigencia Final</label>
                <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                  <input placeholder="Selected date" type="date" name="fechavenc" id="fechavenc"
                                          class="form-control"  oninput="valida_vencimiento()" max= "9999-12-31" required>
                                          <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                </div>
                <div style="color:red; visibility: hidden" id="validador6">Debes seleccionar Fecha de
                  Vencimiento</div>
              </div>
              <div class="col-inline">
            <label for="moneda_poliza">Moneda Póliza</label>
            
              <select class="form-control" id="moneda_poliza" name="moneda_poliza" onChange="cambio_moneda(); pobladeducible()">
                <option value="UF" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "UF") echo "selected" ?>>UF</option>
                <option value="USD" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "USD") echo "selected" ?>>USD</option>
                <option value="CLP" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "CLP") echo "selected" ?>>CLP</option>
              </select>
            
          </div>
              
          </div>
          
          <div class ="form-row">
              <div class="col">
            
            <label for="compania">Compañía</label>
            <label style="color: darkred">&nbsp; *</label>
            <select class="form-control" name="selcompania" id="selcompania" required>
                  <option value="">Selecciona una compañía</option>
                  <option value="Axa Assistance"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Axa Assistance") echo "selected" ?>>Axa Assistance</option>
                  <option value="BCI Seguros"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "BCI Seguros") echo "selected" ?>>BCI Seguros</option>
                  <option value="Chilena Consolidada"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Chilena Consolidada") echo "selected" ?>>Chilena Consolidada</option>
                  <option value="CHUBB"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "CHUBB") echo "selected" ?>>CHUBB</option>
                  <option value="Confuturo"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Confuturo") echo "selected" ?>>Confuturo</option>
                  <option value="Consorcio"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Consorcio") echo "selected" ?>>Consorcio</option>
                  <option value="Continental"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Continental") echo "selected" ?>>Continental</option>
                  <option value="Contempora"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Contempora") echo "selected" ?>>Contempora</option>
                  <option value="Coris"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Coris") echo "selected" ?>>Coris</option>
                  <option value="HDI Seguros"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "HDI Seguros") echo "selected" ?>>HDI Seguros</option>
                  <option value="Liberty"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Liberty") echo "selected" ?>>Liberty</option>                       
                                          
                  <option value="Mapfre"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Mapfre") echo "selected" ?>>Mapfre</option>
                  <option value="Ohio National Financial Group"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Ohio National Financial Group") echo "selected" ?>>Ohio National</option>
                  <option value="Orsan"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Orsan") echo "selected" ?>>Orsan</option>
                  <option value="Reale Seguros"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Reale Seguros") echo "selected" ?>>Reale Seguros</option>
                  <option value="Renta Nacional"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Renta Nacional") echo "selected" ?>>Renta Nacional</option>
                  <option value="Southbridge"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Southbridge") echo "selected" ?>>Southbridge</option>
                  <option value="Sur Asistencia"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Sur Asistencia") echo "selected" ?>>Sur Asistencia</option>
                  <option value="Suaval"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Suaval") echo "selected" ?>>Suaval</option>
                  <option value="Sura"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Sura") echo "selected" ?>>Sura</option>
                  <option value="STARR"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "STARR") echo "selected" ?>>STARR</option>
                  <option value="Unnio"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $selcompania == "Unnio") echo "selected" ?>>Unnio</option>
                </select>
                <div class="invalid-feedback">Debes seleccionar una Compañía</div>
              
              
          </div>
          <div class="col-6">
                <label for="sel1">Ramo:&nbsp;</label>
                <label style="color: darkred">*</label>
                <select class="form-control" name="ramo" id="ramo" onChange="vencimientogarantia();cambia_deducible();" required> 
                                        
                  <option value="">Selecciona un ramo</option>
                  <option value="AC - Accidentes Personales"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="AC - Accidentes Personales") echo "selected" ?>>ACCIDENTES PERSONALES - Accidentes Personales</option>
                  <option value="AC - Protección Financiera"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="AC - Protección Financiera") echo "selected" ?>>ACCIDENTES PERSONALES - Protección Financiera</option>
                  <option value="ASISTENCIA EN VIAJE"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="ASISTENCIA EN VIAJE") echo "selected" ?>>ASISTENCIA EN VIAJE</option>
                  <option value="INC - Condominio"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="INC - Condominio") echo "selected" ?>>INCENDIO - Condominio</option>
                  <option value="INC - Hogar"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="INC - Hogar") echo "selected" ?>>INCENDIO - Hogar</option>
                  <option value="INC - Misceláneos"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="INC - Misceláneos") echo "selected" ?>>INCENDIO - Misceláneos</option>
                  <option value="INC - Perjuicio por Paralización"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="INC - Perjuicio por Paralización") echo "selected" ?>>INCENDIO - Perjuicio por Paralización</option>
                  <option value="INC - Pyme"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="INC - Pyme") echo "selected" ?>>INCENDIO - Pyme</option>
                  <option value="INC - TRBF (Todo Riesgo Bienes Físicos)"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="INC - TRBF (Todo Riesgo Bienes Físicos)") echo "selected" ?>>INCENDIO - TRBF (Todo Riesgo Bienes Físicos)</option>
                  <option value="D&O Condominio"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="D&O Condominio") echo "selected" ?>>RESPONSABILIDAD CIVIL - D&O Condominio</option>
                  <option value="RC General"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="RC General") echo "selected" ?>>RESPONSABILIDAD CIVIL - RC General</option>
                  <option value="VEH - Vehículos Comerciales Livianos"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="VEH - Vehículos Comerciales Livianos") echo "selected" ?>>VEHÍCULOS - Vehículos Comerciales Livianos</option>
                  <option value="VEH - Vehículos Particulares"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="VEH - Vehículos Particulares") echo "selected" ?>>VEHÍCULOS - Vehículos Particulares</option>
                  <option value="VEH - Vehículos Pesados"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="VEH - Vehículos Pesados") echo "selected" ?>>VEHÍCULOS - Vehículos Pesados</option>
                  <option value="null">--------------------------------------------------------------</option>
                  <option value="AVERÍA DE MAQUINARIA"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="AVERÍA DE MAQUINARIA") echo "selected" ?>>AVERÍA DE MAQUINARIA</option>
                  <option value="CASCO - Aéreo"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="CASCO - Aéreo") echo "selected" ?>>CASCO - Aéreo</option>
                  <option value="CASCO - Marítimo"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="CASCO - Marítimo") echo "selected" ?>>CASCO - Marítimo</option>
                  <option value="Garantía"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="Garantía") echo "selected" ?>>GARANTÍA</option>
                  <option value="ING - Equipo Contratistas"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="ING - Equipo Contratistas") echo "selected" ?>>INGENIERÍA - Equipo Contratistas</option>
                  <option value="ING - Equipo Móvil Agrícola"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="ING - Equipo Móvil Agrícola") echo "selected" ?>>INGENIERÍA - Equipo Móvil Agrícola</option>
                  <option value="ING - Equipos Electrónicos"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="ING - Equipos Electrónicos") echo "selected" ?>>INGENIERÍA - Equipos Electrónicos</option>
                  <option value="ING- TRC (Todo Riesgo Construcción)"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="ING- TRC (Todo Riesgo Construcción)") echo "selected" ?>>INGENIERÍA - TRC (Todo Riesgo Construcción)</option>
                  <option value="REMESA DE VALORES"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="REMESA DE VALORES") echo "selected" ?>>REMESA DE VALORES</option>
                  <option value="ROBO CON FUERZA"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="ROBO CON FUERZA") echo "selected" ?>>ROBO CON FUERZA EN LAS COSAS Y VIOLENCIA EN LAS PERSONAS</option>
                  <option value="ROTURA DE CRISTALES"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="ROTURA DE CRISTALES") echo "selected" ?>>ROTURA DE CRISTALES</option>
                  <option value="SEGURO ARRIENDO"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="SEGURO ARRIENDO") echo "selected" ?>>SEGURO ARRIENDO</option>
                  <option value="SEGURO DE CRÉDITO"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="SEGURO DE CRÉDITO") echo "selected" ?>>SEGURO DE CRÉDITO</option>
                  <option value="CABOTAJE"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="CABOTAJE") echo "selected" ?>>TRANSPORTE - CABOTAJE</option>
                  <option value="INTERNACIONAL"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="INTERNACIONAL") echo "selected" ?>>TRANSPORTE - INTERNACIONAL</option>
                  <option value="APV"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="APV") echo "selected" ?>>VIDA - APV</option>
                  <option value="VIDA"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo =="VIDA") echo "selected" ?>>VIDA - VIDA</option>
                  <option value="AP"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo == "AP") echo "selected" ?>>AP</option>
                  <option value="D&O"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo == "D&O") echo "selected" ?>>D&O</option>
                  <option value="INC"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo == "INC") echo "selected" ?>>INC</option>
                  <option value="PyME"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo == "PyME") echo "selected" ?>>PyME</option>
                  <option value="RC"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo == "RC") echo "selected" ?>>RC</option>
                  <option value="VEH"
                                          <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $ramo == "VEH") echo "selected" ?>>VEH</option>
                </select>
                <div class="invalid-feedback">Debes seleccionar un Ramo</div>
                
           
            </div>
            
              
  </div>
  
                <br>
                <br>
             <label for="pago"><b>Vendedor</b></label>
              <br>
               <div class="form-row">
                <div class="col-md-4 mb-3">
                  <div class="form-row">
                    <div class="col" style="width:72%;" >
                      <input type="text" class="form-control" id="nombre_vendedor"
                                              name="nombre_vendedor" placeholder="Nombre Vendedor" style="width:72%;" >
                    </div>
                   </div>
                </div>
                </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo" style="background-color:whitesmoke">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                              data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
                              style="color:#536656">Datos Ítem</button>
          </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body" id="card-body-two">
  


          <label for = "id_item"><b>Información de Ítem</b></label><br>
          <div class="form-row">
    
          <div class="container" id="main" >
            
            
            <div class="container" style="overflow-x:auto;width:100%;height: auto">
              <table class="table"  id="mytable"  style="width:3500px">
                <tr>
                  <th style="width:20px">N° Ítem</th>
                  <th style="width:200px" >RUT Asegurado</th>
                  <th style="width:300px">Nombre Asegurado</th>
                  <th style="width:300px">Materia Asegurada <label style="color: darkred">*</label></th>
                  <th style="width:300px">Patente o Ubicación</th>
                  <th style="width:200px">Cobertura</th>
                  <th style="width:100px">Deducible</th>
                  <th style="width:50px">Prima Afecta</th>
                  <th style="width:50px">Prima Exenta</th>
                  <th style="width:50px">Prima Neta</th>
                  <th style="width:50px">Prima Bruta</th>
                  <th style="width:150px">Monto Asegurado <label style="color: darkred">*</label></th>
                  <th style="width:100px" id="titulo_venc_gtia">Vencimiento Garantía</th>
                  
                </tr>
              </table>
              <br>
            </div>
            <br>
            <br>
            <input type="button" id="btAdd" value="Añadir" class="btn"
                              style="background-color: #536656; color: white" />
            <input type="button" id="btRemove" value="Eliminar" class="btn"
                              style="background-color: #536656; color: white" />
          </div>
        </div>


        
      </div>
    </div>
    

    </div>
    <div class="card">
      <div class="card-header" id="headingthree" style="background-color:whitesmoke">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                              data-target="#collapsethree" aria-expanded="false" aria-controls="collapsethree"
                              style="color:#536656">Comentarios </button>
        </h5>
      </div>
      <div id="collapsethree" class="collapse" aria-labelledby="headingthree" data-parent="#accordionExample">
        <div class="card-body" id="card-body-three">
          <label for="comentario"><b>Comentarios</b></label>
          <br>
          <textarea class="form-control" rows="2" style="height:100px" id='comentario' name='comentario'
                              style="text-indent:0px" ;>
          </textarea>
        
        </div>
      </div>
    </div>
      <div class="card">
      <div class="card-header" id="headingfour" style="background-color:whitesmoke">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                              data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour"
                              style="color:#536656">Información de Póliza </button>
        </h5>
      </div>
      <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordionExample">
        <div class="card-body" id="card-body-four">
        
          <label for = "datos_poliza"><b>Datos Póliza</b></label>
            <br>
          <div class ="form-row">
              <div class="col-md-4 mb-3">
                <label for="poliza">Número de Poliza</label>
                <label style="color: darkred">&nbsp; *</label>
                <input type="text" class="form-control" id="nro_poliza" name="nro_poliza"
                                       style="width:72%;" required>
                </div>
          <div class="col-md-4 mb-3">
          <label for="fecha_emision_poliza">Fecha Emisión Póliza &nbsp;&nbsp;</label>
          <div class="md-form">
            <input placeholder="Selected date" type="date" id="fecha_emision_poliza" name="fecha_emision_poliza"
                                          class="form-control"  max= "9999-12-31" style="width:72%;">
          </div>
        </div>
      </div>
          <br> 
          <label for = "datos_poliza"><b>Comisión</b></label>
          <br>
        <div class="form-row">
            <div class="col-md-4 mb-3">
              <label>Porcentaje Comisión del Corredor</label>
              <div class="form-inline">
                <input type="text" class="form-control" id="porcentaje_comsion"
                                          name="porcentaje_comsion" onChange="calculacomision()">
                <div class="input-group-prepend"><span class="input-group-text"
                                              id="porcentaje_comi">%</span></div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="comision">Comisión Correspondiente</label>
              <div class="form-inline">
                <div class="input-group-prepend"><span class="input-group-text"
                                              id="moneda5">UF</span></div>
                <input type="text" class="form-control" id="comision" name="comision">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label>Comisión Bruta a Pago</label>
              <div class="form-inline">
                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                <input type="text" class="form-control" id="comisionbruta" name="comisionbruta">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label>Comisión Neta a Pago</label>
              <div class="form-inline">
                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                <input type="text" class="form-control" id="comisionneta" name="comisionneta">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label>Número de Boleta</label>
              
              <input type="text" class="form-control" name="boleta" id="boleta" style="width:72%;">
              
            </div>
            <div class="col-md-4 mb-3">
              <label for="fechadeposito">Fecha Depósito</label>
              <div class="md-form">
                <input placeholder="Selected date" type="date" name="fechadeposito"
                                          id="fechadeposito" class="form-control" onchange="validadorfecha(this.id)" max= "9999-12-31" style="width:72%;">
              </div>
            </div>
          </div>
          <br>
              <label for="comisionnegativa"><b>Comisión Negativa</b></label>
          <br>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="comision">Monto</label>
              <div class="form-inline">
                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                <input type="text" class="form-control" name="comisionneg" id="comisionneg">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="comision">Boleta Comisión Negativa</label>
              <input type="text" class="form-control" name="boletaneg" id="boletaneg" style="width:72%;">
            </div>
          </div>
          <br>
            <label for="infopago"><b>Información de Pago</b></label>
          <br>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="formapago">Forma de Pago</label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="form" style="display: flex; align-items: center;">
                <select class="form-control" name="modo_pago" id="modo_pago"
                                          onChange="modopago();" style="width:30%;" required>
                  <option value="">-</option>
                  <option value="PAT" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $modo_pago == "PAT") echo "selected" ?>>PAT</option>
                  <option value="PAC" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $modo_pago == "PAC") echo "selected" ?>>PAC</option>
                  <option value="Plan de pago"<?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $modo_pago == "Plan de pago") echo "selected" ?>>Plan de pago</option>
                  <option value="Contado" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $modo_pago == "Contado") echo "selected" ?>>Contado</option>
                </select>
                <select class="form-control" name="cuotas" id="cuotas" style="width:42%;">
                  <option value="">Número Cuotas</option>
                  <option value="Sin cuotas" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "Contado") echo "selected" ?>>Sin Cuotas</option>
                  <option value="2 Cuotas" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "2 Cuotas") echo "selected" ?>>2 Cuotas</option>
                  <option value="3 Cuotas" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "3 Cuotas") echo "selected" ?>>3 Cuotas</option>
                  <option value="4 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "4 Cuotas") echo "selected" ?>>4 Cuotas</option>
                  <option value="5 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "5 Cuotas") echo "selected" ?>>5 Cuotas</option>
                  <option value="6 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "6 Cuotas") echo "selected" ?>>6 Cuotas</option>
                  <option value="7 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "7 Cuotas") echo "selected" ?>>7 Cuotas</option>
                  <option value="8 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "8 Cuotas") echo "selected" ?>>8 Cuotas</option>
                  <option value="9 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "9 Cuotas") echo "selected" ?>>9 Cuotas</option>
                  <option value="10 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "10 Cuotas") echo "selected" ?>>10 Cuotas</option>
                  <option value="11 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "11 Cuotas") echo "selected" ?>>11 Cuotas</option>
                  <option value="12 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "12 Cuotas") echo "selected" ?>>12 Cuotas</option>
                  <option value="13 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "13 Cuotas") echo "selected" ?>>13 Cuotas</option>
                  <option value="14 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "14 Cuotas") echo "selected" ?>>14 Cuotas</option>
                  <option value="15 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "15 Cuotas") echo "selected" ?>>15 Cuotas</option>
                  <option value="16 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "16 Cuotas") echo "selected" ?>>16 Cuotas</option>
                  <option value="17 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "17 Cuotas") echo "selected" ?>>17 Cuotas</option>
                  <option value="18 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "18 Cuotas") echo "selected" ?>>18 Cuotas</option>
                  <option value="19 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "19 Cuotas") echo "selected" ?>>19 Cuotas</option>
                  <option value="20 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "20 Cuotas") echo "selected" ?>>21 Cuotas</option>
                  <option value="21 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "21 Cuotas") echo "selected" ?>>21 Cuotas</option>
                  <option value="22 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "22 Cuotas") echo "selected" ?>>22 Cuotas</option>
                  <option value="23 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "23 Cuotas") echo "selected" ?>>23 Cuotas</option>
                  <option value="24 Cuotas"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "24 Cuotas") echo "selected" ?>>24 Cuotas</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="valorcuota">Valor Cuota</label>
              <div class="form-inline">
                <select class="form-control" name="moneda_cuota" id="moneda_cuota" style="width:20%;">
                  <option value="UF"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_cuota == "UF") echo "selected" ?>>UF</option>
                  <option value="USD"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_cuota == "USD") echo "selected" ?>>USD</option>
                  <option value="CLP"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_cuota == "CLP") echo "selected" ?>>CLP</option>
                </select>
                <input type="text" class="form-control" name="valorcuota" id="valorcuota"
                                          oninput="concatenar(this.id)" style="width:52%;">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="fechaprimer">Fecha Primera Cuota</label>
              <div class="md-form">
                <input type="date" class="form-control" id="fechaprimer" name="fechaprimer" onchange="validadorfecha(this.id); valida_primerpago()" max= "9999-12-31" style="width:72%;">
              </div>
            </div>
          </div>
         
          </div>
        
        </div>
      </div>
    </div>
    <br>
    <div id="auxiliar2" style="display: none;"></div>
    <input id="auxiliar3" placeholder="false" style="display: none;" />
    
    <button class="btn" type="button" style="background-color: #536656; color: white"
              id='boton_submit' >Registrar</button>
</form>


<br>
<br>
</div>/
<script>

//function validadatos() {
            //// Fetch all the forms we want to apply custom Bootstrap validation styles to
//            var forms = document.getElementsByClassName('needs-validation');
            ////var form =document.getElementById('formulario');
            
            //var button = document.getElementById('boton_submit');
            // Loop over them and prevent submission
            //var validation = 
        //Array.prototype.slice.call(forms).forEach(function(form) {
          //      form.addEventListener('click', function(event) {
                   // if (form.checkValidity() === false) {
            //       console.log(form.checkValidity())
              //       if (!form.checkValidity() ) {
                         
                         
                //        event.preventDefault();
                  //      event.stopPropagation();
                      
                        
                //    }
                 //   form.classList.add('was-validated');
                //}, false);
            //});
        //};


$("#boton_submit").click(function(e){

    blnFormValidity= $('#formulario')[0].checkValidity()
    console.log(blnFormValidity)
   document.getElementById('formulario').classList.add('was-validated');
    if(blnFormValidity==false){
        e.preventDefault();
        return false
    }
    document.getElementById('auxiliar3').value = blnFormValidity;
    
    genera_propuesta();
})
 
 
    // Example starter JavaScript for disabling form submissions if there are invalid fields
  //  (function() {
     //   'use strict';
    //    window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
     //       var forms = document.getElementsByClassName('needs-validation');
            //var form =document.getElementById('formulario');
            
        //    var button = document.getElementById('boton_submit');
            // Loop over them and prevent submission
      //      var validation = Array.prototype.filter.call(forms, function(form) {
        //        form.addEventListener('submit', function(event) {
          //          if (form.checkValidity() === false) {
            //            event.preventDefault();
              //          event.stopPropagation();
                        
            //        }
              //      form.classList.add('was-validated');
        //        }, false);
         //   });
        //}, false);
    //})();
</script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

<script src="/assets/js/jquery.redirect.js"></script>
<script src="/assets/js/validarRUT.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>
</html><script>
function valida_rut_duplicado_prop() {
    var dato = $('#rutprop').val();
    console.log(dato);
    var rut_sin_dv = dato.replace('-', '');
    rut_sin_dv = rut_sin_dv.slice(0, -1);
    $.ajax({
        type: "POST",
        url: "/bambooQA/backend/clientes/busqueda_nombre.php",
        data: {
            rut: rut_sin_dv
        },
        dataType: 'JSON',
        success: function(response) {
            if (response.resultado == 'antiguo') {
                document.getElementById("nombre_prop").value = response.nombre;
                console.log(response.nombre)
                
            }
        }
    });
}
function valida_rut_duplicado_aseg(item) {
    var item2 = item;
    var dato =  document.getElementById("rutaseg[" + item2 + "]").value;
    console.log(dato);
    var rut_sin_dv = dato.replace('-', '');
    rut_sin_dv = rut_sin_dv.slice(0, -1);
    $.ajax({
        type: "POST",
        url: "/bambooQA/backend/clientes/busqueda_nombre.php",
        data: {
            rut: rut_sin_dv
        },
        dataType: 'JSON',
        success: function(response) {
            if (response.resultado == 'antiguo') {
                document.getElementById("nombre_seg[" + item + "]").value = response.nombre;
                console.log(response.nombre)
             
            }
        }
    });
}
function checkRadio(name) {
    if (name == "nueva") {
        document.getElementById("radio_si").checked = false;
        document.getElementById("radio_no").checked = true;
        document.getElementById("busca_poliza").style.display = "none";
        document.getElementById("poliza_renovada").style.display = "none"
    } else if (name == "renovacion") {
        document.getElementById("radio_no").checked = false;
        document.getElementById("radio_si").checked = true;
        document.getElementById("busca_poliza").style.display = "block";
        document.getElementById("poliza_renovada").style.display = "block";
        document.getElementById("poliza_renovada").disabled = true
    }
}
function checkRadio2(name) {
    
    var contador =  document.getElementById("contador").value;
   
    console.log(contador);
    if (name == "diferentes") {
        document.getElementById("radio2_si").checked = false;
        document.getElementById("radio2_no").checked = true;
        //document.getElementById("busca_rut_aseg").style.display = "flex";
        
        
        for (var i = 1; i <= contador; i++){
            
            document.getElementById("rutaseg[" + i + "]").value = ""
            document.getElementById("rutaseg[" + i + "]").disabled = false;
            document.getElementById("nombre_seg[" + i + "]").value = "";
            document.getElementById("nombre_seg[" + i + "]").disabled = false;
            document.getElementById("busca_rut_aseg[" + i + "]").style.display = "block";
            
            
             console.log(i);
             
             console.log(document.getElementById("rutaseg[" + i + "]").value);
            
        }
        
    } else if (name == "iguales") {
        document.getElementById("radio2_no").checked = false;
        document.getElementById("radio2_si").checked = true;
        //document.getElementById("rutaseg").disabled = true;
        //document.getElementById("busca_rut_aseg").style.display = "none";
        //document.getElementById("rutprop").value = document.getElementById("rutaseg").value;
        
        
        for (var i = 1; i <= contador; i++){
            
            document.getElementById("rutaseg[" + i + "]").value = document.getElementById("rutprop").value;
            document.getElementById("rutaseg[" + i + "]").disabled = true;
            document.getElementById("nombre_seg[" + i + "]").value = document.getElementById("nombre_prop").value;
            document.getElementById("nombre_seg[" + i + "]").disabled = true;
            document.getElementById("busca_rut_aseg[" + i + "]").style.display = "none";
            
            
             console.log(i);
             
             console.log(document.getElementById("rutaseg[" + i + "]").value);
            
        }
        
        console.log(document.getElementById("rutprop").value);
        
    }
}

function copiadatos() {
    if (document.getElementById("radio2_si").checked) {
        //document.getElementById("rutaseg").value = document.getElementById("rutprop").value;
        //document.getElementById("nombre_seg").value = document.getElementById("nombre_prop").value;
        //document.getElementById("apellidop_seg").value = document.getElementById("apellidop_prop").value;
        //document.getElementById("apellidom_seg").value = document.getElementById("apellidom_prop").value;
    } else {
    }
}


function cambio_moneda() {
    var moneda = document.getElementById("moneda_poliza").value;
    var ramo = document.getElementById("ramo").value;
     var contador = document.getElementById("contador").value;
     
     if (ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General") {
     for (var i = 1; i <= contador; i++)
     {
    console.log("si");
    document.getElementById("moneda2["+i+"]").innerHTML = moneda;
    document.getElementById("moneda3["+i+"]").innerHTML = moneda;
    document.getElementById("moneda4["+i+"]").innerHTML = moneda;
    document.getElementById("moneda5["+i+"]").innerHTML = moneda;
    document.getElementById("moneda7["+i+"]").innerHTML = moneda;
     }
     
     }
     
     else{
         
         for (var i = 1; i <= contador; i++)
            {
                
                document.getElementById("moneda2["+i+"]").innerHTML = moneda;
                document.getElementById("moneda3["+i+"]").innerHTML = moneda;
                document.getElementById("moneda4["+i+"]").innerHTML = moneda;
                document.getElementById("moneda5["+i+"]").innerHTML = moneda;
    
            }          
         }
}

function calculaprimabruta() {
    
    var contador = document.getElementById("contador").value;
     for (var i = 1; i <= contador; i++)
     {
         
    var primaafecta = document.getElementById("prima_afecta["+i+"]").value;
    var primaexenta = document.getElementById("prima_exenta["+i+"]").value;
    var primabruta;
    var primaneta;
    primabruta = parseFloat(primaafecta.replace(",", "."), 10) * (1.19) + parseFloat(primaexenta.replace(",", "."))
    primaneta = parseFloat(primaafecta.replace(",", "."), 10) + parseFloat(primaexenta.replace(",", "."))
    document.getElementById("prima_bruta["+i+"]").value = primabruta.toFixed(2).replace(".", ",")
    document.getElementById("prima_neta["+i+"]").value = primaneta.toFixed(2).replace(".", ",")
    
     }
}


function cambia_deducible() {
    
    var ramo = document.getElementById("ramo").value;
    var contador = document.getElementById("contador").value;
      
    if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo == "VEH - Vehículos Particulares" ||
        ramo == "VEH - Vehículos Pesados") {
        console.log("si");
        
        for (var i = contador; i <= contador; i++){
            
               console.log("si2");
               
               document.getElementById("div_deducible["+i+"]").innerHTML = '<div class="form-inline" id="deducible_defecto[' +i+ ']" style="display:flex ;align-items: center;">'+
               '<select class="form-control" id="deducible_veh_1" name="deducible_veh_1">'+
               '<option value="null" ?>Selecciona el deducible </option>'+
               '<option value="Sin deducible" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "Sin deducible") echo "selected" ?>>Sin deducible</option>'+
               '<option value="UF 3" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 3") echo "selected" ?>>UF 3</option>'+
               '<option value="UF 5" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 5") echo "selected" ?>>UF 5</option>'+
               '<option value="UF 10" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 10") echo "selected" ?>>UF 10</option>'+
               '<option value="UF 20" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 20") echo "selected" ?>>UF 20</option>'+
               '<option value="UF 50" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 50") echo "selected" ?>>UF 50</option>'+
                '</select></div>';
                          
                      }
        
        
        
    } else if (ramo == "INC" || ramo == "Hogar" || ramo == "PyME" || ramo == "INC - Condominio" || ramo ==
        "INC - Hogar" || ramo == "INC - Misceláneos" || ramo == "INC - Perjuicio por Paralización" || ramo ==
        "INC - Pyme" || ramo == "INC - TRBF (Todo Riesgo Bienes Físicos)") {
      
      
     
        for (var i = 1; i <= contador; i++){
            
            
               
               document.getElementById("div_deducible["+i+"]").innerHTML = '<div class="form-inline" id="deducible_defecto[' +i+ ']">'+
              '<input type="text" class="form-control" name="deducible_inc_1" id="deducible_inc_1" value="Varios" onChange="pobladeducible()"></div>';
                          
                      }
        
      
      
            

    } else if (ramo == "A. VIAJE" || ramo == "APV" || ramo == "AP" || ramo == "Vida" || ramo == "Garantía" || ramo ==
        "AC - Accidentes Personales" || ramo == "AC - Protección Financiera" || ramo == "ASISTENCIA EN VIAJE" || ramo ==
        "APV" || ramo == "VIDA") {
        
         for (var i = 1; i <= contador; i++){
            
            
               
               document.getElementById("div_deducible["+i+"]").innerHTML = '<div class="form-inline" id="deducible_defecto[' +i+ ']">'+
              '<input type="text" class="form-control" name="deducible_viaje_1" id="deducible_viaje_1" value="No Aplica" onChange="pobladeducible()"></div>';
                          
         }
        

    } else if (ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General") {



         for (var i = 1; i <= contador; i++){
            
            id="deducible_defecto[' +i+ ']"
               
               document.getElementById("div_deducible["+i+"]").innerHTML = '<div class="form-row" id="deducible_rc['+i+']"  align-items: center;">'+
               '<div class="col-2">'+
                '<input type="text" class="form-control" name="deducible_porcentaje" id="deducible_porcentaje['+i+']" placeholder="%" style="width:44px">'+
              '</div>'+
              '<label style="font-size:75%;">% Pérdida con mínimo de</label><br>'+
              '<div class="col" style="display: flex; align-items: center;">'+
              ' <div class="input-group-prepend"><span class="input-group-text" id="moneda7['+i+']">UF</span></div>'+
               ' <input type="text" class="form-control" name="deducible_valor" id="deducible_valor['+i+']" placeholder="Valor" onChange="pobladeducible()"></div></div>'+
               '<div class="form-inline" style="display:none" ><input type="text" class="form-control" name="deducible" id="deducible_defecto[' +i+ ']"></div>'
                          
         }
        
        
            
    } else {
        
    }
}

function pobladeducible(){
    
     var contador = document.getElementById("contador").value;
     var ramo = document.getElementById("ramo").value;
     if (ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General") {
     for (var i = 1; i <= contador; i++){
         
          document.getElementById('deducible_defecto[' +i+ ']').value = document.getElementById('deducible_porcentaje['+i+']').value +
            "% de la Pérdida con mínimo de " + document.getElementById('moneda7['+i+']').innerHTML + " " + document
            .getElementById('deducible_valor['+i+']').value;
         
         
     }
     
     }
     
  
}

$('#test1').on('shown.bs.modal', function() {
    console.log("test");
    /*

    */
    //$('#modal_text').trigger('focus')
})
var tabla_clientes = $('#listado_clientes').DataTable({

    "ajax": "/bambooQA/backend/clientes/busqueda_listado_clientes.php",
    "scrollX": true,
    "columns": [{
            "className": 'details-control',
            "orderable": false,
            "data": "rut",
            "render": function(data, type, full, meta) {
                return '<button type="button" id="' + data +
                    '" onclick="seleccion_rut(this.id)" class="btn btn-outline-primary">Seleccionar</button>';
            }
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
            "data": "apellidop"
        }

    ],
    "columnDefs": [{
            "targets": [5],
            "visible": false,
        },
        {
            "targets": [5],
            "searchable": false
        }
    ],
    "order": [
        [5, "asc"]
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
var origen = '';
var item='';
function origen_busqueda(origen_boton, indice_item) {
    console.log('origen: <' +origen_boton +'> - nro_item: <'+ indice_item +'>')
    origen = origen_boton;
    item=indice_item
}
function seleccion_rut(rut) {

    switch (origen.substring(0,14)) {
        case 'busca_rut_prop': {
            document.getElementById("rutprop").value = rut;
            document.getElementById("rutprop").onchange();
            //document.getElementById("rutaseg").onchange()
            break;
        }
        case 'busca_rut_aseg': {
            console.log("rutaseg[" + item + "]")
            document.getElementById("rutaseg[" + item + "]").value = rut;
           
            document.getElementById("rutaseg[" + item + "]").onchange();
            break;
        }
        default: {
            break;
        }
    }
    $('#modal_cliente').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}




function habilitaedicion1() {
    var fields1 = document.getElementById("card-body-one").getElementsByTagName('*');
    for (var i = 0; i < fields1.length; i++) {
        fields1[i].disabled = false;
    }
    var fields2 = document.getElementById("card-body-two").getElementsByTagName('*');
    for (var i = 0; i < fields2.length; i++) {
        fields2[i].disabled = false;
    }
    var fields3 = document.getElementById("card-body-three").getElementsByTagName('*');
    for (var i = 0; i < fields3.length; i++) {
        fields3[i].disabled = false;
    }
    var fields4 = document.getElementById("card-body-four").getElementsByTagName('*');
    for (var i = 0; i < fields4.length; i++) {
        fields4[i].disabled = false;
    }
    document.getElementById("rutprop").readonly = true;
    //document.getElementById("rutaseg").readonly = true;
    document.getElementById("nombre_prop").disabled = true;
    document.getElementById("nombre_prop").readonly = true;
    document.getElementById("nombre_seg").disabled = true;
    document.getElementById("edicion1").style.display = "none";
    document.getElementById("anular").style.display = "none";
    document.getElementById("cancelar1").style.display = "none";
    document.getElementById("boton_submit").style.display = "flex";
      bPreguntar = false;
}
document.addEventListener("DOMContentLoaded", function(event) {
    var bPreguntar = true;
    

	//window.onbeforeunload = preguntarAntesDeSalir;
 
	function preguntarAntesDeSalir () {
	    
	
		var respuesta;
 
		if ( bPreguntar ) {
			respuesta = confirm ( '¿Seguro que quieres salir?' );
 
			if ( respuesta ) {
				window.onunload = function () {
					return true;
				}
			} else {
				return false;
			}
		}
	}
	
    var consulta= '<?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && isset( $_POST[ "numero_propuesta" ]) == true ) echo "True"; ?>'
    if (consulta=='True'){
        var orgn = '<?php echo $camino; ?>';
        switch (orgn) {
            case 'modificar': {
                    if ('<?php echo $rut_completo_prop; ?>' == '<?php echo $rut_completo_aseg; ?>') {
                        document.getElementById("radio2_si").checked = true;
                        document.getElementById("radio2_no").checked = false;
                    }
                    if ('<?php echo $estado; ?>' == "Cancelado") {
                        document.getElementById("datos_cancelacion").style.display = "block";
                        document.getElementById("cancelar").style.display = "none";
                        document.getElementById("cancelar1").style.display = "none";
                        document.getElementById("datofecha_cancelacion").readOnly = true;
                        document.getElementById("datomotivo_cancela").readOnly = true;
                    }
                    if ('<?php echo $venc_gtia; ?>' !== "0000-00-00"){
                        document.getElementById("pregunta_gtia").checked = true;
                        document.getElementById("venc_gtia").readOnly = false;
                        
                        
                    }
                    
                    
                    document.getElementById("titulo1").style.display = "none";
                    document.getElementById("titulo2").style.display = "flex";
                    document.getElementById("pregunta_renovar").style.display = "none";
                    document.getElementById("ramo").value = '<?php echo $ramo; ?>';
                    document.getElementById("rutprop").value = '<?php echo $rut_completo_prop; ?>';
                    //document.getElementById("rutaseg").value = '<?php echo $rut_completo_aseg; ?>';
                    document.getElementById("fechainicio").value = '<?php echo $fechainicio; ?>';
                    document.getElementById("fechavenc").value = '<?php echo $fechavenc; ?>';
                    document.getElementById("nro_poliza").value = '<?php echo $nro_poliza; ?>';
                    document.getElementById("cobertura").value = '<?php echo $cobertura; ?>';
                    document.getElementById("materia").value = '<?php echo $materia; ?>';
                    document.getElementById("detalle_materia").value = '<?php echo $detalle_materia; ?>';
                    document.getElementById("deducible").value = '<?php echo $deducible; ?>';
                    document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza; ?>';
                    document.getElementById("prima_afecta").value = '<?php echo $prima_afecta; ?>';
                    document.getElementById("prima_exenta").value = '<?php echo $prima_exenta; ?>';
                    document.getElementById("prima_neta").value = '<?php echo $prima_neta; ?>';
                    document.getElementById("prima_bruta").value = '<?php echo $prima_bruta; ?>';
                    document.getElementById("monto_aseg").value = '<?php echo $monto_aseg; ?>';
                    document.getElementById("nro_propuesta").value = '<?php echo $nro_propuesta; ?>';
                    document.getElementById("fechaprop").value = '<?php echo $fechaprop; ?>';
                    document.getElementById("comision").value = '<?php echo $comision; ?>';
                    document.getElementById("porcentaje_comsion").value = '<?php echo $porcentaje_comsion; ?>';
                    document.getElementById("comisionbruta").value = '<?php echo $comisionbruta; ?>';
                    document.getElementById("comisionneta").value = '<?php echo $comisionneta; ?>';
                    document.getElementById("fechadeposito").value = '<?php echo $depositado_fecha; ?>';
                    document.getElementById("comisionneg").value = '<?php echo $comision_negativa; ?>';;
                    document.getElementById("boletaneg").value = '<?php echo $boleta_negativa; ?>';
                    document.getElementById("boleta").value = '<?php echo $boleta; ?>';
                    document.getElementById("cuotas").value = '<?php echo $cuotas; ?>';
                    document.getElementById("valorcuota").value = '<?php echo $valorcuota; ?>';
                    document.getElementById("fechaprimer").value = '<?php echo $fechaprimer; ?>';
                    document.getElementById("nombre_vendedor").value = '<?php echo $nombre_vendedor; ?>';
                    document.getElementById("formulario").action = "/bambooQA/backend/propuesta_polizas/modifica_propuesta_polizas.php";
                    
                    document.getElementById("numero_propuesta").value = '<?php echo $numero_propuesta; ?>';
                    document.getElementById("endoso").value = '<?php echo $endoso; ?>';
                    document.getElementById("comentario").value = '<?php echo $comentario; ?>';
                    document.getElementById("boton_submit").childNodes[0].nodeValue = "Guardar cambios";
                    document.getElementById("boton_submit").style.display = "none";
                    document.getElementById("venc_gtia").value = '<?php echo $venc_gtia; ?>';
                    
                    document.getElementById("datofecha_cancelacion").value = '<?php echo $fech_cancela; ?>';
                    document.getElementById("datomotivo_cancela").value = '<?php echo $motivo_cancela; ?>';

                    document.getElementById("item").value = '<?php echo $item; ?>';
                    
                    valida_rut_duplicado_prop();
                    valida_rut_duplicado_aseg();
                    document.getElementById("botones_edicion").style.display = "flex"
                    var fields1 = document.getElementById("card-body-one").getElementsByTagName('*');
                    for (var i = 0; i < fields1.length; i++) {
                        fields1[i].disabled = true;
                    }
                    var fields2 = document.getElementById("card-body-two").getElementsByTagName('*');
                    for (var i = 0; i < fields2.length; i++) {
                        fields2[i].disabled = true;
                    }
                    var fields3 = document.getElementById("card-body-three").getElementsByTagName('*');
                    for (var i = 0; i < fields3.length; i++) {
                        fields3[i].disabled = true;
                    }
                    var fields4 = document.getElementById("card-body-four").getElementsByTagName('*');
                    for (var i = 0; i < fields4.length; i++) {
                        fields4[i].disabled = true;
                    }
                    var ramo = document.getElementById("ramo").value;
                    if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo ==
                        "VEH - Vehículos Particulares" || ramo == "VEH - Vehículos Pesados") {
                        document.getElementById("deducible_veh").style.display = "flex";
                                document.getElementById("vencimiento_gtia").style.display = "flex";
                        document.getElementById("deducible_defecto").style.display = "none";
                        var deducible = document.getElementById("deducible").value;
                        document.getElementById("deducible_veh_1").value = deducible;
                    } else if (ramo == "INC" || ramo == "Hogar" || ramo == "PyME" || ramo == "INC - Condominio" ||
                        ramo == "INC - Hogar" || ramo == "INC - Misceláneos" || ramo ==
                        "INC - Perjuicio por Paralización" || ramo == "INC - Pyme" || ramo ==
                        "INC - TRBF (Todo Riesgo Bienes Físicos)") {
                        document.getElementById("deducible_defecto").style.display = "none";
                        document.getElementById("deducible_inc").style.display = "flex";
                        var deducible = document.getElementById("deducible").value;
                        document.getElementById("deducible_inc_1").value = deducible;
                    } else if (ramo == "A. VIAJE" || ramo == "APV" || ramo == "AP" || ramo == "Vida" || ramo ==
                        "Garantía" || ramo == "AC - Accidentes Personales" || ramo == "AC - Protección Financiera" ||
                        ramo == "ASISTENCIA EN VIAJE" || ramo == "APV" || ramo == "VIDA") {
                        document.getElementById("deducible_defecto").style.display = "none";
                        document.getElementById("deducible_viaje").style.display = "flex";
                        var deducible = document.getElementById("deducible").value;
                        document.getElementById("deducible_viaje_1").value = deducible;
                    } else if (ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General") {
                        document.getElementById("deducible_defecto").style.display = "none";
                        document.getElementById("deducible_rc").style.display = "flex";
                        var deducible = document.getElementById("deducible").value
                        var cadena = document.getElementById("deducible").value.split("%")
                        document.getElementById("deducible_porcentaje").value = cadena[0];
                        document.getElementById("moneda7").innerHTML = '<?php echo $moneda_poliza; ?>';
                        document.getElementById("deducible_valor").value = cadena[1].substring(cadena[1].length - 2,
                            cadena[1].length);
                    } else {
                        document.getElementById("deducible_defecto").value = document.getElementById("deducible")
                            .value;
                    }
                    var moneda = document.getElementById("moneda_poliza").value;
                    document.getElementById("moneda").innerHTML = moneda;
                    document.getElementById("moneda2").innerHTML = moneda;
                    document.getElementById("moneda3").innerHTML = moneda;
                    document.getElementById("moneda4").innerHTML = moneda;
                    document.getElementById("moneda5").innerHTML = moneda;
                    document.getElementById("moneda7").innerHTML = moneda;
                    break;
                    bPreguntar = false;
            }
            default:{
            break;
            }
        }
        document.querySelectorAll('input[type=text]').forEach(node => node.addEventListener('keypress', e => {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        }))
        var moneda = document.getElementById("moneda_poliza").value;
        document.getElementById("moneda").innerHTML = moneda;
        document.getElementById("moneda2").innerHTML = moneda;
        document.getElementById("moneda3").innerHTML = moneda;
        document.getElementById("moneda4").innerHTML = moneda;
        document.getElementById("moneda5").innerHTML = moneda;
        document.getElementById("moneda7").innerHTML = moneda;
    }
});


document.getElementById("busca_rut_prop").addEventListener("click", function(event) {
    event.preventDefault()
});

document.getElementById("formulario").addEventListener('submit', function(event) {

    if (document.getElementById("nombre_prop").value == "") {
        document.getElementById("validador10").style.visibility = "visible";
        event.preventDefault();
    }
});

function validadorfecha(id){
    
    var fechainicial = document.getElementById(id).value;
    fechafinal = new Date(9999,12,31)
   
    if( Date.parse(fechafinal) < Date.parse(fechainicial) ){
        alert("El año ingresado tiene mas de 4 dígitos");
        
    }
}




function vencimientogarantia(){
  var ramo = document.getElementById("ramo").value;
  var contador = document.getElementById("contador").value;
  
            if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo ==
                "VEH - Vehículos Particulares" || ramo == "VEH - Vehículos Pesados") {
                    console.log(ramo);
                for (var i = 1; i <= contador; i++){
                          document.getElementById("venc_gtia["+i+"]").disabled = false;
                          
                      }
                
            }
                else {      
              
                    for (var i = 1; i <= contador; i++){
              document.getElementById("venc_gtia["+i+"]").disabled =true;
              
              
             
                    }
                }
}



  function genera_propuesta(){
   //genera arrays por items
   
   if(document.getElementById("auxiliar3").value == "true")
   {
      var contador =  document.getElementById("contador").value;
      var rutaseg = [];
      var materia = [];
      var detalle_materia = [];
      var cobertura = [];
      var deducible = [];
      var prima_afecta = [];
      var prima_exenta = [];
      var prima_neta = [];
      var prima_bruta = [];
      var monto_aseg = [];
      var venc_gtia =[];
      for (var i = 1; i <= contador; i++){

        rutaseg.push(document.getElementById("rutaseg["+i+"]").value);
        materia.push(document.getElementById("materia["+i+"]").value);
        detalle_materia.push(document.getElementById("detalle_materia["+i+"]").value);
        cobertura.push(document.getElementById("cobertura["+i+"]").value);
        deducible.push(document.getElementById("deducible_defecto["+i+"]").value);
        prima_afecta.push(document.getElementById("prima_afecta["+i+"]").value);
        prima_exenta.push(document.getElementById("prima_exenta["+i+"]").value);
        prima_neta.push(document.getElementById("prima_neta["+i+"]").value);
        prima_bruta.push(document.getElementById("prima_bruta["+i+"]").value);
        monto_aseg.push(document.getElementById("monto_aseg["+i+"]").value);
        venc_gtia.push(document.getElementById("venc_gtia["+i+"]").value);
      
      }
    //console.log(rutaseg);
   //envía información a
    //if (document.getElementById("headingfour").style.display =="none"){ Pendiente ocular datos póliza
    var camino='<?php echo $camino; ?>';
    switch (camino) {
        case 'crear_propuesta': {
          $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
          //$.redirect('/bambooQA/test_felipe.php', { 
            'accion': 'crear_propuesta',
          //Propuesta
          'rutprop': document.getElementById("rutprop").value,
          'fechaprop': document.getElementById("fechaprop").value,
          'nro_propuesta': document.getElementById("nro_propuesta").value, //automàtica
          'fechainicio': document.getElementById("fechainicio").value,
          'fechavenc': document.getElementById("fechavenc").value,
          'moneda_poliza': document.getElementById("moneda_poliza").value,
          'selcompania': document.getElementById("selcompania").value, 
          'ramo': document.getElementById("ramo").value, 
          'comentario': document.getElementById("comentario").value, 
          'nombre_vendedor': document.getElementById("nombre_vendedor").value,

          //Ítem
          'rutaseg':  rutaseg,
          'materia': materia,
          'detalle_materia': detalle_materia,
          'cobertura': cobertura,
          'deducible': deducible,
          'prima_afecta': prima_afecta,
          'prima_exenta': prima_exenta,
          'prima_neta': prima_neta,
          'prima_bruta': prima_bruta,
          'monto_aseg': monto_aseg,
          'venc_gtia': venc_gtia

          }, 'post');
      }
      break;
      case 'crear_poliza': {
          $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
          //$.redirect('/bambooQA/test_felipe.php', {  
          'accion': 'crear_poliza',

          //Propuesta
          'rutprop': document.getElementById("rutprop").value,
          'fechaprop': document.getElementById("fechaprop").value,
          'nro_propuesta': document.getElementById("nro_propuesta").value, //automàtica
          'fechainicio': document.getElementById("fechainicio").value,
          'fechavenc': document.getElementById("fechavenc").value,
          'moneda_poliza': document.getElementById("moneda_poliza").value,
          'selcompania': document.getElementById("selcompania").value, 
          'ramo': document.getElementById("ramo").value, 
          'comentario': document.getElementById("comentario").value,
          'nombre_vendedor': document.getElementById("nombre_vendedor").value,

          //Ítem
          'rutaseg':  rutaseg,
          'materia': materia,
          'detalle_materia': detalle_materia,
          'cobertura': cobertura,
          'deducible': deducible,
          'prima_afecta': prima_afecta,
          'prima_exenta': prima_exenta,
          'prima_neta': prima_neta,
          'prima_bruta': prima_bruta,
          'monto_aseg': monto_aseg,
          'venc_gtia': venc_gtia,
          
          //Póliza
          'nro_poliza': document.getElementById("nro_poliza").value, //automático
          'comision': document.getElementById("comision").value,
          'porcentaje_comsion': document.getElementById("porcentaje_comsion").value,
          'comisionbruta': document.getElementById("comisionbruta").value,
          'comisionneta': document.getElementById("comisionneta").value,
          'fechadeposito': document.getElementById("fechadeposito").value,
          'comisionneg': document.getElementById("comisionneg").value,
          'boletaneg': document.getElementById("boletaneg").value,
          'boleta': document.getElementById("boleta").value,
          'cuotas': document.getElementById("cuotas").value,
          'valorcuota': document.getElementById("valorcuota").value,
          'fechaprimer': document.getElementById("fechaprimer").value
          }, 'post');
        }
        break;
      }
    }
  }
    
 function valida_vencimiento(){
     
     
     var fecha_venc = new Date (document.getElementById("fechavenc").value);
     var fecha_inicio = new Date( document.getElementById("fechainicio").value);
     var day_venc = fecha_venc.getDate()+1;
     var month_venc = fecha_venc.getMonth()+1;
     var year_venc = fecha_venc.getFullYear();
     var day_ini = fecha_inicio.getDate()+1;
     var month_ini = fecha_inicio.getMonth()+1;
     var year_ini = fecha_inicio.getFullYear();
     
     
     if(year_venc > 1000)
     {
         if (day_ini != day_venc || month_ini != month_venc || year_venc != year_ini+1 ){
             
             alert("La fecha de Vigencia Final es distinta de un año \nFecha Vigencia Final: "+ day_venc +"-" + month_venc + "-" + year_venc);
         }
         
         
     }
     
     var fecha = document.getElementById("fechavenc").value;
     
     
     console.log(document.getElementById("fechavenc").value);
     console.log(fecha.length);
     
     console.log(fecha_venc);
     console.log(fecha_inicio);
     console.log((fecha_venc - fecha_inicio)/(1000*60*60*24));
     
     //if  ((fecha_venc - fecha_inicio)/(1000*60*60*24) >= -44138) 
     //{
     //if ((fecha_venc - fecha_inicio)/(1000*60*60*24) !=  365 && (fecha_venc - fecha_inicio)/(1000*60*60*24) !=  366 ) 
     //{
         
      //   alert("La fecha de Vigencia Final es distinta de un año \nFecha Vigencia Final: "+ day +"-" + month + "-" + year);
         
    // }
     
 //}
 }

 
(function(){

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
 
 $(document).ready(function() {
      
    var iCnt = 0;
   
    // Crear un elemento div añadiendo estilos CSS
    var container = $(document.createElement('div')).css({
        padding: '10px',
        margin: '20px',
        width: '340px',
    });
    
   $('#btAdd').click(function() {
        if (iCnt <= 100) {

            iCnt = iCnt + 1;

            // Añadir caja de texto.

            if (iCnt == 0) {
                var divSubmit = $(document.createElement('div'));
                //                    $(divSubmit).append('<input type=button class="bt" onclick="GetTextValue()"' + 
                //                            'id=btSubmit value=Enviar />');

            }
            
            else if (document.getElementById("radio2_si").checked) {
                
                var newElement = '<tr id =item' + iCnt+ ' style="width:80%;">'+
                '<td><input class="form-control" type="text" value="' + iCnt + '" id="numero_item[]" name="numero_item[]" required/></td>'+
                '<td><div class="input-group-prepend"><button type="button" id="busca_rut_aseg[' + iCnt + ']" data-toggle="modal" onclick="origen_busqueda(this.id,' + iCnt + ')" data-target="#modal_cliente"><i class="fas fa-search"></i></button><input type="text" class="form-control" '+
                    'id="rutaseg[' + iCnt + ']" name="rutaseg[]" onchange="valida_rut_duplicado_aseg(' + iCnt + ')" oninput="checkRut(this);"'+
                    '  required/></div></td>' +
                '<td><input type="text" id="nombre_seg[' + iCnt + ']" class="form-control" name="nombreaseg[]" required></td>'+
                '<td><textarea type="text" class="form-control" id="materia[' + iCnt + ']" name="materia[]" rows="1" required></textarea></td>'+
                '<td><input type="text" class="form-control" id="detalle_materia[' + iCnt + ']" name="detalle_materia[]"></td>'+
                '<td><input type="text" class="form-control" id="cobertura[' + iCnt + ']" name="cobertura[]"></td>'+
                '<td><div class="form-inline" id="div_deducible[' + iCnt + ']"><div class="input-group-prepend"><span class="input-group-text" id="moneda[' + iCnt + ']">UF</span></div> '+
                    '<input type="text" class="form-control" name="deducible_defecto"'+
                     'id="deducible_defecto[' + iCnt + ']" onChange="pobladeducible()"></div></td>'+
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda2[' + iCnt + ']">UF</span></div>'+
                      '<input type="text" class="form-control" name="prima_afecta[]" id="prima_afecta[' + iCnt + ']" onChange="calculaprimabruta()"></div></td>'+
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda3[' + iCnt + ']">UF</span></div>'+
                      '<input type="text" class="form-control" name="prima_exenta[]" id="prima_exenta[' + iCnt + ']" onChange="calculaprimabruta()" style="width=75%"></div></td>'+ 
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda4[' + iCnt + ']">UF</span></div>'+
                      '<input type="text" class="form-control" name="prima_bruta[]" id="prima_bruta[' + iCnt + ']"></div></td>'+
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda5[' + iCnt + ']">UF</span></div>'+
                '<input type="text" class="form-control" name="prima_neta[]" id="prima_neta[' + iCnt + ']"></div></td>'+
                '<td><input type="text" class="form-control" name="monto_aseg[]" id="monto_aseg[' + iCnt + ']"  required>' +    
                 '<td> <input placeholder="Seleccionar fecha si aplica" type="date" name="venc_gtia[]" id="venc_gtia[' + iCnt + ']" class="form-control"></td>'+
               '</tr>';
            $("#mytable").append($(newElement));
                document.getElementById("rutaseg["+iCnt+"]").value = document.getElementById("rutprop").value;
                document.getElementById("nombre_seg["+iCnt+"]").value = document.getElementById("nombre_prop").value;
                document.getElementById("rutaseg["+iCnt+"]").disabled = true;
                document.getElementById("nombre_seg["+iCnt+"]").disabled = true;
                document.getElementById("busca_rut_aseg["+iCnt+"]").style.display = "none";

            $('#main').after(container, divSubmit);
             document.getElementById("contador").value = iCnt;
                
                
            }
            
            else 
            {
            var newElement = '<tr id =item' + iCnt + ' style="width:80%;">'+
                '<td><input class="form-control" type="text" value="' + iCnt + '" id="numero_item[]" name="numero_item[]" required/></td>'+
                '<td><div class="input-group-prepend"><button type="button" id="busca_rut_aseg[' + iCnt + ']" data-toggle="modal" onclick="origen_busqueda(this.id,' + iCnt + ')" data-target="#modal_cliente"><i class="fas fa-search"></i></button><input type="text" class="form-control" '+
                    'id="rutaseg[' + iCnt + ']" name="rutaseg[]" placeholder="1111111-1" onchange="valida_rut_duplicado_aseg(' + iCnt + ')" oninput="checkRut(this);"'+
                    '  required/></div></td>' +
                '<td><input type="text" id="nombre_seg[' + iCnt + ']" class="form-control" name="nombreaseg[]"  required></td>'+
                '<td><textarea type="text" class="form-control" id="materia[' + iCnt + ']" name="materia[]" rows="1" required></textarea></td>'+
                '<td><input type="text" class="form-control" id="detalle_materia[' + iCnt + ']" name="detalle_materia[]"></td>'+
                '<td><input type="text" class="form-control" id="cobertura[' + iCnt + ']" name="cobertura[]"></td>'+
                '<td><div class="form-inline" id="div_deducible[' + iCnt + ']"  ><div class="input-group-prepend"><span class="input-group-text" id="moneda[' + iCnt + ']">UF</span></div> '+
                    '<input type="text" class="form-control" name="deducible_defecto"'+
                     'id="deducible_defecto[' + iCnt + ']" onChange="pobladeducible()"></div></td>'+
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda2">UF</span></div>'+
                      '<input type="text" class="form-control" name="prima_afecta[]" id="prima_afecta[' + iCnt + ']" onChange="calculaprimabruta()"></div></td>'+
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda2">UF</span></div>'+
                      '<input type="text" class="form-control" name="prima_exenta[]" id="prima_exenta[' + iCnt + ']" onChange="calculaprimabruta()"></div></td>'+ 
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda2">UF</span></div>'+
                      '<input type="text" class="form-control" name="prima_neta[]" id="prima_neta[' + iCnt + ']"></div></td>'+
                '<td><input type="text" class="form-control" name="monto_aseg[]" id="monto_aseg[' + iCnt + ']"  required>' +    
                 '<td> <input placeholder="Seleccionar fecha si aplica" type="date" name="venc_gtia[]" id="venc_gtia[' + iCnt + ']" class="form-control"></td>'+
               '</tr>';
               
            $("#mytable").append($(newElement));
            $('#main').after(container, divSubmit);
             document.getElementById("contador").value = iCnt;
         }
        }
        
        
        else { //se establece un limite para añadir elementos, 5 es el limite
            iCnt = iCnt + 1;

            $("#mytable").append('<label id=label>Limite Alcanzado</label> ');
            $('#btAdd').attr('class', 'btn');
            $('#btAdd').attr('disabled', 'disabled');
             document.getElementById("contador").value = iCnt;

        }
        
        vencimientogarantia();
        cambia_deducible();
        cambio_moneda();
    });
    


  $('#btRemove').click(function() { // Elimina un elemento por click

        if (iCnt != 1) {
           
            $('#btAdd').removeAttr('disabled');
            $('#item' + iCnt).remove();
             iCnt = iCnt - 1;
              document.getElementById("contador").value = iCnt;
             
             
        if (iCnt == 100) {
            $('#label').remove();
            
        }
        }
        if (iCnt == 1) {
            
            
            //$('#mytable').remove();
            //$(container).remove();
            //                $('#btSubmit').remove(); 
            $('#btAdd').removeAttr('disabled');
            $('#btAdd').attr('class', 'btn')
            iCnt = 1;
            //var newElement2 =
              //  '<table class="table" id="mytable"><tr><th>Nombre Contacto</th><th>Telefono</th><th>E-mail</th></tr></table>';
           // $("#main").append($(newElement2));
            //$("#mytable").append($(newElement));
        }
    });
 });

</script>