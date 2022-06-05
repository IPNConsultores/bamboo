<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}
require_once "/home/gestio10/public_html/backend/config.php";
mysqli_set_charset($link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo_prePAP');


//$_SERVER[ "REQUEST_METHOD" ] = "POST";
//$_POST["accion"] = 'crea_propuesta_endoso';
//$_POST["numero_poliza"]='872';
//$_POST["numero_propuesta"]="E000004";
$numero_propuesta='';
$camino=$_POST["accion"];
if ($_SERVER[ "REQUEST_METHOD" ] == "POST" and $_POST["accion"] == 'crea_propuesta_endoso')
{
  $query = "select distinct a.numero_poliza, a.compania, a.id as id_poliza,a.ramo, a.vigencia_inicial, a.vigencia_final, CONCAT_WS('-',a.rut_proponente, a.dv_proponente) as rut_proponente, CONCAT_WS(' ',b.nombre_cliente, b.apellido_paterno, ' ', b.apellido_materno) as nombre_proponente, FORMAT(sum(c.prima_afecta), 2, 'de_DE') as total_prima_afecta, FORMAT(sum(c.prima_exenta), 2, 'de_DE') as total_prima_exenta, FORMAT(sum(c.prima_neta), 2, 'de_DE') as total_prima_neta, FORMAT(sum(c.prima_bruta_anual), 2, 'de_DE') as total_prima_bruta, FORMAT(sum(c.monto_asegurado), 2, 'de_DE') as total_monto_asegurado, a.moneda_poliza from polizas_2 as a left join clientes as b on a.rut_proponente=b.rut_sin_dv left join items as c on a.numero_poliza=c.numero_poliza where a.id='".$_POST["numero_poliza"]."'";
  $resultado = mysqli_query( $link, $query );
  While( $row = mysqli_fetch_object( $resultado ) ) {
    $numero_poliza = $row->numero_poliza;
    $ramo=$row->ramo;
    $id_poliza = $row->id_poliza;
    $compania = $row->compania;
    $vigencia_inicial = $row->vigencia_inicial;
    $vigencia_final = $row->vigencia_final;
    $rut_proponente = $row->rut_proponente;
    $nombre_proponente = $row->nombre_proponente;
    $total_prima_afecta = $row->total_prima_afecta;
    $total_prima_exenta = $row->total_prima_exenta;
    $total_prima_neta = $row->total_prima_neta;
    $total_prima_bruta = $row->total_prima_bruta;
    $total_monto_asegurado = $row->total_monto_asegurado;
    $moneda_poliza = $row->moneda_poliza;
  }
}
elseif ($_SERVER[ "REQUEST_METHOD" ] == "POST" and ($_POST["accion"] == 'actualiza_propuesta' or $_POST["accion"] =='crear_endoso')){
    $query = "select * from propuesta_endosos where numero_propuesta_endoso='".$_POST["numero_propuesta"]."'";
  $resultado = mysqli_query( $link, $query );
  While( $row = mysqli_fetch_object( $resultado ) ) {
    $numero_propuesta = $_POST["numero_propuesta"];
    $numero_poliza = $row->numero_poliza;
    $ramo=$row->ramo;
    $id_poliza = $row->id_poliza;
    $compania = $row->compania;
    $vigencia_inicial = $row->vigencia_inicial;
    $vigencia_final = $row->vigencia_final;
    $rut_proponente = $row->rut_proponente.'-'.$row->dv_proponente;
    $nombre_proponente = $row->nombre_proponente;
    $prima_neta_afecta = $row->prima_neta_afecta;
    $prima_neta_exenta = $row->prima_neta_exenta;
    $iva = $row->IVA;
    $prima_total = $row->prima_total;
    $total_monto_asegurado = $row->monto_asegurado_endoso;
    $moneda_poliza_endoso = $row->moneda_poliza_endoso;
    $tasa_afecta_endoso=$row->tasa_afecta_endoso;
    $tasa_exenta_endoso=$row->tasa_exenta_endoso;
    $tipo_endoso=$row->tipo_endoso;
    $fecha_ingreso=$row->fecha_ingreso;
    $descripcion_endoso=$row->descripcion_endoso;
    $dice=$row->dice;
    $debe_decir=$row->debe_decir;
    $fecha_prorroga=$row->fecha_prorroga;
    $comentarios=$row->comentario_endoso;
  }
}
elseif($_SERVER[ "REQUEST_METHOD" ] == "POST" and $_POST["accion"] == 'crear_endoso'){
    $query = "select * from endosos where numero_endoso='".$_POST["numero_endoso"]."'";
  $resultado = mysqli_query( $link, $query );
  While( $row = mysqli_fetch_object( $resultado ) ) {
    $numero_endoso = $_POST["numero_endoso"];
    $numero_poliza = $row->numero_poliza;
    $ramo=$row->ramo;
    $id_poliza = $row->id_poliza;
    $compania = $row->compania;
    $vigencia_inicial = $row->vigencia_inicial;
    $vigencia_final = $row->vigencia_final;
    $rut_proponente = $row->rut_proponente.'-'.$row->dv_proponente;
    $nombre_proponente = $row->nombre_proponente;
    $prima_neta_afecta = $row->prima_neta_afecta;
    $prima_neta_exenta = $row->prima_neta_exenta;
    $iva = $row->IVA;
    $prima_total = $row->prima_total;
    $total_monto_asegurado = $row->monto_asegurado_endoso;
    $moneda_poliza_endoso = $row->moneda_poliza_endoso;
    $tasa_afecta_endoso=$row->tasa_afecta_endoso;
    $tasa_exenta_endoso=$row->tasa_exenta_endoso;
    $tipo_endoso=$row->tipo_endoso;
    $fecha_ingreso=$row->fecha_ingreso;
    $descripcion_endoso=$row->descripcion_endoso;
    $dice=$row->dice;
    $debe_decir=$row->debe_decir;
    $comentario=$row->comentario_endoso;
  }   
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="/bamboo/images/bamboo.png">
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
<div id=titulo2 style="display:none">
  <p>Propuesta de Endoso / Aceptar propuesta de Endoso: <?php  echo $numero_propuesta; ?></p>
  <br>
</div>
<div id=titulo3 style="display:none">
  <p>Endoso / Editar Endoso: <?php  echo $numero_endoso; ?></p>
  <br>
</div>
<div id=titulo4 style="display:none">
  <p>Propuesta de Endoso / Editar propuesta: <?php  echo $numero_propuesta; ?></p>
  <br>
</div>
  <form action="/bamboo/backend/propuesta_endoso/crea_propuesta_endoso.php" class="needs-validation" method="POST" id="formulario"  novalidate>
  
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
            <div class="col-5">
                <label for = "motivo_endoso"><b>Motivo del Endoso</b></label>
                <label style="color: darkred">*</label>
                <br>
                <select class="form-control" id="motivo_endoso" name="motivo_endoso" onchange=cambio_motivo() required>
                    <option value="">Selecciona Motivo</option>
                    <option value="Endoso Aumento">Endoso Aumento</option>
                    <option value="Endoso de Disminución o Anulación">Endoso de Disminución o Anulación</option>
                    <option value="Endoso Prorroga">Endoso Prorroga</option>
                    <option value="Endoso Sin Movimiento">Endoso Sin Movimiento</option>
                </select>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
          <div class="col-4" id="col_fecha_ingreso" style="display:none">
                <label for="fecha_prorroga"><b>Fecha Prorroga:&nbsp;</b></label>
                <label style="color: darkred">*</label>
                <div class="md-form">

                   <input placeholder="Selected date" type="date" name="fecha_prorroga" id="fecha_prorroga" onchange="prorroga()" value=""
                      class="form-control" max= "9999-12-31" required>
                      <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                </div>
          </div>
        </div>
         <br>
        <div class ="form-row">
            <div class="col-5">
                <label for="ramo"><b>Ramo</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                    <select class="form-control" name="ramo" id="ramo" onChange="cambia_deducible();" required> 
                                        
                  <option value="">Selecciona un ramo</option>
                  <option value="AC - Accidentes Personales">ACCIDENTES PERSONALES - Accidentes Personales</option>
                  <option value="AC - Protección Financiera">ACCIDENTES PERSONALES - Protección Financiera</option>
                  <option value="ASISTENCIA EN VIAJE">ASISTENCIA EN VIAJE</option>
                  <option value="INC - Condominio">INCENDIO - Condominio</option>
                  <option value="INC - Hogar">INCENDIO - Hogar</option>
                  <option value="INC - Misceláneos">INCENDIO - Misceláneos</option>
                  <option value="INC - Perjuicio por Paralización">INCENDIO - Perjuicio por Paralización</option>
                  <option value="INC - Pyme">INCENDIO - Pyme</option>
                  <option value="INC - TRBF (Todo Riesgo Bienes Físicos)">INCENDIO - TRBF (Todo Riesgo Bienes Físicos)</option>
                  <option value="D&O Condominio">RESPONSABILIDAD CIVIL - D&O Condominio</option>
                  <option value="RC General">RESPONSABILIDAD CIVIL - RC General</option>
                  <option value="VEH - Vehículos Comerciales Livianos">VEHÍCULOS - Vehículos Comerciales Livianos</option>
                  <option value="VEH - Vehículos Particulares">VEHÍCULOS - Vehículos Particulares</option>
                  <option value="VEH - Vehículos Pesados">VEHÍCULOS - Vehículos Pesados</option>
                  <option value="null">--------------------------------------------------------------</option>
                  <option value="AVERÍA DE MAQUINARIA">AVERÍA DE MAQUINARIA</option>
                  <option value="CASCO - Aéreo">CASCO - Aéreo</option>
                  <option value="CASCO - Marítimo">CASCO - Marítimo</option>
                  <option value="Garantía">GARANTÍA</option>
                  <option value="ING - Equipo Contratistas">INGENIERÍA - Equipo Contratistas</option>
                  <option value="ING - Equipo Móvil Agrícola">INGENIERÍA - Equipo Móvil Agrícola</option>
                  <option value="ING - Equipos Electrónicos">INGENIERÍA - Equipos Electrónicos</option>
                  <option value="ING- TRC (Todo Riesgo Construcción)">INGENIERÍA - TRC (Todo Riesgo Construcción)</option>
                  <option value="REMESA DE VALORES">REMESA DE VALORES</option>
                  <option value="ROBO CON FUERZA">ROBO CON FUERZA EN LAS COSAS Y VIOLENCIA EN LAS PERSONAS</option>
                  <option value="ROTURA DE CRISTALES">ROTURA DE CRISTALES</option>
                  <option value="SEGURO ARRIENDO">SEGURO ARRIENDO</option>
                  <option value="SEGURO DE CRÉDITO">SEGURO DE CRÉDITO</option>
                  <option value="CABOTAJE">TRANSPORTE - CABOTAJE</option>
                  <option value="INTERNACIONAL">TRANSPORTE - INTERNACIONAL</option>
                  <option value="APV">VIDA - APV</option>
                  <option value="VIDA">VIDA - VIDA</option>
                  <option value="AP">AP</option>
                  <option value="D&O">D&O</option>
                  <option value="INC">INC</option>
                  <option value="PyME">PyME</option>
                  <option value="RC">RC</option>
                  <option value="VEH">VEH</option>
                </select>
                    <div class="invalid-feedback">Debes seleccionar un Ramo</div>
                </div>
                
            </div>
            <div class="col-4">
                <label for="nro_poliza"><b>Compañía</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <select class="form-control" name="selcompania" id="compania" required>
                  <option value="">Selecciona una compañía</option>
                  <option value="Axa Assistance">Axa Assistance</option>
                  <option value="BCI Seguros">BCI Seguros</option>
                  <option value="Chilena Consolidada">Chilena Consolidada</option>
                  <option value="CHUBB">CHUBB</option>
                  <option value="Confuturo">Confuturo</option>
                  <option value="Consorcio">Consorcio</option>
                  <option value="Continental">Continental</option>
                  <option value="Contempora">Contempora</option>
                  <option value="Coris">Coris</option>
                  <option value="HDI Seguros">HDI Seguros</option>
                  <option value="Liberty">Liberty</option>                       
                  <option value="Mapfre">Mapfre</option>
                  <option value="Ohio National Financial Group">Ohio National</option>
                  <option value="Orsan">Orsan</option>
                  <option value="Reale Seguros">Reale Seguros</option>
                  <option value="Renta Nacional">Renta Nacional</option>
                  <option value="Southbridge">Southbridge</option>
                  <option value="Sur Asistencia">Sur Asistencia</option>
                  <option value="Suaval">Suaval</option>
                  <option value="Sura">Sura</option>
                  <option value="STARR">STARR</option>
                  <option value="Unnio">Unnio</option>
                </select>
                <div class="invalid-feedback">Debes seleccionar una Compañía</div>
              
            </div>
            
            <div class="col-2">
                <label for="nro_poliza"><b>Número de Póliza</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                   <input type="text" class="form-control" id="nro_poliza"
                                          name="nro_poliza" readonly>
                </div>
                <div style="color:red; visibility: hidden" id="validador6">Debes seleccionar Fecha de Vencimiento</div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-5">
                <label for="corredor"><b>Corredor</b></label>
                    <input type="text" class="form-control" id="corredor"
                                          name="corredor" value="Adriana Sandoval Páez">
            </div>
            <div class="col-4">
            <label for="rut_corredor"><b>RUT Corredor</b></label>
             <input type="text" class="form-control" id="rut_corredor"
                                          name="rut_corredor" value="10.228.002-4">
             </div>
              
          </div>
        
          <br>
           <br>
          <div class="form-row">
            <div class="col-3">
              <label for="fechaprimer"><b>Fecha Ingreso</b></label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" max= "9999-12-31" style="width:72%;" >
              </div>
            </div>
            <div class="col-3">
              <label for="fecha_vigencia"><b>Fecha Vigencia Inicial</b></label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input type="date" class="form-control" id="fecha_vigencia_inicial" name="fecha_vigencia_inicial" onchange="calculadias()"  max= "9999-12-31" style="width:72%;">
              </div>
            </div>
            <div class="col-3">
              <label for="fecha_vigencia"><b>Fecha Vigencia Final</b></label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input type="date" class="form-control" id="fecha_vigencia_final" name="fecha_vigencia_final" max= "9999-12-31" onchange="calculadias()" style="width:72%;">
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
                <label for="RUT"><b>RUT Proponente</b></label>
                <label style="color: darkred">&nbsp; *</label>
                <input type="text" class="form-control" id="rutprop" name="rutprop"
                              placeholder="1111111-1" required>
                <div class="invalid-feedback">Dígito verificador no válido. Verifica rut </div>
             </div>
             
            <div class="col-5">
                <label for="Nombre"><b>Nombre Proponente</b></label>
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
                    <input type="number" class="form-control" id="monto" name="monto" onchange="calculatasas()">
                </div>
                <div style="color:red; visibility: hidden" id="validador6">Debes seleccionar Fecha de Vencimiento</div>
                </div>

            <div class="col-2">
                <label for="moneda_poliza"><b>Moneda Póliza</b></label>
                <select class="form-control" id="moneda_poliza" name="moneda_poliza">
                    <option value="UF" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "UF") echo "selected" ?> >UF</option>
                    <option value="USD" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "USD") echo "selected" ?> >USD</option>
                    <option value="CLP" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "CLP") echo "selected" ?> >CLP</option>
                </select>
            </div>
            <div class="col-2">
            <label for="tasa_afecta"><b>Tasa Afecta %</b></label>
                <div class="md-form">
                    <input type="number" step="0.01" placeholder="0,00"  class="form-control" id="tasa_afecta">
                </div>
            </div>
            <div class="col-2">
            <label for="tasa_exenta"><b>Tasa Exenta %</b></label>
                <div class="md-form">
                    <input type="number" step="0.01" placeholder="0,00"  class="form-control" id="tasa_exenta">
                </div>
            </div>
          </div>
          <div class="form-row">
                <div class="col-2">
                    <label for="monto"><b>Prima Neta Exenta</b></label>
                    <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                    <input type="number" class="form-control" id="prima_neta_exenta" name="prima_neta_exenta" onchange="calculatasas(),calculaprimatotal()">
                </div>
                </div>

            <div class="col-2">
                <label for="monto"><b>IVA</b></label>
                    <label style="color: darkred">&nbsp; *</label>
                <div class="md-form">
                    <input type="number" class="form-control" id="iva" name="iva" onchange="calculaprimatotal();">
                </div>
            </div>
            <div class="col-2">
            <label for="moneda_poliza"><b>Prima Neta Afecta</b></label>
                <div class="md-form">
                    <input type="number" class="form-control" id="prima_neta_afecta" name="prima_neta_afecta" onchange="calculatasas(),calculaIVA(),calculaprimatotal()">
                </div>
            </div>
            <div class="col-2">
            <label for="moneda_poliza"><b>Prima Total</b></label>
                <div class="md-form">
                    <input type="number" class="form-control" id="prima_total" name="prima_total">
                </div>
            </div>
          </div>
         </div>
        </div>
        
  
  
  
  
        </div>
        <div class="card" id="card_confirma" style="display:flex">
            <div class="card-header" id="headingthree" style="background-color:whitesmoke">
             <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                              data-target="#collapsethree" aria-expanded="false" aria-controls="collapsethree"
                              style="color:#536656"> Comentarios </button>
             </h5>
            </div>
        <div id="collapsethree" class="collapse" aria-labelledby="headingthree" data-parent="#accordionExample">
         <div class="card-body" id="card-body-three">
            <div class="form-row" id="caja_numero_endoso" style="display:none">
                <div class="col-3">
                    <label for="monto"><b>Número de Endoso</b></label>
                    <label style="color: darkred">&nbsp; *</label>
                    <div class="md-form">
                    <input type="text" class="form-control" id="nro_endoso" name="nro_endoso">
                    </div>
                </div>
            </div>
            <br>
            <div class="form-row">
                <label for="comentario_externo"><b>Comentarios </b></label>
            <br>
                    <textarea class="form-control" rows="2" style="height:100px" id='comentarios' name='comentario'
                              style="text-indent:0px" ;></textarea>
            
            </div>
           
        
         </div>
        </div>
        </div>
   
</div>
    
</form>
<br>
<button class="btn" type="button" style="background-color: #536656; color: white"
              id='boton_prueba' onclick=" genera_propuesta()">Registrar</button>
<br>
</body>
<foot>
    <br>
</foot>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
<script src="/assets/js/jquery.redirect.js"></script>
<script src="/assets/js/validarRUT.js"></script>
<script src="/assets/js/bootstrap-notify.js"></script>
<script src="/assets/js/bootstrap-notify.min.js"></script>

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

function prorroga(){
    
    var fecha = new Date();
    fecha =document.getElementById('fecha_prorroga').value
   document.getElementById('fecha_vigencia_final').value = fecha;
    console.log(fecha);
    
}
    
    
document.addEventListener("DOMContentLoaded", function(event) {
   


    var orgn = '<?php echo $camino; ?>';
    console.log(orgn)
        switch (orgn) 
        {
          case 'crea_propuesta_endoso': {
            document.getElementById("ramo").value = '<?php echo $ramo; ?>';
            document.getElementById("compania").value = '<?php echo $compania; ?>';
            document.getElementById("nro_poliza").value = '<?php echo $numero_poliza; ?>';
            document.getElementById("fecha_vigencia_inicial").value = '<?php echo $vigencia_inicial; ?>';
            document.getElementById("fecha_vigencia_final").value = '<?php echo $vigencia_final; ?>';
            document.getElementById("rutprop").value = '<?php echo $rut_proponente; ?>';
            document.getElementById("nombre_prop").value = '<?php echo $nombre_proponente; ?>';
            document.getElementById("monto").value = '<?php echo $total_monto_asegurado*1; ?>';
            document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza; ?>';
            document.getElementById("prima_neta_exenta").value = '<?php echo $total_prima_exenta*1; ?>';
            document.getElementById("iva").value = '<?php echo $total_prima_afecta*0.19; ?>';
            document.getElementById("prima_neta_afecta").value = '<?php echo $total_prima_afecta*1; ?>';
            document.getElementById("prima_total").value = '<?php echo $total_prima_bruta*1; ?>';
            document.getElementById("titulo1").style.display = "flex";
            document.getElementById("titulo2").style.display = "none";
            document.getElementById("titulo3").style.display = "none";
            document.getElementById("titulo4").style.display = "none";
            
            break;  
          }
           case 'actualiza_propuesta':{
            document.getElementById("ramo").value = '<?php echo $ramo; ?>';
            document.getElementById("compania").value = '<?php echo $compania; ?>';
            document.getElementById("nro_poliza").value = '<?php echo $numero_poliza; ?>';
            document.getElementById("fecha_vigencia_inicial").value = '<?php echo $vigencia_inicial; ?>';
            document.getElementById("fecha_vigencia_final").value = '<?php echo $vigencia_final; ?>';
            document.getElementById("rutprop").value = '<?php echo $rut_proponente; ?>';
            document.getElementById("nombre_prop").value = '<?php echo $nombre_proponente; ?>';
            document.getElementById("monto").value = '<?php echo $total_monto_asegurado*1; ?>';
            document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza_endoso; ?>';
            document.getElementById("prima_neta_exenta").value = '<?php echo $prima_neta_exenta*1; ?>';
            document.getElementById("iva").value = '<?php echo $iva*1; ?>';
            document.getElementById("prima_neta_afecta").value = '<?php echo $prima_neta_afecta*1; ?>';
            document.getElementById("prima_total").value = '<?php echo $prima_total*1; ?>';
            document.getElementById("motivo_endoso").value = '<?php echo $tipo_endoso; ?>';
            document.getElementById("fecha_ingreso").value = '<?php echo $fecha_ingreso; ?>';
            document.getElementById("descripcion_endoso").value = '<?php echo $descripcion_endoso; ?>';
            document.getElementById("dice").value = '<?php echo $dice; ?>';
            document.getElementById("debe_decir").value = '<?php echo $debe_decir; ?>';
            document.getElementById("tasa_afecta").value = '<?php echo $tasa_afecta_endoso*1; ?>';
            document.getElementById("tasa_exenta").value = '<?php echo $tasa_exenta_endoso*1; ?>';
            document.getElementById("fecha_prorroga").value='<?php echo $fecha_prorroga; ?>';
            document.getElementById("comentarios").value = '<?php echo $comentarios; ?>';
            document.getElementById("titulo1").style.display = "none";
            document.getElementById("titulo2").style.display = "none";
            document.getElementById("titulo3").style.display = "none";
            document.getElementById("titulo4").style.display = "flex";

            if('<?php echo $tipo_endoso; ?>' == "Endoso Prorroga") {
              document.getElementById("col_fecha_ingreso").style.display ="block";
            }
               
               break;
               
           }
           case 'editar_endoso':{
            document.getElementById("ramo").value = '<?php echo $ramo; ?>';
            document.getElementById("compania").value = '<?php echo $compania; ?>';
            document.getElementById("nro_poliza").value = '<?php echo $numero_poliza; ?>';
            document.getElementById("fecha_vigencia_inicial").value = '<?php echo $vigencia_inicial; ?>';
            document.getElementById("fecha_vigencia_final").value = '<?php echo $vigencia_final; ?>';
            document.getElementById("rutprop").value = '<?php echo $rut_proponente; ?>';
            document.getElementById("nombre_prop").value = '<?php echo $nombre_proponente; ?>';
            document.getElementById("monto").value = '<?php echo $total_monto_asegurado*1; ?>';
            document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza_endoso; ?>';
            document.getElementById("prima_neta_exenta").value = '<?php echo $prima_neta_exenta*1; ?>';
            document.getElementById("iva").value = '<?php echo $iva*1; ?>';
            document.getElementById("prima_neta_afecta").value = '<?php echo $prima_neta_afecta*1; ?>';
            document.getElementById("prima_total").value = '<?php echo $prima_total*1; ?>';
            document.getElementById("motivo_endoso").value = '<?php echo $tipo_endoso; ?>';
            document.getElementById("fecha_ingreso").value = '<?php echo $fecha_ingreso; ?>';
            document.getElementById("descripcion_endoso").value = '<?php echo $descripcion_endoso; ?>';
            document.getElementById("dice").value = '<?php echo $dice; ?>';
            document.getElementById("debe_decir").value = '<?php echo $debe_decir; ?>';
            document.getElementById("tasa_afecta").value = '<?php echo $tasa_afecta_endoso*1; ?>';
            document.getElementById("tasa_exenta").value = '<?php echo $tasa_exenta_endoso*1; ?>';
            document.getElementById("nro_endoso").value = '<?php echo $numero_endoso; ?>';
            document.getElementById("comentarios").value = '<?php echo $comentarios; ?>';
            document.getElementById("fecha_prorroga").value='<?php echo $fecha_prorroga; ?>';
              document.getElementById("titulo1").style.display = "none";
              document.getElementById("titulo2").style.display = "none";
              document.getElementById("titulo3").style.display = "flex";
              document.getElementById("titulo4").style.display = "none";
              if('<?php echo $tipo_endoso; ?>' == "Endoso Prorroga") {
              document.getElementById("col_fecha_ingreso").style.display ="block";
            }            
               break;
               
           }
           case 'crear_endoso':{
            document.getElementById("ramo").value = '<?php echo $ramo; ?>';
            document.getElementById("compania").value = '<?php echo $compania; ?>';
            document.getElementById("nro_poliza").value = '<?php echo $numero_poliza; ?>';
            document.getElementById("fecha_vigencia_inicial").value = '<?php echo $vigencia_inicial; ?>';
            document.getElementById("fecha_vigencia_final").value = '<?php echo $vigencia_final; ?>';
            document.getElementById("rutprop").value = '<?php echo $rut_proponente; ?>';
            document.getElementById("nombre_prop").value = '<?php echo $nombre_proponente; ?>';
            document.getElementById("monto").value = '<?php echo $total_monto_asegurado*1; ?>';
            document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza_endoso; ?>';
            document.getElementById("prima_neta_exenta").value = '<?php echo $prima_neta_exenta*1; ?>';
            document.getElementById("iva").value = '<?php echo $iva*1; ?>';
            document.getElementById("prima_neta_afecta").value = '<?php echo $prima_neta_afecta*1; ?>';
            document.getElementById("prima_total").value = '<?php echo $prima_total*1; ?>';
            document.getElementById("motivo_endoso").value = '<?php echo $tipo_endoso; ?>';
            document.getElementById("fecha_ingreso").value = '<?php echo $fecha_ingreso; ?>';
            document.getElementById("descripcion_endoso").value = '<?php echo $descripcion_endoso; ?>';
            document.getElementById("dice").value = '<?php echo $dice; ?>';
            document.getElementById("debe_decir").value = '<?php echo $debe_decir; ?>';
            document.getElementById("fecha_prorroga").value='<?php echo $fecha_prorroga; ?>';
            document.getElementById("tasa_afecta").value = '<?php echo $tasa_afecta_endoso*1; ?>';
            document.getElementById("tasa_exenta").value = '<?php echo $tasa_exenta_endoso*1; ?>';
            document.getElementById("comentarios").value = '<?php echo $comentarios; ?>';
                document.getElementById("titulo1").style.display = "none";
                document.getElementById("titulo2").style.display = "flex";
                document.getElementById("titulo3").style.display = "none";
                document.getElementById("titulo4").style.display = "none";
                document.getElementById("caja_numero_endoso").style.display = "flex";
                document.getElementById("nro_endoso").required = "true";              
                if('<?php echo $tipo_endoso; ?>' == "Endoso Prorroga") {
              document.getElementById("col_fecha_ingreso").style.display ="block";
            }
               break;
               
           }
           
           
        }
        
//<<---PONER FECHA y CALCULAR DIAS--->>

    var request = new XMLHttpRequest()
    request.open('GET', 'https://mindicador.cl/api', true)
    request.onload = function() {
        // Begin accessing JSON data here
        var data = JSON.parse(this.response)
        if (request.status >= 200 && request.status < 400) {
            let date = new Date(data.fecha)
            let day = date.getDate()
            let month = date.getMonth() + 1
            let year = date.getFullYear()
            
        if (month < 10) {
            if (day < 10) {
                var fecha = `${year}-0${month}-0${day}`}
            else {
                var fecha = `${year}-0${month}-${day}`
            }
        } else {
            if (day < 10) {
                var fecha = `${year}-${month}-0${day}`}
            else {
                var fecha = `${year}-${month}-${day}`
            }
        }
            console.log(fecha);
            document.getElementById('fecha_ingreso').value = fecha;
    } else {}
}
    request.send();

    calculadias();
    
//CALCULAR TASAS

console.log(document.getElementById('monto').value);
console.log(document.getElementById('prima_neta_exenta').value);
console.log(document.getElementById('prima_neta_exenta').value);
console.log(document.getElementById('tasa_afecta').value);

   

})

function calculadias(){

    if (document.getElementById('fecha_vigencia_inicial').value!==""){
         var inicio  = new Date(document.getElementById('fecha_vigencia_inicial').value); 
         var final = new Date(document.getElementById('fecha_vigencia_final').value); 
         var diferencia = final.getTime() - inicio.getTime() 
         document.getElementById('dias').value= diferencia/86400000 ;
    }
}

function calculatasas(){
    
    var monto =    document.getElementById('monto').value;
    var prima_neta_exenta = document.getElementById('prima_neta_exenta').value;
    
    var prima_neta_afecta = document.getElementById('prima_neta_afecta').value;
    
    var tasa_afecta = prima_neta_afecta/monto*100;
    var tasa_exenta = prima_neta_exenta/monto*100;
    
    document.getElementById('tasa_afecta').value = tasa_afecta.toFixed(2);
    document.getElementById('tasa_exenta').value = tasa_exenta.toFixed(2);
}

function calculaIVA(){
    
    var prima_neta_afecta = document.getElementById('prima_neta_afecta').value;
    document.getElementById('iva').value = prima_neta_afecta*0.19
     
    
}
function calculaprimatotal(){
    var prima_neta_exenta = document.getElementById('prima_neta_exenta').value;
    var prima_neta_afecta = document.getElementById('prima_neta_afecta').value;
    var iva = document.getElementById('iva').value;
    
    
    document.getElementById('prima_total').value = parseFloat(document.getElementById('prima_neta_exenta').value)+parseFloat(document.getElementById('prima_neta_afecta').value)+parseFloat(document.getElementById('iva').value);
}


function genera_propuesta(){


    var camino='<?php echo $camino; ?>';

    switch (camino) {
        case 'crea_propuesta_endoso': {
          //$.redirect('/bamboo/test_felipe.php', {
        $.redirect('/bamboo/backend/endosos/crea_endosos.php', {
          'tipo_endoso':document.getElementById('motivo_endoso').value,
          'ramo': document.getElementById('ramo').value,
          'compania': document.getElementById('compania').value,
          'nro_poliza': document.getElementById('nro_poliza').value,
          'fecha_ingreso':document.getElementById('fecha_ingreso').value,
          'fecha_vigencia_inicial': document.getElementById('fecha_vigencia_inicial').value,
          'fecha_vigencia_final': document.getElementById('fecha_vigencia_final').value,
          'rutprop':document.getElementById('rutprop').value,
          'nombre': document.getElementById('nombre_prop').value,
          'descripcion_endoso': document.getElementById('descripcion_endoso').value,
          'dice':document.getElementById('dice').value,
          'debe_decir': document.getElementById('debe_decir').value,
          'monto': document.getElementById('monto').value,
          'moneda_poliza':document.getElementById('moneda_poliza').value,
          'prima_neta_exenta': document.getElementById('prima_neta_exenta').value,
          'iva': document.getElementById('iva').value,
          'prima_neta_afecta':document.getElementById('prima_neta_afecta').value,
          'prima_total': document.getElementById('prima_total').value,
          'tasa_afecta': document.getElementById('tasa_afecta').value,
          'tasa_exenta': document.getElementById('tasa_exenta').value,
          'comentario_endoso': document.getElementById('comentarios').value,
          'fecha_prorroga': document.getElementById('fecha_prorroga').value,
          'id_poliza':'<?php echo $id_poliza; ?>',
          'accion':camino
          }, 'post');
        break;
        }
        case 'actualiza_propuesta': {
          //$.redirect('/bamboo/test_felipe.php', {
        $.redirect('/bamboo/backend/endosos/crea_endosos.php', {
          'tipo_endoso':document.getElementById('motivo_endoso').value,
          'ramo': document.getElementById('ramo').value,
          'compania': document.getElementById('compania').value,
          'nro_poliza': document.getElementById('nro_poliza').value,
          'fecha_ingreso':document.getElementById('fecha_ingreso').value,
          'fecha_vigencia_inicial': document.getElementById('fecha_vigencia_inicial').value,
          'fecha_vigencia_final': document.getElementById('fecha_vigencia_final').value,
          'rutprop':document.getElementById('rutprop').value,
          'nombre': document.getElementById('nombre_prop').value,
          'descripcion_endoso': document.getElementById('descripcion_endoso').value,
          'dice':document.getElementById('dice').value,
          'debe_decir': document.getElementById('debe_decir').value,
          'monto': document.getElementById('monto').value,
          'moneda_poliza':document.getElementById('moneda_poliza').value,
          'prima_neta_exenta': document.getElementById('prima_neta_exenta').value,
          'iva': document.getElementById('iva').value,
          'prima_neta_afecta':document.getElementById('prima_neta_afecta').value,
          'prima_total': document.getElementById('prima_total').value,
          'tasa_afecta': document.getElementById('tasa_afecta').value,
          'tasa_exenta': document.getElementById('tasa_exenta').value,
          'comentario_endoso': document.getElementById('comentarios').value,
          'fecha_prorroga': document.getElementById('fecha_prorroga').value,
          'id_poliza':'<?php echo $id_poliza; ?>',
          'numero_propuesta_endoso':'<?php echo $numero_propuesta ?>',
          'accion':camino
          }, 'post');
        break;
        }
        case 'crear_endoso': {
          //$.redirect('/bamboo/test_felipe.php', {
        $.redirect('/bamboo/backend/endosos/crea_endosos.php', {
          'tipo_endoso':document.getElementById('motivo_endoso').value,
          'ramo': document.getElementById('ramo').value,
          'compania': document.getElementById('compania').value,
          'nro_poliza': document.getElementById('nro_poliza').value,
          'fecha_ingreso':document.getElementById('fecha_ingreso').value,
          'fecha_vigencia_inicial': document.getElementById('fecha_vigencia_inicial').value,
          'fecha_vigencia_final': document.getElementById('fecha_vigencia_final').value,
          'rutprop':document.getElementById('rutprop').value,
          'nombre': document.getElementById('nombre_prop').value,
          'descripcion_endoso': document.getElementById('descripcion_endoso').value,
          'dice':document.getElementById('dice').value,
          'debe_decir': document.getElementById('debe_decir').value,
          'monto': document.getElementById('monto').value,
          'moneda_poliza':document.getElementById('moneda_poliza').value,
          'prima_neta_exenta': document.getElementById('prima_neta_exenta').value,
          'iva': document.getElementById('iva').value,
          'prima_neta_afecta':document.getElementById('prima_neta_afecta').value,
          'prima_total': document.getElementById('prima_total').value,
          'tasa_afecta': document.getElementById('tasa_afecta').value,
          'tasa_exenta': document.getElementById('tasa_exenta').value,
          'id_poliza':'<?php echo $id_poliza; ?>',
          'numero_propuesta_endoso':'<?php echo $numero_propuesta ?>',
          'numero_endoso':document.getElementById("nro_endoso").value,
          'fecha_prorroga': document.getElementById('fecha_prorroga').value,
          'comentario_endoso':document.getElementById("comentarios").value,
          'accion':camino
          }, 'post');
        break;
        }
    }
   }
  
</script>

