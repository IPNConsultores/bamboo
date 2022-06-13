<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}
//$_SERVER[ "REQUEST_METHOD" ] = "POST";
//$_POST["accion"] = 'generar_documento';
//$_POST["numero_propuesta"]='P000021';
    if ($_SERVER[ "REQUEST_METHOD" ] == "POST" and $_POST["accion"] == 'generar_documento')
    {
    
      require_once "/home/gestio10/public_html/backend/config.php";
      mysqli_set_charset( $link, 'utf8' );
      mysqli_select_db( $link, 'gestio10_asesori1_bamboo' );
      $query = "select poliza_renovada, numero_propuesta, a.rut_proponente,a.dv_proponente, b.nombre_cliente, b.telefono, b.telefono, b.correo, b.direccion_personal, b.direccion_laboral , DATE_FORMAT(fecha_propuesta,'%d-%m-%Y') as fecha_propuesta , DATE_FORMAT(vigencia_inicial,'%d-%m-%Y') as vigencia_inicial, DATE_FORMAT(vigencia_final,'%d-%m-%Y') as vigencia_final, CONCAT(DATEDIFF(vigencia_final,vigencia_inicial),' días') as plazo_vigencia, moneda_poliza, compania, ramo, comentarios_int, comentarios_ext, vendedor, forma_pago, valor_cuota, nro_cuotas, moneda_valor_cuota, DATE_FORMAT(fecha_primera_cuota,'%d-%m-%Y') as fecha_primera_cuota,DATE_FORMAT(fecha_propuesta,'%d') as dia_pago, CONCAT_WS(' ',FORMAT(porcentaje_comision, 2, 'de_DE'),'%') as porcentaje_comision from propuesta_polizas as a left join clientes as b on a.rut_proponente=b.rut_sin_dv where numero_propuesta='".$_POST["numero_propuesta"]."'";
      $resultado = mysqli_query( $link, $query );
      While( $row = mysqli_fetch_object( $resultado ) ) {
    
        $rut_prop = $row->rut_proponente;
        $dv_prop = $row->dv_proponente;
        $poliza_renovada = $row->poliza_renovada;
        $rut_completo_prop = $rut_prop . '-' . $dv_prop;
        $nombre_proponente = $row->nombre_cliente;
        $telefono = $row->telefono;
        $correo = $row->correo;
        $direccion_personal = $row->direccion_personal;
        $direccion_laboral = $row->direccion_laboral;
        $selcompania = $row->compania;
        $ramo = $row->ramo;
        $fechainicio = $row->vigencia_inicial;
        $fechavenc = $row->vigencia_final;
        $plazo_vigencia = $row->plazo_vigencia;
        $moneda_poliza = $row->moneda_poliza;
        $nro_propuesta = $row->numero_propuesta;
        $fechaprop = $row->fecha_propuesta;    
        $modo_pago = $row->forma_pago;
        $cuotas = $row->nro_cuotas;
        $moneda_cuota = $row->moneda_valor_cuota;
        $valorcuota = $row->valor_cuota;
        $fechaprimer = $row->fecha_primera_cuota;
        $dia_pago = $row->dia_pago;
        $porcentaje_comision = $row->porcentaje_comision;
        
        $nombre_vendedor = $row->vendedor;
        $comentarios_int = str_replace( "\r\n", "\\n", $row->comentarios_int );
        $comentarios_ext = str_replace( "\r\n", "\\n", $row->comentarios_ext );
        $nro_items=0;
        
        $query_item = "SELECT numero_item, rut_asegurado, dv_asegurado, b.nombre_cliente, b.telefono, b.telefono, b.correo, b.direccion_personal, b.direccion_laboral, materia_asegurada, patente_ubicacion, cobertura, deducible, CONCAT_WS(' ',FORMAT(tasa_afecta, 2, 'de_DE'),'%') as tasa_afecta ,CONCAT_WS(' ',FORMAT(tasa_exenta, 2, 'de_DE'),'%')as tasa_exenta, CONCAT_WS(' ',FORMAT(prima_afecta, 2, 'de_DE')) as prima_afecta,CONCAT_WS(' ',FORMAT(prima_exenta, 2, 'de_DE')) as prima_exenta, prima_neta, CONCAT_WS(' ',FORMAT(prima_bruta_anual, 2, 'de_DE')) as prima_bruta_anual, CONCAT_WS(' ',FORMAT(monto_asegurado, 2, 'de_DE')) as monto_asegurado,venc_gtia, CONCAT_WS(' ',FORMAT(prima_afecta*0.19, 2, 'de_DE')) as prima_afecta_iva FROM `items` as a left join clientes as b on a.rut_asegurado=b.rut_sin_dv where numero_propuesta='".$_POST["numero_propuesta"]."'order by numero_item asc";
        $resultado_item = mysqli_query( $link, $query_item );
            While( $row_item = mysqli_fetch_object( $resultado_item ) ) {
                $nro_items+=1;
                $item[]=$row_item->numero_item;
                $rut_aseg = $row_item->rut_asegurado;
                $dv_aseg = $row_item->dv_asegurado;
                $rut_completo_aseg[] = $rut_aseg . '-' . $dv_aseg;
                $nombre_proponente_asegurado[] = $row_item->nombre_cliente;
                $telefono_asegurado[] = $row_item->telefono;
                $correo_asegurado[] = $row_item->correo;
                $direccion_personal_asegurado[] = $row_item->direccion_personal;
                $direccion_laboral_asegurado[] = $row_item->direccion_laboral;
                $cobertura[] = str_replace( "\r\n", "\n",$row_item->cobertura);
                $materia_i = $row_item->materia_asegurada;
                $materia[] = str_replace( "\r\n", "\n", $materia_i );
                $detalle_materia_i = $row_item->patente_ubicacion;
                $detalle_materia[] = str_replace( "\r\n", "\n", $detalle_materia_i );
                $deducible[] = $row_item->deducible;
                $tasa_afecta[] = $row_item->tasa_afecta;
                $tasa_exenta[] = $row_item->tasa_exenta;
                $prima_afecta[] = $row_item->prima_afecta;
                $prima_exenta[] = $row_item->prima_exenta;
                $prima_neta[] = $row_item->prima_neta;
                $prima_bruta[] = $row_item->prima_bruta_anual;
                $monto_aseg[] = $row_item->monto_asegurado;
                $venc_gtia[] = $row_item->venc_gtia;
                $prima_afecta_iva[] = $row_item->prima_afecta_iva;
            }
        }
    }
    mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="/assets/js/jquery.redirect.js"></script>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="/bamboo/images/bamboo.png">
<!-- Bootstrap --> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    
<div class="container" id="capture">
    <button id="BotonPDF" onclick="makePDF();">Generar PDF</button>
    <br>
    <br>
    <section id="section1">
    <div class="row" style="float:center; align:middle">
        <div class="col-1"></div>
                <div class="col" style="float: center;vertical-align: middle; border-style :solid; border-color: grey; border-width: 2px; border-right-width: 0px; border-bottom-width:1px">
                <div class="row">
        <div class="col">
                        <p><img src="/bamboo/images/logo_bamboo _verde.png" width="150" class="img-fluid" style="float: center;vertical-align: middle "></p>
            </div>
            <div class="col" style="vertical-align:middle;">
    
                       <figure class="text-center">
                        <blockquote class="blockquote">
                             <p><b>Propuesta de Póliza</b></p>
                        </blockquote>
  
                        </figure>
         </div>
    </div>
                    
                </div>
                 <div class="col-4" style="border-style :solid; border-color: grey; border-width: 2px; border-bottom-width:1px;border-left-width:1px;  ">
                    <div class= "row align-items-center">
                        <div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                                <label>Propuesta:</label> 
                        </div>
                         <div class="col" contenteditable="true">       
                                <label id="nro_propuesta"></label>
                                <br>
                         </div>
                    </div>
                    <div class= "row align-items-center">
                        <div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >
                                <label>Fecha:</label>
                        </div>
                        <div class="col" contenteditable="true">
                                <label id="fechaprop" class="text-end">fecha</label>
                                <br>
                        </div>       
                                
                    </div>
                    <div class= "row align-items-center">
                        <div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                                <label>Compañía</label>
                                <br>
                        </div>
                        <div class="col" contenteditable="true">
                                <label id="compania"></label>
                        </div>
                    </div>
                    <div class= "row align-items-center" style="background-color:#f5f5f5;border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px; top:0 ; bottom:0;">
                        <div class="col" style="background-color:#f5f5f5;border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px; top:0 ; bottom:0;">
                                <label>Ramo</label>
                                <br>
                        </div>
                        <div class="col" contenteditable="true"style="background-color:#fff;border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px; top:0 ; bottom:0;">
                             <label id="ramo">ramo</label>
                                <br>
                            
                        </div>
                    </div>
                    <div class= "row align-items-center">
                        <div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >
                                <label>Corredor</label>
                                
                        </div>
                        <div class="col" contenteditable="true">
                                <label>Adriana Sandoval P.</label>
                                <br>
                        </div>
                    </div>
                    <div class= "row align-items-center">
                        <div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                                <label>Rut Corredor</label>
                                
                         </div>
                         <div class="col" contenteditable="true">
                             <label>10.228.002-4</label>
                                <br>
                             
                         </div>
                    </div>
                
      
            </div>
     <div class="col-1"></div>
    </div>
    
  <!--DATOS PROPONENTE -->
    <div class="row" id='renovacion' style="display:none" >
        <div class="col-1"></div>
        <div id='titulo_renovacion' class="col" style="background-color:yellow;border-style :solid; border-color: grey; border-width: 1px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px"></div>
    <div class="col-1"></div>
    </div>
        <div class="row" >
        <div class="col-1"></div>
        <div class="col" style="background-color:lightgrey;border-style :solid; border-color: grey; border-width: 1px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px; "> <b>PROPONENTE / CONTRATANTE </b></div>

        <div class="col-1"></div>
    </div>
    <div class="row" >
        <div class="col-1"></div>
            <div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >
                <div class= "row align-items-center">
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>RUT:</label> 
                    </div>
                    <div class="col" contenteditable="true">       
                        <label id="rut_proponente"></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Nombre:</label> 
                    </div>
                    <div class="col" contenteditable="true">       
                        <label id="nombre_proponente"></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Dirección:</label> 
                    </div>
                    <div class="col" contenteditable="true">       
                        <label id="direccion_particular"></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px; padding-top: 6px;padding-bottom: 5px; ">
                        <label  class = "text-right" >Comuna:</label> 
                    </div>
                    <div class="col" contenteditable="true" >       
                        <input type="text" placeholder="Ingresar Comuna" class="form-inline" name="comuna" id="comuna">
                        <br>
                    </div>
                    <div class="col-1" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">       
                        <label>Ciudad:</label>
                        <br>
                    </div>
                    <div class="col" contenteditable="true">       
                        <input type="text" placeholder="Ingresar Ciudad" class="form-inline" name="ciudad" id="ciudad">
                        <br>
                    </div>
                    <div class="col-1" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">       
                        <label>Región:</label>
                        <br>
                    </div>
                        <div class="col" contenteditable="true">       
                        <input type="text" placeholder="Ingresar Región" class="form-inline" name="region" id="region">
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Teléfono</label> 
                    </div>
                    <div class="col-10" contenteditable="true">       
                        <label id="telefono"></label>
                        <br>
                    </div>
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">       
                        <label>E-mail:</label>
                        <br>
                    </div>
                    <div class="col" contenteditable="true">       
                        <label id="correo"></label>
                        <br>
                    </div>
                    
                </div>
            
            </div>
        <div class="col-1"></div>
    </div>
<!--Resumen documento -->
     <div class="row" >
        <div class="col-1"></div>
        <div class="col" style="background-color:lightgrey;border-style :solid; border-color: grey; border-width: 1px; border-top-width:0px; border-right-width: 2px;border-left-width: 2px; "> <b>RESUMEN DOCUMENTO </b></div>
        <div class="col-1"></div>
    </div>
    <div class="row" >
        <div class="col-1"></div>
            <div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Moneda Póliza: </label> 
                    </div>
                    <div class="col-1" style="text-align:right" contenteditable="true">       
                        <label id="moneda_poliza"></label>
                        <br>
                    </div>
                    <div class="col-3"></div>
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Items:</label> 
                    </div>
                    <div class="col-2" style="text-align:right" contenteditable="true">       
                        <span id="numero_items" >3</span>
                        <br>
                    </div>
                    
                </div>
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Monto Total Asegurado:</label> 
                    </div>
                    <div class="col-1" style="text-align:right">       
                        <label id="moneda_poliza_MTA"></label>
                        <br>
                    </div>
                    <div class="col-3" contenteditable="true">       
                        <label id="monto_asegurado"></label>
                        <br>
                    </div>

                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Comisión Corredor</label> 
                    </div>
                    <div class="col-2" style="text-align:right" contenteditable="true">       
                        <label id= "comision_corredor" ></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Prima Neta Total Afecta:</label> 
                    </div>
                    <div class="col-1" style="text-align:right" contenteditable="true">       
                        <label id="moneda_poliza_PN"></label>
                        <br>
                    </div>
                    <div class="col-2" contenteditable="true">       
                        <label id="total_prima_neta"></label>
                        <br>
                    </div>
                    <div class="col-1">
                        <label> </label>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Prima Neta Total Exenta:</label> 
                    </div>
                    <div class="col-1" style="text-align:right" contenteditable="true">       
                        <label id="moneda_poliza_PE"></label>
                        <br>
                    </div>
                    <div class="col-2" contenteditable="true">       
                        <label id="total_prima_exenta">prima_exenta</label>
                        <br>
                    </div>
                    <div class="col-1">
                        <label> </label>
                    </div>
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Días de Vigencia:</label> 
                    </div>
                    <div class="col-2" style="text-align:right" contenteditable="true">       
                        <label id="plazo_vigencia"></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>IVA</label> 
                    </div>
                    <div class="col-1" style="text-align:right" contenteditable="true">       
                        <label id="moneda_poliza_iva">$</label>
                        <br>
                    </div>
                    <div class="col-2" contenteditable="true">       
                        <label id="total_iva">iva</label>
                        <br>
                    </div>
                    <div class="col-1">
                        <label> </label>
                    </div>
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Vigencia Inicial:</label> 
                    </div>
                    <div class="col-2" style="text-align:right" contenteditable="true">       
                        <label id="vigencia_inicial"></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Prima Bruta Total Periodo Vigencia:</label> 
                    </div>
                    <div class="col-1" style="text-align:right" contenteditable="true">       
                        <label id="moneda_poliza_PT">$</label>
                        <br>
                    </div>
                    <div class="col-2" contenteditable="true">       
                        <label id="total_prima_periodo">prima</label>
                        <br>
                    </div>
                    <div class="col-1">
                        <label> </label>
                    </div>
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Vigencia Final:</label> 
                    </div>
                    <div class="col-2" style="text-align:right" contenteditable="true">       
                        <label id="vigencia_final"></label>
                        <br>
                    </div>
                </div>
            </div>
        <div class="col-1"></div>
    </div>

<!--FORMA DE PAGO -->
 <div class="row" >
        <div class="col-1"></div>
        <div class="col" style="background-color:lightgrey;border-style :solid; border-color: grey; border-width: 1px; border-top-width:0px; border-right-width: 2px;border-left-width: 2px; "> <b>FORMA DE PAGO</b></div>
        <div class="col-1"></div>
 </div>
 <div class="row" >
        <div class="col-1"></div>
            <div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Medio de Pago: </label> 
                    </div>
                    <div class="col-1" style="text-align:right" contenteditable="true">       
                        <label id="modo_pago"></label>
                        <br>
                    </div>
                    <div class="col-3"></div>
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Cantidad de Cuotas:</label> 
                    </div>
                    <div class="col-2" style="text-align:right" contenteditable="true">       
                        <label id="cuotas"></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;padding-top: 6px;padding-bottom: 5px">
                        <label>Día de Pago:</label> 
                    </div>
                    <div class="col-3" style="text-align:left"contenteditable="true">       
                        <input type="text" placeholder="Día de pago" class="form-inline" name="dia_pago" id="dia_pago">
                        <br>
                    </div>
                    
                    <div class="col-1">
                        <label> </label>
                    </div>
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Valor de Cada cuota:</label> 
                    </div>
                    <div class="col-1" style="text-align:right" contenteditable="true">       
                        <label id="moneda_cuota"></label>
                        <br>
                    </div>
                    <div class="col-1" style="text-align:right" contenteditable="true">       
                        <label id="valorcuota"></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Fecha 1er Vencimiento:</label> 
                    </div>
                    <div class="col-2" contenteditable="true">       
                        <label id="fechaprimer"></label>
                        <br>
                    </div>
                </div>
            </div>
        <div class="col-1"></div>
    </div>
    <div class="row" >
        <div class="col-1"></div>
            <div class="col" style="border-style:solid; border-color: grey; border-width: 1px; border-top-width:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >
            </div>
        <div class="col-1"></div>    
    </div>
</section>
<!--FORMA DE PAGO -->
    <div class="row" >
        <div class="col-1"></div>
        <div class="col" style="background-color:lightgrey;border-style :solid; border-color: grey; border-width: 1px; border-top-width:0px; border-right-width: 2px;border-left-width: 2px; "> <b>ITEMS Y CONDICIONES PARTICULARES</b></div>
        <div class="col-1"></div>
    </div>
    <div id=info_item[1]></div> 
    <div id=info_item[2]></div> 
    <div id=info_item[3]></div> 
    <div id=info_item[4]></div> 
    <div id=info_item[5]></div> 
    <div id=info_item[6]></div> 
    <div id=info_item[7]></div> 
    <div id=info_item[8]></div> 
    <div id=info_item[9]></div> 
    <div id=info_item[10]></div> 
    <div id=info_item[11]></div> 
    <div id=info_item[12]></div> 
    <div id=info_item[13]></div> 
    <div id=info_item[14]></div>
    <div id=info_item[15]></div> 
    <div id=info_item[16]></div> 
    <div id=info_item[17]></div> 
    <div id=info_item[18]></div> 
    <div id=info_item[19]></div> 
    <div id=info_item[20]></div> 
    <div id=info_item[21]></div> 
    
    <div class="row" >
        <div class="col-1"></div>
        <div class="col" style="background-color:lightgrey;border-style :solid; border-color: grey; border-width: 1px; border-top-width:0px; border-right-width: 2px;border-left-width: 2px;"> <b>COMENTARIOS </b></div>
        <div class="col-1"></div>
        
</div>
 <div class="row" >
        <div class="col-1"></div>
        
        <div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 1px; border-top-width:0px; border-right-width: 2px;border-left-width: 2px;padding-right:0"> 
        
        <div style = "display:flex;width:100%;">
            <div style="background-color:#f5f5f5; border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;width:250px;">
                <label>Comentarios Externos: </label> 
        </div>
        <div style="background-color:#fff; border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;width:100%;">
            <label id="comentarios_ext" style="text-align:justify;padding:0 10px 10px 10px" contenteditable="true"></label>
        <br>
        </div>
        </div>
        </div>
        <div class="col-1"></div>
        
</div>


</div>

    


 <br>
 <br>
    
</body>

</hmtl>

<script>
 function makePDF() {
        
      //  chaobordes();
          NoButton();
          NoBorder();
        
        html2canvas(document.querySelector("#capture"),{
            allowTaint:true,
            useCORS: true,
            scale: 1
        }).then(canvas => {document.body.appendChild(canvas)
          var imgData = canvas.toDataURL('image/png');
          var imgWidth = 210; 
          var pageHeight = 295;  
          var imgHeight = canvas.height * imgWidth / canvas.width;
          var heightLeft = imgHeight;
          var doc = new jsPDF('p', 'mm', 'a4');
          var position = 0;
          doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
          heightLeft -= pageHeight;

          while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            doc.addPage();
            doc.addImage(imgData, 'IMG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
          }
          doc.save('<?php echo $nro_propuesta; ?>.pdf');
          NoContainer();
          $.redirect('/bamboo/backend/propuesta_polizas/crea_propuesta_polizas.php', {
                'numero_propuesta': '<?php echo $nro_propuesta; ?>',
                'accion':'envio_propuesta'
            }, 'post');
    });
    }
document.addEventListener("DOMContentLoaded", function(event) {
if ('<?php echo $poliza_renovada; ?>'!==''){
    document.getElementById("titulo_renovacion").innerHTML = "<b>Renueva póliza nro: <?php echo $poliza_renovada; ?></b>";
    document.getElementById("renovacion").style.display="flex";
}
    
    document.getElementById("numero_items").innerHTML = '<?php echo $nro_items; ?>';
    var contador= parseInt(document.getElementById("numero_items").innerHTML);
       //console.log(contador);
    for (var i = 1; i <= contador; i++)
    {
        
      
       // console.log(i);
        
        var texto_item='<div class="row" >'+
            '<div class="col-1"></div>'+
            '<div class="col" style="background-color:lightgrey;border-style :solid; border-color: grey; border-width: 1px; border-top-width:0px; border-right-width: 2px;border-left-width: 2px; "> <b> - Item '+ i +'</b></div>'+
            '<div class="col-1"></div>'+
        '</div>'+
        '<div class="row" >'+
           '<div class="col-1"></div>'+
                '<div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>RUT:</label>'+ 
                        '</div>'+
                        '<div class="col"contenteditable="true" >'+       
                           '<label id="rut[' + i + ']">rut_asegurado</label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Nombre:</label>'+
                        '</div>'+
                        '<div class="col" contenteditable="true">'+
                            '<label id="nom_asegurado[' + i + ']"></label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Dirección:</label>'+
                        '</div>'+
                        '<div class="col" contenteditable="true">'+       
                            '<label id="direccion_asegurado[' + i + ']">direccion_asegurado</label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;padding-top: 6px;padding-bottom: 5px" >'+
                            '<label>Comuna:</label>'+ 
                        '</div>'+
                        '<div class="col" contenteditable="true">'+      
                            '<input type="text" placeholder="Ingresar Comuna" class="form-inline" name="comuna_asegurado" id="comuna_asegurado[' + i + ']">'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-1" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+       
                            '<label>Ciudad:</label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col" contenteditable="true">'+      
                            '<input type="text" placeholder="Ingresar Ciudad" class="form-inline" name="ciudad_asegurado" id="ciudad_asegurado[' + i + ']">'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-1" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+       
                            '<label>Región:</label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col" contenteditable="true">'+      
                            '<input type="text" placeholder="Ingresar Región" class="form-inline" name="region_asegurado" id="region_asegurado[' + i + ']">'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Teléfono_Asegurado</label>'+
                        '</div>'+
                        '<div class="col-10" contenteditable="true">'+       
                            '<label id="telefono_asegurado[' + i + ']">telefono_asegurado</label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">'+       
                            '<label>E-mail:</label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col" contenteditable="true">'+       
                            '<label id="mail_asegurado[' + i + ']">mail_asegurado</label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '<div class="col-1"></div>'+
        '</div>'+
        '<div class="row" >'+
            '<div class="col-1"></div>'+
                '<div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >'+
                    '<div class= "row align-items-center">'+
                        '<div class="col" style="background-color:#f5f5f5; border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">'+
                            '<label>Materia Asegurada:</label> '+
                        '</div>'+

                        '<div class="col" contenteditable="true">'+       
                            '<label id="detalle_materia[' + i + ']">detalle_materia</label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '<div class="col-1"></div>'+
        '</div>'+
        '<div class="row" >'+
            '<div class="col-1"></div>'+
                '<div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >'+
                    '<div class= "row align-items-center">'+
                        '<div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Patente o Ubicación del Riesgo:</label> '+
                        '</div>'+
                        '<div class="col" contenteditable="true">'+       
                            '<label id="ubicacion_riesgo[' + i + ']">ubicacion_riesgo</label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '<div class="col-1"></div>'+
        '</div>'+
        '<div class="row" >'+
            '<div class="col-1"></div>'+
                '<div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >'+
                    '<div class= "row align-items-center">'+
                        '<div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Coberturas:</label> '+
                        '</div>'+
                        '<div class="col" contenteditable="true">'+       
                            '<label id="cobertura[' + i + ']">cobertura</label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '<div class="col-1"></div>'+
        '</div>'+
        '<div class="row" >'+
            '<div class="col-1"></div>'+
                '<div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >'+
                    '<div class= "row align-items-center">'+
                        '<div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Deducible:</label> '+
                        '</div>'+
                        '<div class="col" contenteditable="true">'+       
                            '<label id="deducible[' + i + ']">deducible</label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '<div class="col-1"></div>'+
        '</div>'+
        '<div class="row" >'+
            '<div class="col-1"></div>'+
                '<div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Monto Asegurado:</label> '+
                        '</div>'+
                        '<div class="col-1" style="text-align:right" contenteditable="true">'+       
                            '<label id="moneda_monto[' + i + ']"></label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-2" contenteditable="true">'+      
                            '<label id="monto_asegurado[' + i + ']">monto asegurado</label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-1">'+
                            '<label> </label>'+
                        '</div>'+
                        '<div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Tasa Afecta %:</label> '+
                        '</div>'+
                        '<div class="col-1" style="text-align:right" contenteditable="true">'+   
                            '<label id="tasa_afecta[' + i + ']">tasa_afecta</label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;"><label> </label></div>'+
                        '<div class="col-4"></div>'+
                        '<div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Tasa Exenta %:</label> '+
                        '</div>'+
                        '<div class="col-1" style="text-align:right" contenteditable="true">'+
                            '<label id="tasa_exenta[' + i + ']">tasa_exenta</label>'+
                            '<br>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '<div class="col-1"></div>'+
        '</div>'+
        '<div class="row" >'+
            '<div class="col-1"></div>'+
                '<div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Prima Neta Afecta:</label> '+
                        '</div>'+
                        '<div class="col-1" style="text-align:right" contenteditable="true">'+       
                            '<label id="moneda_prima_neta[' + i + ']">moneda</label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-2" contenteditable="true">'+       
                            '<label id="prima_neta_afecta[' + i + ']"></label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-1">'+
                            '<label> </label>'+
                        '</div>'+
                    '</div>'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Prima Neta Exenta:</label> '+
                        '</div>'+
                        '<div class="col-1" style="text-align:right" contenteditable="true">'+       
                            '<label id="prima_neta_exenta[' + i + ']">moneda</label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-2" contenteditable="true">'+       
                        '<label id="prima_exenta[' + i + ']"></label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-5">'+
                            '<label> </label>'+
                        '</div>'+
                    '</div>'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>IVA:</label> '+
                        '</div>'+
                        '<div class="col-1" style="text-align:right" contenteditable="true">'+       
                            '<label id="moneda_iva[' + i + ']"></label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-2" contenteditable="true">'+       
                            '<label id="prima_afecta_iva[' + i + ']">iva_item</label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-5">'+
                            '<label> </label>'+
                        '</div>'+
                    '</div>'+
                    '<div class= "row align-items-center">'+
                        '<div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;" >'+
                            '<label>Prima Bruta del Periodo Vigencia:</label> '+
                        '</div>'+
                        '<div class="col-1" style="text-align:right" contenteditable="true">'+       
                            '<label id="moneda_prima_iva[' + i + ']"></label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-2" contenteditable="true">'+       
                            '<label id="prima_bruta[' + i + ']"></label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-5">'+
                            '<label> </label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '<div class="col-1"></div>'+
        '</div>'
        
   // console.log("info_item["+i+"]");
        document.getElementById("info_item["+i+"]").innerHTML = texto_item;
    }

//pobla información desde BBDD
    //  console.log('Cargando información');

    document.getElementById("nro_propuesta").innerHTML = '<?php echo $nro_propuesta; ?>';
    document.getElementById("rut_proponente").innerHTML = '<?php echo $rut_completo_prop; ?>';
    document.getElementById("nombre_proponente").innerHTML = '<?php echo $nombre_proponente; ?>';
    document.getElementById("direccion_particular").innerHTML = '<?php echo $direccion_laboral; ?>';
    document.getElementById("telefono").innerHTML = '<?php echo $telefono; ?>';
    document.getElementById("correo").innerHTML = '<?php echo $correo; ?>';
    
    document.getElementById("fechaprop").innerHTML = '<?php echo $fechaprop; ?>';
    document.getElementById("compania").innerHTML = '<?php echo $selcompania; ?>';
    document.getElementById("ramo").innerHTML = '<?php echo $ramo; ?>';
    document.getElementById("moneda_poliza").innerHTML = '<?php echo $moneda_poliza; ?>';
    document.getElementById("moneda_poliza_PT").innerHTML = '<?php echo $moneda_poliza; ?>';
    document.getElementById("moneda_poliza_PN").innerHTML = '<?php echo $moneda_poliza; ?>';
    document.getElementById("moneda_poliza_MTA").innerHTML = '<?php echo $moneda_poliza; ?>';    
    
    document.getElementById("moneda_poliza_PE").innerHTML = '<?php echo $moneda_poliza; ?>';
        document.getElementById("moneda_poliza_iva").innerHTML = '<?php echo $moneda_poliza; ?>';
    
    document.getElementById("vigencia_inicial").innerHTML = '<?php echo $fechainicio; ?>';
    document.getElementById("vigencia_final").innerHTML = '<?php echo $fechavenc; ?>';
    document.getElementById("plazo_vigencia").innerHTML = '<?php echo $plazo_vigencia; ?>';

    
    document.getElementById("modo_pago").innerHTML = '<?php echo $modo_pago; ?>';
    if ('<?php echo $cuotas; ?>'==''){
        document.getElementById("cuotas").innerHTML=1;
    } else{
    document.getElementById("cuotas").innerHTML = '<?php echo $cuotas; ?>';}
    document.getElementById("moneda_cuota").innerHTML = '<?php echo $moneda_cuota; ?>';
    document.getElementById("valorcuota").innerHTML = '<?php echo $valorcuota; ?>';
    document.getElementById("fechaprimer").innerHTML = '<?php echo $fechaprimer; ?>';
    //document.getElementById("dia_pago").innerHTML = '< ?php echo $dia_pago; ?>';
    document.getElementById("total_prima_neta").innerHTML = "<?php echo number_format(array_sum($prima_afecta), 2, ",", "."); ?>";
    document.getElementById("total_prima_exenta").innerHTML = "<?php echo number_format(array_sum($prima_exenta), 2, ",", "."); ?>";
    document.getElementById("total_iva").innerHTML = "<?php echo number_format(array_sum($prima_afecta)*0.19, 2, ",", "."); ?>"
    document.getElementById("total_prima_periodo").innerHTML = "<?php echo number_format(array_sum($prima_afecta)*1.19+array_sum($prima_exenta), 2, ",", "."); ?>";
    

    
    //agregar ítems 
    var contador=1;
    var rut_completo_aseg=<?php echo json_encode($rut_completo_aseg); ?>;
    var nombre_asegurado=<?php echo json_encode($nombre_proponente_asegurado); ?>;
    var direccion_personal_asegurado=<?php echo json_encode($direccion_laboral_asegurado); ?>;
    //var comuna
    //var region
    var telefono_asegurado=<?php echo json_encode($telefono_asegurado); ?>;
    var correo_asegurado=<?php echo json_encode($correo_asegurado); ?>;
    var materia=<?php echo json_encode($materia); ?>;
    var detalle_materia=<?php echo json_encode($detalle_materia); ?>;
    var cobertura=<?php echo json_encode($cobertura); ?>;
    var deducible=<?php echo json_encode($deducible); ?>;
    var monto_aseg=<?php echo json_encode($monto_aseg); ?>;
    var tasa_afecta=<?php echo json_encode($tasa_afecta); ?>;
    var tasa_exenta=<?php echo json_encode($tasa_exenta); ?>;
    var prima_afecta=<?php echo json_encode($prima_afecta); ?>;
    var prima_exenta=<?php echo json_encode($prima_exenta); ?>;
    var prima_bruta=<?php echo json_encode($prima_bruta); ?>;
    var comentarios_ext=<?php echo json_encode($comentarios_ext); ?>;
    var prima_afecta_iva=<?php echo json_encode($prima_afecta_iva); ?>;
    var porcentaje_comision=<?php echo json_encode($porcentaje_comision); ?>;
    
    
   
    
    //validación inicial de cantidad de ítems 
    if('<?php echo $nro_items; ?>'=='1'){ 
        
        document.getElementById("monto_asegurado").innerHTML = '<?php echo $monto_aseg[0]; ?>';
    } 
    else {
        document.getElementById("monto_asegurado").innerHTML ='<?php echo array_sum($monto_aseg); ?>';
    }
    
    document.getElementById("comision_corredor").innerHTML = '<?php echo $porcentaje_comision; ?>';
    
    while (contador<='<?php echo $nro_items; ?>'){
        document.getElementById("rut["+contador.toString()+"]").innerHTML = rut_completo_aseg[contador.toString()-1];  
        document.getElementById("nom_asegurado["+contador.toString()+"]").innerHTML = nombre_asegurado[contador.toString()-1];
        
        document.getElementById("direccion_asegurado["+contador.toString()+"]").innerHTML = direccion_laboral_asegurado[contador.toString()-1]


       
        document.getElementById("telefono_asegurado["+contador.toString()+"]").innerHTML = telefono_asegurado[contador.toString()-1]
        document.getElementById("mail_asegurado["+contador.toString()+"]").innerHTML = correo_asegurado[contador.toString()-1]
        document.getElementById("detalle_materia["+contador.toString()+"]").innerHTML = materia[contador.toString()-1];
        document.getElementById("ubicacion_riesgo["+contador.toString()+"]").innerHTML = detalle_materia[contador.toString()-1];
        document.getElementById("cobertura["+contador.toString()+"]").innerHTML = cobertura[contador.toString()-1];
        document.getElementById("deducible["+contador.toString()+"]").innerHTML = deducible[contador.toString()-1];
        document.getElementById("moneda_monto["+contador.toString()+"]").innerHTML  ='<?php echo $moneda_poliza; ?>';
        document.getElementById("moneda_iva["+contador.toString()+"]").innerHTML  ='<?php echo $moneda_poliza; ?>';
        document.getElementById("moneda_prima_neta["+contador.toString()+"]").innerHTML  ='<?php echo $moneda_poliza; ?>';
        document.getElementById("prima_neta_exenta["+contador.toString()+"]").innerHTML  ='<?php echo $moneda_poliza; ?>';
        document.getElementById("moneda_prima_iva["+contador.toString()+"]").innerHTML  ='<?php echo $moneda_poliza; ?>';
        document.getElementById("monto_asegurado["+contador.toString()+"]").innerHTML = monto_aseg[contador.toString()-1];
        document.getElementById("tasa_afecta["+contador.toString()+"]").innerHTML = tasa_afecta[contador.toString()-1];
        document.getElementById("tasa_exenta["+contador.toString()+"]").innerHTML = tasa_exenta[contador.toString()-1];
        document.getElementById("prima_neta_afecta["+contador.toString()+"]").innerHTML = prima_afecta[contador.toString()-1];
        document.getElementById("prima_exenta["+contador.toString()+"]").innerHTML = prima_exenta[contador.toString()-1];
        document.getElementById("prima_bruta["+contador.toString()+"]").innerHTML = prima_bruta[contador.toString()-1];
        document.getElementById("comentarios_ext").innerHTML = '<?php echo $comentarios_ext; ?>';
        document.getElementById("prima_afecta_iva["+contador.toString()+"]").innerHTML = prima_afecta_iva[contador.toString()-1];
        
       // document.getElementById("Prima_con_IVA_vigencia["+contador.toString()+"]").innerHTML = wtf[contador.toString()-1];
     
        contador+=1;
    }
});

   
    var nro_items = <?php echo json_encode($nro_items); ?>;
    //console.log(nro_items);
    
    window.hmtl2canvas = html2canvas;
    window.jsPDF = window.jspdf.jsPDF;
    
    
    var idarr = [];
    for (var i = 1; i < nro_items+1 ; i++) {
      //  idarr.push(`comuna_asegurado[${i}] required=`);
    //    idarr.push(`ciudad_asegurado[${i}] required=`);
      //  idarr.push(`region_asegurado[${i}] required=`);
        idarr.push(`comuna_asegurado[${i}]`);
        idarr.push(`ciudad_asegurado[${i}]`);
        idarr.push(`region_asegurado[${i}]`);
    };

    
    var id=[ "comuna" ,
    "ciudad" ,
    "region" , "dia_pago"];

    var resultado = id.concat(idarr);
    
    //console.log(resultado);
    
    function NoBorderScript(){
        document.getElementById("region_asegurado").style.border="none"
    }

    function NoBorder(){
        
        for(var i = 0; i < resultado.length ; i++){
            try{
             //console.log(resultado[i])
             document.getElementById(resultado[i]).style.border="none"
             if (document.getElementById(resultado[i]).innerHTML=='')
             {
                 document.getElementById(resultado[i]).placeholder=''
             }
            
        }
        catch{console.log("ocurrio un error")}    
        }
    }
    
    function NoContainer(){
        document.getElementById("capture").style.display="none";
        
    }
    
    function NoButton(){
        
        document.getElementById("BotonPDF").style.display="none";
    }

</script>