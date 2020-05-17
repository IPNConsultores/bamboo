<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}
$camino='';

 $id_poliza=estandariza_info($_POST["id_poliza"]);
    require_once "/home/gestio10/public_html/backend/config.php";
    mysqli_set_charset( $link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    $query= 'select  rut_proponente,  dv_proponente,  rut_asegurado,  dv_asegurado,  compania,  ramo,  vigencia_inicial,  vigencia_final,  numero_poliza,  cobertura,  materia_asegurada,  patente_ubicacion, moneda_poliza,  deducible,  prima_afecta,  prima_exenta,  prima_neta,  prima_bruta_anual,  monto_asegurado,  numero_propuesta,  fecha_envio_propuesta,  moneda_comision,  comision,  porcentaje_comision,  comision_bruta,  comision_neta, moneda_valor_cuota,  forma_pago, nro_cuotas,  valor_cuota,  fecha_primera_cuota,  vendedor, nombre_vendedor, poliza_renovada, comision_negativa, boleta_negativa, depositado_fecha, numero_boleta from polizas where id=261';
      $resultado=mysqli_query($link, $query);
      While($row=mysqli_fetch_object($resultado))
      {
          $camino='modificar';
         $rut_prop=$row->rut_proponente;
         $dv_prop=$row->dv_proponente;
         $rut_aseg=$row->rut_asegurado;
         $dv_aseg=$row->dv_asegurado;
         $rut_completo_prop = $rut_prop.'-'.$dv_prop;
        $rut_completo_aseg = $rut_aseg.'-'.$dv_aseg;
         $selcompania=$row->compania;
         $ramo=$row->ramo;
         $fechainicio=$row->vigencia_inicial;
         $fechavenc=$row->vigencia_final;
         $nro_poliza=$row->numero_poliza;
         $cobertura=$row->cobertura;
         $materia=$row->materia_asegurada;
         $detalle_materia=$row->patente_ubicacion;
         $moneda_poliza=$row->moneda_poliza;
         $deducible=$row->deducible;
         $prima_afecta=$row->prima_afecta;
         $prima_exenta=$row->prima_exenta;
         $prima_neta=$row->prima_neta;
         $prima_bruta=$row->prima_bruta_anual;
         $monto_aseg=$row->monto_asegurado;
         $nro_propuesta=$row->numero_propuesta;
         $fechaprop=$row->fecha_envio_propuesta;
         $moneda_comision=$row->moneda_comision;
         $comision=$row->comision;
         $porcentaje_comsion=$row->porcentaje_comision;
         $comisionbruta=$row->comision_bruta;
         $comisionneta=$row->comision_neta;
         $modo_pago=$row->forma_pago;
         $cuotas=$row->nro_cuotas;
         $moneda_cuota=$row->moneda_valor_cuota;
         $valorcuota=$row->valor_cuota;
         $fechaprimer=$row->fecha_primera_cuota;
         $con_vendedor=$row->vendedor;
         $nombre_vendedor=$row->nombre_vendedor;
         $poliza_renovada=$row->poliza_renovada;
         $boleta=$row->numero_boleta;
         $comision_negativa=$row->comision_negativa;
         $boleta_negativa=$row->boleta_negativa;
         $depositado_fecha=$row->depositado_fecha;
         
      }

if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["id_poliza"])==true){
//
}
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creación Póliza</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />

    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>

<body>
    <!-- body code goes here -->

    <?php include 'header2.php' ?>
    </div>
    <div class="container">
        <p>Póliza / Creación<br>
        </p>
        <button type="btn" onclick="precargar_data()">cargar</button>
  
        <h5 class="form-row">&nbsp;Datos Póliza</h5>
        <br>
        <br>
        <div class="form-check form-check-inline">
            <label class="form-check-label">¿Desea renovar una póliza existente?:&nbsp;&nbsp;</label>
            <input class="form-check-input" type="radio" name="nueva" id="radio_no" value="nueva"
                onclick="checkRadio(this.name)" checked="checked">
            <label class="form-check-label" for="inlineRadio1">No&nbsp;</label>
            <input class="form-check-input" type="radio" name="renovacion" id="radio_si" value="renovacion"
                onclick="checkRadio(this.name)">
            <label class="form-check-label" for="inlineRadio2">Si&nbsp;&nbsp;</label>
            <button class="btn" id="busca_poliza" data-toggle="modal" data-target="#modal_poliza"
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
                                        <th>Materia</th>
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
            <div class="col">
            <form action="/bamboo/backend/polizas/crea_poliza.php"  class="needs-validation" method="POST" novalidate id="formulario">
            <div id="auxiliar" style="display: none;">
                <input name="id_poliza" id="id_poliza">
            </div>
                <input type="text" class="form-control" name="poliza_renovada" placeholder="Póliza Anterior"
                    id="poliza_renovada" style="display:none;">
            </div>
        </div>
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
                    <div class="card-body">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">¿Cliente Asegurado y Proponente son la misma
                                persona?:&nbsp;&nbsp;</label>
                            <input class="form-check-input" type="radio" name="diferentes" id="radio2_no"
                                value="diferentes" onclick="checkRadio2(this.name)" checked="checked">
                            <label class="form-check-label" for="inlineRadio1">No&nbsp;</label>
                            <input class="form-check-input" type="radio" name="iguales" id="radio2_si" value="iguales"
                                onclick="checkRadio2(this.name)">
                            <label class="form-check-label" for="inlineRadio2">Si&nbsp;&nbsp;</label>

                        </div>
                                                    <p><strong>Datos Proponente<br>
                                </strong></p>
                            <div class="form-row">
                                <div class="form-row">
                                    <div class="col-md mb-3">
                                        <label for="RUT">RUT</label>
                                        <input type="text" class="form-control" id="rutprop" name="rutprop"
                                            placeholder="1111111-1" oninput="checkRut(this);copiadatos()"
                                            onchange="valida_rut_duplicado_prop();copiadatos()" required>
                                        <div class="invalid-feedback">Dígito verificador no válido. Verifica rut
                                            ingresado</div>


                                    </div>
                                    <button class="btn" id="busca_rut_prop" data-toggle="modal"
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
                                                        aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
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
                                                            </tr>
                                                        </table>
                                                        <div id="botones_cliente"></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
                                    <label for="prop">&nbsp;</label>
                                    <br>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="Nombre">Nombre</label>
                                        <input type="text" id="nombre_prop" class="form-control" name="nombre"
                                            onchange="copiadatos()" required>
                                        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="ApellidoP">Apellido Paterno</label>
                                        <input type="text" id="apellidop_prop" class="form-control"
                                            onchange="copiadatos()" name="apellidop" required>
                                        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="ApellidoM">Apellido Materno</label>
                                        <input type="text" id="apellidom_prop" class="form-control" name="apellidom"
                                            onchange="copiadatos()" required>
                                        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                                    </div>
                                </div>
                            </div>
                            <p><strong>Datos Asegurado<br></strong></p>
                            <div class="form-row">
                                <div class="form-row">
                                    <div class="col-md mb-3">
                                        <label for="RUT">RUT</label>
                                        <input type="text" class="form-control" id="rutaseg" name="rutaseg"
                                            placeholder="1111111-1" oninput="checkRut(this)"
                                            onchange="valida_rut_duplicado_aseg()" required>
                                        <div class="invalid-feedback">Dígito verificador no válido. Verifica rut
                                            ingresado</div>

                                    </div>
                                    <button class="btn" id="busca_rut_aseg" onclick="origen_busqueda(this.id)"
                                        data-toggle="modal" data-target="#modal_cliente"
                                        style="background-color: #536656; color: white;margin-top: 30px;margin-left: 5px; height: 40px">Buscar
                                        RUT</button>
                                </div>
                                <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
                                    <label for="prop">&nbsp;</label>
                                    <br>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="Nombre">Nombre</label>
                                        <input type="text" id="nombre_seg" class="form-control" name="nombreaseg"
                                            required>
                                        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="ApellidoP">Apellido Paterno</label>
                                        <input type="text" id="apellidop_seg" class="form-control" name="apellidopaseg"
                                            required>
                                        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="ApellidoM">Apellido Materno</label>
                                        <input type="text" id="apellidom_seg" class="form-control" name="apellidomaseg"
                                            required>
                                        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
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
                            style="color:#536656">Compañía, Vigencia, Materia y Deducible</button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <label for="compania"><b>Compañía</b></label>
                        <br>
                        <div class="form-row">
                            <div class="form-inline">
                                <select class="form-control" name="selcompania" id="selcompania">
                                    <option value="BCI Seguros" <?php if ($selcompania == "BCI Seguros") echo "selected" ?> >BCI Seguros</option>
                                    <option value="Chilena Consolidada" <?php if ($selcompania == "Chilena Consolidada") echo "selected" ?> >Chilena Consolidada</option>
                                    <option value="CHUBB" <?php if ($selcompania == "CHUBB") echo "selected" ?> >CHUBB</option>
                                    <option value="Confuturo" <?php if ($selcompania == "Confuturo") echo "selected" ?> >Confuturo</option>
                                    <option value="Consorcio" <?php if ($selcompania == "Consorcio") echo "selected" ?> >Consorcio</option>
                                    <option value="Continental" <?php if ($selcompania == "Continental") echo "selected" ?> >Continental</option>
                                    <option value="HDI Seguros" <?php if ($selcompania == "HDI Seguros") echo "selected" ?> >HDI Seguros</option>
                                    <option value="Maphre" <?php if ($selcompania == "Maphre") echo "selected" ?> >Maphre</option>
                                    <option value="Ohio National Financial Group" <?php if ($selcompania == "Ohio National Financial Group") echo "selected" ?> >Ohio National Financial Group</option>
                                    <option value="Orsan" <?php if ($selcompania == "Orsan") echo "selected" ?> >Orsan</option>
                                    <option value="Reale Seguros" <?php if ($selcompania == "Reale Seguros") echo "selected" ?> >Reale Seguros</option>
                                    <option value="Renta Nacional" <?php if ($selcompania == "Renta Nacional") echo "selected" ?> >Renta Nacional</option>
                                    <option value="Southbridge" <?php if ($selcompania == "Southbridge") echo "selected" ?> >Southbridge</option>
                                    <option value="Sura" <?php if ($selcompania == "Sura") echo "selected" ?> >Sura</option>
                                    <option value="Unnio" <?php if ($selcompania == "Unnio") echo "selected" ?> >Unnio</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <label for="poliza"><b>Póliza</b></label>
                        <br>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="sel1">Ramo:&nbsp;</label>
                                <select class="form-control" name="ramo" id="ramo">
                                    <option value="VEH" <?php if ($ramo == "VEH") echo "selected" ?> >VEH</option>
                                    <option value="Hogar" <?php if ($ramo == "Hogar") echo "selected" ?> >Hogar</option>
                                    <option value="A. VIAJE" <?php if ($ramo == "A. VIAJE") echo "selected" ?> >A. VIAJE</option>
                                    <option value="RC" <?php if ($ramo == "RC") echo "selected" ?> >RC</option>
                                    <option value="INC" <?php if ($ramo == "INC") echo "selected" ?> >INC</option>
                                    <option value="APV" <?php if ($ramo == "APV") echo "selected" ?> >APV</option>
                                    <option value="D&O" <?php if ($ramo == "D&O") echo "selected" ?> >D&O</option>
                                    <option value="AP" <?php if ($ramo == "AP") echo "selected" ?> >AP</option>
                                    <option value="Vida" <?php if ($ramo == "Vida") echo "selected" ?> >Vida</option>
                                    <option value="Garantía" <?php if ($ramo == "Garantía") echo "selected" ?> >Garantía</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="Nombre">Vigencia Inicial</label>
                                <div class="md-form">
                                    <input placeholder="Selected date" type="date" id="fechainicio" name="fechainicio"
                                        class="form-control">
                                </div>
                                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="Nombre">Vigencia Final</label>
                                <div class="md-form">
                                    <input placeholder="Selected date" type="date" name="fechavenc" id="fechavenc" class="form-control">
                                </div>
                                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-4">
                                <label for="poliza">Número de Poliza</label>
                                <input type="text" class="form-control" id="nro_poliza" name="nro_poliza" required>
                                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
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
                                <input type="text" class="form-control" id="materia" name="materia" required>
                                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                            </div>
                            <div class="col">
                                <label for="poliza">Patente o Ubicación</label>
                                <input type="text" class="form-control"  id="detalle_materia" name="detalle_materia" required>
                                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                            </div>
                        </div>
                        <br>
                        <label for="materia"><b>Deducible, Primas y Montos</b></label>
                        <br>
                        <div class="form-row; form-inline">
                            <label for="moneda_poliza">Moneda Prima</label>
                            <div class="col-1">
                                <select class="form-control" id="moneda_poliza" name="moneda_poliza">
                                    <option value="UF" <?php if ($moneda_poliza == "UF") echo "selected" ?> >UF</option>
                                    <option value="USD" <?php if ($moneda_poliza == "USD") echo "selected" ?> >USD</option>
                                    <option value="CLP" <?php if ($moneda_poliza == "CLP") echo "selected" ?> >CLP</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="deducible">Deducible</label>
                                <input type="text" class="form-control" name="deducible" id="deducible" oninput="concatenar(this.id)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="prima_afecta">Prima Afecta</label>
                                <input type="text" class="form-control" name="prima_afecta" id="prima_afecta" oninput="concatenar(this.id)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="prima_exenta">Prima Exenta</label>
                                <input type="text" class="form-control" id="prima_exenta" name="prima_exenta"
                                    oninput="concatenar(this.id)">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="prima_afecta">Prima Neta</label>
                                <input type="text" class="form-control" id="prima_neta" name="prima_neta" oninput="concatenar(this.id)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="prima_afecta">Prima Bruta Anual</label>
                                <input type="text" class="form-control" id="prima_bruta" name="prima_bruta" oninput="concatenar(this.id)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="monto_aseg">Monto Asegurado</label>
                                <input type="text" class="form-control" name="monto_aseg" id="monto_aseg" oninput="concatenar(this.id)">
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
                    <div class="card-body">
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
                                    <input placeholder="Selected date" type="date" name="fechaprop" id="fechaprop" class="form-control">
                                </div>
                            </div>
                        </div>
                        <br>
                        <label for="materia"><b>Comisión</b></label>
                        <br>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="comision">Comisión Correspondiente</label>
                                <div class="form-inline">
                                    <input type="text" class="form-control" id="comision" name="comision">
                                    <select class="form-control" name="moneda_comision" id="moneda_comision">
                                        <option value="UF" <?php if ($moneda_comision == "UF") echo "selected" ?> >UF->dejar igual que prima</option>
                                        <option value="USD" <?php if ($moneda_comision == "USD") echo "selected" ?> >USD</option>
                                        <option value="CLP" <?php if ($moneda_comision == "CLP") echo "selected" ?> >CLP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Porcentaje Comisión del Corredor</label>
                                <input type="text" class="form-control" id="porcentaje_comsion" name="porcentaje_comsion">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Comisión Bruta a Pago</label>
                                <input type="text" class="form-control" id="comisionbruta" name="comisionbruta">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Comisión Neta a Pago</label>
                                <input type="text" class="form-control" id="comisionneta" name="comisionneta">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Número de Boleta</label>
                                <input type="text" class="form-control" name="boleta" id="boleta">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="fechadeposito">Fecha Depósito</label>
                                <div class="md-form">
                                    <input placeholder="Selected date" type="date" id="fechadeposito"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="comision">Comisión Negativa</label>
                                <input type="text" class="form-control" name="comisionneg" id="comisionneg">
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
                                <div class="form-row">
                                <div class="form-inline">
                                    <select class="form-control" name="moneda_cuota" id="moneda_cuota">
                                        <option value="UF" <?php if ($moneda_cuota == "UF") echo "selected" ?> >UF</option>
                                        <option value="USD" <?php if ($moneda_cuota == "USD") echo "selected" ?> >USD</option>
                                        <option value="CLP" <?php if ($moneda_cuota == "CLP") echo "selected" ?> >CLP</option>
                                    </select>
                                </div>
                                    <div class="col-4">
                                        <select class="form-control" name="modo_pago" id="modo_pago" onChange="modopago()">
                                            <option value="PAT" <?php if ($modo_pago == "PAT") echo "selected" ?> >PAT</option>
                                            <option value="PAC" <?php if ($modo_pago == "PAC") echo "selected" ?> >PAC</option>
                                            <option value="OTROS" <?php if ($modo_pago == "OTROS") echo "selected" ?> >Cupon de Pago</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="cuotas" name="cuotas"
                                            placeholder="Número de Cuotas">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="valorcuota">Valor Cuota</label>
                                <input type="text" class="form-control"  name="valorcuota" id="valorcuota" oninput="concatenar(this.id)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="fechaprimer">Fecha Primera Cuota</label>
                                <div class="md-form">
                                    <input placeholder="Selected date" type="date" id="fechaprimer" name="fechaprimer"
                                        class="form-control">
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
                                        <select class="form-control" name="con_vendedor" id="con_vendedor" onChange="validavendedor()">
                                            <option value="Si" <?php if ($con_vendedor == "Si") echo "selected" ?> >Si</option>
                                            <option value="No" <?php if ($con_vendedor == "No") echo "selected" ?> >No</option>
                                        </select>
                                    </div>
                                    &nbsp;
                                    <div class="col">
                                        <input type="text" class="form-control" id="nombre_vendedor" name="nombre_vendedor"
                                            placeholder="Nombre Vendedor">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <button class="btn" type="submit" style="background-color: #536656; color: white">Registrar</button>
        </form>
        <br>
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
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>-->

</body>

</html>
<script>
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
        document.getElementById("poliza_renovada").disabled = "true"
    }
}

function checkRadio2(name) {
    if (name == "diferentes") {
        document.getElementById("radio2_si").checked = false;
        document.getElementById("radio2_no").checked = true;
        document.getElementById("nombre_seg").disabled = false;
        document.getElementById("rutaseg").disabled = false;
        document.getElementById("apellidop_seg").disabled = false;
        document.getElementById("apellidom_seg").disabled = false;
        document.getElementById("busca_rut_aseg").style.display = "block";


    } else if (name == "iguales") {
        document.getElementById("radio2_no").checked = false;
        document.getElementById("radio2_si").checked = true;
        document.getElementById("nombre_seg").disabled = "true";
        document.getElementById("rutaseg").disabled = "true";
        document.getElementById("apellidop_seg").disabled = "true";
        document.getElementById("apellidom_seg").disabled = "true";
        document.getElementById("busca_rut_aseg").style.display = "none";
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

function concatenar(name) {
    var moneda = document.getElementById("moneda_poliza").value;
    var texto = document.getElementById(name).value.replace(' ' + moneda, '');
    var final = texto + ' ' + moneda;

    document.getElementById(name).value = final;
}

function modopago() {
    if (document.getElementById("modo_pago").value == "PAT") {
        document.getElementById("cuotas").disabled = false;

    } else {
        document.getElementById("cuotas").disabled = true;

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
        "columns": [2, 3, 13, 14],
    },
    "dom": 'Pfrtip',
    "columns": [{
            "className": 'details-control',
            "orderable": false,
            "data": "id_poliza",
            "render": function(data, type, full, meta) {
                return '<button type="button" id="' + data +
                    '" onclick="renovar_poliza(this.id)" class="btn btn-outline-primary">Renovar</button>';
            }
        },
        {
            "data": "estado",
            title: "Estado"
        },
        {
            "data": "numero_poliza",
            title: "Nro Póliza"
        },
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
            "data": "deducible",
            title: "Deducible"
        },
        {
            "data": "prima_afecta",
            title: "Prima afecta"
        },
        {
            "data": "prima_exenta",
            title: "Prima exenta"
        },
        {
            "data": "prima_bruta_anual",
            title: "Prima bruta anual"
        },
        {
            "data": "anomes_final",
            title: "Añomes final"
        },
        {
            "data": "anomes_inicial",
            title: "Añomes inicial"
        }

    ],
    //          "search": {
    //          "search": "abarca"
    //          },
    "columnDefs": [{
            "targets": [10, 11, 12, 13, 14],
            "visible": false,
        },
        {
            "targets": [10, 11, 12, 13, 14],
            "searchable": false
        },
        {
            "searchPanes": {
                "preSelect": ['202004'],
            },
            "targets": [13],
        },
        {
            targets: 1,
            render: function(data, type, row, meta) {
                var estado = '';
                switch (data) {
                    case 'Activo':
                        estado = '<span class="badge badge-primary">' + data + '</span>';
                        break;
                    case 'Cerrado':
                        estado = '<span class="badge badge-dark">' + data + '</span>';
                        break;
                    case 'Atrasado':
                        estado = '<span class="badge badge-danger">' + data + '</span>';
                        break;
                    default:
                        estado = '<span class="badge badge-light">' + data + '</span>';
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

function renovar_poliza(poliza) {
    console.log(poliza);
    $('#modal_poliza').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}
function precargar_data(){
var orgn='<?php echo $camino; ?>';
if (orgn=='modificar'){
    document.getElementById("rutprop").value = '<?php echo $rut_completo_prop; ?>';
    document.getElementById("rutaseg").value = '<?php echo $rut_completo_aseg; ?>';
    
    document.getElementById("fechainicio").value = '<?php echo $fechainicio; ?>';
    document.getElementById("fechavenc").value = '<?php echo $fechavenc; ?>';
    document.getElementById("nro_poliza").value = '<?php echo $nro_poliza; ?>';
    document.getElementById("cobertura").value = '<?php echo $cobertura; ?>';
    document.getElementById("materia").value = '<?php echo $materia; ?>';
    document.getElementById("detalle_materia").value = '<?php echo $detalle_materia; ?>';
    document.getElementById("deducible").value = '<?php echo $deducible; ?>';
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
    document.getElementById("formulario").action="/bamboo/backend/polizas/modifica_poliza.php";
    document.getElementById("id_poliza").value = '<?php echo $id_poliza; ?>';
    
    valida_rut_duplicado_prop();
    valida_rut_duplicado_aseg();
    
}
}
</script>