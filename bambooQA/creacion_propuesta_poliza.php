
<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}
$camino = $nro_poliza = $selcompania = '';
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" and isset( $_POST[ "id_propuesta" ]) == true ) {
  require_once "/home/gestio10/public_html/backend/config.php";
  if ( isset( $_POST[ "modificar" ] ) == true ) {
    $camino = 'modificar';  }
  
 $id_propuesta = estandariza_info( $_POST[ "id_propuesta" ] );

  require_once "/home/gestio10/public_html/backend/config.php";
  mysqli_set_charset( $link, 'utf8' );
  mysqli_select_db( $link, 'gestio10_asesori1_bamboo_QA' );
  $query = "select rut_proponente, dv_proponente, rut_asegurado, dv_asegurado, compania, ramo, datediff(vigencia_final,vigencia_inicial) as dif_dias, vigencia_inicial, vigencia_final, numero_propuesta, cobertura, materia_asegurada, patente_ubicacion, moneda_poliza, deducible, FORMAT(prima_afecta, 4, 'es_CL') as prima_afecta, FORMAT(prima_exenta, 4, 'es_CL') as prima_exenta, FORMAT(prima_neta, 4, 'es_CL') as prima_neta, FORMAT(prima_bruta_anual, 4, 'es_CL') as prima_bruta_anual, monto_asegurado, fecha_propuesta, estado, item from propuesta_polizas where id=" . $id_propuesta;
  $resultado = mysqli_query( $link, $query );
  While( $row = mysqli_fetch_object( $resultado ) ) {
    $rut_prop = $row->rut_proponente;
    $dv_prop = $row->dv_proponente;
    $rut_aseg = $row->rut_asegurado;
    $dv_aseg = $row->dv_asegurado;
    $rut_completo_prop = $rut_prop . '-' . $dv_prop;
    $rut_completo_aseg = $rut_aseg . '-' . $dv_aseg;
    $selcompania = $row->compania;
    $ramo = $row->ramo;
    $fechainicio = $row->vigencia_inicial;
    $fechavenc = $row->vigencia_final;
    $dif_dias = $row->dif_dias;
    $cobertura = $row->cobertura;
    $materia = $row->materia_asegurada;
    $materia = str_replace( "\r\n", "\\n", $materia );
    $detalle_materia = $row->patente_ubicacion;
    $detalle_materia = str_replace( "\r\n", "\\n", $detalle_materia );
    $moneda_poliza = $row->moneda_poliza;
    $deducible = $row->deducible;
    $prima_afecta = $row->prima_afecta;
    $prima_exenta = $row->prima_exenta;
    $prima_neta = $row->prima_neta;
    $prima_bruta = $row->prima_bruta_anual;
    $monto_aseg = $row->monto_asegurado;
    $id_propuesta = $row->id_propuesta;
    $nro_propuesta = $row->numero_propuesta;
    $fechaprop = $row->fecha_envio_propuesta;
    $estado = $row->estado;
    $item = $row->item;
  }

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
<br>
<div class="form-check form-check-inline">
<div class="col align-self-end" id="botones_edicion" style="display:none ;align-items: center;">
  <button type="button" class="btn btn-second" id="edicion1" onclick="habilitaedicion1()"
                    style="background-color: #536656; margin-right: 5px ;color: white; display: flex">Editar</button>
  
</div>

</div>
<!-- --------------------------------------------                -->
 
<!-- --------------------------------------------                -->
<form action="/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php" class="needs-validation" method="POST" id="formulario" novalidate>
  <div class="accordion" id="accordionExample">
    <div class="card">
      <div class="card-header" id="headingOne" style="background-color:whitesmoke">
        <h5 class="mb-0">
          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne" style="color:#536656">Asegurado y
          Proponente</button>
        </h5>
      </div>
      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                    data-parent="#accordionExample">
        <div class="card-body" id="card-body-one"><br>
          <div class="form-check form-check-inline">
            <label class="form-check-label">¿Cliente Asegurado y Proponente son la misma
              persona?:&nbsp;&nbsp;</label>
            <input class="form-check-input" type="radio" name="diferentes" id="radio2_no"
                                value="diferentes" onchange="checkRadio2(this.name)">
            <label class="form-check-label">No&nbsp;</label>
            <input class="form-check-input" type="radio" name="iguales" id="radio2_si" value="iguales"
                                onclick="checkRadio2(this.name)" checked="checked" onchange="copiadatos()">
            <label class="form-check-label" for="inlineRadio2">Si&nbsp;&nbsp;</label>
          </div>
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
                                    onchange="valida_rut_duplicado_prop();copiadatos();rutprop_completo();nombre_prop_completo();"
                                    required readonly>
              <div class="invalid-feedback">Dígito verificador no válido. Verifica rut
                ingresado</div>
              <div style="color:red; visibility: hidden" id="validador10">No puedes dejar este campo
                en blanco</div>
            </div>
            <button type="button" class="btn btn-secondary" id="busca_rut_prop" data-toggle="modal"
                                onclick="origen_busqueda(this.id)" data-target="#modal_cliente"
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
                                    onchange="valida_rut_duplicado_prop();copiadatos();nombre_prop_completo();" required
                                    disabled>
              <div style="color:red; visibility: hidden" id="validador1">No puedes dejar este campo en
                blanco</div>
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
          <br>
          <br>
          <p><strong>Datos Asegurado<br>
            </strong></p>
          <div class="form-row">
            <div class="col-md-3 mb-3">
              <label for="RUT">RUT</label>
              <label style="color: darkred">&nbsp; *</label>
              <input type="text" class="form-control" id="rutaseg" name="rutaseg"
                                    placeholder="1111111-1" oninput="checkRut(this);rutaseg_completo();"
                                    oninput="checkRut(this);copiadatos()"
                                    onchange="valida_rut_duplicado_aseg();copiadatos();rutaseg_completo(); nombre_seg_completo();"
                                    required readonly>
              <div class="invalid-feedback">Dígito verificador no válido. Verifica rut
                
                ingresado</div>
              <div style="color:red; visibility: hidden" id="validador11">No puedes dejar este campo
                en blanco</div>
            </div>
            <button type="button" class="btn" id="busca_rut_aseg" onclick="origen_busqueda(this.id)"
                                data-toggle="modal" data-target="#modal_cliente"
                                style="background-color: #536656; color: white;margin-top: 30px;margin-left: 5px; height: 40px; visibility:hidden">Buscar
            RUT</button>
            <div class="col-1 ">
              <label for="prop">&nbsp;</label>
              <br>
            </div>
            <div class="col">
              <label for="Nombre">Nombre</label>
              <label style="color: darkred">&nbsp; *</label>
              <input type="text" id="nombre_seg" class="form-control" name="nombreaseg"
                                    onchange="nombre_seg_completo()" Oninput="nombre_seg_completo()" required disabled>
              <div style="color:red; visibility: hidden" id="validador2">No puedes dejar este campo en
                blanco</div>
            </div>
            <div class="col-md-4 mb-3" style="display:none">
              <label for="ApellidoP">Apellido Paterno</label>
              <input type="text" id="apellidop_seg" class="form-control" name="apellidopaseg"
                                    disabled>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3" style="display:none">
              <label for="ApellidoM">Apellido Materno</label>
              <input type="text" id="apellidom_seg" class="form-control" name="apellidomaseg"
                                    disabled>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
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
                            style="color:#536656">Compañía, Vigencia, Materia y Deducible</button>
        </h5>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body" id="card-body-two">
        <label for = "id_propuesta"><b>Datos Propuesta</b></label><br>
        <div class="form-row">
            <div class="col-4">
              <label for="seguimiento">N° de Seguimiento:&nbsp;</label>
              <label style="color: darkred">*</label>
              <input type="text" class="form-control" id="numero_propuesta" name="numero_propuesta">
            </div>
        
        <div class="col-4">
              <label for="seguimiento">Fecha Ingreso Propuesta:&nbsp;</label>
              <label style="color: darkred">*</label>
              <div class="md-form">
                <input placeholder="Selected date" type="date" name="fechaprop" id="fechaprop" value="<?php echo date("Y-m-d");?>"
                    class="form-control" onchange="fechavenc_completo();" oninput="valida_vencimiento()" max= "9999-12-31" required>
              </div>
         </div>
        </div>
        <br>
          <label for="compania"><b>Compañía</b></label>
          <label style="color: darkred">&nbsp; *</label>
          <br>
          <div class="form-row">
            <div class="form-inline">
              <select class="form-control" name="selcompania" id="selcompania"
                                    onChange="selcompania_completo()">
                <option value="null">Selecciona una compañía</option>
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
            </div>
          </div>
          <br>
          <label for="poliza"><b>Póliza</b></label>
          <br>
          <div class="form-row">
            <div class="col-6">
              <label for="sel1">Ramo:&nbsp;</label>
              <label style="color: darkred">*</label>
              <select class="form-control" name="ramo" id="ramo"
                                    onChange="cambia_deducible();ramo_completo();vencimientogarantia()">
                <option value="null">Selecciona un ramo</option>
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
            </div>
            <div class="col">
              <label for="Nombre">Vigencia Inicial</label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input placeholder="Selected date" type="date" id="fechainicio" name="fechainicio"
                                        class="form-control" onchange="fechainicio_completo(); validadorfecha(this.id)" max= "9999-12-31" required>
              </div>
              <div style="color:red; visibility: hidden" id="validador5">Debes seleccionar Fecha de
                Inicio</div>
            </div>
            <div class="col">
              <label for="Nombre">Vigencia Final</label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input placeholder="Selected date" type="date" name="fechavenc" id="fechavenc"
                                        class="form-control" onchange="fechavenc_completo();" oninput="valida_vencimiento()" max= "9999-12-31" required>
              </div>
              <div style="color:red; visibility: hidden" id="validador6">Debes seleccionar Fecha de
                Vencimiento</div>
            </div>
          </div>
          <br>
          <div class="form-row">
         
            <div class="col-2">
              <label for="item">Ítem</label>
              <input type="text" class="form-control" id="item" name="item">
             
            </div>
            <div class="col-4">
              <label for="cobertura">Cobertura</label>
              <input type="text" class="form-control" id="cobertura" name="cobertura">
            </div>
          </div>
          <br>
          <label for="materia"><b>Materia</b></label>
          <br>
          <div class="form-row">
            <div class="col">
              <label for="poliza">Materia Asegurada</label>
              <label style="color: darkred">&nbsp; *</label>
              <textarea type="text" class="form-control" id="materia" name="materia" rows="3"
                                    onchange="materia_completo();" required></textarea>
              <div style="color:red; visibility: hidden" id="validador8">Debes indicar materia</div>
            </div>
          </div>
          <br>
          <div class="form-row">
            <div class="col">
              <label for="poliza">Patente o Ubicación</label>
              <label style="color: darkred">&nbsp; *</label>
              <textarea type="text" class="form-control" id="detalle_materia" name="detalle_materia"
                                    rows="3" onchange="detalle_materia_completo();" required></textarea>
              <div style="color:red; visibility: hidden" id="validador9">Debes indicar patente o
                ubicación</div>
            </div>
          </div>
          <br>
          <div class="form-row" id="vencimiento_gtia" style = "display:none">
          <div class="col-3">             
            <label for="venc_garantia">Vencimiento Garantía del automóvil</label>
              <div class="form-check">
                 <input type="checkbox" class="form-check-input" id="pregunta_gtia" Onclick =vencimiento_garantía()>
                 <label class="form-check-label" for="pregunta_gtia">Vencimiento Garantía</label>
             </div>
            <div class="md-form">
              <input placeholder="Selected date" type="date" name="venc_gtia" id="venc_gtia" class="form-control" readonly>
              
              <br>
              <br>
            </div>
          </div>
        </div>
        <label for="materia"><b>Deducible, Primas y Montos</b></label>
        <br>
        <div class="form-row; form-inline">
          <label for="moneda_poliza">Moneda Prima</label>
          <div class="col-1">
            <select class="form-control" id="moneda_poliza" name="moneda_poliza" onChange="cambio_moneda()">
              <option value="UF" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "UF") echo "selected" ?>>UF</option>
              <option value="USD" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "USD") echo "selected" ?>>USD</option>
              <option value="CLP" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_poliza == "CLP") echo "selected" ?>>CLP</option>
            </select>
          </div>
        </div>
        <br>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="deducible">Deducible</label>
            <div class="form-inline" style="display:none">
              <input type="text" class="form-control" name="deducible" id="deducible">
            </div>
            <div class="form-inline" id="deducible_defecto">
              <div class="input-group-prepend"><span class="input-group-text"
                                            id="moneda">UF</span></div>
              <input type="text" class="form-control" name="deducible_defecto"
                                        id="deducible_defecto_1" onChange="pobladeducible()">
            </div>
            <div class="form-inline" id="deducible_veh" style="display:none ;align-items: center;">
              <select class="form-control" id="deducible_veh_1" name="deducible_veh_1"
                                        onChange="pobladeducible()">
                <option value="null" ?>Selecciona el deducible</option>
                <option value="Sin deducible" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "Sin deducible") echo "selected" ?>>Sin deducible</option>
                <option value="UF 3" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 3") echo "selected" ?>>UF 3</option>
                <option value="UF 5" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 5") echo "selected" ?>>UF 5</option>
                <option value="UF 10" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 10") echo "selected" ?>>UF 10</option>
                <option value="UF 20" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 20") echo "selected" ?>>UF 20</option>
                 <option value="UF 50" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $deducible == "UF 50") echo "selected" ?>>UF 50</option>
              </select>
            </div>
            <div class="form-inline" id="deducible_viaje" style="display:none">
              <input type="text" class="form-control" name="deducible_viaje_1" id="deducible_viaje_1" value="No Aplica" onChange="pobladeducible()">
            </div>
            <div class="form-inline" id="deducible_inc" style="display:none">
              <input type="text" class="form-control" name="deducible_inc_1" id="deducible_inc_1" value="Varios" onChange="pobladeducible()">
            </div>
            <div class="form" id="deducible_rc" style="display: none; align-items: center;">
              <div class="col-3">
                <input type="text" class="form-control" name="deducible_porcentaje" id="deducible_porcentaje" placeholder="%">
              </div>
              <label style="font-size: 10px;">% Pérdida con mínimo de</label>
              <div class="col-md-5" style="display: flex; align-items: center;">
                <div class="input-group-prepend"><span class="input-group-text" id="moneda7">UF</span></div>
                <input type="text" class="form-control" name="deducible_valor" id="deducible_valor" placeholder="Valor" onChange="pobladeducible()">
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="prima_afecta">Prima Neta Afecta</label>
            <div class="form-inline">
              <div class="input-group-prepend"><span class="input-group-text"
                                            id="moneda2">UF</span></div>
              <input type="text" class="form-control" name="prima_afecta" id="prima_afecta"
                                        onChange="calculaprimabruta()">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="prima_exenta">Prima Neta Exenta</label>
            <div class="form-inline">
              <div class="input-group-prepend"><span class="input-group-text"
                                            id="moneda3">UF</span></div>
              <input type="text" class="form-control" id="prima_exenta" name="prima_exenta"
                                        onChange="calculaprimabruta()">
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="prima_afecta">Prima Neta Total</label>
            <div class="form-inline">
              <div class="input-group-prepend"><span class="input-group-text"
                                            id="moneda4">UF</span></div>
              <input type="text" class="form-control" id="prima_neta" name="prima_neta">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="prima_afecta">Prima Bruta Anual</label>
            <div class="form-inline">
              <div class="input-group-prepend"><span class="input-group-text"
                                            id="moneda5">UF</span></div>
              <input type="text" class="form-control" id="prima_bruta" name="prima_bruta">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="monto_aseg">Monto Asegurado</label>
             <label style="color: darkred">&nbsp; *</label>
          
            <input type="text" class="form-control" name="monto_aseg" id="monto_aseg" onchange = "monto_aseg_completo()">
              <div style="color:red; visibility: hidden" id="validador13">Debes indicar monto</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  

  </div>
  <br>
  <div id="auxiliar2" style="display: none;">
  </div>
  <button class="btn" type="submit" style="background-color: #536656; color: white"
            id='boton_submit' onclick = "bPreguntar = false">Registrar</button>
</form>
<br>
<br>
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
<script src="/assets/js/jquery.redirect.js"></script>
<script src="/assets/js/validarRUT.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</body>
</html><script>
function valida_rut_duplicado_prop() {
    var dato = $('#rutprop').val();
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
                document.getElementById("apellidop_prop").value = response.apellidop;
                document.getElementById("apellidom_prop").value = response.apellidom;
            }
        }
    });
}
function valida_rut_duplicado_aseg() {
    var dato = $('#rutaseg').val();
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
                document.getElementById("nombre_seg").value = response.nombre;
                document.getElementById("apellidop_seg").value = response.apellidop;
                document.getElementById("apellidom_seg").value = response.apellidom;
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
    if (name == "diferentes") {
        document.getElementById("radio2_si").checked = false;
        document.getElementById("radio2_no").checked = true;
        document.getElementById("busca_rut_aseg").style.visibility = "visible";
    } else if (name == "iguales") {
        document.getElementById("radio2_no").checked = false;
        document.getElementById("radio2_si").checked = true;
        document.getElementById("rutaseg").disabled = true;
        document.getElementById("busca_rut_aseg").style.visibility = "hidden";
        document.getElementById("rutprop").value = document.getElementById("rutaseg").value;
    }
}
function copiadatos() {
    if (document.getElementById("radio2_si").checked) {
        document.getElementById("rutaseg").value = document.getElementById("rutprop").value;
        document.getElementById("nombre_seg").value = document.getElementById("nombre_prop").value;
        document.getElementById("apellidop_seg").value = document.getElementById("apellidop_prop").value;
        document.getElementById("apellidom_seg").value = document.getElementById("apellidom_prop").value;
    } else {
    }
}
function cambio_moneda() {
    var moneda = document.getElementById("moneda_poliza").value;
    document.getElementById("moneda").innerHTML = moneda;
    document.getElementById("moneda2").innerHTML = moneda;
    document.getElementById("moneda3").innerHTML = moneda;
    document.getElementById("moneda4").innerHTML = moneda;
    document.getElementById("moneda5").innerHTML = moneda;
    document.getElementById("moneda7").innerHTML = moneda;
}
function calculaprimabruta() {
    var primaafecta = document.getElementById("prima_afecta").value;
    var primaexenta = document.getElementById("prima_exenta").value;
    var primabruta;
    var primaneta;
    primabruta = parseFloat(primaafecta.replace(",", "."), 10) * (1.19) + parseFloat(primaexenta.replace(",", "."))
    primaneta = parseFloat(primaafecta.replace(",", "."), 10) + parseFloat(primaexenta.replace(",", "."))
    document.getElementById("prima_bruta").value = primabruta.toFixed(2).replace(".", ",")
    document.getElementById("prima_neta").value = primaneta.toFixed(2).replace(".", ",")
}

function pobladeducible() {
    ramo = document.getElementById("ramo").value;
    if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo == "VEH - Vehículos Particulares" ||
        ramo == "VEH - Vehículos Pesados") {
        document.getElementById("deducible").value = document.getElementById("deducible_veh_1").value;
    } else if (ramo == "INC" || ramo == "Hogar" || ramo == "PyME" || ramo == "INC - Condominio" || ramo ==
        "INC - Hogar" || ramo == "INC - Misceláneos" || ramo == "INC - Perjuicio por Paralización" || ramo ==
        "INC - Pyme" || ramo == "INC - TRBF (Todo Riesgo Bienes Físicos)") {
        document.getElementById("deducible").value = document.getElementById("deducible_inc_1").value;
    } else if (ramo == "A. VIAJE" || ramo == "APV" || ramo == "AP" || ramo == "Vida" || ramo == "Garantía" || ramo ==
        "AC - Accidentes Personales" || ramo == "AC - Protección Financiera" || ramo == "ASISTENCIA EN VIAJE" || ramo ==
        "APV" || ramo == "VIDA") {
        document.getElementById("deducible").value = document.getElementById("deducible_viaje_1").value;
    } else if (ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General") {
        document.getElementById("deducible").value = document.getElementById("deducible_porcentaje").value +
            "% de la Pérdida con mínimo de " + document.getElementById("moneda7").innerHTML + " " + document
            .getElementById("deducible_valor").value;
    } else {
        document.getElementById("deducible").value = document.getElementById("deducible_defecto_1").value
    }
}
function cambia_deducible() {
    var ramo = document.getElementById("ramo").value;
    if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo == "VEH - Vehículos Particulares" ||
        ramo == "VEH - Vehículos Pesados") {
        document.getElementById("deducible_veh").style.display = "flex";
        document.getElementById("deducible_defecto").style.display = "none";
        document.getElementById("deducible_inc").style.display = "none";
        document.getElementById("deducible_viaje").style.display = "none";
        document.getElementById("deducible_rc").style.display = "none";
        document.getElementById("deducible").value = document.getElementById("deducible_veh_1").value;
    } else if (ramo == "INC" || ramo == "Hogar" || ramo == "PyME" || ramo == "INC - Condominio" || ramo ==
        "INC - Hogar" || ramo == "INC - Misceláneos" || ramo == "INC - Perjuicio por Paralización" || ramo ==
        "INC - Pyme" || ramo == "INC - TRBF (Todo Riesgo Bienes Físicos)") {
        document.getElementById("deducible_veh").style.display = "none";
        document.getElementById("deducible_defecto").style.display = "none";
        document.getElementById("deducible_inc").style.display = "flex";
        document.getElementById("deducible_viaje").style.display = "none";
        document.getElementById("deducible_rc").style.display = "none";
        document.getElementById("deducible").value = document.getElementById("deducible_inc_1").value;

    } else if (ramo == "A. VIAJE" || ramo == "APV" || ramo == "AP" || ramo == "Vida" || ramo == "Garantía" || ramo ==
        "AC - Accidentes Personales" || ramo == "AC - Protección Financiera" || ramo == "ASISTENCIA EN VIAJE" || ramo ==
        "APV" || ramo == "VIDA") {
        document.getElementById("deducible_veh").style.display = "none";
        document.getElementById("deducible_defecto").style.display = "none";
        document.getElementById("deducible_inc").style.display = "none";
        document.getElementById("deducible_viaje").style.display = "flex";
        document.getElementById("deducible_rc").style.display = "none";
        document.getElementById("deducible").value = document.getElementById("deducible_viaje_1").value;

    } else if (ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General") {
        document.getElementById("deducible_veh").style.display = "none";
        document.getElementById("deducible_defecto").style.display = "none";
        document.getElementById("deducible_inc").style.display = "none";
        document.getElementById("deducible_viaje").style.display = "none";
        document.getElementById("deducible_rc").style.display = "flex";
        document.getElementById("deducible").value = document.getElementById("deducible_porcentaje").value +
            "% de la Pérdida con mínimo de " + document.getElementById("moneda7").innerHTML + " " + document
            .getElementById("deducible_valor").value;
    } else {
        document.getElementById("deducible_veh").style.display = "none";
        document.getElementById("deducible_defecto").style.display = "flex";
        document.getElementById("deducible_inc").style.display = "none";
        document.getElementById("deducible_viaje").style.display = "none";
        document.getElementById("deducible_rc").style.display = "none";
        document.getElementById("deducible").value = document.getElementById("deducible_defecto_1").value
    }
}
function validavendedor() {
    if (document.getElementById("con_vendedor").value == "Si") {
        document.getElementById("nombre_vendedor").disabled = false;
    } else {
        document.getElementById("nombre_vendedor").disabled = true;
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
function origen_busqueda(origen_boton) {
    origen = origen_boton;
}
function seleccion_rut(rut) {

    switch (origen) {
        case 'busca_rut_prop': {
            document.getElementById("rutprop").value = rut;
            document.getElementById("rutprop").onchange()
            document.getElementById("rutaseg").onchange()
            break;
        }
        case 'busca_rut_aseg': {
            document.getElementById("rutaseg").value = rut;
            document.getElementById("rutaseg").onchange()
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
    document.getElementById("rutaseg").readonly = true;
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
	
    var consulta= '<?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && isset( $_POST[ "id_propuesta" ]) == true ) echo "True"; ?>'
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
                    document.getElementById("rutaseg").value = '<?php echo $rut_completo_aseg; ?>';
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
                    
                    document.getElementById("id_propuesta").value = '<?php echo $id_propuesta; ?>';
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
                        document.getElementById("deducible_defecto_1").value = document.getElementById("deducible")
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

document.getElementById("formulario").addEventListener('submit', function(event) {

    if (document.getElementById("rutprop").value == "") {
        document.getElementById("validador10").style.visibility = "visible";
        event.preventDefault();
    }
    if (document.getElementById("rutaseg").value == "") {
        document.getElementById("validador11").style.visibility = "visible";
        event.preventDefault();
    }
    if (document.getElementById("nombre_prop").value == "") {
        document.getElementById("validador1").style.visibility = "visible";
        event.preventDefault();
    }
    if (document.getElementById("nombre_seg").value == "") {
        document.getElementById("validador2").style.visibility = "visible";
        event.preventDefault();
    }
    if (document.getElementById("selcompania").value == "null") {
        document.getElementById("selcompania").style.color = "red";
        event.preventDefault();
    }
    if (document.getElementById("ramo").value == "null") {
        document.getElementById("ramo").style.color = "red";
        event.preventDefault();
    }
    if (document.getElementById("fechainicio").value == "") {
        document.getElementById("validador5").style.visibility = "visible";
        event.preventDefault();
    }
    if (document.getElementById("fechavenc").value == "") {
        document.getElementById("validador6").style.visibility = "visible";
        event.preventDefault();
    }
    if (document.getElementById("nro_poliza").value == "") {
        document.getElementById("validador7").style.visibility = "visible";
        event.preventDefault();
    }
    if (document.getElementById("materia").value == "") {
        document.getElementById("validador8").style.visibility = "visible";
        event.preventDefault();
    }
    if (document.getElementById("detalle_materia").value == "") {
        document.getElementById("validador9").style.visibility = "visible";
        event.preventDefault();
    }
     if (document.getElementById("monto_aseg").value == "") {
        document.getElementById("validador13").style.visibility = "visible";
        event.preventDefault();
    }
     else {
    }
    
    
});
document.getElementById("busca_rut_prop").addEventListener("click", function(event) {
    event.preventDefault()
});

function validadorfecha(id){
    
    var fechainicial = document.getElementById(id).value;
    fechafinal = new Date(9999,12,31)
   
    if( Date.parse(fechafinal) < Date.parse(fechainicial) ){
        alert("El año ingresado tiene mas de 4 dígitos");
        
    }
}
function rutprop_completo() {
    if (document.getElementById("rutprop").value != "") {
        document.getElementById("validador10").style.visibility = "hidden";
    }
}
function rutaseg_completo() {
    if (document.getElementById("rutaseg").value != "") {
        document.getElementById("validador11").style.visibility = "hidden";
    }
}
function nombre_prop_completo() {
    if (document.getElementById("nombre_prop").value != "") {
        document.getElementById("validador1").style.visibility = "hidden";
        document.getElementById("validador10").style.visibility = "hidden";
    }
}
function nombre_seg_completo() {
    if (document.getElementById("nombre_seg").value != "") {
        document.getElementById("validador2").style.visibility = "hidden";
        document.getElementById("validador11").style.visibility = "hidden";
    }
}
function selcompania_completo() {
    if (document.getElementById("selcompania").value != "null") {
        document.getElementById("selcompania").style.color = "grey";
    }
}
function ramo_completo() {
    if (document.getElementById("ramo").value != "null") {
        document.getElementById("ramo").style.color = "grey";
    }
}
function fechainicio_completo() {
    if (document.getElementById("fechainicio").value != "") {
        document.getElementById("validador5").style.visibility = "hidden";
    }
}
function fechavenc_completo() {
    if (document.getElementById("fechavenc").value != "") {
        document.getElementById("validador6").style.visibility = "hidden";
    }
}

function materia_completo() {
    if (document.getElementById("materia").value != "") {
        document.getElementById("validador8").style.visibility = "hidden";
    }
}
function detalle_materia_completo() {
    if (document.getElementById("detalle_materia").value != "") {
        document.getElementById("validador9").style.visibility = "hidden";
    }
}
function monto_aseg_completo() {
    if (document.getElementById("monto_aseg").value != "") {
        document.getElementById("validador13").style.visibility = "hidden";
    }
}



function vencimientogarantia(){
  var ramo = document.getElementById("ramo").value;
            if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo ==
                "VEH - Vehículos Particulares" || ramo == "VEH - Vehículos Pesados") {
                document.getElementById("vencimiento_gtia").style.display ="flex";
                }
                else {      
              document.getElementById("vencimiento_gtia").style.display ="none";
                }
}

function vencimiento_garantía(){
    
    if (document.getElementById("pregunta_gtia").checked == true)
    {
         document.getElementById("venc_gtia").readOnly = false;
         
        
        
    }
    
   else  if (document.getElementById("pregunta_gtia").checked == false){
        
         document.getElementById("venc_gtia").readOnly = true;
         document.getElementById("venc_gtia").value = '';
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

</script>