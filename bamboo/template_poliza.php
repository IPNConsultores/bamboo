<?php
 
function estandariza_info($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
require_once "/home/gestio10/public_html/backend/config.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        mysqli_set_charset( $link, 'utf8');
        mysqli_select_db($link, 'gestio10_asesori1_bamboo');
            //poliza
$resultado_template=mysqli_query($link, 'SELECT template FROM template_correos where producto="vehiculo" and instancia="envio_poliza"');
            While($row=mysqli_fetch_object($resultado_template))
                {
                    $template=$row->template;
                }

        // Viene desde póliza
        if(!empty(trim($_POST["id_poliza"]))){
            $busqueda=$_POST["id_poliza"];
            
                $resultado_poliza=mysqli_query($link, 'SELECT fecha_primera_cuota, forma_pago, moneda_poliza, deducible, prima_afecta, prima_exenta, prima_bruta_anual, id, ramo, compania, vigencia_inicial, vigencia_final, numero_poliza, materia_asegurada, patente_ubicacion,cobertura, rut_proponente, rut_asegurado FROM polizas where id='.$busqueda.' order by compania, numero_poliza;');
    
                While($row=mysqli_fetch_object($resultado_poliza))
                    {
                        $moneda_poliza= $row ->moneda_poliza;
                        $deducible= $row ->deducible;
                        $fecha_primera_cuota= $row ->fecha_primera_cuota;
                        $forma_pago= $row ->forma_pago;
                        $prima_bruta_anual= $row ->prima_bruta_anual;
                        $id= $row ->id;
                        $ramo= $row ->ramo;
                        $numero_poliza= $row ->numero_poliza;
                        $compania = $row->compania;
                        $vigencia_final= $row->vigencia_final;
                        $vigencia_inicial= $row->vigencia_inicial;
                        $materia_asegurada= $row->materia_asegurada;
                        $patente_ubicacion = $row->patente_ubicacion;
                        $cobertura = $row->cobertura;
                        $rut_proponente = $row->rut_proponente;
                        $rut_asegurado = $row->rut_asegurado;

                    }     
            
                        $template=str_replace('_[NRO_POLIZA]_',$numero_poliza, $template);
                        $template=str_replace('_[RAMO]_',$ramo, $template);
                        $template=str_replace('_[COMPANIA]_',$compania, $template);
                        $template=str_replace('_[NOMBRE_CLIENTE]_','Felipe Abarca', $template);
                        $template=str_replace('_[VIGENCIA_INICIAL]_',$vigencia_inicial, $template);
                        $template=str_replace('_[VIGENCIA_FINAL]_',$vigencia_final, $template);
                        $template=str_replace('_[COBERTURA]_',$cobertura, $template);
                        $template=str_replace('_[DEDUCIBLE]_',$deducible, $template);
                        $template=str_replace('_[PRIMERA_CUOTA]_',$fecha_primera_cuota, $template);
                        $template=str_replace('_[FORMA_PAGO]_',$forma_pago, $template);
                        $template=str_replace('_[PRIMA_ANUAL]_',$prima_bruta_anual, $template);
                        $template=str_replace('_[VEHICULO]_',$materia_asegurada, $template);


                        $template = str_replace( '_[SALTO_LINEA]_', '<br>', $template );
                        $template = str_replace( '_[NEG_ini]_', '<b>', $template );
                        $template = str_replace( '_[NEG_fin]_', '</b>', $template );
                        $template = str_replace( '_[SUB_ini]_', '<u>', $template );
                        $template = str_replace( '_[SUB_fin]_', '</u>', $template );
                        $template = str_replace( '_[CUR_ini]_', '<em>', $template );
                        $template = str_replace( '_[CUR_fin]_', '</em>', $template );
                        $template = str_replace( '_[LINEA]_', '<hr>', $template );
                        

        mysqli_close($link);
        } 
    }
?>
<!--
<?php
$subject = urlencode('Envío de documentación');
$body = urlencode($template);
$url = htmlspecialchars("https://mail.google.com/mail/?view=cm&fs=1&su=$subject&body=$body");
?>
-->



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Generador de correo - Informar póliza creada</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div id="header">
        <?php include 'header2.php' ?>
    </div>

    <div class="container">
           <div class="row">
                <div class="col-4">
                    <label><b>Instancia</b></label>
                    <select class="form-control" name="instancia" id="instancia">
                        <option value="envio_poliza" <?php if ($instancia == "envio_poliza") echo "selected" ?>>Informar póliza</option>
                        <option value="renovacion" <?php if ($instancia == "renovacion") echo "selected" ?> >Renovación</option>
                        <option value="otro" <?php if ($instancia == "otro") echo "selected" ?> >Otro</option>
                    </select>
                </div>
                  <div class="col" style="align-self:flex-end">
                    <button class="btn" type="submit"
                        style="background-color: #536656; color: white; height: 45; align-self: center">Buscar
                        template</button>
                </div>
        </form>
    </div>
        
      <br>
        <div name='correo'>
		<div class=col>
				<h6>Resultado</h6>
            <div id="template_correo" class="form-control bg-light text-dark" rows="10"
                style="height: 400px; border-style: solid;overflow-y: scroll"><?php echo $template; ?>
            </div>
			<br>
        
                    <a class="btn" type="submit"
                        style="background-color: #536656; color: white; height: 45; align-self: center;" 
					   target="_blank" onClick="mail()">Enviar mail</a>
                
			
        </div>
			<br>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
     <script src="/assets/js/jquery.redirect.js"></script>
	
	<script>
	
	function mail() {
		var a = document.getElementById("template_correo")
		var b = document.getElementById("template_correo")
		var body2 = ''
		var body3 = ''
		a.innerHTML = body2;
		b.innerHTML = body3;
		alert(a.innerHTML);
		alert(b.innerHTML);
		window.open('https://mail.google.com/mail/?view=cm&fs=1&su=prueba&body='<?php echo $template; ?>);
		window.open('https://mail.google.com/mail/?view=cm&fs=1&su=prueba&body='+body3);	
	}
	
	</script>
	
</body>
</html>