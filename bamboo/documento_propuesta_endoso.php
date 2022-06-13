<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}


//$_SERVER[ "REQUEST_METHOD" ] = "POST";
//$_POST["accion"] = 'generar_documento';
//$_POST["numero_propuesta"]='E000012';

    if ($_SERVER[ "REQUEST_METHOD" ] == "POST" and $_POST["accion"] == 'generar_documento')
    {
    
      require_once "/home/gestio10/public_html/backend/config.php";
      mysqli_set_charset( $link, 'utf8' );
      mysqli_select_db( $link, 'gestio10_asesori1_bamboo' );
      $query = "select a.numero_poliza as numero_poliza,a.descripcion_endoso, numero_propuesta_endoso as numero_propuesta,moneda_poliza_endoso, a.compania, a.ramo, a.rut_proponente, a.dv_proponente, b.nombre_cliente, b.telefono, b.correo, b.direccion_personal, b.direccion_laboral,DATE_FORMAT(fecha_ingreso_endoso,'%d-%m-%Y') as fecha_propuesta , DATE_FORMAT(vigencia_inicial,'%d-%m-%Y') as vigencia_inicial, DATE_FORMAT(vigencia_final,'%d-%m-%Y') as vigencia_final, CONCAT(DATEDIFF(vigencia_final,vigencia_inicial),' días') as plazo_vigencia,DATE_FORMAT(fecha_prorroga,'%d-%m-%Y') as fecha_prorroga,  CONCAT_WS(' ',FORMAT(tasa_afecta_endoso, 2, 'de_DE'),'%') as tasa_afecta ,CONCAT_WS(' ',FORMAT(tasa_exenta_endoso, 2, 'de_DE'),'%')as tasa_exenta, CONCAT_WS(' ',FORMAT(prima_neta_afecta, 2, 'de_DE')) as prima_afecta,CONCAT_WS(' ',FORMAT(prima_neta_exenta, 2, 'de_DE')) as prima_exenta, CONCAT_WS(' ',FORMAT(IVA, 2, 'de_DE')) as prima_afecta_iva, CONCAT_WS(' ',FORMAT(prima_total, 2, 'de_DE')) as prima_bruta_anual, a.comentario_endoso, a.debe_decir, a.dice, a.monto_asegurado_endoso, a.tipo_endoso, a.numero_poliza, count(c.id) as numero_items
                from propuesta_endosos as a left join clientes as b on a.rut_proponente=b.rut_sin_dv left join items as c on a.numero_poliza=c.numero_poliza where a.numero_propuesta_endoso='".$_POST["numero_propuesta"]."'";
      $resultado = mysqli_query( $link, $query );
      While( $row = mysqli_fetch_object( $resultado ) ) {
        $comentario_endoso = str_replace( "\r\n", "<br/>", $row->comentario_endoso );
        $debe_decir = str_replace( "\r\n", "<br/>", $row->debe_decir);
        $dice = str_replace( "\r\n", "<br/>", $row->dice);
        $tipo_endoso = $row->tipo_endoso;
        $numero_poliza = $row->numero_poliza;
        $tasa_afecta = $row->tasa_afecta;
        $tasa_exenta = $row->tasa_exenta;
        $fecha_prorroga=$row->fecha_prorroga;
        $prima_afecta = $row->prima_afecta;
        $prima_exenta = $row->prima_exenta;
        $prima_afecta_iva = $row->prima_afecta_iva;
        $prima_bruta = $row->prima_bruta_anual;
        $monto_aseg = $row->monto_asegurado_endoso;
        $numero_poliza = $row -> numero_poliza;
        
        $descripcion_endoso=str_replace( "\r\n", "<br/>", $row->descripcion_endoso);
        $rut_prop = $row->rut_proponente;
        $dv_prop = $row->dv_proponente;
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
        $moneda_poliza = $row->moneda_poliza_endoso;
        $nro_propuesta = $row->numero_propuesta;
        $fechaprop = $row->fecha_propuesta;    



        $nro_items=$row->numero_items;
        
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
                             <p><b>Propuesta de Endoso</b></p>
                        </blockquote>
  
                        </figure>
         </div>
    </div>
                    
                </div>
                 <div class="col-4" style="border-style :solid; border-color: grey; border-width: 2px; border-bottom-width:1px;border-left-width:1px;  ">
                    <div class= "row align-items-center">
                        <div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                                <label>Número de Póliza:</label> 
                        </div>
                         <div class="col" contenteditable="true">       
                                <label id="numero_poliza"></label>
                                <br>
                    </div>
                    </div>
                    <div class= "row align-items-center">
                        <div class="col" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                                <label>Propuesta Endoso:</label> 
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
                        <span id="numero_items" ></span>
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
                        <label>Tasa Afecta</label> 
                    </div>
                    <div class="col-2" style="text-align:right" contenteditable="true">       
                        <label id= "tasa_afecta" ></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Prima Neta Afecta:</label> 
                    </div>
                    <div class="col-1" style="text-align:right" contenteditable="true">       
                        <label id="moneda_poliza_PN"></label>
                        <br>
                    </div>
                    <div class="col-3" contenteditable="true">       
                        <label id="total_prima_neta"></label>
                        <br>
                    </div>
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Tasa Exenta</label> 
                    </div>
                    <div class="col-2" style="text-align:right" contenteditable="true">       
                        <label id= "tasa_exenta" ></label>
                        <br>
                    </div>
                </div>
                <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Prima Neta Exenta:</label> 
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
                        <label>Prima Vigencia con IVA:</label> 
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
                
                 <div class= "row align-items-center">
                    <div class="col-3" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label></label> 
                    </div>
                    <div class="col-1">       
                        
                        
                    </div>
                    <div class="col-2" >       
                        
                       
                    </div>
                    <div class="col-1">
                        <label> </label>
                    </div>
                    <div class="col-2" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Fecha de prorroga:</label> 
                    </div>
                    <div class="col-2" style="text-align:right" contenteditable="true">       
                        <label id="fecha_prorroga"></label>
                        <br>
                    </div>
                </div>
                
            </div>
        <div class="col-1"></div>
    </div>

<!--FORMA DE PAGO -->
 <div class="row" >
        <div class="col-1"></div>
        <div class="col" style="background-color:lightgrey;border-style :solid; border-color: grey; border-width: 1px; border-top-width:0px; border-right-width: 2px;border-left-width: 2px; "> <b>DETALLES DEL ENDOSO</b></div>
        <div class="col-1"></div>
 </div>
 <div class="row" >
        <div class="col-1"></div>
            <div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >
                <div class= "row align-items-center">
                    <div class="col-3 align-self-stretch" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;">
                        <label>Tipo de Endoso: </label> 
                    </div>
                    <div class="col-5 align-self-stretch" style="text-align:left;" contenteditable="true">       
                        <label id="tipo_endoso"></label>
                        <br>
                    </div>
                    
                </div>
                <div class= "row align-items-center align-self-stretch">
                    <div class="col-3 align-self-stretch" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;padding-top: 6px;padding-bottom: 5px;">
                        <label>Descripcion del Endoso:</label> 
                    </div>
                    <div id="descripcion_endoso" class="col-5" style="text-align:left;" contenteditable="true">       
                        
                        <br>
                    </div>
                    
                    <div class="col-1">
                        <label> </label>
                    </div>
                    
                </div>
                
                <div class= "row align-items-center">
                    <div class="col-3 align-self-stretch" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;height: auto;">
                        <label>Dice:</label>
                    </div>
                
                    <div id="dice" class="col-3"style="text-align:left;" contenteditable="true"></div>
                    
                    
                    
                    
                    <div class="col-2 align-self-stretch"   style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;height: auto;">       
                        <label>Debe decir:</label>
                        
                        <br>
                    </div>
                    <div id="debe_decir" class="col-4" style="text-align:left;"contenteditable="true"></div>
                </div>
            </div>
        <div class="col-1"></div>
    </div>
<!--FORMA DE PAGO -->
 <div class="row" >
        <div class="col-1"></div>
        <div class="col" style="background-color:lightgrey;border-style :solid; border-color: grey; border-width: 1px; border-top-width:0px; border-right-width: 2px;border-left-width: 2px; height: auto;"> <b>COMENTARIOS</b></div>
        <div class="col-1"></div>
 </div>
 <div class="row" >
        <div class="col-1"></div>
            <div class="col" style="border-style :solid; border-color: grey; border-width: 2px; border-top:0px; border-right-width: 2px;border-left-width: 2px;border-bottom-width:1px" >
                <div class= "row align-items-center">
                    <div class="col-3 align-self-stretch" style="background-color:#f5f5f5;border-style :solid; border-color: grey; border-width: 0px; border-top-width:0px; border-right-width: 0px;border-left-width: 0px;height: auto;">
                        <label>Comentario endoso: </label> 
                    </div>
                    <div class="col-5 align-self-stretch" style="text-align:left;" contenteditable="true">       
                        <label id="comentario_endoso"></label>
                        <br>
                    </div>
                </div>
            </div>
        <div class="col-1"></div>
    </div>
</section>



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
          doc.save('Propuesta endoso <?php echo $nro_propuesta; ?>.pdf');
          NoContainer();
          $.redirect('/bamboo/listado_propuesta_endosos.php', {
                'busqueda': '<?php echo $nro_propuesta; ?>',
            }, 'post');
    });
    }
document.addEventListener("DOMContentLoaded", function(event) {
//pobla información desde BBDD
    //  console.log('Cargando información');
    document.getElementById("numero_poliza").innerHTML = '<?php echo $numero_poliza; ?>';
    document.getElementById("nro_propuesta").innerHTML = '<?php echo $nro_propuesta; ?>';
    document.getElementById("rut_proponente").innerHTML = '<?php echo $rut_completo_prop; ?>';
    document.getElementById("nombre_proponente").innerHTML = '<?php echo $nombre_proponente; ?>';
    var direccion_laboral ='<?php echo $direccion_laboral; ?>';
    var direccion_personal = '<?php echo $direccion_personal; ?>';    
    console.log(direccion_laboral);
    console.log(direccion_personal);
    if (direccion_laboral == 'NO' && direccion_personal == 'NO'){
    
        document.getElementById("direccion_particular").innerHTML = "<span style='color: red;'>INGRESAR DIRECCIÓN</span>";
    }
    
    else if (direccion_laboral === 'NO'){
        
        console.log("dirección personal")
        document.getElementById("direccion_particular").innerHTML = '<?php echo $direccion_personal; ?>';
    }
    
    else{
        console.log("dirección Laboral")
    document.getElementById("direccion_particular").innerHTML = '<?php echo $direccion_laboral; ?>';
        }  
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

    document.getElementById("numero_items").innerHTML = '<?php echo $nro_items; ?>';

    document.getElementById("total_prima_neta").innerHTML = "<?php echo $prima_afecta; ?>";
    document.getElementById("total_prima_exenta").innerHTML = '<?php echo $prima_exenta; ?>';
    document.getElementById("total_iva").innerHTML = "<?php echo $prima_afecta_iva; ?>"
    document.getElementById("total_prima_periodo").innerHTML = "<?php echo $prima_bruta; ?>";
    document.getElementById("monto_asegurado").innerHTML = "<?php echo $monto_aseg; ?>";
    document.getElementById("fecha_prorroga").innerHTML = "<?php echo $fecha_prorroga; ?>";
    document.getElementById("tipo_endoso").innerHTML = "<?php echo $tipo_endoso; ?>";
    document.getElementById("dice").innerHTML = "<?php echo $dice; ?>";
    document.getElementById("debe_decir").innerHTML = "<?php echo $debe_decir; ?>";
    document.getElementById("descripcion_endoso").innerHTML = '<?php echo $descripcion_endoso; ?>';

    document.getElementById("tasa_afecta").innerHTML = "<?php echo $tasa_afecta; ?>";
    document.getElementById("tasa_exenta").innerHTML = "<?php echo $tasa_exenta; ?>";
    document.getElementById("comentario_endoso").innerHTML = '<?php echo $comentario_endoso; ?>';


    
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
    function NoBorderScript(){
        document.getElementById("region_asegurado").style.border="none"
    }

    
    function NoContainer(){
        document.getElementById("capture").style.display="none";
        
    }
    
    function NoButton(){
        
        document.getElementById("BotonPDF").style.display="none";
    }

</script>