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
<?php include 'header2.php' ?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
<div class="container">
<div id=titulo1 style="display:flex">
  <p>Propuesta de Endoso / Creación</p>
  <br>
</div>


  <form action="/bambooQA/backend/propuesta_endoso/crea_propuesta_endoso.php" class="needs-validation" method="POST" id="formulario"  novalidate>
  
<div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne" style="background-color:whitesmoke">
          <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                              aria-expanded="true" aria-controls="collapseOne" style="color:#536656">Información General del Endoso</button>
          </h5>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body" id="card-body-one">
            
        <div class="form-row">
            <div class="col-4">
                <label for = "motivo_endoso"><b>Motivo del Endoso</b></label>
                <br>
                <select class="form-control" id="motivo_endoso" name="motivo_endoso" onchange=cambio_motivo()>
                    <option value="Endoso Aumento">Endoso Aumento</option>
                    <option value="Endoso de Disminución o Anulación">Endoso de Disminución o Anulación</option>
                    <option value="Endoso Prorroga">Endoso Prorroga</option>
                    <option value="Endoso Sin Movimiento">Endoso Sin Movimiento</option>
                </select>
            </div>
          <div class="col-4" id="col_fecha_ingreso" style="display:none">
                <label for="fecha_ingreso"><b>Fecha Prorroga:&nbsp;</b></label>
                <label style="color: darkred">*</label>
                <div class="md-form">
                   <input placeholder="Selected date" type="date" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo date("Y-m-d");?>"
                      class="form-control" max= "9999-12-31" required>
                </div>
          </div>
        </div>
        <br>
        <br>
        <div class ="form-row">
            <div class="col-5">
                <label for="ramo"><b>Ramo</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
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
            
            <div class="col-2">
                <label for="nro_poliza"><b>Número de Póliza</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                   <input type="text" class="form-control" id="nro_poliza"
                                          name="nro_poliza">
                </div>
                <div style="color:red; visibility: hidden" id="validador6">Debes seleccionar Fecha de Vencimiento</div>
            </div>
            <div class="col">
                <label for="corredor"><b>Corredor</b></label>
                    <input type="text" class="form-control" id="corredor"
                                          name="corredor" value="Adriana Sandoval Páez">
            </div>
            <div class="col">
            <label for="rut_corredor"><b>RUT Corredor</b></label>
             <input type="text" class="form-control" id="rut_corredor"
                                          name="rut_corredor" value="10.228.002-4">
             </div>
              
          </div>
          
          <div class="form-row">
            <div class="col-3">
              <label for="fechaprimer"><b>Fecha Ingreso</b></label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" max= "9999-12-31" style="width:72%;">
              </div>
            </div>
            <div class="col-3">
              <label for="fecha_vigencia"><b>Fecha Vigencia Inicial</b></label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input type="date" class="form-control" id="fecha_vigencia_inicial" name="fecha_vigencia_inicial" max= "9999-12-31" style="width:72%;">
              </div>
            </div>
            <div class="col-3">
              <label for="fecha_vigencia"><b>Fecha Vigencia Final</b></label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input type="date" class="form-control" id="fecha_vigencia_final" name="fecha_vigencia_final" max= "9999-12-31" style="width:72%;">
              </div>
            </div>
            <div class="col-3">
              <label for="dias"><b>Días</b></label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input type="number" class="form-control" id="dias" name="dias" max= "365">
              </div>
            </div>
            
          </div>
          <br>
          <div class = "form-row">
            <div class="col-md-3 mb-3">
                <label for="RUT"><b>RUT Contratante</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <input type="text" class="form-control" id="rutprop" name="rutprop"
                              placeholder="1111111-1" required>
                <div class="invalid-feedback">Dígito verificador no válido. Verifica rut </div>
             </div>
             
            <div class="col-5">
                <label for="Nombre"><b>Nombre Contratante</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <input type="text" id="nombre_prop" class="form-control" name="nombre" required>
                              
                <div   style="color:red; font-size: 12px ; visibility: hidden" id="validador10">No puedes dejar este campo
                 en blanco</div>
             <br>
            </div>
              
          </div>

         
        <div class = "form-row">
            
            <div class="col">
                <label for="descripción_endoso"><b>Descripción del Endoso</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <textarea class="form-control" rows="2" style="height:100px" id='descripcion_endoso' name='descripcion_endoso' style="text-indent:0px" ;></textarea>
                
             <br>
            </div>
              
          </div> 
          
          <div class = "form-row">
            
            <div class="col-6">
                <label for="descripción_endoso"><b>Dice</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <textarea class="form-control" rows="2" style="height:100px" id='dice' name='dice' style="text-indent:0px" ;></textarea>
                
             <br>
            </div>
            <div class="col-6">
                <label for="descripción_endoso"><b>Debe Decir</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <textarea class="form-control" rows="2" style="height:100px" id='debe_decir' name='debe_decir' style="text-indent:0px" ;></textarea>
                
             <br>
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
                              style="color:#536656">Primas y Montos</button>
          </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body" id="card-body-two">
            <div class="form-row">
                <div class="col-2">
                    <label for="monto"><b>Monto</b></label>
                    <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                    <input type="text" class="form-control" id="monto" name="monto">
                </div>
                <div style="color:red; visibility: hidden" id="validador6">Debes seleccionar Fecha de Vencimiento</div>
                </div>

            <div class="col-2">
                <label for="moneda_poliza"><b>Moneda Póliza</b></label>
                <select class="form-control" id="moneda_poliza" name="moneda_poliza">
                    <option value="UF" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "UF") echo "selected" ?>>UF</option>
                    <option value="USD" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "USD") echo "selected" ?>>USD</option>
                    <option value="CLP" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "CLP") echo "selected" ?>>CLP</option>
                </select>
            </div>
            <div class="col-2">
            <label for="moneda_poliza"><b>Tasa %</b></label>
                <div class="md-form">
                    <input type="text" class="form-control" id="monto" name="monto">
                </div>
            </div>
          </div>
          <div class="form-row">
                <div class="col-2">
                    <label for="monto"><b>Prima Neta Exenta</b></label>
                    <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                    <input type="text" class="form-control" id="prima_neta_exenta" name="prima_neta_exenta">
                </div>
                </div>

            <div class="col-2">
                <label for="monto"><b>IVA</b></label>
                    <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                    <input type="text" class="form-control" id="iva" name="iva">
                </div>
            </div>
            <div class="col-2">
            <label for="moneda_poliza"><b>Prima Neta Afecta</b></label>
                <div class="md-form">
                    <input type="text" class="form-control" id="prima_neta_afecta" name="prima_neta_afecta">
                </div>
            </div>
            <div class="col-2">
            <label for="moneda_poliza"><b>Prima Total</b></label>
                <div class="md-form">
                    <input type="text" class="form-control" id="prima_total" name="prima_total">
                </div>
            </div>
          </div>
         </div>
        </div>
        
  
  
  
  
        </div>
   
    </div>
    
 </form>
<br>
<button class="btn" type="button" style="background-color: #536656; color: white"
              id='boton_prueba' onclick=" validarutitem()">Registrar</button>
<br>
</body>
<foot>
    <br>
</foot>

<script>
    
function cambio_motivo(){
    
    var motivo_endoso = document.getElementById("motivo_endoso").value;

    if(motivo_endoso == "Endoso Prorroga") {
      
        document.getElementById("col_fecha_ingreso").style.display ="block";
    }   
    
    else{
        
        document.getElementById("col_fecha_ingreso").style.display ="none";
    }
    
}
    
    
</script>

