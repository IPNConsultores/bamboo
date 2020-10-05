<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}
$camino = $nro_poliza = $selcompania = '';
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" and isset( $_POST[ "id_poliza" ]) == true ) {
  require_once "/home/gestio10/public_html/backend/config.php";
  if ( isset( $_POST[ "renovar" ] ) == true ) {
    $camino = 'renovar';
    mysqli_set_charset( $link, 'utf8' );
    mysqli_select_db( $link, 'gestio10_asesori1_bamboo' );
    $query = "update polizas set tipo_poliza='Renovada' where id=" . $id_poliza;
    $resultado = mysqli_query( $link, $query );
  } else {
    $camino = 'modificar';
  }
  
 $id_poliza = estandariza_info( $_POST[ "id_poliza" ] );

  require_once "/home/gestio10/public_html/backend/config.php";
  mysqli_set_charset( $link, 'utf8' );
  mysqli_select_db( $link, 'gestio10_asesori1_bamboo' );
  $query = "select  rut_proponente,  dv_proponente,  rut_asegurado,  dv_asegurado,  compania,  ramo, datediff(vigencia_final,vigencia_inicial) as dif_dias, vigencia_inicial,  vigencia_final, date_add(vigencia_final, interval 1 year) as vigencia_final_renovada, numero_poliza,  cobertura,  materia_asegurada,  patente_ubicacion, moneda_poliza,  deducible,  FORMAT(prima_afecta, 4, 'de_DE') as prima_afecta,  FORMAT(prima_exenta, 4, 'de_DE') as prima_exenta,  FORMAT(prima_neta, 4, 'de_DE') as prima_neta,  FORMAT(prima_bruta_anual, 4, 'de_DE') as prima_bruta_anual,  monto_asegurado,  numero_propuesta,  fecha_envio_propuesta,  moneda_comision,  FORMAT(comision, 4, 'de_DE') as comision,  FORMAT(porcentaje_comision, 4, 'de_DE') as porcentaje_comision,  FORMAT(comision_bruta, 4, 'de_DE') as comision_bruta,  FORMAT(comision_neta, 4, 'de_DE') as comision_neta, moneda_valor_cuota,  forma_pago, nro_cuotas,  FORMAT(valor_cuota, 4, 'de_DE') as valor_cuota,  fecha_primera_cuota, date_add(fecha_primera_cuota, interval 1 year) as fecha_primera_cuota_ren,   vendedor, nombre_vendedor, poliza_renovada, FORMAT(comision_negativa, 4, 'de_DE') as comision_negativa, boleta_negativa, depositado_fecha, numero_boleta, endoso, informacion_adicional, estado, venc_gtia, fech_cancela, motivo_cancela,item from polizas where id=" . $id_poliza;
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
    $fechavenc_ren = $row->vigencia_final_renovada;
    $dif_dias = $row->dif_dias;
    $fecha_primera_cuota_ren = $row->fecha_primera_cuota_ren;
    $nro_poliza = $row->numero_poliza;
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
    $nro_propuesta = $row->numero_propuesta;
    $fechaprop = $row->fecha_envio_propuesta;
    $moneda_comision = $row->moneda_comision;
    $comision = $row->comision;
    $porcentaje_comsion = $row->porcentaje_comision;
    $comisionbruta = $row->comision_bruta;
    $comisionneta = $row->comision_neta;
    $modo_pago = $row->forma_pago;
    $cuotas = $row->nro_cuotas;
    $moneda_cuota = $row->moneda_valor_cuota;
    $valorcuota = $row->valor_cuota;
    $fechaprimer = $row->fecha_primera_cuota;
    $con_vendedor = $row->vendedor;
    $nombre_vendedor = $row->nombre_vendedor;
    $poliza_renovada = $row->poliza_renovada;
    $boleta = $row->numero_boleta;
    $comision_negativa = $row->comision_negativa;
    $boleta_negativa = $row->boleta_negativa;
    $depositado_fecha = $row->depositado_fecha;
    $endoso = $row->endoso;
    $endoso = str_replace( "\r\n", "\\n", $endoso );
    $comentario = $row->informacion_adicional;
    $comentario = str_replace( "\r\n", "\\n", $comentario );
    $estado = $row->estado;
    $venc_gtia = $row->venc_gtia;
    $fech_cancela = $row->fech_cancela;
    $motivo_cancela = $row->motivo_cancela;
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
<link rel="icon" href="/bamboo/images/bamboo.png">
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
  <p>Póliza / Creación<br>
  </p>
</div>
<div id=titulo2 style="display:none">
  <p>Póliza / Modificación / N° Póliza :
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
  <button ctype="button" lass="btn btn-second" id="cancelar1" onclick="cancela()"
                    style="background-color: #721c24; margin-right: 5px ;color: white; display: flex">Cancelar</button>
  <button type="button" class="btn btn-second" id="anular" onclick="modifica_estado(this.id)"
                    style="background-color: #721c24; margin-right: 5px; color: white; display: flex">Anular</button>
</div>
<div class="form" id="pregunta_renovar" style="display:flex ;align-items: center;">
  <label class="form-check-label">¿Desea renovar una póliza existente?:&nbsp;&nbsp;</label>
  <input class="form-check-input" type="radio" name="nueva" id="radio_no" value="nueva"
                    onclick="checkRadio(this.name)" checked="checked">
  <label class="form-check-label" for="inlineRadio1">No&nbsp;</label>
  <input class="form-check-input" type="radio" name="renovacion" id="radio_si" value="renovacion"
                    onclick="checkRadio(this.name)">
  <label class="form-check-label" for="inlineRadio2">Si&nbsp;&nbsp;</label>
  <button type="button" class="btn" id="busca_poliza" data-toggle="modal" data-target="#modal_poliza"
                    style="background-color: #536656; color: white;display: none">Buscar Póliza</button>
  <div class="modal fade" id="modal_poliza" tabindex="-1" role="dialog" aria-labelledby="modal_text"
                    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div id="test1" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_text">Buscar Póliza a Renovar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <table class="display" style="width:100%" id="listado_polizas">
              <tr>
                <th></th>
                <th>Estado</th>
                <th>Póliza</th>
                <th>Compañia</th>
                <th>Ramo</th>
                <th>Inicio Vigencia</th>
                <th>Fin Vigencia</th>
                <th>Materia Asegurada</th>
                <th>Observaciones</th>
                <th>nom_clienteP</th>
                <th>nom_clienteA</th>
              </tr>
            </table>
            <div id="botones_poliza"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col">
<!-- "/bamboo/backend/polizas/crea_poliza.php" -->
<form action="/bamboo/backend/polizas/crea_poliza.php" class="needs-validation" method="POST"

                    id="formulario" novalidate>
  <div id="auxiliar" style="display: none;">
    <input name="id_poliza" id="id_poliza">
  </div>
  <input type="text" class="form-control" name="poliza_renovada" placeholder="Póliza Anterior"
                        id="poliza_renovada" style="display:none;">
  </div>
  </div>
<!-- --------------------------------------------                -->
  <div class ="col" id="datos_cancelacion"  style = "display:none"><br>
    <div class ="row" >
      <div class="col"style="display:flex ;align-items: center;">
        <p><b>Complete información de</p>
        &nbsp;
        <p style="color:red">CANCELACIÓN</b></p>
      </div>
    </div>
    <div class ="row" >
      <div class="col-4" style="display:flex ;align-items: center;">
        <label for="datofecha_cancelacion">Fecha Cancelación &nbsp;&nbsp;</label>
        <div class="md-form">
          <input placeholder="Selected date" type="date" id="datofecha_cancelacion" name="datofecha_cancelacion"
                                        class="form-control">
        </div>
      </div>
      <div class="col" style="display:flex ;align-items: center;">
        <label for="datomotivo_cancela">Motivo &nbsp;&nbsp;</label>
        <div class = "col-9">
          <input placeholder="Ingresa un Motivo" type="text" id="datomotivo_cancela" class="form-control" name="datomotivo_cancela">
        </div>
        <button type="button" class="btn btn-second" id="cancelar" onclick="modifica_estado(this.id)" style="background-color: #721c24; margin-right: 5px ;color: white; display: flex">Confirmar Cancelación</button>
      </div>
    </div>
  </div>
<!-- --------------------------------------------                -->
  <br>
  <br>
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
                                        class="form-control" onchange="fechainicio_completo()" required>
              </div>
              <div style="color:red; visibility: hidden" id="validador5">Debes seleccionar Fecha de
                Inicio</div>
            </div>
            <div class="col">
              <label for="Nombre">Vigencia Final</label>
              <label style="color: darkred">&nbsp; *</label>
              <div class="md-form">
                <input placeholder="Selected date" type="date" name="fechavenc" id="fechavenc"
                                        class="form-control" onchange="fechavenc_completo()" required>
              </div>
              <div style="color:red; visibility: hidden" id="validador6">Debes seleccionar Fecha de
                Vencimiento</div>
            </div>
          </div>
          <br>
          <div class="form-row">
            <div class="col-4">
              <label for="poliza">Número de Poliza</label>
              <label style="color: darkred">&nbsp; *</label>
              <input type="text" class="form-control" id="nro_poliza" name="nro_poliza"
                                    onchange="nro_poliza_completo()" required>
              <div style="color:red; visibility: hidden" id="validador7">Debes ingresar número de
                póliza</div>
            </div>
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
            <input type="text" class="form-control" name="monto_aseg" id="monto_aseg">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree" style="background-color:whitesmoke">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"
                            style="color:#536656">Propuesta, Comisiones y Método de Pagos</button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body" id="card-body-three">
        <label for="propuesta"><b>Propuesta</b></label>
        <br>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="nro_propuesta">Número de Propuesta</label>
            <input type="text" class="form-control" id="nro_propuesta" name="nro_propuesta">
          </div>
          <div class="col-md-4 mb-3">
            <label for="fechaprop">Fecha Envío Propuesta</label>
            <div class="md-form">
              <input placeholder="Selected date" type="date" name="fechaprop" id="fechaprop"
                                        class="form-control">
            </div>
          </div>
        </div>
        <br>
        <label for="materia"><b>Comisión</b></label>
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
            <input type="text" class="form-control" name="boleta" id="boleta">
          </div>
          <div class="col-md-4 mb-3">
            <label for="fechadeposito">Fecha Depósito</label>
            <div class="md-form">
              <input placeholder="Selected date" type="date" name="fechadeposito"
                                        id="fechadeposito" class="form-control">
            </div>
          </div>
        </div>
        <br>
        <label for="materia"><b>Comisión Negativa</b></label>
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
            <input type="text" class="form-control" name="boletaneg" id="boletaneg">
          </div>
        </div>
        <br>
        <label for="pago"><b>Pago</b></label>
        <br>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="formapago">Forma de Pago</label>
            <label style="color: darkred">&nbsp; *</label>
            <div class="form" style="display: flex; align-items: center;">
              <select class="form-control" name="modo_pago" id="modo_pago"
                                        onChange="modopago();modopago_completo();">
                <option value="null">Selecciona forma de pago</option>
                <option value="PAT"
                                            <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $modo_pago == "PAT") echo "selected" ?>>PAT</option>
                <option value="PAC"
                                            <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $modo_pago == "PAC") echo "selected" ?>>PAC</option>
                <option value="Plan de pago"
                                            <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $modo_pago == "Plan de pago") echo "selected" ?>>Plan de pago</option>
                <option value="Contado"
                                            <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $modo_pago == "Contado") echo "selected" ?>>Contado</option>
              </select>
              <select class="form-control" name="cuotas" id="cuotas"
                                        onchange="cuotas_completo();">
                <option value="null">Selecciona Cantidad de Cuotas</option>
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
              <select class="form-control" name="moneda_cuota" id="moneda_cuota">
                <option value="UF"
                                            <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_cuota == "UF") echo "selected" ?>>UF</option>
                <option value="USD"
                                            <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_cuota == "USD") echo "selected" ?>>USD</option>
                <option value="CLP"
                                            <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_cuota == "CLP") echo "selected" ?>>CLP</option>
              </select>
              <input type="text" class="form-control" name="valorcuota" id="valorcuota"
                                        oninput="concatenar(this.id)">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="fechaprimer">Fecha Primera Cuota</label>
            <div class="md-form">
              <input type="date" class="form-control" id="fechaprimer" name="fechaprimer">
            </div>
          </div>
        </div>
        <br>
        <label for="pago"><b>Vendedor</b></label>
        <br>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <div class="form-row">
              <div class="col-4">
                <select class="form-control" name="con_vendedor" id="con_vendedor"
                                            onChange="validavendedor()">
                  <option value="No"
                                                <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $con_vendedor == "No") echo "selected" ?>>No</option>
                  <option value="Si"
                                                <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $con_vendedor == "Si") echo "selected" ?>>Si</option>
                </select>
              </div>
              &nbsp;
              <div class="col">
                <input type="text" class="form-control" id="nombre_vendedor"
                                            name="nombre_vendedor" placeholder="Nombre Vendedor" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingfour" style="background-color:whitesmoke">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour"
                            style="color:#536656">Comentarios y Endosos</button>
      </h5>
    </div>
    <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordionExample">
      <div class="card-body" id="card-body-four">
        <label for="comentario"><b>Comentarios</b></label>
        <br>
        <textarea class="form-control" rows="2" style="height:100px" id='comentario' name='comentario'
                            style="text-indent:0px" ;>
        </textarea>
        <br>
        <label for="endoso"><b>Endosos</b></label>
        <br>
        <textarea class="form-control" rows="2" style="height:100px" id='endoso' name='endoso'
                            style="text-indent:0px" ;>
        </textarea>
      </div>
    </div>
  </div>
  </div>
  <br>
  <div id="auxiliar2" style="display: none;">
    <input name="id_poliza_renovada" id="id_poliza_renovada">
    <input name="nro_poliza_renovada" id="nro_poliza_renovada">
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
        url: "/bamboo/backend/clientes/busqueda_nombre.php",
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
        url: "/bamboo/backend/clientes/busqueda_nombre.php",
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
function calculacomision() {
    var porcentajecomision = document.getElementById("porcentaje_comsion").value;
    var primaneta = document.getElementById("prima_neta").value;
    var comision;
    comision = parseFloat(porcentajecomision.replace(",", "."), 10) / (100) * parseFloat(primaneta.replace(",", "."))
    document.getElementById("comision").value = comision.toFixed(2).replace(".", ",")
}
function modopago() {
    if (document.getElementById("modo_pago").value == "Contado") {
        document.getElementById("cuotas").disabled = true;
        document.getElementById("cuotas").value = "Contado";
    } else {
        document.getElementById("cuotas").disabled = false;
        document.getElementById("cuotas").value = "null";
    }
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
var table = $('#listado_polizas').DataTable({
    "ajax": "/bamboo/backend/polizas/busqueda_listado_polizas.php",
    "scrollX": true,
    "searchPanes": {
        "columns": [2, 3, 8, 9],
    },
    "dom": 'Pfrtip',
    "columns": [{
            "className": 'details-control',
            "orderable": false,
            "data": null,
            "render": function(data, type, row, meta) {
                return '<button type="button" id="' + row.id_poliza +
                    '" name="' + row.tipo_poliza +
                    '" onclick="renovar_poliza(this.id, this.name)" class="btn btn-outline-primary">Renovar</button>';
            }
        },
        {
            "data": "estado",
            title: "Estado"
        },
        { 
                data: null, 
                title: "Nro Póliza",
                render: function ( data, type, row ) {
                    return data.numero_poliza + ' (' + data.item + ')';
            } },
        {
            "data": "compania",
            title: "Compañía"
        },
        {
            "data": "ramo",
            title: "Ramo"
        },
        {
            "data": "vigencia_inicial",
            title: "Vigencia Inicio"
        },
        {
            "data": "vigencia_final",
            title: "Vigencia Término"
        },
        {
            "data": "materia_asegurada",
            title: "Materia asegurada"
        },
        {
            "data": "patente_ubicacion",
            title: "Observaciones materia asegurada"
        },
        {
            "data": "nom_clienteP",
            title: "Nombre proponente"
        },
        {
            "data": "nom_clienteA",
            title: "Nombre asegurado"
        }
    ],
    "columnDefs": [{
            "targets": [5, 6],
            "searchable": false
        },
        {
            targets: 1,
            render: function(data, type, row, meta) {
                var estado = '';
                switch (data) {
                  case 'Activo':
                            estado='<span class="badge badge-primary">'+data+'</span>';
                            break;
                        case 'Renovado':
                                estado='<span class="badge badge-warning">'+data+'</span>';
                                break;
                        case 'Vencido':
                            estado='<span class="badge badge-danger">'+data+'</span>';
                            break;
                        case 'Cancelado':
                            estado='<span class="badge badge-dark">'+data+'</span>';
                            break;
                        default:
                            estado='<span class="badge badge-light">'+data+'</span>';
                            break;
                }
                return estado; //render link in cell
            }
        }
    ],
    "order": [
        [3, "asc"],
        [4, "asc"]
    ],
    "oLanguage": {
        "sSearch": "Búsqueda rápida",
        "sLengthMenu": 'Mostrar <select>' +
            '<option value="10">10</option>' +
            '<option value="25">30</option>' +
            '<option value="50">50</option>' +
            '<option value="-1">todos</option>' +
            '</select> registros',
        "sInfoFiltered": "(_TOTAL_ registros de _MAX_ registros totales)",
        "sLengthMenu": "Muestra _MENU_ registros por página",
        "sZeroRecords": "No hay registros asociados",
        "sInfo": "Mostrando página _PAGE_ de _PAGES_",
        "sInfoEmpty": "No hay registros disponibles",
        "oPaginate": {
            "sNext": "Siguiente",
            "sPrevious": "Anterior",
            "sLast": "Última"
        }
    },
    "language": {
        "searchPanes": {
            "title": {
                _: 'Filtros seleccionados - %d',
                0: 'Sin Filtros Seleccionados',
                1: '1 Filtro Seleccionado',
            }
        }
    }
});
var tabla_clientes = $('#listado_clientes').DataTable({

    "ajax": "/bamboo/backend/clientes/busqueda_listado_clientes.php",
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
function renovar_poliza(poliza, tipo_poliza) {
    //acá se debe hacer la validación
    console.log(poliza);
    console.log(tipo_poliza);
    if (tipo_poliza == 'Renovada') {
        console.log('Alerta de renovación');
        var r = confirm("La póliza seleccionada ya se encuentra renovada por otra póliza. ¿Deseas continuar?");
        if (r == true) {
            console.log('Continúa renovandola');
            var r2 = confirm("¿Deseas editar la póliza que renovó la póliza seleccionada?");
            if (r2 == true) {
                console.log('Edita póliza');

                $.ajax({
                    type: "POST",
                    url: "/bamboo/backend/polizas/busqueda_poliza_renovada.php",
                    data: {
                        id_a_renovar: poliza
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        var datax = JSON.parse(response);
                        //console.log(datax);
                    }
                });
            } else {
                console.log('Renovación nueva');
                $('#modal_poliza').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $.redirect('/bamboo/creacion_poliza.php', {
                    'id_poliza': poliza,
                    'renovar': true
                }, 'post');
            }
        } else {
            console.log('No continúa');
            $('#modal_poliza').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $.redirect('/bamboo/creacion_poliza.php');
        }
    } else {
        console.log('continúa normal');
        $('#modal_poliza').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $.redirect('/bamboo/creacion_poliza.php', {
            'id_poliza': poliza,
            'renovar': true
        }, 'post');
    }
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
                document.getElementById("datofecha_cancelacion").readOnly = false;
                document.getElementById("datomotivo_cancela").readOnly = false;
  //    document.getElementById("datos_cancelacion").style.display = "none";
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
	
    var consulta= '<?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && isset( $_POST[ "id_poliza" ]) == true ) echo "True"; ?>'
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
            document.getElementById("formulario").action = "/bamboo/backend/polizas/modifica_poliza.php";
            
            document.getElementById("id_poliza").value = '<?php echo $id_poliza; ?>';
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
        case 'renovar': {
            var rut_prop = '<?php echo $rut_completo_prop; ?>';
            var rut_aseg = '<?php echo $rut_completo_aseg; ?>';
            if (rut_prop == rut_aseg) {
                document.getElementById("radio2_si").checked = true;
                document.getElementById("radio2_no").checked = false;
            } 
            else 
            {
                document.getElementById("radio2_no").checked = true;
                document.getElementById("radio2_si").checked = false;
            }
             if ('<?php echo $venc_gtia; ?>' !== "0000-00-00"){
                document.getElementById("pregunta_gtia").checked = true;
                document.getElementById("venc_gtia").readOnly = false;
                
                
            }
            document.getElementById("busca_poliza").style.display = "block";
            document.getElementById("poliza_renovada").style.display = "block";
            document.getElementById("poliza_renovada").disabled = true;
            document.getElementById("radio_si").checked = true;
            document.getElementById("radio_no").checked = false;
            document.getElementById("rutprop").value = '<?php echo $rut_completo_prop; ?>';
            document.getElementById("rutaseg").value = '<?php echo $rut_completo_aseg; ?>';
            document.getElementById("cobertura").value = '<?php echo $cobertura; ?>';
            document.getElementById("materia").value = '<?php echo $materia; ?>';
            document.getElementById("detalle_materia").value = '<?php echo $detalle_materia; ?>';
            document.getElementById("deducible").value = '<?php echo $deducible; ?>';
            document.getElementById("comision").value = '<?php echo $comision; ?>';
            document.getElementById("porcentaje_comsion").value = '<?php echo $porcentaje_comsion; ?>';
            document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza; ?>';
            document.getElementById("prima_afecta").value = '<?php echo $prima_afecta; ?>';
            document.getElementById("prima_exenta").value = '<?php echo $prima_exenta; ?>';
            document.getElementById("prima_neta").value = '<?php echo $prima_neta; ?>';
            document.getElementById("prima_bruta").value = '<?php echo $prima_bruta; ?>';
            document.getElementById("monto_aseg").value = '<?php echo $monto_aseg; ?>';
            document.getElementById("cuotas").value = '<?php echo $cuotas; ?>';
            document.getElementById("valorcuota").value = '<?php echo $valorcuota; ?>';
            document.getElementById("nro_poliza_renovada").value = '<?php echo $nro_poliza; ?>';
            document.getElementById("id_poliza_renovada").value = '<?php echo $id_poliza; ?>';
            document.getElementById("comentario").value = '<?php echo $comentario; ?>';
            document.getElementById("fechainicio").value = '<?php echo $fechavenc; ?>';
			document.getElementById("venc_gtia").value = '<?php echo $venc_gtia; ?>';
			document.getElementById("datofecha_cancelacion").value = '<?php echo $fech_cancela; ?>';
			document.getElementById("datomotivo_cancela").value = '<?php echo $motivo_cancela; ?>';
            var dias_vig_pol = '<?php echo $dif_dias; ?>';
            if (dias_vig_pol == '365' || dias_vig_pol == '366') {
                document.getElementById("fechavenc").value = '<?php echo $fechavenc_ren; ?>';
                document.getElementById("fechaprimer").value = '<?php echo $fecha_primera_cuota_ren; ?>';
            }
            valida_rut_duplicado_prop();
            valida_rut_duplicado_aseg();
            var ramo = document.getElementById("ramo").value;
            if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo ==
                "VEH - Vehículos Particulares" || ramo == "VEH - Vehículos Pesados") {
                document.getElementById("deducible_veh").style.display = "flex";
                document.getElementById("deducible_defecto").style.display = "none";
                var deducible = document.getElementById("deducible").value;
                document.getElementById("deducible_veh_1").value = deducible;
                document.getElementById("vencimiento_gtia").style.display = "flex";
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
            break;
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

function cancela() {
      document.getElementById("datos_cancelacion").style.display = "block";
      document.getElementById("cancelar").style.display = "block";
     document.getElementById("edicion1").style.display = "none";
    document.getElementById("anular").style.display = "none";
    document.getElementById("cancelar1").style.display = "none";
      
}



function modifica_estado(estado) {
    var r2 = confirm("Estás a punto de " + estado + " está póliza ¿Deseas continuar?");
    if (r2 == true) {
      //        $.redirect('/bamboo/backend/polizas/modifica_poliza.php', {
       $.redirect('/bamboo/backend/polizas/modifica_poliza.php', {
            'id_poliza': document.getElementById("id_poliza").value,
            'accion': estado,
            'datofecha_cancelacion': document.getElementById("datofecha_cancelacion").value,
            'nro_poliza': document.getElementById("nro_poliza").value,
            'datomotivo_cancela': document.getElementById("datomotivo_cancela").value
            
        }, 'post');
    }
}
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
    if (document.getElementById("modo_pago").value == "null") {
        document.getElementById("modo_pago").style.color = "red";
        event.preventDefault();
    }
    if (document.getElementById("cuotas").value == "null") {
        document.getElementById("cuotas").style.color = "red";
        event.preventDefault();
    } else {
    }
});
document.getElementById("busca_rut_prop").addEventListener("click", function(event) {
    event.preventDefault()
});
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
function nro_poliza_completo() {
    if (document.getElementById("nro_poliza").value != "") {
        document.getElementById("validador7").style.visibility = "hidden";
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
function modopago_completo() {
    if (document.getElementById("modo_pago").value != "null") {
        document.getElementById("modo_pago").style.color = "grey";
    }
}
function cuotas_completo() {
    if (document.getElementById("cuotas").value != "null") {
        document.getElementById("cuotas").style.color = "grey";
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