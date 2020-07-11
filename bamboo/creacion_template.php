<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}
$template = $resultado_template = $instancia = $producto = '';

function estandariza_info( $data ) {
  $data = trim( $data );
  $data = stripslashes( $data );
  $data = htmlspecialchars( $data );
  return $data;
}
require_once "/home/gestio10/public_html/backend/config.php";

if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
  mysqli_set_charset( $link, 'utf8' );
  mysqli_select_db( $link, 'gestio10_asesori1_bamboo' );

  switch ( $_POST[ "tipo" ] ) {
    case "probar":
      $template = estandariza_info( $_POST[ "template" ] );
      $instancia = $_POST[ "instancia" ];
      $producto = $_POST[ "seguro" ];
      break;
    case "guardar":
      $template = estandariza_info( $_POST[ "template" ] );
      $instancia = $_POST[ "instancia" ];
      $producto = $_POST[ "seguro" ];
      $verif_combi = mysqli_query( $link, 'SELECT COUNT(*) AS contador FROM template_correos WHERE producto="' . $producto . '" and instancia="' . $instancia . '"' );
      While( $row = mysqli_fetch_object( $verif_combi ) ) {
        $verif = estandariza_info( $row->contador );
      }
      if ( !$verif == 0 ) {
        mysqli_query( $link, 'UPDATE template_correos SET template="' . $template . '" where producto="' . $producto . '" and instancia="' . $instancia . '"' );
      } else {
        mysqli_query( $link, 'INSERT INTO template_correos(template, producto, instancia) values ("' . $template . '","' . $producto . '", "' . $instancia . '");' );
      }
      break;
    case "buscar":
      $instancia = $_POST[ "instancia" ];
      $producto = $_POST[ "seguro" ];
      $resultado_template = mysqli_query( $link, 'SELECT template FROM template_correos where producto="' . $producto . '" and instancia="' . $instancia . '"' );
      While( $row = mysqli_fetch_object( $resultado_template ) ) {
        $template = estandariza_info( $row->template );
      }
      break;
  }


  $template_ejemplo = $template;
  $template_ejemplo = str_replace( '_[NOMBRE_CLIENTE]_', 'Juan Pérez', $template_ejemplo );
  $template_ejemplo = str_replace( '_[ESTADO]_', 'Activa', $template_ejemplo );
  $template_ejemplo = str_replace( '_[TIPO_POLIZA]_', 'Renovada', $template_ejemplo );
  $template_ejemplo = str_replace( '_[RUT_PROP]_', '12345678', $template_ejemplo );
  $template_ejemplo = str_replace( '_[DV_PROP]_', '9', $template_ejemplo );
  $template_ejemplo = str_replace( '_[RUT_ASEG]_', '12345678', $template_ejemplo );
  $template_ejemplo = str_replace( '_[DV_ASEG]_', '9', $template_ejemplo );
  $template_ejemplo = str_replace( '_[GRUPO]_', 'Red Salud', $template_ejemplo );
  $template_ejemplo = str_replace( '_[COMPANIA]_', 'SURA', $template_ejemplo );
  $template_ejemplo = str_replace( '_[VIGENCIA_INICIAL]_', '01-01-2020', $template_ejemplo );
  $template_ejemplo = str_replace( '_[VIGENCIA_FINAL]_', '31-12-2020', $template_ejemplo );
  $template_ejemplo = str_replace( '_[MES_VENCIMIENTO]_', '12', $template_ejemplo );
  $template_ejemplo = str_replace( '_[ANO_VENCIMIENTO]_', '2020', $template_ejemplo );
  $template_ejemplo = str_replace( '_[POLIZA_RENOVADA]_', '1111111', $template_ejemplo );
  $template_ejemplo = str_replace( '_[RAMO]_', 'VEH', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NUMERO_POLIZA]_', '1923898', $template_ejemplo );
  $template_ejemplo = str_replace( '_[MATERIA_ASEGURADA]_', 'Mercedez', $template_ejemplo );
  $template_ejemplo = str_replace( '_[PATENTE_UBICACION]_', 'AABB 00', $template_ejemplo );
  $template_ejemplo = str_replace( '_[COBERTURA]_', 'Premium', $template_ejemplo );
  $template_ejemplo = str_replace( '_[DEDUCIBLE]_', '5', $template_ejemplo );
  $template_ejemplo = str_replace( '_[MONEDA_POLIZA]_', 'UF ', $template_ejemplo );
  $template_ejemplo = str_replace( '_[PRIMA_AFECTA]_', '16.19', $template_ejemplo );
  $template_ejemplo = str_replace( '_[MONEDA_COMISION]_', 'UF ', $template_ejemplo );
  $template_ejemplo = str_replace( '_[PRIMA_EXENTA]_', '0', $template_ejemplo );
  $template_ejemplo = str_replace( '_[PRIMA_NETA]_', '24,62', $template_ejemplo );
  $template_ejemplo = str_replace( '_[PRIMA_BRUTA_ANUAL]_', '295,44', $template_ejemplo );
  $template_ejemplo = str_replace( '_[MONTO_ASEGURADO]_', 'Valor Comercial', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NUMERO_PROPUESTA]_', '111111', $template_ejemplo );
  $template_ejemplo = str_replace( '_[FECHA_ENVIO_PROPUESTA]_', '01-02-2020', $template_ejemplo );
  $template_ejemplo = str_replace( '_[ENDOSO]_', 'Modificación de Nombre Asegurado', $template_ejemplo );
  $template_ejemplo = str_replace( '_[COMISION]_', '1,5', $template_ejemplo );
  $template_ejemplo = str_replace( '_[PORCENTAJE_COMISION]_', '13', $template_ejemplo );
  $template_ejemplo = str_replace( '_[COMISION_BRUTA]_', '35963', $template_ejemplo );
  $template_ejemplo = str_replace( '_[COMISION_NETA]_', '32124', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NUMERO_BOLETA]_', '5', $template_ejemplo );
  $template_ejemplo = str_replace( '_[MONEDA_COM_NEG]_', 'Peso', $template_ejemplo );
  $template_ejemplo = str_replace( '_[COMISION_NEGATIVA]_', '6532', $template_ejemplo );
  $template_ejemplo = str_replace( '_[BOLETA_NEGATIVA]_', '7', $template_ejemplo );
  $template_ejemplo = str_replace( '_[DEPOSITADO_FECHA]_', '01-03-2020', $template_ejemplo );
  $template_ejemplo = str_replace( '_[VENDEDOR]_', 'Si', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NOMBRE_VENDEDOR]_', 'John Doug', $template_ejemplo );
  $template_ejemplo = str_replace( '_[FORMA_PAGO]_', 'PAT', $template_ejemplo );
  $template_ejemplo = str_replace( '_[MONEDA_VALOR_CUOTA]_', 'CLP', $template_ejemplo );
  $template_ejemplo = str_replace( '_[VALOR_CUOTA]_', '1,7', $template_ejemplo );
  $template_ejemplo = str_replace( '_[FECHA_PRIMERA_CUOTA]_', '01-02-2020', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NRO_CUOTAS]_', '12', $template_ejemplo );
  $template_ejemplo = str_replace( '_[INFO_ADICIONAL]_', 'comentarios adicionales', $template_ejemplo );


  $template_ejemplo = str_replace( '_[SALTO_LINEA]_', '<br>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NEG_ini]_', '<b>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[NEG_fin]_', '</b>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[SUB_ini]_', '<u>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[SUB_fin]_', '</u>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[CUR_ini]_', '<em>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[CUR_fin]_', '</em>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[LINEA]_', '<hr>', $template_ejemplo );
  $template_ejemplo = str_replace( '_[SU_ini]_', '', $template_ejemplo );
  $template_ejemplo = str_replace( '_[SU_fin]_', '', $template_ejemplo );
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<link rel="icon" href="/bamboo/bamboo.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<div id="header">
<?php include 'header2.php' ?>
</div>
<div class="container">
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name='editor_template'>
    <div id="auxiliar" style="display: none;">
      <input name="tipo" id="tipo">
    </div>
    <div class="row">
      <div class="col">
        <label><b>Instancia</b></label>
        <select class="form-control" name="instancia" id="instancia">
          <option value="info_cotizar" <?php if ($instancia == "info_cotizar") echo "selected" ?>>Información para Cotizar</option>
          <option value="envio_cotizacion" <?php if ($instancia == "envio_cotizacion") echo "selected" ?>>Envío de Cotización</option>
          <option value="envio_poliza" <?php if ($instancia == "envio_poliza") echo "selected" ?>>Enviar póliza</option>
          
        </select>
      </div>
      <div class="col-6">
        <label><b>Ramo</b></label>
        <select class="form-control" name="seguro" id="seguro">
 <option value="null">Selecciona un ramo</option>
 <option value="AC - Accidentes Personales "<?php if ($producto =="AC - Accidentes Personales") echo "selected" ?> >ACCIDENTES PERSONALES - Accidentes Personales</option>
 <option value="AC - Protección Financiera  "<?php if ($producto =="AC - Protección Financiera ") echo "selected" ?> >ACCIDENTES PERSONALES - Protección Financiera </option>
  <option value="ASISTENCIA EN VIAJE "<?php if ($producto =="ASISTENCIA EN VIAJE") echo "selected" ?> >ASISTENCIA EN VIAJE</option>
 <option value="INC - Condominio  "<?php if ($producto =="INC - Condominio ") echo "selected" ?> >INCENDIO  - Condominio </option>
 <option value="INC - Hogar "<?php if ($producto =="INC - Hogar") echo "selected" ?> >INCENDIO  - Hogar</option>
 <option value="INC - Misceláneos "<?php if ($producto =="INC - Misceláneos") echo "selected" ?> >INCENDIO  - Misceláneos</option>
 <option value="INC - Perjuicio por Paralización "<?php if ($producto =="INC - Perjuicio por Paralización") echo "selected" ?> >INCENDIO  - Perjuicio por Paralización</option>
 <option value="INC - Pyme "<?php if ($producto =="INC - Pyme") echo "selected" ?> >INCENDIO  - Pyme</option>
 <option value="INC - TRBF (Todo Riesgo Bienes Físicos) "<?php if ($producto =="INC - TRBF (Todo Riesgo Bienes Físicos)") echo "selected" ?> >INCENDIO  - TRBF (Todo Riesgo Bienes Físicos)</option>
 <option value="D&O Condominio  "<?php if ($producto =="D&O Condominio ") echo "selected" ?> >RESPONSABILIDAD CIVIL  - D&O Condominio </option>
 <option value="RC General "<?php if ($producto =="RC General") echo "selected" ?> >RESPONSABILIDAD CIVIL  - RC General</option>
 <option value="VEH - Vehículos Comerciales Livianos "<?php if ($producto =="VEH - Vehículos Comerciales Livianos") echo "selected" ?> >VEHÍCULOS  - Vehículos Comerciales Livianos</option>
 <option value="VEH - Vehículos Particulares "<?php if ($producto =="VEH - Vehículos Particulares") echo "selected" ?> >VEHÍCULOS  - Vehículos Particulares</option>
 <option value="VEH - Vehículos Pesados  "<?php if ($producto =="VEH - Vehículos Pesados ") echo "selected" ?> >VEHÍCULOS  - Vehículos Pesados </option>
 <option value="null">--------------------------------------------------------------</option>
 <option value="AVERÍA DE MAQUINARIA  "<?php if ($producto =="AVERÍA DE MAQUINARIA ") echo "selected" ?> >AVERÍA DE MAQUINARIA </option>
 <option value="CASCO - Aéreo "<?php if ($producto =="CASCO - Aéreo") echo "selected" ?> >CASCO - Aéreo</option>
 <option value="CASCO - Marítimo  "<?php if ($producto =="CASCO - Marítimo ") echo "selected" ?> >CASCO - Marítimo </option>
 <option value="Garantía "<?php if ($producto =="Garantía") echo "selected" ?> >GARANTÍA</option>
 <option value="ING - Equipo Contratistas "<?php if ($producto =="ING - Equipo Contratistas") echo "selected" ?> >INGENIERÍA - Equipo Contratistas</option>
 <option value="ING - Equipo Móvil Agrícola "<?php if ($producto =="ING - Equipo Móvil Agrícola") echo "selected" ?> >INGENIERÍA - Equipo Móvil Agrícola</option>
 <option value="ING - Equipos Electrónicos "<?php if ($producto =="ING - Equipos Electrónicos") echo "selected" ?> >INGENIERÍA - Equipos Electrónicos</option>
 <option value="ING- TRC (Todo Riesgo Construcción) "<?php if ($producto =="ING- TRC (Todo Riesgo Construcción)") echo "selected" ?> >INGENIERÍA - TRC (Todo Riesgo Construcción)</option>
 <option value="REMESA DE VALORES "<?php if ($producto =="REMESA DE VALORES") echo "selected" ?> >REMESA DE VALORES</option>
 <option value="ROBO CON FUERZA  "<?php if ($producto =="ROBO CON FUERZA ") echo "selected" ?> >ROBO CON FUERZA EN LAS COSAS Y VIOLENCIA EN LAS PERSONAS</option>
 <option value="ROTURA DE CRISTALES "<?php if ($producto =="ROTURA DE CRISTALES") echo "selected" ?> >ROTURA DE CRISTALES</option>
 <option value="SEGURO ARRIENDO  "<?php if ($producto =="SEGURO ARRIENDO ") echo "selected" ?> >SEGURO ARRIENDO </option>
 <option value="SEGURO DE CRÉDITO  "<?php if ($producto =="SEGURO DE CRÉDITO ") echo "selected" ?> >SEGURO DE CRÉDITO </option>
 <option value="CABOTAJE "<?php if ($producto =="CABOTAJE") echo "selected" ?> >TRANSPORTE - CABOTAJE</option>
 <option value="INTERNACIONAL  "<?php if ($producto =="INTERNACIONAL ") echo "selected" ?> >TRANSPORTE - INTERNACIONAL </option>
 <option value="APV "<?php if ($producto =="APV") echo "selected" ?> >VIDA - APV</option>
 <option value="VIDA "<?php if ($producto =="VIDA") echo "selected" ?> >VIDA - VIDA</option>
                  <option value="A. VIAJE" <?php if ($ramo == "A. VIAJE") echo "selected" ?> >A. VIAJE</option>
                  <option value="AP" <?php if ($ramo == "AP") echo "selected" ?> >AP</option>
                  <option value="APV" <?php if ($ramo == "APV") echo "selected" ?> >APV</option>
                  <option value="D&O" <?php if ($ramo == "D&O") echo "selected" ?> >D&O</option>
                  <option value="Garantía" <?php if ($ramo == "Garantía") echo "selected" ?> >Garantía</option>
                  <option value="Hogar" <?php if ($ramo == "Hogar") echo "selected" ?> >Hogar</option>
                  <option value="INC" <?php if ($ramo == "INC") echo "selected" ?> >INC</option>
                  <option value="PyME" <?php if ($ramo == "PyME") echo "selected" ?> >PyME</option>
                  <option value="RC" <?php if ($ramo == "RC") echo "selected" ?> >RC</option>
                  <option value="VEH" <?php if ($ramo == "VEH") echo "selected" ?> >VEH</option>
                  <option value="Vida" <?php if ($ramo == "Vida") echo "selected" ?> >Vida</option>
           


        </select>
        <br>
      </div>
      <div class="col" style="align-self: center">
        <button name="buscar" class="btn" type="submit" onclick="envio_data(this.name)"
                        style="background-color: #536656; color: white; height: 45; align-self: center">Buscar
        template</button>
      </div>
    </div>
    <div class="row">
    <div class="col-6 col-md-4">
      <h6>Diccionario de Campos</h6>
      <div class="row"
                    style="height: 200px;margin-bottom: 0px;border-style: solid; border-width: thin;border-color: #D2D8DD">
        <table class="table" id="formato" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 0px">
          <thead >
            <tr>
              <th>Comando</th>
              <th>Definición</th>
            </tr>
          </thead>
        </table>
        <div style= "height:120px; width:400px; overflow-x:auto;margin-top: 0px;">
          <table class="table">
            <tbody>
              <tr>
                <td>_[NOMBRE_CLIENTE]_</td>
                <td>Nombre Cliente</td>
              </tr>
              <tr>
                <td>_[ESTADO]_</td>
                <td>Estado Poliza</td>
              </tr>
              <tr>
                <td>_[TIPO_POLIZA]_</td>
                <td>Tipo de Poliza</td>
              </tr>
              <tr>
                <td>_[RUT_PROP]_</td>
                <td>Rut Proponente</td>
              </tr>
              <tr>
                <td>_[DV_PROP]_</td>
                <td>DV Proponente</td>
              </tr>
              <tr>
                <td>_[RUT_ASEG]_</td>
                <td>Rut Asegurado</td>
              </tr>
              <tr>
                <td>_[DV_ASEG]_</td>
                <td>DV Asegurado</td>
              </tr>
              <tr>
                <td>_[GRUPO]_</td>
                <td>Grupo</td>
              </tr>
              <tr>
                <td>_[COMPANIA]_</td>
                <td>Compañía</td>
              </tr>
              <tr>
                <td>_[VIGENCIA_INICIAL]_</td>
                <td>Vigencia Inicial</td>
              </tr>
              <tr>
                <td>_[VIGENCIA_FINAL]_</td>
                <td>Vigencia Final</td>
              </tr>
              <tr>
                <td>_[MES_VENCIMIENTO]_</td>
                <td>Mes Vencimiento</td>
              </tr>
              <tr>
                <td>_[ANO_VENCIMIENTO]_</td>
                <td>Año Vencimiento</td>
              </tr>
              <tr>
                <td>_[POLIZA_RENOVADA]_</td>
                <td>Poliza Renovada</td>
              </tr>
              <tr>
                <td>_[RAMO]_</td>
                <td>Ramo</td>
              </tr>
              <tr>
                <td>_[NUMERO_POLIZA]_</td>
                <td>Numero Póliza</td>
              </tr>
              <tr>
                <td>_[MATERIA_ASEGURADA]_</td>
                <td>Materia Asegurada</td>
              </tr>
              <tr>
                <td>_[PATENTE_UBICACION]_</td>
                <td>Patente o Ubicación</td>
              </tr>
              <tr>
                <td>_[COBERTURA]_</td>
                <td>Cobertura</td>
              </tr>
              <tr>
                <td>_[DEDUCIBLE]_</td>
                <td>Deducible</td>
              </tr>
              <tr>
                <td>_[MONEDA_POLIZA]_</td>
                <td>Moneda Póliza</td>
              </tr>
              <tr>
                <td>_[PRIMA_AFECTA]_</td>
                <td>Prima Afecta</td>
              </tr>
              <tr>
                <td>_[MONEDA_COMISION]_</td>
                <td>Moneda Comisión</td>
              </tr>
              <tr>
                <td>_[PRIMA_EXENTA]_</td>
                <td>Prima Exenta</td>
              </tr>
              <tr>
                <td>_[PRIMA_NETA]_</td>
                <td>Prima Neta</td>
              </tr>
              <tr>
                <td>_[PRIMA_BRUTA_ANUAL]_</td>
                <td>Prima Bruta Anual</td>
              </tr>
              <tr>
                <td>_[MONTO_ASEGURADO]_</td>
                <td>Monto Asegurado</td>
              </tr>
              <tr>
                <td>_[NUMERO_PROPUESTA]_</td>
                <td>Numero Propuesta</td>
              </tr>
              <tr>
                <td>_[FECHA_ENVIO_PROP]_</td>
                <td>Fecha Envío Propuesta</td>
              </tr>
              <tr>
                <td>_[ENDOSO]_</td>
                <td>Endoso</td>
              </tr>
              <tr>
                <td>_[COMISION]_</td>
                <td>Comisión</td>
              </tr>
              <tr>
                <td>_[PORCENTAJE_COMISION]_</td>
                <td>Porcentaje</td>
              </tr>
              <tr>
                <td>_[COMISION_BRUTA]_</td>
                <td>Comisión Bruta</td>
              </tr>
              <tr>
                <td>_[COMISION_NETA]_</td>
                <td>Comisión Neta</td>
              </tr>
              <tr>
                <td>_[NUMERO_BOLETA]_</td>
                <td>Número boleta</td>
              </tr>
              <tr>
                <td>_[MONEDA_COM_NEG]_</td>
                <td>Moneda Comisión Negativa</td>
              </tr>
              <tr>
                <td>_[COMISION_NEGATIVA]_</td>
                <td>Comisión Negativa</td>
              </tr>
              <tr>
                <td>_[BOLETA_NEGATIVA]_</td>
                <td>Boleta Negativa</td>
              </tr>
              <tr>
                <td>_[DEPOSITADO_FECHA]_</td>
                <td>Fecha Primer depósito</td>
              </tr>
              <tr>
                <td>_[VENDEDOR]_</td>
                <td>Vendedor</td>
              </tr>
              <tr>
                <td>_[NOMBRE_VENDEDOR]_</td>
                <td>Nombre Vendedor</td>
              </tr>
              <tr>
                <td>_[FORMA_PAGO]_</td>
                <td>Forma de Pago</td>
              </tr>
              <tr>
                <td>_[MONEDA_VALOR_CUOTA]_</td>
                <td>Moneda Valor Cuota</td>
              </tr>
              <tr>
                <td>_[VALOR_CUOTA]_</td>
                <td>Valor cuota</td>
              </tr>
              <tr>
                <td>_[FECHA_PRIMERA_CUOTA]_</td>
                <td>Fecha Primera Cuota</td>
              </tr>
              <tr>
                <td>_[NRO_CUOTAS]_</td>
                <td>Numero de Cuotas</td>
              </tr>
              <tr>
                <td>_[INFO_ADICIONAL]_</td>
                <td>Información Adicional</td>
              </tr>
            <td>_[VEHICULO]_</td>
              <td>Vehiculo</td>
            </tr></tbody>
          </table>
        </div>
      </div>
      <br>
      <h6>Diccionario de Formato</h6>
      <div class="row"
                    style="height: 200px;border: solid; border-width: thin;border-color: #D2D8DD">
        <table class="table" id="formato" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 0px">
          <thead >
            <tr>
              <th>Comando</th>
              <th>Definición</th>
            </tr>
          </thead>
        </table>
        </table>
        <div style= "height:120px; width:400px; overflow-x:auto;margin-top: 0px;">
          <table class="table" style: "width:400px">
            <tbody>
              <tr>
                <td>_[SALTO_LINEA]_</td>
                <td>Salto de línea</td>
              </tr>
              <tr>
                <td>_[LINEA]_</td>
                <td>Línea/separador</td>
              </tr>
              <tr>
                <td>_[NEG_ini]_</td>
                <td>Negrita inicio</td>
              </tr>
              <tr>
                <td>_[NEG_fin]_</td>
                <td>Negrita fin</td>
              </tr>
              <tr>
                <td>_[CUR_ini]_</td>
                <td>Cursiva inicio</td>
              </tr>
              <tr>
                <td>_[CUR_fin]_</td>
                <td>Cursiva fin</td>
              </tr>
              <tr>
                <td>_[SUB_ini]_</td>
                <td>Subrayado inicio</td>
              </tr>
              <tr>
                <td>_[SUB_fin]_</td>
                <td>Subrayado fin</td>
              </tr>
              <tr>
                <td>_[SU_ini]_</td>
                <td>Asunto inicio</td>
              </tr>
              <tr>
                <td>_[SU_fin]_</td>
                <td>Asunto fin</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <button class="btn" name="probar" type="submit" style="background-color: #536656; color: white"
                    onclick="envio_data(this.name)">Probar</button>
      <button class="btn" name="guardar" type="submit" style="background-color: #536656; color: white"
                    onclick="envio_data(this.name)">Guardar</button>
    </div>
    <br>
    <div class="col">
      <h6>Template</h6>
      <textarea class="form-control" rows="10" style="height: 200px" id='template' name='template'
                style="text-indent:0px";>
      <?php echo $template; ?>
      </textarea>
      <br>
      <h6>Resultado</h6>
      <div class="form-control bg-light text-dark" rows="10"
                style="height: 200px; border-style: solid;overflow-y: scroll"><?php echo $template_ejemplo; ?></div>
      <br>
    </div>
  </form>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</body>
</html>
<script>
function envio_data(boton) {
    document.getElementById("tipo").value = boton;
}

</script>