<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}
$camino='crear_propuesta';

//$_SERVER[ "REQUEST_METHOD" ] = "POST";
//$_POST["accion"] = 'actualiza_propuesta';
//$_POST["accion_secundaria"] = 'renovar';
//$_POST["numero_propuesta"]='P000764';
//$_POST["numero_poliza"]='TBD';

$poliza_renovada='';
  if ($_SERVER[ "REQUEST_METHOD" ] == "POST" and ($_POST["accion"] == 'actualiza_propuesta' or $_POST["accion"] == 'crear_poliza' or $_POST["accion"] == 'crear_poliza_web'))
    {
      $camino = $_POST["accion"];
      $accion_secundaria=$_POST["accion_secundaria"];
      if ($accion_secundaria=='renovar'){
          $poliza_renovada=$_POST["numero_poliza"];
        $query = "select '' as numero_propuesta, a.id, a.rut_proponente,a.dv_proponente,a.fecha_propuesta, a.vigencia_inicial, a.vigencia_final, a.moneda_poliza, a.compania, a.ramo, a.comentarios_int, a.comentarios_ext, a.vendedor, a.forma_pago, a.valor_cuota, a.nro_cuotas, a.moneda_valor_cuota, a.fecha_primera_cuota, a.porcentaje_comision, count(e.numero_endoso) as numero_endosos from polizas_2 as a left join endosos as e on a.id=e.id_poliza where a.numero_poliza='".$poliza_renovada."'";
        $query_item = "SELECT numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado,venc_gtia FROM `items` where numero_poliza='".$poliza_renovada."' order by numero_item asc";

      }    
      else{
        $query = "select numero_propuesta, id, rut_proponente,dv_proponente,fecha_propuesta, vigencia_inicial, vigencia_final, moneda_poliza, compania, ramo, comentarios_int, comentarios_ext, vendedor,  forma_pago, valor_cuota, nro_cuotas, moneda_valor_cuota, fecha_primera_cuota, porcentaje_comision, fecha_envio_propuesta from propuesta_polizas where numero_propuesta='".$_POST["numero_propuesta"]."'";
        $query_item = "SELECT numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado,venc_gtia FROM `items` where numero_propuesta='".$_POST["numero_propuesta"]."'order by numero_item asc";

      }
      require_once "/home/gestio10/public_html/backend/config.php";
      mysqli_set_charset( $link, 'utf8' );
      mysqli_select_db( $link, 'gestio10_asesori1_bamboo_QA' );
      $resultado = mysqli_query( $link, $query );
      While( $row = mysqli_fetch_object( $resultado ) ) {
        $id = $row->id;
        $rut_prop = $row->rut_proponente;
        $dv_prop = $row->dv_proponente;
        $rut_completo_prop = $rut_prop . '-' . $dv_prop;
        $selcompania = $row->compania;
        $ramo = $row->ramo;
        $fechainicio = $row->vigencia_inicial;
        $fechavenc = $row->vigencia_final;
        $moneda_poliza = $row->moneda_poliza;
        $nro_propuesta = $row->numero_propuesta;
        $fechaprop = $row->fecha_propuesta;    
        $modo_pago = $row->forma_pago;
        $cuotas = $row->nro_cuotas;
        $moneda_cuota = $row->moneda_valor_cuota;
        $valorcuota = $row->valor_cuota;
        $fechaprimer = $row->fecha_primera_cuota;
        $nombre_vendedor = $row->vendedor;
        $porcentaje_comision = $row->porcentaje_comision;
        $fecha_envio_propuesta= $row->fecha_envio_propuesta;
        $numero_endosos= $row->numero_endosos;
        $comentarios_int = str_replace( "\r\n", "\\n", $row->comentarios_int );
        $comentarios_ext = str_replace( "\r\n", "\\n", $row->comentarios_ext );
        $nro_items=0;
        
        $resultado_item = mysqli_query( $link, $query_item );
            While( $row_item = mysqli_fetch_object( $resultado_item ) ) {
                $nro_items+=1;
                $item[]=$row_item->numero_item;
                $rut_aseg = $row_item->rut_asegurado;
                $dv_aseg = $row_item->dv_asegurado;
                $rut_completo_aseg[] = $rut_aseg . '-' . $dv_aseg;
                $cobertura[] = $row_item->cobertura;
                $materia_i = $row_item->materia_asegurada;
                $materia[] = str_replace( "\r\n", "\\n", $materia_i );
                $detalle_materia_i = $row_item->patente_ubicacion;
                $detalle_materia[] = str_replace( "\r\n", "\\n", $detalle_materia_i );
                if ($ramo == "RC" or $ramo == "D&O" or $ramo == "D&O Condominio" or $ramo == "RC General"){
                    
                    $deducible_porcentaje[] = substr($row_item->deducible, 0,strrpos($row_item->deducible, "% de la Pérdida con mínimo de"));
                    $deducible_valor[] = substr($row_item->deducible, strrpos ( $row_item->deducible , " ") + 1, strlen($row_item->deducible) - 1);
                    
                }else{
                    $deducible[] = $row_item->deducible;  
                }
                $tasa_afecta[] = $row_item->tasa_afecta;
                $tasa_exenta[] = $row_item->tasa_exenta;
                $prima_afecta[] = $row_item->prima_afecta;
                $prima_exenta[] = $row_item->prima_exenta;
                $prima_neta[] = $row_item->prima_neta;
                $prima_bruta[] = $row_item->prima_bruta_anual;
                $monto_aseg[] = $row_item->monto_asegurado;
                $venc_gtia[] = $row_item->venc_gtia;
            }
        }
    }
      mysqli_close($link);
    if ($_SERVER[ "REQUEST_METHOD" ] == "POST" and $_POST["accion"] == 'modifica_poliza')
    {
      $camino = $_POST["accion"];
        $accion_secundaria=$_POST["accion_secundaria"];
        if ($accion_secundaria=='renovar'){
            $poliza_renovada=$_POST["numero_poliza"];
        }
      require_once "/home/gestio10/public_html/backend/config.php";
      mysqli_set_charset( $link, 'utf8' );
      mysqli_select_db( $link, 'gestio10_asesori1_bamboo_QA' );
      $query = "select a.id, a.numero_poliza,a.numero_propuesta, a.rut_proponente,a.dv_proponente,a.fecha_propuesta, a.vigencia_inicial, a.vigencia_final, a.moneda_poliza, a.compania, a.ramo, a.comentarios_int, a.comentarios_ext, a.vendedor, a.forma_pago, a.valor_cuota, a.nro_cuotas, a.moneda_valor_cuota, a.fecha_primera_cuota, a.porcentaje_comision, a.comision, a.comision_bruta, a.comision_neta, a.depositado_fecha, a.comision_negativa, a.boleta_negativa, a.numero_boleta, a.fecha_emision_poliza, count(e.numero_endoso) as numero_endosos from polizas_2 as a left join endosos as e on a.id=e.id_poliza where a.numero_poliza='".$_POST["numero_poliza"]."'";
      $resultado = mysqli_query( $link, $query );
      While( $row = mysqli_fetch_object( $resultado ) ) {
        $id = $row->id;
        $rut_prop = $row->rut_proponente;
        $dv_prop = $row->dv_proponente;
        $rut_completo_prop = $rut_prop . '-' . $dv_prop;
        $selcompania = $row->compania;
        $ramo = $row->ramo;
        $fechainicio = $row->vigencia_inicial;
        $fechavenc = $row->vigencia_final;
        $moneda_poliza = $row->moneda_poliza;
        $numero_poliza = $row->numero_poliza;
        $nro_propuesta = $row->numero_propuesta;
        $fechaprop = $row->fecha_propuesta;    
        $modo_pago = $row->forma_pago;
        $cuotas = $row->nro_cuotas;
        $moneda_cuota = $row->moneda_valor_cuota;
        $valorcuota = $row->valor_cuota;
        $fechaprimer = $row->fecha_primera_cuota;
        $nombre_vendedor = $row->vendedor;
        $fecha_emision_poliza = $row->fecha_emision_poliza;
        $porcentaje_comision = $row->porcentaje_comision;
        $comision = $row->comision;
        $comision_bruta = $row->comision_bruta;
        $comision_neta = $row->comision_neta;
        $depositado_fecha = $row->depositado_fecha;
        $comision_negativa = $row->comision_negativa;
        $boleta_negativa = $row->boleta_negativa;
        $numero_boleta = $row->numero_boleta;
        $numero_endosos= $row->numero_endosos;
        $comentarios_int = str_replace( "\r\n", "\\n", $row->comentarios_int );
        $comentarios_ext = str_replace( "\r\n", "\\n", $row->comentarios_ext );
        $nro_items=0;
        
        $query_item = "SELECT numero_item, rut_asegurado, dv_asegurado, materia_asegurada, patente_ubicacion, cobertura, deducible, tasa_afecta, tasa_exenta, prima_afecta, prima_exenta, prima_neta, prima_bruta_anual, monto_asegurado,venc_gtia FROM `items` where numero_poliza='".$_POST["numero_poliza"]."'order by numero_item asc";
        $resultado_item = mysqli_query( $link, $query_item );
            While( $row_item = mysqli_fetch_object( $resultado_item ) ) {
                $nro_items+=1;
                $item[]=$row_item->numero_item;
                $rut_aseg = $row_item->rut_asegurado;
                $dv_aseg = $row_item->dv_asegurado;
                $rut_completo_aseg[] = $rut_aseg . '-' . $dv_aseg;
                $cobertura[] = $row_item->cobertura;
                $materia_i = $row_item->materia_asegurada;
                $materia[] = str_replace( "\r\n", "\\n", $materia_i );
                $detalle_materia_i = $row_item->patente_ubicacion;
                $detalle_materia[] = str_replace( "\r\n", "\\n", $detalle_materia_i );
                if ($ramo == "RC" or $ramo == "D&O" or $ramo == "D&O Condominio" or $ramo == "RC General"){
                    
                    $deducible_porcentaje[] = substr($row_item->deducible, 0,strrpos($row_item->deducible, "% de la Pérdida con mínimo de"));
                    $deducible_valor[] = substr($row_item->deducible, strrpos ( $row_item->deducible , " ") + 1, strlen($row_item->deducible) - 1);
                    
                }else{
                    $deducible[] = $row_item->deducible;  
                }
                $deducible[] = $row_item->deducible;
                $tasa_afecta[] = $row_item->tasa_afecta;
                $tasa_exenta[] = $row_item->tasa_exenta;
                $prima_afecta[] = $row_item->prima_afecta;
                $prima_exenta[] = $row_item->prima_exenta;
                $prima_neta[] = $row_item->prima_neta;
                $prima_bruta[] = $row_item->prima_bruta_anual;
                $monto_aseg[] = $row_item->monto_asegurado;
                $venc_gtia[] = $row_item->venc_gtia;
            }
        }
    }
    mysqli_close($link);
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
  <p>Propuesta de Póliza / Modificación / N° Propuesta:
    <?php  echo $nro_propuesta; ?>
    <br>
  </p>
</div>
<div id=titulo3 style="display:none">
  <p>Póliza / Modificación / N° Póliza:
    <?php  echo $numero_poliza; ?>
    <br>
  </p>
</div>
<div id=titulo4 style="display:none">
  <p>Póliza Web / Creación
  </p>
</div>
<div id=titulo5 style="display:none">
  <p>Póliza Web / Renovación Póliza N°:
    <?php  echo $numero_poliza; ?>
  </p>
</div>
<div id=titulo6 style="display:none">
  <p>Propuesta de Póliza / Renovación Póliza N°: <?php  echo $poliza_renovada; ?> </p>
</div>
<div class="form-row">
<div class="col" id="botones_edicion" style="display:none ;align-items: center;">
  <button type="button" class="btn btn-second" id="edicion1" onclick="habilitaedicion1()"
                    style="background-color: #536656; margin-right: 5px ;color: white; display: inline">Editar</button>
  
</div>
<br>
<br>
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
                              onchange="valida_rut_duplicado_prop();copiadatos();quitavalidador()"  disabled required>
                              
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
              <div class="col-4" id="contenedor_nro_propuesta" style= "display:none">
                <label for="seguimiento">N° de Propuesta:&nbsp;</label>
                <label style="color: darkred">*</label>
                <input type="text" class="form-control" id="nro_propuesta" name="nro_propuesta" disabled>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
              </div>
          
          <div class="col-4">
                <label for="seguimiento">Fecha Ingreso Propuesta:&nbsp;</label>
                <label style="color: darkred">*</label>
                <div class="md-form">
                   <input placeholder="Selected date" type="date" name="fechaprop" id="fechaprop" value="<?php echo date("Y-m-d");?>"
                      class="form-control"  oninput="valida_vencimiento()" max= "9999-12-31" required>
                   <input placeholder="Selected date" type="text" name="fechaprop2" id="fechaprop2" value="No Aplica"
                                    class="form-control" max= "9999-12-31" style="display:none;" readonly>
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
                <select class="form-control" name="cuotas" id="cuotas" style="width:42%;" required>
                  <option value="">Nro Cuotas</option>
                  <option value="Sin cuotas" <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $cuotas == "Sin cuotas") echo "selected" ?>>Sin Cuotas</option>
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
                <select class="form-control" name="moneda_cuota" id="moneda_cuota" style="width:30%;">
                  <option value="UF"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_cuota == "UF") echo "selected" ?>>UF</option>
                  <option value="USD"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_cuota == "USD") echo "selected" ?>>USD</option>
                  <option value="CLP"
                                              <?php if ($_SERVER[ "REQUEST_METHOD" ] == "POST" && $moneda_cuota == "CLP") echo "selected" ?>>CLP</option>
                </select>
                <input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="valorcuota" id="valorcuota"
                                           style="width:42%;">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="fechaprimer">Fecha Primera Cuota</label>
              <div class="md-form">
                <input type="date" class="form-control" id="fechaprimer" name="fechaprimer" onchange="validadorfecha(this.id); valida_primerpago()" max= "9999-12-31" style="width:72%;">
              </div>
            </div>
          </div>
          
          <br>
          <br>
             <label for="pago"><b>Vendedor y Corredor</b></label>
              <br>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                 <label>Nombre del Vendedor</label>
                <div class="form-row">
                  <div class="col" style="width:72%;" >
                    <input type="text" class="form-control" id="nombre_vendedor" name="nombre_vendedor" placeholder="Nombre Vendedor" style="width:72%;" >
                  </div>
                </div>
              </div>
              <div class="col-md-4 mb-3">
              <label>Porcentaje Comisión del Corredor</label>
              <div class="form-inline">
                <input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" id="porcentaje_comsion"
                                          name="porcentaje_comsion" onChange="calculacomision()">
                <div class="input-group-prepend"><span class="input-group-text"
                                              id="porcentaje_comi">%</span></div>
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
            
            
            <div class="container" style="overflow-x:auto;width:100%;height: auto;  white-space: nowrap;">
              <table class="table"  id="mytable"  style="width:450%;white-space: nowrap;">
                <tr>
             	  <th style="width:20px">N° Ítem</th>
                  <th>RUT Asegurado</th>
                  <th>Nombre Asegurado</th>
                  <th>Materia Asegurada <label style="color: darkred">*</label></th>
                  <th>Patente o Ubicación</th>
                  <th>Cobertura</th>
                  <th>Deducible</th>
                  <th>Monto Asegurado <label style="color: darkred">*</label></th>
                  <th>Tasa Afecta</th>
                  <th>Tasa Exenta</th>
                  <th>Prima Afecta</th>
                  <th>Prima Exenta</th>
                  <th>Prima Neta</th>
                  <th>Prima Bruta</th>
                  <th id="titulo_venc_gtia">Vencimiento Garantía</th>
                  
                </tr>
              </table>
              <br>
            </div>
            <br>
            <br>
            <input type="button" id="btAdd" value="Añadir" class="btn"
                              style="background-color: #536656; color: white" onclick="click_agrega_item()"/>
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
          <label for="comentario_interno"><b>Comentarios Internos</b></label>
          <br>
          <textarea class="form-control" rows="2" style="height:100px" id='comentarios_int' name='comentario' style="text-indent:0px" ;></textarea>
          <br>
           <label for="comentario_externo"><b>Comentarios Externos</b></label>
          <br>
          <textarea class="form-control" rows="2" style="height:100px" id='comentarios_ext' name='comentario'
                              style="text-indent:0px" ;>
          </textarea>
        
        </div>
      </div>
    </div>
      <div  id="informacion_poliza" class="card" style="display:none" disabled>
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
                                       style="width:72%;">
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
              <label for="comision">Comisión Correspondiente</label>
              <div class="form-inline">
                <div class="input-group-prepend"><span class="input-group-text"
                                              id="moneda5">UF</span></div>
                <input input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" id="comision" name="comision">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label>Comisión Bruta a Pago</label>
              <div class="form-inline">
                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                <input input type="number" step="0" placeholder="0" class="form-control" id="comisionbruta" name="comisionbruta">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label>Comisión Neta a Pago</label>
              <div class="form-inline">
                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                <input input type="number"  step="0" placeholder="0"  class="form-control" id="comisionneta" name="comisionneta">
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
                <input input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="comisionneg" id="comisionneg">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="comision">Boleta Comisión Negativa</label>
              <input type="text" class="form-control" name="boletaneg" id="boletaneg" style="width:72%;">
            </div>
          </div>
          <br>

         
          </div>
        </div>
        </div>

      
    </div>
    <br>
    
            <div  id="info_endoso" class="card" style="display:none" disabled>
            <div class="card-header" id="headingsix" style="background-color:#A5CCAB">
                <h6 class="mb-0" style="color:#536656"> Endosos
               
                </h6>
            </div>
        <div class="card-body" id="card-body-six">
            <table class="display" id="listado_endosos" style="width:100%">
                <thead>
                <tr>
                    <th></th>
                    <th>Número Endoso</th>
                    <th>Nro Propuesta Endoso</th>
                    <th>Tipo Endoso</th>
                    <th>Fecha ingreso</th>
                    <th>Inicio Vigencia</th>
                    <th>Fin Vigencia</th>
                    <th>Fecha Prorroga</th>
                </tr>
                </thead>
                        </table>
         
        </div>
        
      </div>
      <br>
   
    <div id="auxiliar2" style="display: none;"></div>
    <input id="auxiliar3" placeholder="false" style="display: none;" />
    
    
    <button class="btn" type="button" style="background-color: #536656; color: white; display:none"
              id='boton_submit' onclick=" validarutitem()"></button>
</form>
<button class="btn" type="button" style="background-color: #536656; color: white"
              id='boton_prueba' onclick=" validarutitem()">Registrar</button>
 </div>
<br>
<br>
</div>/
<script>

$("#boton_submit").click(function(e){

    blnFormValidity= $('#formulario')[0].checkValidity()
   document.getElementById('formulario').classList.add('was-validated');
    if(blnFormValidity==false){
        e.preventDefault();
        return false
    }
    document.getElementById('auxiliar3').value = blnFormValidity;
    
    genera_propuesta();
})

</script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

<script src="/assets/js/jquery.redirect.js"></script>
<script src="/assets/js/validarRUT.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
</body>
</html><script>
var orgn='';
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
                var contador =  document.getElementById("contador").value;
                 for (var i = 1; i <= contador; i++){
                     
                    document.getElementById("nombre_seg[" + i + "]").value =response.nombre;
                        
                     
                 }
            
                
            }
        }
    });
}
function valida_rut_duplicado_aseg(item) {
    var item2 = item;
    var dato =  document.getElementById("rutaseg[" + item2 + "]").value;
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
    if (name == "diferentes") {
        document.getElementById("radio2_si").checked = false;
        document.getElementById("radio2_no").checked = true;
    
        
        
        for (var i = 1; i <= contador; i++){
            
            document.getElementById("rutaseg[" + i + "]").value = ""
            document.getElementById("rutaseg[" + i + "]").disabled = false;
            document.getElementById("nombre_seg[" + i + "]").value = "";
            document.getElementById("nombre_seg[" + i + "]").disabled = false;
            document.getElementById("busca_rut_aseg[" + i + "]").style.display = "block";
   
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
   
        }

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
    document.getElementById("prima_bruta["+i+"]").value = primabruta.toFixed(2).replace(".", ".")
    document.getElementById("prima_neta["+i+"]").value = primaneta.toFixed(2).replace(".", ".")
    
     }
}


function cambia_deducible() {
    var ramo = document.getElementById("ramo").value;
    var contador = document.getElementById("contador").value;
    if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo == "VEH - Vehículos Particulares" ||
        ramo == "VEH - Vehículos Pesados") {
        for (var i = 1; i <= contador; i++){
            document.getElementById('deducible_para_otros[' +i+ ']').style.display="none";
            document.getElementById('deducible_para_RC[' +i+ ']').style.display="none";
            document.getElementById('deducible_para_vehiculos[' +i+ ']').style.display="flex";
                      }
    } else if (ramo == "INC" || ramo == "Hogar" || ramo == "PyME" || ramo == "INC - Condominio" || ramo ==
        "INC - Hogar" || ramo == "INC - Misceláneos" || ramo == "INC - Perjuicio por Paralización" || ramo ==
        "INC - Pyme" || ramo == "INC - TRBF (Todo Riesgo Bienes Físicos)") {
        for (var i = 1; i <= contador; i++){
            document.getElementById('deducible_para_otros[' +i+ ']').style.display="flex";
            document.getElementById('deducible_para_RC[' +i+ ']').style.display="none";
            document.getElementById('deducible_para_vehiculos[' +i+ ']').style.display="none";
            document.getElementById('moneda[' + i + ']').style.display="none";
            document.getElementById("deducible_defecto["+i+"]").value="Varios"; 
        }
    } else if (ramo == "A. VIAJE" || ramo == "APV" || ramo == "AP" || ramo == "Vida" || ramo == "Garantía" || ramo ==
        "AC - Accidentes Personales" || ramo == "AC - Protección Financiera" || ramo == "ASISTENCIA EN VIAJE" || ramo ==
        "APV" || ramo == "VIDA") {
         for (var i = 1; i <= contador; i++){
            document.getElementById('deducible_para_otros[' +i+ ']').style.display="flex";
            document.getElementById('deducible_para_RC[' +i+ ']').style.display="none";
            document.getElementById('deducible_para_vehiculos[' +i+ ']').style.display="none";
             document.getElementById('moneda[' + i + ']').style.display="none";
             document.getElementById("deducible_defecto["+i+"]").value="No Aplica";
         }
    } else if (ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General") {
         for (var i = 1; i <= contador; i++){
            document.getElementById('deducible_para_vehiculos[' +i+ ']').style.display="none";
            document.getElementById('deducible_para_otros[' +i+ ']').style.display="none";
            document.getElementById('deducible_para_RC[' +i+ ']').style.display="flex";
                     }
    } else {
    }
}

function pobladeducible(){
     var contador = document.getElementById("contador").value;
     var ramo = document.getElementById("ramo").value;
     var espacio = document.createTextNode('&nbsp')
     if (ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General") {
        for (var i = 1; i <= contador; i++){
              document.getElementById('deducible_defecto[' +i+ ']').value = document.getElementById('deducible_porcentaje['+i+']').value + "% de la Pérdida con mínimo de" + document.getElementById('moneda7['+i+']').innerHTML + " " + document.getElementById('deducible_valor['+i+']').value;
        }
     }
    if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo == "VEH - Vehículos Particulares" ||
        ramo == "VEH - Vehículos Pesados") {
        for (var i = 1; i <= contador; i++){
              document.getElementById('deducible_defecto[' +i+ ']').value = document.getElementById('deducible_vehiculo['+i+']').value;
        }
    }
}

$('#test1').on('shown.bs.modal', function() {
    //console.log("test");
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
                    '" onclick="seleccion_rut(this.id); " class="btn btn-outline-primary">Seleccionar</button>';
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
    //console.log('origen: <' +origen_boton +'> - nro_item: <'+ indice_item +'>')
    origen = origen_boton;
    item=indice_item
}
function seleccion_rut(rut) {

    switch (origen.substring(0,14)) {
        case 'busca_rut_prop': {
            document.getElementById("rutprop").value = rut;
            document.getElementById("rutprop").onchange();
            document.getElementById("validador10").style.visibility = "hidden";
             var contador =  document.getElementById("contador").value;
                 for (var i = 1; i <= contador; i++){
                     
                    document.getElementById("rutaseg[" + i + "]").value = document.getElementById("rutprop").value;
                        
                     
                 }
            
            
            //document.getElementById("rutaseg").onchange()
            break;
        }
        case 'busca_rut_aseg': {
            //console.log("rutaseg[" + item + "]")
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
    //document.getElementById("nombre_seg").disabled = true;
    document.getElementById("edicion1").style.display = "none";
    document.getElementById("nro_propuesta").disabled = true;
    
    var radio =document.getElementById("radio2_si").checked;
    var contador ='<?php echo $nro_items; ?>'
    var ramo = '<?php echo $ramo; ?>'
    
        if ( radio = true)
            {
                for (var i = 1; i <= contador; i++) {
                    document.getElementById("rutaseg["+i+"]").disabled = true;
                    document.getElementById("nombre_seg["+i+"]").disabled = true;
                }
        
            }   
    

        if (ramo != "VEH" && ramo != "VEH - Vehículos Comerciales Livianos" && ramo != "VEH - Vehículos Particulares" && ramo != "VEH - Vehículos Pesados") 
        
            {

                    for (var j = 1; j <= contador; j++)
                    {
                        document.getElementById("venc_gtia["+j+"]").disabled = true;
                    }    
            }
        
        
    
    
     
    }
    
document.addEventListener("DOMContentLoaded", function(event) {
    var bPreguntar = true;
    
orgn = '<?php echo $camino; ?>';

        switch (orgn) 
        {
          case 'aceptar_poliza': {
            document.getElementById("informacion_poliza").style.display = "flex";
            document.getElementById("informacion_poliza").disabled = false;
            document.getElementById("nro_poliza").required = true;
            document.getElementById("modo_pago").required = true;
            break;  
          }
          case 'actualiza_propuesta':{
            if ('<?php echo $rut_completo_prop; ?>' == '<?php echo $rut_completo_aseg; ?>') 
            {
                document.getElementById("radio2_si").checked = true;
                document.getElementById("radio2_no").checked = false;
            }
            document.getElementById("contenedor_nro_propuesta").style.display = "inline";
            document.getElementById("titulo1").style.display = "none";
            document.getElementById("titulo2").style.display = "flex";
            document.getElementById("botones_edicion").style.display = "flex";
           
            document.getElementById("nro_propuesta").value = '<?php echo $nro_propuesta; ?>';
            document.getElementById("rutprop").value = '<?php echo $rut_completo_prop; ?>';
            valida_rut_duplicado_prop();
            document.getElementById("fechaprop").value = '<?php echo $fechaprop; ?>';
            document.getElementById("fechainicio").value = '<?php echo $fechainicio; ?>';
            document.getElementById("fechavenc").value = '<?php echo $fechavenc; ?>';
            document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza; ?>';
            document.getElementById("valorcuota").value = '<?php echo $valorcuota; ?>';
            document.getElementById("fechaprimer").value = '<?php echo $fechaprimer; ?>';
            document.getElementById("nombre_vendedor").value = '<?php echo $nombre_vendedor; ?>';
            document.getElementById("porcentaje_comsion").value = '<?php echo $porcentaje_comision; ?>';
            document.getElementById("comentarios_int").value = '<?php echo $comentarios_int; ?>';
            document.getElementById("comentarios_ext").value = '<?php echo $comentarios_ext; ?>';
            //agregar ítems
            var contador=1;
            var item= <?php echo json_encode($item); ?>;
            var rut_completo_aseg=<?php echo json_encode($rut_completo_aseg); ?>;
            var cobertura=<?php echo json_encode($cobertura); ?>;
            var materia=<?php echo json_encode($materia); ?>;
            var detalle_materia=<?php echo json_encode($detalle_materia); ?>;
            var deducible=<?php echo json_encode($deducible); ?>;
            var deducible_porcentaje_v=<?php echo json_encode($deducible_porcentaje); ?>;
            var deducible_valor_v=<?php echo json_encode($deducible_valor); ?>;
            var tasa_afecta=<?php echo json_encode($tasa_afecta); ?>;
            var tasa_exenta=<?php echo json_encode($tasa_exenta); ?>;
            var prima_afecta=<?php echo json_encode($prima_afecta); ?>;
            var prima_exenta=<?php echo json_encode($prima_exenta); ?>;
            var prima_neta=<?php echo json_encode($prima_neta); ?>;
            var prima_bruta=<?php echo json_encode($prima_bruta); ?>;
            var monto_aseg=<?php echo json_encode($monto_aseg); ?>;
            var venc_gtia=<?php echo json_encode($venc_gtia); ?>;
            var ramo='<?php echo $ramo; ?>';
            
            while (contador<='<?php echo $nro_items; ?>'){
                console.log(contador + ' de total items: ' +'<?php echo $nro_items; ?>' )
                document.getElementById("btAdd").click();
                document.getElementById("materia["+contador.toString()+"]").value = materia[(contador-1).toString()];
                document.getElementById("detalle_materia["+contador.toString()+"]").value = detalle_materia[(contador-1).toString()];
                document.getElementById("cobertura["+contador.toString()+"]").value = cobertura[(contador-1).toString()];
                document.getElementById("cobertura["+contador.toString()+"]").value = cobertura[(contador-1).toString()];
                document.getElementById("tasa_afecta["+contador.toString()+"]").value = tasa_afecta[(contador-1).toString()];
                document.getElementById("tasa_exenta["+contador.toString()+"]").value = tasa_exenta[(contador-1).toString()];
                document.getElementById("prima_afecta["+contador.toString()+"]").value = prima_afecta[(contador-1).toString()];
                document.getElementById("prima_exenta["+contador.toString()+"]").value = prima_exenta[(contador-1).toString()];
                document.getElementById("monto_aseg["+contador.toString()+"]").value = monto_aseg[(contador-1).toString()];
                document.getElementById("prima_bruta["+contador.toString()+"]").value = prima_bruta[(contador-1).toString()];
                document.getElementById("prima_neta["+contador.toString()+"]").value = prima_neta[(contador-1).toString()];
                document.getElementById("venc_gtia["+contador.toString()+"]").value = venc_gtia[(contador-1).toString()];

                if(ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General"){
                    document.getElementById("deducible_porcentaje["+contador.toString()+"]").value = deducible_porcentaje_v[(contador-1).toString()];
                    document.getElementById("deducible_valor["+contador.toString()+"]").value =deducible_valor_v[(contador-1).toString()] ;
                }
                else if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo == "VEH - Vehículos Particulares" || ramo == "VEH - Vehículos Pesados"){
                      document.getElementById("deducible_vehiculo["+contador.toString()+"]").value=deducible[(contador-1).toString()];
                } 
                else
                {
                    document.getElementById("deducible_defecto["+contador.toString()+"]").value = deducible[(contador-1).toString()];
                }
                contador+=1;
            }
 
            
            //inicio renovación póliza

            var origen_2='<?php echo $accion_secundaria; ?>';
                if (origen_2=='renovar'){
                    document.getElementById("contenedor_nro_propuesta").style.display = "none";
                    document.getElementById("titulo2").style.display = "none";
                    document.getElementById("titulo6").style.display = "flex";
                    document.getElementById("fechainicio").value = document.getElementById("fechavenc").value;
                    document.getElementById("fechavenc").value = '';
                    document.getElementById("edicion1").style.display = "none";
                    if ('<?php echo $numero_endosos; ?>'!=='0'){
                        document.getElementById("info_endoso").style.display = "flex";
                    }

                    orgn='crear_propuesta';
                    
                } else {
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
                }
            //fin renovación póliza

            break;
          }
          case 'crear_poliza':{
            if ('<?php echo $rut_completo_prop; ?>' == '<?php echo $rut_completo_aseg; ?>') 
            {
                document.getElementById("radio2_si").checked = true;
                document.getElementById("radio2_no").checked = false;
            }
            document.getElementById("contenedor_nro_propuesta").style.display = "inline";
            document.getElementById("titulo1").style.display = "none";
            document.getElementById("titulo2").style.display = "flex";
            document.getElementById("informacion_poliza").style.display = "flex";
            document.getElementById("nro_poliza").required = true;
            
            document.getElementById("nro_propuesta").value = '<?php echo $nro_propuesta; ?>';
            document.getElementById("rutprop").value = '<?php echo $rut_completo_prop; ?>';
            valida_rut_duplicado_prop();
            document.getElementById("fechaprop").value = '<?php echo $fechaprop; ?>';
            document.getElementById("fechainicio").value = '<?php echo $fechainicio; ?>';
            document.getElementById("fechavenc").value = '<?php echo $fechavenc; ?>';
            document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza; ?>';
            document.getElementById("valorcuota").value = '<?php echo $valorcuota; ?>';
            document.getElementById("fechaprimer").value = '<?php echo $fechaprimer; ?>';
            document.getElementById("nombre_vendedor").value = '<?php echo $nombre_vendedor; ?>';
            document.getElementById("porcentaje_comsion").value = '<?php echo $porcentaje_comision; ?>';
            document.getElementById("comentarios_int").value = '<?php echo $comentarios_int; ?>';
            document.getElementById("comentarios_ext").value = '<?php echo $comentarios_ext; ?>';
            //agregar ítems
            var contador=1;
            var item= <?php echo json_encode($item); ?>;
            var rut_completo_aseg=<?php echo json_encode($rut_completo_aseg); ?>;
            var cobertura=<?php echo json_encode($cobertura); ?>;
            var materia=<?php echo json_encode($materia); ?>;
            var detalle_materia=<?php echo json_encode($detalle_materia); ?>;
            var deducible=<?php echo json_encode($deducible); ?>;
            var deducible_porcentaje_v=<?php echo json_encode($deducible_porcentaje); ?>;
            var deducible_valor_v=<?php echo json_encode($deducible_valor); ?>;
            var tasa_afecta=<?php echo json_encode($tasa_afecta); ?>;
            var tasa_exenta=<?php echo json_encode($tasa_exenta); ?>;
            var prima_afecta=<?php echo json_encode($prima_afecta); ?>;
            var prima_exenta=<?php echo json_encode($prima_exenta); ?>;
            var prima_neta=<?php echo json_encode($prima_neta); ?>;
            var prima_bruta=<?php echo json_encode($prima_bruta); ?>;
            var monto_aseg=<?php echo json_encode($monto_aseg); ?>;
            var venc_gtia=<?php echo json_encode($venc_gtia); ?>;
            var ramo='<?php echo $ramo; ?>';
            while (contador<='<?php echo $nro_items; ?>'){
                document.getElementById("btAdd").click();
                document.getElementById("materia["+contador.toString()+"]").value = materia[(contador-1).toString()];
                document.getElementById("detalle_materia["+contador.toString()+"]").value = detalle_materia[(contador-1).toString()];
                document.getElementById("cobertura["+contador.toString()+"]").value = cobertura[(contador-1).toString()];
                document.getElementById("cobertura["+contador.toString()+"]").value = cobertura[(contador-1).toString()];
                document.getElementById("tasa_afecta["+contador.toString()+"]").value = tasa_afecta[(contador-1).toString()];
                document.getElementById("tasa_exenta["+contador.toString()+"]").value = tasa_exenta[(contador-1).toString()];
                document.getElementById("prima_afecta["+contador.toString()+"]").value = prima_afecta[(contador-1).toString()];
                document.getElementById("prima_exenta["+contador.toString()+"]").value = prima_exenta[(contador-1).toString()];
                document.getElementById("monto_aseg["+contador.toString()+"]").value = monto_aseg[(contador-1).toString()];
                document.getElementById("prima_bruta["+contador.toString()+"]").value = prima_bruta[(contador-1).toString()];
                document.getElementById("prima_neta["+contador.toString()+"]").value = prima_neta[(contador-1).toString()];
                document.getElementById("venc_gtia["+contador.toString()+"]").value = venc_gtia[(contador-1).toString()];
                if(ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General"){
                    document.getElementById("deducible_porcentaje["+contador.toString()+"]").value = deducible_porcentaje_v[(contador-1).toString()];
                    document.getElementById("deducible_valor["+contador.toString()+"]").value =deducible_valor_v[(contador-1).toString()] ;
                    
                }
                else if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo == "VEH - Vehículos Particulares" || ramo == "VEH - Vehículos Pesados"){
                      document.getElementById("deducible_vehiculo["+contador.toString()+"]").value=deducible[(contador-1).toString()];
                } 
                else
                {
                    document.getElementById("deducible_defecto["+contador.toString()+"]").value = deducible[(contador-1).toString()];
                }
                contador+=1;
            }
            break;
          }
          case 'modifica_poliza':{
            if ('<?php echo $rut_completo_prop; ?>' == '<?php echo $rut_completo_aseg; ?>') 
            {
                document.getElementById("radio2_si").checked = true;
                document.getElementById("radio2_no").checked = false;
            }
            if ('<?php echo $numero_endosos; ?>'!=='0'){
                document.getElementById("info_endoso").style.display = "flex";
            }
            
            
            document.getElementById("contenedor_nro_propuesta").style.display = "inline";
            document.getElementById("titulo1").style.display = "none";
            document.getElementById("titulo3").style.display = "flex";
            document.getElementById("informacion_poliza").style.display = "flex";
            
            document.getElementById("nro_poliza").required = true;
            
            document.getElementById("nro_propuesta").value = '<?php echo $nro_propuesta; ?>';
            document.getElementById("rutprop").value = '<?php echo $rut_completo_prop; ?>';
            valida_rut_duplicado_prop();
            document.getElementById("fechaprop").value = '<?php echo $fechaprop; ?>';
            document.getElementById("fechainicio").value = '<?php echo $fechainicio; ?>';
            document.getElementById("fechavenc").value = '<?php echo $fechavenc; ?>';
            document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza; ?>';
            document.getElementById("valorcuota").value = '<?php echo $valorcuota; ?>';
            document.getElementById("fechaprimer").value = '<?php echo $fechaprimer; ?>';
            document.getElementById("nombre_vendedor").value = '<?php echo $nombre_vendedor; ?>';
            document.getElementById("porcentaje_comsion").value = '<?php echo $porcentaje_comision; ?>';
            document.getElementById("comentarios_int").value = '<?php echo $comentarios_int; ?>';
            document.getElementById("comentarios_ext").value = '<?php echo $comentarios_ext; ?>';
            
            
            document.getElementById("nro_poliza").value = '<?php echo $numero_poliza; ?>';
            document.getElementById("fecha_emision_poliza").value = '<?php echo $fecha_emision_poliza; ?>';
            document.getElementById("comision").value = '<?php echo $comision; ?>';
            document.getElementById("comisionbruta").value = '<?php echo $comision_bruta; ?>';
            document.getElementById("comisionneta").value = '<?php echo $comision_neta; ?>';
            document.getElementById("fechadeposito").value = '<?php echo $depositado_fecha; ?>';
            document.getElementById("comisionneg").value = '<?php echo $comision_negativa; ?>';
            document.getElementById("boletaneg").value = '<?php echo $boleta_negativa; ?>';
            document.getElementById("boleta").value = '<?php echo $numero_boleta; ?>';

            
            
            //agregar ítems
            var contador=1;
            var item= <?php echo json_encode($item); ?>;
            var rut_completo_aseg=<?php echo json_encode($rut_completo_aseg); ?>;
            var cobertura=<?php echo json_encode($cobertura); ?>;
            var materia=<?php echo json_encode($materia); ?>;
            var detalle_materia=<?php echo json_encode($detalle_materia); ?>;
            var deducible=<?php echo json_encode($deducible); ?>;
            var deducible_porcentaje_v=<?php echo json_encode($deducible_porcentaje); ?>;
            var deducible_valor_v=<?php echo json_encode($deducible_valor); ?>;
            var tasa_afecta=<?php echo json_encode($tasa_afecta); ?>;
            var tasa_exenta=<?php echo json_encode($tasa_exenta); ?>;
            var prima_afecta=<?php echo json_encode($prima_afecta); ?>;
            var prima_exenta=<?php echo json_encode($prima_exenta); ?>;
            var prima_neta=<?php echo json_encode($prima_neta); ?>;
            var prima_bruta=<?php echo json_encode($prima_bruta); ?>;
            var monto_aseg=<?php echo json_encode($monto_aseg); ?>;
            var venc_gtia=<?php echo json_encode($venc_gtia); ?>;
            var ramo='<?php echo $ramo; ?>';

            while (contador<='<?php echo $nro_items; ?>'){
                document.getElementById("btAdd").click();
                document.getElementById("materia["+contador.toString()+"]").value = materia[(contador-1).toString()];
                document.getElementById("detalle_materia["+contador.toString()+"]").value = detalle_materia[(contador-1).toString()];
                document.getElementById("cobertura["+contador.toString()+"]").value = cobertura[(contador-1).toString()];
                document.getElementById("cobertura["+contador.toString()+"]").value = cobertura[(contador-1).toString()];
                document.getElementById("tasa_afecta["+contador.toString()+"]").value = tasa_afecta[(contador-1).toString()];
                document.getElementById("tasa_exenta["+contador.toString()+"]").value = tasa_exenta[(contador-1).toString()];
                document.getElementById("prima_afecta["+contador.toString()+"]").value = prima_afecta[(contador-1).toString()];
                document.getElementById("prima_exenta["+contador.toString()+"]").value = prima_exenta[(contador-1).toString()];
                document.getElementById("monto_aseg["+contador.toString()+"]").value = monto_aseg[(contador-1).toString()];
                document.getElementById("prima_bruta["+contador.toString()+"]").value = prima_bruta[(contador-1).toString()];
                document.getElementById("prima_neta["+contador.toString()+"]").value = prima_neta[(contador-1).toString()];
                document.getElementById("venc_gtia["+contador.toString()+"]").value = venc_gtia[(contador-1).toString()];
                if(ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General"){
                    document.getElementById("deducible_porcentaje["+contador.toString()+"]").value = deducible_porcentaje_v[(contador-1).toString()];
                    document.getElementById("deducible_valor["+contador.toString()+"]").value =deducible_valor_v[(contador-1).toString()] ;
                }
                else if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo == "VEH - Vehículos Particulares" || ramo == "VEH - Vehículos Pesados"){
                      document.getElementById("deducible_vehiculo["+contador.toString()+"]").value=deducible[(contador-1).toString()];
                } 
                else
                {
                    document.getElementById("deducible_defecto["+contador.toString()+"]").value = deducible[(contador-1).toString()];
                }
                contador+=1;
            }
            
            //inicio renovación póliza
            
                var origen_2='<?php echo $accion_secundaria; ?>';
                if (origen_2=='renovar'){
                    document.getElementById("contenedor_nro_propuesta").style.display = "inline";
                    document.getElementById("titulo3").style.display = "none";
                    document.getElementById("titulo5").style.display = "flex";
                    document.getElementById("informacion_poliza").style.display = "flex";
                    document.getElementById("nro_poliza").required = true;
                    document.getElementById("nro_propuesta").value = "WEB";
                    document.getElementById("fechaprop").style.display = "none";
                    document.getElementById("fechaprop2").style.display = "flex";
                    document.getElementById("nro_poliza").value = '';
                    document.getElementById("fecha_emision_poliza").value = '';
                    document.getElementById("comision").value = '<?php echo $comision; ?>';
                    document.getElementById("comisionbruta").value = '<?php echo $comision_bruta; ?>';
                    document.getElementById("comisionneta").value = '<?php echo $comision_neta; ?>';
                    document.getElementById("fechadeposito").value = '';
                    document.getElementById("comisionneg").value = '';
                    document.getElementById("boletaneg").value = '';
                    document.getElementById("boleta").value = '';
                    document.getElementById("fechaprimer").value = '';
                    document.getElementById("fechainicio").value = document.getElementById("fechavenc").value;
                    document.getElementById("fechavenc").value = '';
                     
                    orgn='crear_poliza_web';
                    
                }
            //fin renovación póliza
            
            
            break;
          }
          case 'crear_poliza_web':{

            document.getElementById("contenedor_nro_propuesta").style.display = "inline";
            document.getElementById("titulo1").style.display = "none";
            document.getElementById("titulo4").style.display = "flex";
            document.getElementById("informacion_poliza").style.display = "flex";
            document.getElementById("nro_poliza").required = true;
            document.getElementById("nro_propuesta").value = "WEB";
            document.getElementById("fechaprop").style.display = "none";
            document.getElementById("fechaprop2").style.display = "flex";
            
            var origen_2='<?php echo $accion_secundaria; ?>';
        if (origen_2=='renovar'){
            if ('<?php echo $rut_completo_prop; ?>' == '<?php echo $rut_completo_aseg; ?>') 
            {
                document.getElementById("radio2_si").checked = true;
                document.getElementById("radio2_no").checked = false;
            }
            if ('<?php echo $numero_endosos; ?>'!=='0'){
                document.getElementById("info_endoso").style.display = "flex";
            }
            document.getElementById("nro_poliza").required = true;
            
            document.getElementById("nro_propuesta").value = '<?php echo $nro_propuesta; ?>';
            document.getElementById("rutprop").value = '<?php echo $rut_completo_prop; ?>';
            valida_rut_duplicado_prop();
            document.getElementById("fechaprop").value = '<?php echo $fechaprop; ?>';
            document.getElementById("fechainicio").value = '<?php echo $fechainicio; ?>';
            document.getElementById("fechavenc").value = '<?php echo $fechavenc; ?>';
            document.getElementById("moneda_poliza").value = '<?php echo $moneda_poliza; ?>';
            document.getElementById("valorcuota").value = '<?php echo $valorcuota; ?>';
            document.getElementById("fechaprimer").value = '<?php echo $fechaprimer; ?>';
            document.getElementById("nombre_vendedor").value = '<?php echo $nombre_vendedor; ?>';
            document.getElementById("porcentaje_comsion").value = '<?php echo $porcentaje_comision; ?>';
            document.getElementById("comentarios_int").value = '<?php echo $comentarios_int; ?>';
            document.getElementById("comentarios_ext").value = '<?php echo $comentarios_ext; ?>';
            
            
            document.getElementById("nro_poliza").value = '<?php echo $numero_poliza; ?>';
            document.getElementById("fecha_emision_poliza").value = '<?php echo $fecha_emision_poliza; ?>';
            document.getElementById("comision").value = '<?php echo $comision; ?>';
            document.getElementById("comisionbruta").value = '<?php echo $comision_bruta; ?>';
            document.getElementById("comisionneta").value = '<?php echo $comision_neta; ?>';
            document.getElementById("fechadeposito").value = '<?php echo $depositado_fecha; ?>';
            document.getElementById("comisionneg").value = '<?php echo $comision_negativa; ?>';
            document.getElementById("boletaneg").value = '<?php echo $boleta_negativa; ?>';
            document.getElementById("boleta").value = '<?php echo $numero_boleta; ?>';

            
            
            //agregar ítems
            var contador=1;
            var item= <?php echo json_encode($item); ?>;
            var rut_completo_aseg=<?php echo json_encode($rut_completo_aseg); ?>;
            var cobertura=<?php echo json_encode($cobertura); ?>;
            var materia=<?php echo json_encode($materia); ?>;
            var detalle_materia=<?php echo json_encode($detalle_materia); ?>;
            var deducible=<?php echo json_encode($deducible); ?>;
            var deducible_porcentaje_v=<?php echo json_encode($deducible_porcentaje); ?>;
            var deducible_valor_v=<?php echo json_encode($deducible_valor); ?>;
            var tasa_afecta=<?php echo json_encode($tasa_afecta); ?>;
            var tasa_exenta=<?php echo json_encode($tasa_exenta); ?>;
            var prima_afecta=<?php echo json_encode($prima_afecta); ?>;
            var prima_exenta=<?php echo json_encode($prima_exenta); ?>;
            var prima_neta=<?php echo json_encode($prima_neta); ?>;
            var prima_bruta=<?php echo json_encode($prima_bruta); ?>;
            var monto_aseg=<?php echo json_encode($monto_aseg); ?>;
            var venc_gtia=<?php echo json_encode($venc_gtia); ?>;
            var ramo='<?php echo $ramo; ?>';

            while (contador<='<?php echo $nro_items; ?>'){
                document.getElementById("btAdd").click();
                document.getElementById("materia["+contador.toString()+"]").value = materia[(contador-1).toString()];
                document.getElementById("detalle_materia["+contador.toString()+"]").value = detalle_materia[(contador-1).toString()];
                document.getElementById("cobertura["+contador.toString()+"]").value = cobertura[(contador-1).toString()];
                document.getElementById("cobertura["+contador.toString()+"]").value = cobertura[(contador-1).toString()];
                document.getElementById("tasa_afecta["+contador.toString()+"]").value = tasa_afecta[(contador-1).toString()];
                document.getElementById("tasa_exenta["+contador.toString()+"]").value = tasa_exenta[(contador-1).toString()];
                document.getElementById("prima_afecta["+contador.toString()+"]").value = prima_afecta[(contador-1).toString()];
                document.getElementById("prima_exenta["+contador.toString()+"]").value = prima_exenta[(contador-1).toString()];
                document.getElementById("monto_aseg["+contador.toString()+"]").value = monto_aseg[(contador-1).toString()];
                document.getElementById("prima_bruta["+contador.toString()+"]").value = prima_bruta[(contador-1).toString()];
                document.getElementById("prima_neta["+contador.toString()+"]").value = prima_neta[(contador-1).toString()];
                document.getElementById("venc_gtia["+contador.toString()+"]").value = venc_gtia[(contador-1).toString()];
                if(ramo == "RC" || ramo == "D&O" || ramo == "D&O Condominio" || ramo == "RC General"){
                    document.getElementById("deducible_porcentaje["+contador.toString()+"]").value = deducible_porcentaje_v[(contador-1).toString()];
                    document.getElementById("deducible_valor["+contador.toString()+"]").value =deducible_valor_v[(contador-1).toString()] ;
                }
                else if (ramo == "VEH" || ramo == "VEH - Vehículos Comerciales Livianos" || ramo == "VEH - Vehículos Particulares" || ramo == "VEH - Vehículos Pesados"){
                      document.getElementById("deducible_vehiculo["+contador.toString()+"]").value=deducible[(contador-1).toString()];
                } 
                else
                {
                    document.getElementById("deducible_defecto["+contador.toString()+"]").value = deducible[(contador-1).toString()];
                }
                contador+=1;
            }
                    document.getElementById("nro_poliza").value = '';
                    document.getElementById("fecha_emision_poliza").value = '';
                    document.getElementById("comision").value = '<?php echo $comision; ?>';
                    document.getElementById("comisionbruta").value = '<?php echo $comision_bruta; ?>';
                    document.getElementById("comisionneta").value = '<?php echo $comision_neta; ?>';
                    document.getElementById("fechadeposito").value = '';
                    document.getElementById("comisionneg").value = '';
                    document.getElementById("boletaneg").value = '';
                    document.getElementById("boleta").value = '';
                    document.getElementById("fechaprimer").value = '';
                    document.getElementById("fechainicio").value = document.getElementById("fechavenc").value;
                    document.getElementById("fechavenc").value = '';
        }
            break;
          }
          default:{

            break;
          }
          
         
        }
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

          dosdecimales("valorcuota");
          dosdecimales("porcentaje_comsion");
          dosdecimales("comsion");
           
          contador2="1";
          var items ='<?php echo $nro_items; ?>'
          console.log('<?php echo $nro_items; ?>');
          
           while (contador2<=items){
               
         
               dosdecimales("tasa_afecta["+contador2+"]");
               dosdecimales("tasa_exenta["+contador2+"]");
               dosdecimales("prima_afecta["+contador2+"]");
               dosdecimales("prima_exenta["+contador2+"]");
               dosdecimales("prima_neta["+contador2+"]");
               dosdecimales("prima_bruta["+contador2+"]");
             contador2++
              
           }
          
});


document.getElementById("busca_rut_prop").addEventListener("click", function(event) {
    event.preventDefault()
});

document.getElementById("formulario").addEventListener('submit', function(event) {

    if (document.getElementById("nombre_prop").value == "") {
        document.getElementById("validador10").style.visibility = "visible";
 
        event.preventDefault();
        window.history.back();
    }
     if (document.getElementById("contador").value == "0") {
        alert("No has ingresado Items");
        
        event.preventDefault();
        window.history.back();
    }
     else {
    }
});

function dosdecimales(id){
    
    valor= document.getElementById(id).value;
    
    valor = parseFloat(this.valor).toFixed(2);
    document.getElementById(id).value = valor;
}

function validarutitem(){
    
    
    if (document.getElementById("nombre_prop").value == "") {
        document.getElementById("validador10").style.visibility = "visible";
 
      event.preventDefault();
       
    }
     else if (document.getElementById("contador").value == "0") {
        alert("No has ingresado Items");
 
       event.preventDefault();
        
    }
     else {
         document.getElementById("boton_submit").click();
    }
}

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
      var deducible_defecto = [];
      var prima_afecta = [];
      var prima_exenta = [];
      var prima_neta = [];
      var prima_bruta = [];
      var monto_aseg = [];
      var venc_gtia =[];
      var tasa_afecta =[];
      var tasa_exenta =[];
      var prima_afecta =[];
      var prima_exenta =[];
      var prima_neta =[];
      var prima_bruta =[];
      var monto_aseg =[];
      var numero_item =[];
      
      
      for (var i = 1; i <= contador; i++){

        rutaseg.push(document.getElementById("rutaseg["+i+"]").value);
        materia.push(document.getElementById("materia["+i+"]").value);
        detalle_materia.push(document.getElementById("detalle_materia["+i+"]").value);
        cobertura.push(document.getElementById("cobertura["+i+"]").value);
        deducible.push(document.getElementById("deducible_defecto["+i+"]").value);
        tasa_afecta.push(document.getElementById("tasa_afecta["+i+"]").value);
        tasa_exenta.push(document.getElementById("tasa_exenta["+i+"]").value);
        prima_afecta.push(document.getElementById("prima_afecta["+i+"]").value);
        prima_exenta.push(document.getElementById("prima_exenta["+i+"]").value);
        prima_neta.push(document.getElementById("prima_neta["+i+"]").value);
        prima_bruta.push(document.getElementById("prima_bruta["+i+"]").value);
        monto_aseg.push(document.getElementById("monto_aseg["+i+"]").value);
        venc_gtia.push(document.getElementById("venc_gtia["+i+"]").value);
        numero_item.push(document.getElementById("numero_item["+i+"]").value);
      }

    var camino=orgn;

    switch (camino) {
        case 'crear_propuesta': {
          $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
          //$.redirect('/bambooQA/test_felipe3.php', {
            'accion': 'crear_propuesta',
          //Propuesta
          'rutprop': document.getElementById("rutprop").value,
          'fechaprop': document.getElementById("fechaprop").value,
          'numero_propuesta': document.getElementById("nro_propuesta").value, //automàtica
          'fechainicio': document.getElementById("fechainicio").value,
          'fechavenc': document.getElementById("fechavenc").value,
          'moneda_poliza': document.getElementById("moneda_poliza").value,
          'selcompania': document.getElementById("selcompania").value, 
          'ramo': document.getElementById("ramo").value, 
          'comentarios_int': document.getElementById("comentarios_int").value,
          'comentarios_ext': document.getElementById("comentarios_ext").value,  
          'nombre_vendedor': document.getElementById("nombre_vendedor").value,
          'forma_pago': document.getElementById("modo_pago").value,
          'valor_cuota': document.getElementById("valorcuota").value,
          'nro_cuotas': document.getElementById("cuotas").value,
          'moneda_valor_cuota': document.getElementById("moneda_cuota").value,
          'fecha_primera_cuota': document.getElementById("fechaprimer").value,
          'porcentaje_comsion': document.getElementById("porcentaje_comsion").value,
          'contador_items':contador,
          //Ítem
          'rutaseg':  rutaseg,
          'materia': materia,
          'detalle_materia': detalle_materia,
          'cobertura': cobertura,
          'deducible': deducible,
          'tasa_afecta': tasa_afecta,
          'tasa_exenta': tasa_exenta,
          'prima_afecta': prima_afecta,
          'prima_exenta': prima_exenta,
          'prima_neta': prima_neta,
          'prima_bruta': prima_bruta,
          'monto_aseg': monto_aseg,
          'venc_gtia': venc_gtia,
          
        //renovación
          'accion_secundaria':'<?php echo $accion_secundaria; ?>',
          'poliza_renovada':'<?php echo $poliza_renovada; ?>'

          }, 'post');
        break;
        }
        case 'actualiza_propuesta': {
          $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
          //$.redirect('/bambooQA/test_felipe2.php', { 
            'accion': 'actualiza_propuesta',
          //Propuesta
          'rutprop': document.getElementById("rutprop").value,
          'fechaprop': document.getElementById("fechaprop").value,
          'numero_propuesta': document.getElementById("nro_propuesta").value, //automàtica
          'fechainicio': document.getElementById("fechainicio").value,
          'fechavenc': document.getElementById("fechavenc").value,
          'moneda_poliza': document.getElementById("moneda_poliza").value,
          'selcompania': document.getElementById("selcompania").value, 
          'ramo': document.getElementById("ramo").value, 
          'comentarios_int': document.getElementById("comentarios_int").value,
          'comentarios_ext': document.getElementById("comentarios_ext").value,  
          'nombre_vendedor': document.getElementById("nombre_vendedor").value,
          'forma_pago': document.getElementById("modo_pago").value,
          'valor_cuota': document.getElementById("valorcuota").value,
          'nro_cuotas': document.getElementById("cuotas").value,
          'moneda_valor_cuota': document.getElementById("moneda_cuota").value,
          'fecha_primera_cuota': document.getElementById("fechaprimer").value,
          'porcentaje_comsion': document.getElementById("porcentaje_comsion").value,
          'contador_items':contador,
          //Ítem
          'rutaseg':  rutaseg,
          'materia': materia,
          'detalle_materia': detalle_materia,
          'cobertura': cobertura,
          'deducible': deducible,
          'tasa_afecta': tasa_afecta,
          'tasa_exenta': tasa_exenta,
          'prima_afecta': prima_afecta,
          'prima_exenta': prima_exenta,
          'prima_neta': prima_neta,
          'prima_bruta': prima_bruta,
          'monto_aseg': monto_aseg,
          'venc_gtia': venc_gtia,
          'numero_item':numero_item
          }, 'post');
        break;
      }
        case 'crear_poliza': {
          $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
          //$.redirect('/bambooQA/test_felipe2.php', { 
            'accion': 'crear_poliza',
          //Propuesta
          'rutprop': document.getElementById("rutprop").value,
          'fechaprop': document.getElementById("fechaprop").value,
          'numero_propuesta': document.getElementById("nro_propuesta").value, //automàtica
          'fechainicio': document.getElementById("fechainicio").value,
          'fecha_envio_propuesta': '<?php echo $fecha_envio_propuesta; ?>',
          'fechavenc': document.getElementById("fechavenc").value,
          'moneda_poliza': document.getElementById("moneda_poliza").value,
          'selcompania': document.getElementById("selcompania").value, 
          'ramo': document.getElementById("ramo").value, 
          'comentarios_int': document.getElementById("comentarios_int").value,
          'comentarios_ext': document.getElementById("comentarios_ext").value,  
          'nombre_vendedor': document.getElementById("nombre_vendedor").value,
          'forma_pago': document.getElementById("modo_pago").value,
          'valor_cuota': document.getElementById("valorcuota").value,
          'nro_cuotas': document.getElementById("cuotas").value,
          'moneda_valor_cuota': document.getElementById("moneda_cuota").value,
          'fecha_primera_cuota': document.getElementById("fechaprimer").value,
          'contador_items':contador,
          //Ítem
          'rutaseg':  rutaseg,
          'materia': materia,
          'detalle_materia': detalle_materia,
          'cobertura': cobertura,
          'deducible': deducible,
          'tasa_afecta': tasa_afecta,
          'tasa_exenta': tasa_exenta,
          'prima_afecta': prima_afecta,
          'prima_exenta': prima_exenta,
          'prima_neta': prima_neta,
          'prima_bruta': prima_bruta,
          'monto_aseg': monto_aseg,
          'venc_gtia': venc_gtia,
          'numero_item':numero_item,

          
          //Póliza
          'nro_poliza': document.getElementById("nro_poliza").value,
          'fecha_emision_poliza': document.getElementById("fecha_emision_poliza").value,
          'comision': document.getElementById("comision").value,
          'porcentaje_comsion': document.getElementById("porcentaje_comsion").value,
          'comisionbruta': document.getElementById("comisionbruta").value,
          'comisionneta': document.getElementById("comisionneta").value,
          'fechadeposito': document.getElementById("fechadeposito").value,
          'comisionneg': document.getElementById("comisionneg").value,
          'boletaneg': document.getElementById("boletaneg").value,
          'boleta': document.getElementById("boleta").value
          }, 'post');
          break;
      }
        case 'modifica_poliza': {
          $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
          //$.redirect('/bambooQA/test_felipe2.php', { 
            'accion': 'modifica_poliza',
          //Propuesta
          'rutprop': document.getElementById("rutprop").value,
          'fechaprop': document.getElementById("fechaprop").value,
          'numero_propuesta': document.getElementById("nro_propuesta").value, //automàtica
          'fechainicio': document.getElementById("fechainicio").value,
          'fechavenc': document.getElementById("fechavenc").value,
          'moneda_poliza': document.getElementById("moneda_poliza").value,
          'selcompania': document.getElementById("selcompania").value, 
          'ramo': document.getElementById("ramo").value, 
          'comentarios_int': document.getElementById("comentarios_int").value,
          'comentarios_ext': document.getElementById("comentarios_ext").value,  
          'nombre_vendedor': document.getElementById("nombre_vendedor").value,
          'forma_pago': document.getElementById("modo_pago").value,
          'valor_cuota': document.getElementById("valorcuota").value,
          'nro_cuotas': document.getElementById("cuotas").value,
          'moneda_valor_cuota': document.getElementById("moneda_cuota").value,
          'fecha_primera_cuota': document.getElementById("fechaprimer").value,
            'numero_poliza': document.getElementById("nro_poliza").value,
            'fecha_emision_poliza': document.getElementById("fecha_emision_poliza").value,
            'comision':document.getElementById("comision").value,
            'comisionbruta': document.getElementById("comisionbruta").value,
            'comisionneta': document.getElementById("comisionneta").value,
            'fechadeposito': document.getElementById("fechadeposito").value,
            'comisionneg': document.getElementById("comisionneg").value ,
            'boletaneg': document.getElementById("boletaneg").value,
            'boleta':document.getElementById("boleta").value,
          'contador_items':contador,
          //Ítem
          'rutaseg':  rutaseg,
          'materia': materia,
          'detalle_materia': detalle_materia,
          'cobertura': cobertura,
          'deducible': deducible,
          'tasa_afecta': tasa_afecta,
          'tasa_exenta': tasa_exenta,
          'prima_afecta': prima_afecta,
          'prima_exenta': prima_exenta,
          'prima_neta': prima_neta,
          'prima_bruta': prima_bruta,
          'monto_aseg': monto_aseg,
          'venc_gtia': venc_gtia,
          'numero_item':numero_item,
          //Póliza
          'nro_poliza': document.getElementById("nro_poliza").value,
          'fecha_emision_poliza': document.getElementById("fecha_emision_poliza").value,
          'comision': document.getElementById("comision").value,
          'porcentaje_comsion': document.getElementById("porcentaje_comsion").value,
          'comisionbruta': document.getElementById("comisionbruta").value,
          'comisionneta': document.getElementById("comisionneta").value,
          'fechadeposito': document.getElementById("fechadeposito").value,
          'comisionneg': document.getElementById("comisionneg").value,
          'boletaneg': document.getElementById("boletaneg").value,
          'boleta': document.getElementById("boleta").value
          }, 'post');
          break;
      }
        case 'crear_poliza_web': {
        
          $.redirect('/bambooQA/backend/propuesta_polizas/crea_propuesta_polizas.php', {
          //$.redirect('/bambooQA/test_felipe3.php', { 
            'accion': 'crear_poliza_web',
          //Propuesta
          'rutprop': document.getElementById("rutprop").value,
          'fechaprop': document.getElementById("fechaprop").value,
          'fechainicio': document.getElementById("fechainicio").value,
          'numero_propuesta': 'WEB', //automàtica
          'fechavenc': document.getElementById("fechavenc").value,
          'moneda_poliza': document.getElementById("moneda_poliza").value,
          'selcompania': document.getElementById("selcompania").value, 
          'ramo': document.getElementById("ramo").value, 
          'comentarios_int': document.getElementById("comentarios_int").value,
          'comentarios_ext': document.getElementById("comentarios_ext").value,  
          'nombre_vendedor': document.getElementById("nombre_vendedor").value,
          'forma_pago': document.getElementById("modo_pago").value,
          'valor_cuota': document.getElementById("valorcuota").value,
          'nro_cuotas': document.getElementById("cuotas").value,
          'moneda_valor_cuota': document.getElementById("moneda_cuota").value,
          'fecha_primera_cuota': document.getElementById("fechaprimer").value,
          'contador_items':contador,
          //Ítem
          'rutaseg':  rutaseg,
          'materia': materia,
          'detalle_materia': detalle_materia,
          'cobertura': cobertura,
          'deducible': deducible,
          'tasa_afecta': tasa_afecta,
          'tasa_exenta': tasa_exenta,
          'prima_afecta': prima_afecta,
          'prima_exenta': prima_exenta,
          'prima_neta': prima_neta,
          'prima_bruta': prima_bruta,
          'monto_aseg': monto_aseg,
          'venc_gtia': venc_gtia,
          'numero_item':numero_item,

          
          //Póliza
          'nro_poliza': document.getElementById("nro_poliza").value,
          'comision': document.getElementById("comision").value,
          'porcentaje_comsion': document.getElementById("porcentaje_comsion").value,
          'comisionbruta': document.getElementById("comisionbruta").value,
          'comisionneta': document.getElementById("comisionneta").value,
          'fechadeposito': document.getElementById("fechadeposito").value,
          'comisionneg': document.getElementById("comisionneg").value,
          'boletaneg': document.getElementById("boletaneg").value,
          'boleta': document.getElementById("boleta").value,
          
          //renovación
          'accion_secundaria':'<?php echo $accion_secundaria; ?>',
          'poliza_renovada':'<?php echo $poliza_renovada; ?>'
          
          }, 'post');
          break;

      }
   
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
 
  function valida_primerpago(){
     
     
     var fecha_primer = new Date (document.getElementById("fechaprimer").value);
     var day_venc = fecha_primer.getDate()+1;
     var month_venc = fecha_primer.getMonth()+1;
     var year_venc = fecha_primer.getFullYear();
     var hoy = new Date();
     

     
     
     if(year_venc > 1000)
     {
         if (fecha_primer < hoy){
             
             alert("La fecha del primer pago es retroactiva");
         }
         
         
     }
     
    
 }
 function modopago() {
    if (document.getElementById("modo_pago").value == "Contado") {
        document.getElementById("cuotas").disabled = true;
        document.getElementById("cuotas").value = "Contado";
        
    } else {
        document.getElementById("cuotas").disabled = false;
        document.getElementById("cuotas").value = "";
    }
}
    var iCnt = 0;
   
    // Crear un elemento div añadiendo estilos CSS
    var container = $(document.createElement('div')).css({
        padding: '10px',
        margin: '20px',
        width: '340px',
    });
     function click_agrega_item(){

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
                '<td><input class="form-control" type="text" value="' + iCnt + '" id="numero_item[' + iCnt + ']" name="numero_item[]" disabled required/></td>'+
                '<td><div class="input-group-prepend"><button type="button" id="busca_rut_aseg[' + iCnt + ']" data-toggle="modal" onclick="origen_busqueda(this.id,' + iCnt + ')" data-target="#modal_cliente"><i class="fas fa-search"></i></button><input type="text" class="form-control" '+
                    'id="rutaseg[' + iCnt + ']" name="rutaseg[]" onchange="valida_rut_duplicado_aseg(' + iCnt + ')" oninput="checkRut(this);"'+
                    '  required/></div></td>' +
                '<td><input type="text" id="nombre_seg[' + iCnt + ']" class="form-control" name="nombreaseg[]" required></td>'+
                '<td><textarea type="text" class="form-control" id="materia[' + iCnt + ']" name="materia[]" rows="1" required></textarea></td>'+
                '<td><input type="text" class="form-control" id="detalle_materia[' + iCnt + ']" name="detalle_materia[]"></td>'+
                '<td><input type="text" class="form-control" id="cobertura[' + iCnt + ']" name="cobertura[]"></td>'+
            // inicio deducible
                '<td><div class="form-inline" id="div_deducible[' + iCnt + ']">'+
                //inicio deducible para RC
                    '<div id="deducible_para_RC[' + iCnt + ']" style="display:none;">'+
                    
                        '<div class="form-row" id="deducible_rc['+iCnt+']"  style="align-items: center;">'+
                            '<div class="row" style="align-items: center;">'+
                                '<input class="form-control" name="deducible_porcentaje" id="deducible_porcentaje['+iCnt+']" placeholder="%" style="width:44px" onChange="pobladeducible()">&nbsp'+
                                '<label style="font-size:75%;display:block;">% Pérdida con mínimo de      </label>&nbsp'+
                            
                                '<div class="input-group-prepend"><span class="input-group-text" id="moneda7['+iCnt+']">UF</span></div>'+
                                '<input type="text" class="form-control" name="deducible_valor" id="deducible_valor['+iCnt+']" placeholder="Valor" onChange="pobladeducible()">'+
                            '</div>'+
                        '</div>'+
                    
                    '</div>'+
                //inicio deducible para vehiculos
                    '<div id="deducible_para_vehiculos[' + iCnt + ']" style="display:none;"> '+
                        '<select class="form-control" id="deducible_vehiculo[' +iCnt+ ']" onChange="pobladeducible()">'+
                            '<option value="null" ?>Selecciona el deducible </option>'+
                            '<option value="Sin deducible">Sin deducible</option>'+
                            '<option value="UF 3">UF 3</option>'+
                            '<option value="UF 5">UF 5</option>'+
                            '<option value="UF 10">UF 10</option>'+
                            '<option value="UF 20">UF 20</option>'+
                            '<option value="UF 50">UF 50</option>'+
                        '</select>'+
                    '</div>'+
                //inicio deducible normal
                    '<div id="deducible_para_otros[' + iCnt + ']">'+
                        '<div class="input-group-prepend"><span class="input-group-text" id="moneda[' + iCnt + ']">UF</span></div> '+
                        '<input type="text" class="form-control" name="deducible_defecto" id="deducible_defecto[' + iCnt + ']" onChange="pobladeducible()">'+
        
                    '</div>'+
                '</div></td>'+
            // fin deducible
                '<td><input type="number" class="form-control" name="monto_aseg[]" id="monto_aseg[' + iCnt + ']" onchange= "dosdecimales(this.id);"  required>' +  
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="pormilla[' + iCnt + ']">%</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="tasa_afecta[]" id="tasa_afecta[' + iCnt + ']" "></div></td>'+
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="pormilla2[' + iCnt + ']">%</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="tasa_exenta[]" id="tasa_exenta[' + iCnt + ']"  style="width=75%"></div></td>'+ 
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda2[' + iCnt + ']">UF</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="prima_afecta[]" id="prima_afecta[' + iCnt + ']" onChange="calculaprimabruta()"></div></td>'+
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda3[' + iCnt + ']">UF</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="prima_exenta[]" id="prima_exenta[' + iCnt + ']" onChange="calculaprimabruta()" style="width=75%"></div></td>'+ 
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda4[' + iCnt + ']">UF</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="prima_bruta[]" id="prima_bruta[' + iCnt + ']"></div></td>'+
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda5[' + iCnt + ']">UF</span></div>'+
                '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="prima_neta[]" id="prima_neta[' + iCnt + ']"></div></td>'+
                  
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
                '<td><input class="form-control" type="text" value="' + iCnt + '" id="numero_item[' + iCnt + ']" name="numero_item[' + iCnt + ']" disabled required/></td>'+
                '<td><div class="input-group-prepend"><button type="button" id="busca_rut_aseg[' + iCnt + ']" data-toggle="modal" onclick="origen_busqueda(this.id,' + iCnt + ')" data-target="#modal_cliente"><i class="fas fa-search"></i></button><input type="text" class="form-control" '+
                    'id="rutaseg[' + iCnt + ']" name="rutaseg[]" placeholder="1111111-1" onchange="valida_rut_duplicado_aseg(' + iCnt + ')" oninput="checkRut(this);"'+
                    '  required/></div></td>' +
                '<td><input type="text" id="nombre_seg[' + iCnt + ']" class="form-control" name="nombreaseg[]"  required></td>'+
                '<td><textarea type="text" class="form-control" id="materia[' + iCnt + ']" name="materia[]" rows="1" required></textarea></td>'+
                '<td><input type="text" class="form-control" id="detalle_materia[' + iCnt + ']" name="detalle_materia[]"></td>'+
                '<td><input type="text" class="form-control" id="cobertura[' + iCnt + ']" name="cobertura[]"></td>'+
                
            // inicio deducible
                '<td><div class="form-inline" id="div_deducible[' + iCnt + ']">'+
                //inicio deducible para RC
                   '<div id="deducible_para_RC[' + iCnt + ']" style="display:none;">'+
                    
                        '<div class="form-row" id="deducible_rc['+iCnt+']"  style="align-items: center;">'+
                            '<div class="row" style="align-items: center;">'+
                                '<input class="form-control" name="deducible_porcentaje" id="deducible_porcentaje['+iCnt+']" placeholder="%" style="width:44px" onChange="pobladeducible()">&nbsp'+
                                '<label style="font-size:75%;display:block;">% Pérdida con mínimo de      </label>&nbsp'+
                            
                                '<div class="input-group-prepend"><span class="input-group-text" id="moneda7['+iCnt+']">UF</span></div>'+
                                '<input type="text" class="form-control" name="deducible_valor" id="deducible_valor['+iCnt+']" placeholder="Valor" onChange="pobladeducible()">'+
                            '</div>'+
                        '</div>'+
                    
                    '</div>'+
                //inicio deducible para vehiculos
                    '<div id="deducible_para_vehiculos[' + iCnt + ']" style="display:none;" > '+
                        '<select class="form-control" id="deducible_vehiculo[' +iCnt+ ']" onChange="pobladeducible()">'+
                            '<option value="null" ?>Selecciona el deducible </option>'+
                            '<option value="Sin deducible">Sin deducible</option>'+
                            '<option value="UF 3">UF 3</option>'+
                            '<option value="UF 5">UF 5</option>'+
                            '<option value="UF 10">UF 10</option>'+
                            '<option value="UF 20">UF 20</option>'+
                            '<option value="UF 50">UF 50</option>'+
                        '</select>'+
                    '</div>'+
                //inicio deducible normal
                    '<div id="deducible_para_otros[' + iCnt + ']">'+
                        '<div class="input-group-prepend"><span class="input-group-text" id="moneda[' + iCnt + ']">UF</span></div> '+
                        '<input type="text" class="form-control" name="deducible_defecto" id="deducible_defecto[' + iCnt + ']" onChange="pobladeducible()">'+
        
                    '</div>'+
                '</div></td>'+
            // fin deducible
                
                
                '<td><input type="number" onchange= "dosdecimales(this.id);" class="form-control" name="monto_aseg[]" id="monto_aseg[' + iCnt + ']"  required>' +  
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="pormilla[' + iCnt + ']">%</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="tasa_afecta[]" id="tasa_afecta[' + iCnt + ']" "></div></td>'+
                '<td> <div class="form-inline" onchange= "dosdecimales(this.id);" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="pormilla2[' + iCnt + ']">%</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="tasa_exenta[]" id="tasa_exenta[' + iCnt + ']"  style="width=75%"></div></td>'+ 
                '<td> <div class="form-inline" onchange= "dosdecimales(this.id);" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda2[' + iCnt + ']">UF</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="prima_afecta[]" id="prima_afecta[' + iCnt + ']" onChange="calculaprimabruta()"></div></td>'+
                '<td> <div class="form-inline" onchange= "dosdecimales(this.id);" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda3[' + iCnt + ']">UF</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="prima_exenta[]" id="prima_exenta[' + iCnt + ']" onChange="calculaprimabruta()" style="width=75%"></div></td>'+ 
                '<td> <div class="form-inline" onchange= "dosdecimales(this.id);" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda4[' + iCnt + ']">UF</span></div>'+
                      '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="prima_bruta[]" id="prima_bruta[' + iCnt + ']"></div></td>'+
                '<td> <div class="form-inline" style="width:auto"><div class="input-group-prepend"><span class="input-group-text" id="moneda5[' + iCnt + ']">UF</span></div>'+
                '<input type="number" onchange= "dosdecimales(this.id);" step="0.01" placeholder="0,00" class="form-control" name="prima_neta[]" id="prima_neta[' + iCnt + ']"></div></td>'+
                  
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
    
    }
    $(document).bind('keydown',function(e){
      if ( e.which == 27 ) {
                                                  
      console.log("Has pulsado la tecla ESC");
      $('.modal-backdrop').remove();
                                             };
                               });
 $(document).ready(function() {

     var listado_filtrado="/bambooQA/backend/endosos/busqueda_listado_endosos_filtrada.php?id="+'<?php echo $id; ?>'
     var table_endosos = $('#listado_endosos').DataTable({
        "ajax": listado_filtrado,
        "scrollX": true,
        "dom": 'Pfrtip',
        "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": '<i class="fas fa-search-plus"></i>'
            }, //0
            {
                "data": "numero_endoso",
                title: "Número Endoso"
            }, //1
            { 
                data: "numero_propuesta_endoso", 
                title: "Nro Propuesta Endoso",
            }, //2
            {
                "data": "tipo_endoso",
                title: "Tipo Endoso"
            }, //3
            {
                "data": "fecha_ingreso_endoso",
                title: "Fecha ingreso"
            }, //4
            {
                "data": "vigencia_inicial",
                title: "Inicio Vigencia"
            }, //5
            {
                "data": "vigencia_final",
                title: "Fin Vigencia"
            }, //6
            {
                "data": "fecha_prorroga",
                title: "Fecha Prorroga"
            } //7
        ],
        "columnDefs": 
        [
        {
        targets: [4,5,6,7],
         render: function(data, type, full)
         {
            if (data==null || data=="0000-00-00")
            {
                return '';
            }
            else
            {
                return moment(data).format('YYYY/MM/DD');
            }
         }}
        ],
        "order": [
            [4, "desc"]
        ],
        "oLanguage": {
            "sSearch": "Búsqueda rápida",
            "sLengthMenu": 'Mostrar <select>' +
                '<option value="10">10</option>' +
                '<option value="25">30</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">todos</option>' +
                '</select> registros',
                "sInfoFiltered": "(Resultado búsqueda: _TOTAL_ de _MAX_ registros totales)",
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
                "title":{
                    _: 'Filtros seleccionados - %d',
                    0: 'Sin Filtros Seleccionados',
                    1: '1 Filtro Seleccionado',
                }
            }
        }
    });
    $("#listado_endosos_filter input")
    .off()
    .on('keyup change', function (e) {
    if (e.keyCode !== 13 || this.value == "") {
        var texto1=this.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");  
        table_endosos.search(texto1)
            .draw();
    }
        
    });
    $('#listado_endosos tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table_endosos.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format_endoso(row.data())).show();
            tr.addClass('shown');
        }
    });


    
   //$('#btAdd').click();



  $('#btRemove').click(function() { // Elimina un elemento por click

        if (iCnt != 0) {
           
            $('#btAdd').removeAttr('disabled');
            $('#item' + iCnt).remove();
             iCnt = iCnt - 1;
              document.getElementById("contador").value = iCnt;
             
             
        if (iCnt == 100) {
            $('#label').remove();
            
        }
        }
        if (iCnt == 0) {
            
            
            //$('#mytable').remove();
            //$(container).remove();
            //                $('#btSubmit').remove(); 
            $('#btAdd').removeAttr('disabled');
            $('#btAdd').attr('class', 'btn')
            iCnt = 0;
            //var newElement2 =
              //  '<table class="table" id="mytable"><tr><th>Nombre Contacto</th><th>Telefono</th><th>E-mail</th></tr></table>';
           // $("#main").append($(newElement2));
            //$("#mytable").append($(newElement));
        }
    });
 });


document.getElementById("formulario").addEventListener('submit', function(event) {
    if (document.getElementById("rutprop").value == "") {
        document.getElementById("validador10").style.visibility = "visible";
        event.preventDefault();
    }
     else {
    }
    
    
});

function quitavalidador(){
    
    if (document.getElementById("nombre_prop").value != ""){
        
        alert("asda");
        document.getElementById("validador10").style.visibility = "hidden";
    } 
    
}
function format_endoso(d) {
    // `d` is the original data object for the row
    var ext_cancelado='';
    return '<table background-color:#F6F6F6; color:#FFF; cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
            '<td VALIGN=TOP>Primas: </td>' +
            '<td>'+
                 '<table class="table table-striped" style="width:100%">'+
                    '<tr>' +
                        '<td>Total Prima afecta:</td>' +
                        '<td>' + d.prima_neta_afecta + '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td>Total Prima exenta:</td>' +
                        '<td>' + d.prima_neta_exenta + '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td>Total Prima neta anual:</td>' +
                        '<td>' + d.iva + '</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td>Total Prima bruta anual:</td>' +
                        '<td>' + d.prima_total + '</td>' +
                    '</tr>' +
                '</table>'+
            '</td>' +
        '</tr>' +
        '<tr>' +
        '<td VALIGN=TOP>Detalle: </td>' +
            '<td>'+
                '<table class="table table-striped" style="padding-left:50px;" cellpadding="5" cellspacing="0" border="0" id="listado_polizas">'+
                    '<tr>'+
                        '<th>Descripción</th>'+
                        '<th>Dice</th>'+
                        '<th>Debe Decir</th>'+
                        '<th>Comentario</th>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>' + d.descripcion_endoso + '</td>'+
                    '<td>' + d.dice + '</td>'+
                    '<td>' + d.debe_decir + '</td>'+
                    '<td>' + d.comentario_endoso + '</td>'+
                '</table>'+
            '</td>' +
        '</tr>' +    
        '<tr>' +
            '<td> </td>' +
            '<td> </td>' +
        '</tr>' +
        '</table>';
}
</script>