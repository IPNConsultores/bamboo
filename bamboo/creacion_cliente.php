<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

      
    require_once "/home/gestio10/public_html/backend/config.php";
    mysqli_set_charset( $link, 'utf8' );
    mysqli_select_db( $link, 'gestio10_asesori1_bamboo' );
 $contador_contactos=0;
    $cant_contactos = 0;
$camino='';
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" and isset( $_POST[ "id_cliente" ] ) == true ) {
  $contactos_array=array();
  $rut=$nombre_cliente=$correo=$direccionl=$id=$direccionp=$telefono=$fecha_ingreso=$referido=$grupo='';
    $camino='modificar';
	$idcliente=$_POST["id_cliente"];
   $sql = "SELECT id,CONCAT_WS( '-',rut_sin_dv,dv) as rut, nombre_cliente , correo, direccion_laboral, direccion_personal, id, telefono, fecha_ingreso, referido, grupo FROM clientes Where id =".$idcliente.";";

    $resultado=mysqli_query($link, $sql);
    $codigo='{
      "data": [';
    $conta=0;
  While($row=mysqli_fetch_object($resultado))
  {     $conta=$conta+1;
   		$id=$row->id;
        $rut= $row->rut;
        $nombre_cliente= $row->nombre_cliente;
        $correo = $row->correo;
        $direccionl = $row->direccion_laboral;
        $direccionp = $row->direccion_personal;
        $telefono = $row->telefono;
        $fecha_ingreso = $row ->fecha_ingreso;
        $referido = $row->referido;
        $grupo = $grupo->grupo;
  
    $resultado_contador_contactos=mysqli_query($link, "SELECT count(*) as contador FROM clientes_contactos where id_cliente='".$row->id."';");
    while ($fila=mysqli_fetch_object($resultado_contador_contactos))
    {
        $contador_contactos=0;
      $cant_contactos=$fila->contador;
      $resultado_contactos=mysqli_query($link, "SELECT  nombre, telefono, correo FROM clientes_contactos where id_cliente='".$row->id."';");
        $contactos_array=array("contactos"=>& $fila->contador);
        if (!$cant_contactos=="0"){
      while($indice=mysqli_fetch_object($resultado_contactos)){
          $contador_contactos=$contador_contactos+1;
          $contactos_array=array_merge($contactos_array, array(
              "nombre".$contador_contactos =>& $indice->nombre,
              "telefono".$contador_contactos =>& $indice->telefono,
              "correo".$contador_contactos =>& $indice->correo 
              ));
      }}
      
    }
        if ($conta==1){
      $codigo.= json_encode(array_merge(array(
        "id" =>& $row->id,
        "nombre"=>& $row->nombre_cliente,
        "correo_electronico" =>& $row->correo,
        "direccionl" =>& $row->direccion_laboral,
        "direccionp" =>& $row->direccion_personal,
        "telefono" =>& $row->telefono,
        "fecingreso" =>& $row->fecha_ingreso,
        "referido" =>& $row->referido,
        "grupo" =>& $row->grupo,
        "rut" =>& $row->rut), 
        $contactos_array));
    } else {
    $codigo.= ', '.json_encode(array_merge(array(
      "id" =>& $row->id,
      "nombre"=>& $row->nombre_cliente,
      "correo_electronico" =>& $row->correo,
      "direccionl" =>& $row->direccion_laboral,
      "direccionp" =>& $row->direccion_personal,
      "telefono" =>& $row->telefono,
      "fecingreso" =>& $row->fecha_ingreso,
      "referido" =>& $row->referido,
      "grupo" =>& $row->grupo,
      "rut" =>& $row->rut), 
        $contactos_array)
    );}
  }
  $codigo.=']}';
    

      
  
}
?>

<!DOCTYPE html>
<html lang="es">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="/bamboo/images/bamboo.png">
<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>


<!-- body code goes here "/bamboo/backend/clientes/crea_cliente.php"-->
<div id="header">
<?php include 'header.php' ?>
</div>
<div class="container">
  <p>Clientes / Creación<br>
  </p>
  <form action="/bamboo/backend/clientes/crea_cliente.php" class="needs-validation" method="POST" id="formulario"novalidate>
    <h5 class="form-row">&nbsp;Datos personales</h5>
    <br>
    <div class="form-row">
      <div class="col">
        <label for="Nombre"> Nombre</label><label style= "color: darkred">*</label>
        
        <input type="text" class="form-control" name="nombre"  id="nombre" required>
		 <input type="text" class="form-control" name="id"  id="id" style="display: none">
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      
       
      
      <div class="col-md-4 mb-3" style="display : none">
        <label for="ApellidoP">Apellido Paterno</label>
        <label style= "color: darkred">*</label>
        <input type="text" class="form-control" name="apellidop" id="apellidop">
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3" style="display : none">
        <label for="ApellidoM">Apellido Materno</label>
        <label style= "color: darkred">*</label>
        <input type="text" class="form-control" name="apellidom" id="apellidom">
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="form-row">
          <div class="col-md-8 mb-3 col-lg-12">
            <label for="RUT">RUT</label>
            <label style= "color: darkred">*</label>
            <input type="text" class="form-control" id="rut" name="rut" id="rut" placeholder="1111111-1"
                                oninput="checkRut(this)" onchange="valida_rut_duplicado()" required>
			  <input type="text" class="form-control" name="rut2"  id="rut2" style="display: none">
            <div class="invalid-feedback">Dígito verificador no válido. Verifica rut ingresado</div>
          </div>
        </div>
      </div>
       </div>
       <div class="form-row">
      <div class="col-md-4 mb-3">
        <label for="validationCustomUsername">E-mail</label>
        <label style= "color: darkred">*</label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text" id="mail">@</span></div>
          <input type="email" class="form-control" name="correo_electronico" id="correo" required>
          <div class="invalid-feedback">Campo en blanco o sin formato mail (aaa@bbb.xxx)</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustomUsername">Telefono</label>
        <label style= "color: darkred">*</label>
        <div class="input-group">
          <input type="text" class="form-control" name="telefono" id="telefono" placeholder="56 9 XXXX XXXX" required>
          <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="Dirección">Dirección Principal</label>
                <input type="text" class="form-control" name="direccionp" id="direccionp">
        
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustomUsername">Dirección Secundaria</label>
        <div class="input-group">
          <input type="text" class="form-control" name="direccionl" id="direccionl">
          
        </div>
      </div>
     
      <div class="col-md-4 mb-3">
          <label for="grupo">Grupo</label>
          <input type="text" class="form-control" name="grupo" id="grupo">
        </div>
        <div class="col-md-4 mb-3">
          <label for="referido">Referido</label>
          <input type="text" class="form-control" name="referido" id="referido">
        </div>
        
       </div>
      
   
	  <br>
      <br>
    <div class="form-row"></div>
    <div class="form-check form-check-inline">
      <label class="form-check-label" style="padding-left:5em">¿Quieres asociar algún contacto a este cliente nuevo?:&nbsp;&nbsp;</label>
      <input class="form-check-input" type="radio" name="no_contacto" id="radio_no" value="sin_contacto"
                    onclick="checkRadio(this.name)" checked="checked">
      <label class="form-check-label" for="inlineRadio1">No&nbsp;</label>
      <input class="form-check-input" type="radio" name="si_contacto" id="radio_si" value="con_contacto"
                    onclick="checkRadio(this.name)">
      <label class="form-check-label" for="inlineRadio2">Si</label>
    </div>
    <div id="info_contactos" style="display: none;"><br>
      <br>
      <br>
      <h5 class="form-row">&nbsp;Información de Contacto</h5>
      <br>
      <div class="form-row">
        <div class="container" id="main">
          <input type="button" id="btAdd" value="Añadir" class="btn"
                            style="background-color: #536656; color: white" />
          <input type="button" id="btRemove" value="Eliminar" class="btn"
                            style="background-color: #536656; color: white" />
          <br>
          <br>
          <div class="container-md">
            <table class="table" id="mytable">
              <tr>
                <th>Nombre Contacto</th>
                <th>Telefono</th>
                <th>E-mail</th>
              </tr>
            </table>
            <br>
          </div>
        </div>
      </div>
    </div>
    <div id="auxiliar" style="display: none;">
      <input name="contactos" id="contactos">
	  <input name="nombrecontact[]" id="nombrecontact">
	  <input name="telefonocontact[]" id="telefonocontact">
	 <input name="correocontact[]" id="correocontact">		
    </div>
    <br>
    <hr>
    <button class="btn" type="submit" style="background-color: #536656; color: white" id="boton_submit">Registrar</button>
  </form>
  
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
<script src="/assets/js/jquery.redirect.js"></script>
<script src="/assets/js/validarRUT.js"></script>
<script src="/assets/js/bootstrap-notify.js"></script>
<script src="/assets/js/bootstrap-notify.min.js"></script>


</body>
</html>
<script>
function valida_rut_duplicado() {
    if (document.getElementById("rut").checkValidity() == true) {
        var dato = $('#rut').val();
        var rut_sin_dv = dato.replace('-', '');
        rut_sin_dv = rut_sin_dv.slice(0, -1);
        $.ajax({
            type: "POST",
            url: "/bamboo/backend/clientes/clientes_duplicados.php",
            data: {
                rut: rut_sin_dv
            },
            dataType: 'JSON',
            success: function(response) {

                if (response.resultado == 'duplicado') {
                    var r = confirm(
                        "El rut que acabas de ingresar ya se encuentra en la base de datos. ¿Deseas ver la información asociada al rut?"
                    );
                    if (r == true) {
                        $.redirect('/bamboo/listado_clientes.php', {
                            'busqueda': rut_sin_dv
                        }, 'post');

                    } else {
                        location.href =
                            "http://gestionipn.cl/bamboo/creacion_cliente.php";
                        $.notify({
                            // options
                            message: 'Se han limpiado los valores del formulario'
                        }, {
                            // settings
                            type: 'info'
                        });
                    }
                }

            }

        });
    }

}

function alerta() {
    $.notify({
        // options
        message: 'Cliente creado con éxito'
    }, {
        // settings
        type: 'success'
    });
}
$(document).ready(function() {
      
    var iCnt = 0;
    var rut = document.getElementById("rut").value;
    if( rut !=="")
    {
         iCnt = <?php echo $cant_contactos; ?>;
        
    }
    else{
     iCnt = 0;
}
    // Crear un elemento div añadiendo estilos CSS
    var container = $(document.createElement('div')).css({
        padding: '10px',
        margin: '20px',
        width: '340px',
    });

    $('#btAdd').click(function() {
        if (iCnt <= 4) {

            iCnt = iCnt + 1;

            // Añadir caja de texto.

            if (iCnt == 1) {
                var divSubmit = $(document.createElement('div'));
                //                    $(divSubmit).append('<input type=button class="bt" onclick="GetTextValue()"' + 
                //                            'id=btSubmit value=Enviar />');

            }
            var newElement = '<tr id =registro' + iCnt +
                '><td><input class="form-control" type="text" value="" id="nombrecontact[]" name="nombrecontact[]"'+
                ' required/></td><td><input class="form-control" type="text" value="" id="telefonocontact[]" name="telefonocontact[]"'+
                ' placeholder="56 9 XXXX XXXX" required /></td><td><input class="form-control" type="email" value="" id="emailcontact[]" name="emailcontact[]"'+
                ' placeholder="aaa@bbb.com" required /></td></tr>';
            $("#mytable").append($(newElement));

            $('#main').after(container, divSubmit);
        } else { //se establece un limite para añadir elementos, 5 es el limite
            iCnt = iCnt + 1;

            $("#mytable").append('<label id=label>Limite Alcanzado</label> ');
            $('#btAdd').attr('class', 'btn');
            $('#btAdd').attr('disabled', 'disabled');

        }
    });

    $('#btRemove').click(function() { // Elimina un elemento por click

        if (iCnt != 0) {
           
            $('#btAdd').removeAttr('disabled');
            $('#registro' + iCnt).remove();
             iCnt = iCnt - 1;
        if (iCnt == 5) {
            $('#label').remove();
            
        }
        }
        if (iCnt == 0) {
            
            
            $('#mytable').remove();
            $(container).remove();
            //                $('#btSubmit').remove(); 
            $('#btAdd').removeAttr('disabled');
            $('#btAdd').attr('class', 'btn')

            var newElement2 =
                '<table class="table" id="mytable"><tr><th>Nombre Contacto</th><th>Telefono</th><th>E-mail</th></tr></table>';
            $("#main").append($(newElement2));
            $("#mytable").append($(newElement));
        }
    });


});

function envio_contactos(boton) {
    document.getElementById("contactos").value = iCnt;
}

function checkRadio(name) {
    if (name == "si_contacto") {
        document.getElementById("radio_si").checked = true;
        document.getElementById("radio_no").checked = false;
        document.getElementById("info_contactos").style.display = "inline";

    } else if (name == "no_contacto") {
        document.getElementById("radio_no").checked = true;
        document.getElementById("radio_si").checked = false;
        document.getElementById("info_contactos").style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function() {
      
  var camino = '<?php echo $camino; ?>';
  if (camino=='modificar'){
      var cant_contact = <?php echo intval($cant_contactos); ?>;
      var info_contact = <?php echo json_encode($contactos_array);?>;
      
      
       if( cant_contact !== 0){
          
        document.getElementById("radio_si").checked = true;
        document.getElementById("radio_no").checked = false;
        document.getElementById("info_contactos").style.display = "inline";
        document.getElementById("rut").disabled ="true";
        
         document.getElementById("nombre").value = '<?php echo $nombre_cliente; ?>';
         document.getElementById("rut").value = '<?php echo $rut; ?>';
         document.getElementById("correo").value = '<?php echo $correo; ?>';
         document.getElementById("telefono").value = '<?php echo $telefono; ?>';
         document.getElementById("direccionp").value = '<?php echo $direccionp; ?>';
         document.getElementById("direccionl").value = '<?php echo $direccionl; ?>';
         document.getElementById("referido").value = '<?php echo $referido; ?>';
         document.getElementById("grupo").value = '<?php echo $grupo; ?>';
		 document.getElementById("formulario").action="/bamboo/backend/clientes/modifica_cliente.php";
         document.getElementById("rut2").value = '<?php echo $rut; ?>';
		 document.getElementById("id").value = '<?php echo $id; ?>';
         document.getElementById("boton_submit").childNodes[0].nodeValue="Guardar cambios";
    
    for ($k= 1; $k <= cant_contact ;$k++){
         
       var container = $(document.createElement('div')).css({
        padding: '10px',
        margin: '20px',
        width: '340px',
    });
    var divSubmit = $(document.createElement('div'));
              
            var newElement= '<tr id ="registro'+$k+'"><td><input class="form-control" type="text" value="" id="nombrecontact['+$k+']" name="nombrecontact['+$k+']"/></td><td><input class="form-control" type="text" value="" id="telefonocontact['+$k+']" name="telefonocontact['+$k+']" /></td><td><input class="form-control" type="email" value="" id="emailcontact['+$k+']" name="emailcontact['+$k+']"" /></td></tr>';
          
            $("#mytable").append($(newElement));

            document.getElementById("nombrecontact["+$k+"]").value = info_contact["nombre"+$k]
            document.getElementById("telefonocontact["+$k+"]").value = info_contact["telefono"+ $k]
            document.getElementById("emailcontact["+$k+"]").value = info_contact["correo"+ $k]
            
            
           }
       
        
      }
      
      else {
           document.getElementById("radio_si").checked = false;
        document.getElementById("radio_no").checked = true;
        
        document.getElementById("rut").readonly =false;
        
         document.getElementById("nombre").value = '<?php echo $nombre_cliente; ?>';
         document.getElementById("rut").value = '<?php echo $rut; ?>';
         document.getElementById("correo").value = '<?php echo $correo; ?>';
         document.getElementById("telefono").value = '<?php echo $telefono; ?>';
         document.getElementById("direccionp").value = '<?php echo $direccionp; ?>';
         document.getElementById("direccionl").value = '<?php echo $direccionl; ?>';
         document.getElementById("referido").value = '<?php echo $referido; ?>';
         document.getElementById("grupo").value = '<?php echo $grupo; ?>';
		 document.getElementById("formulario").action="/bamboo/backend/clientes/modifica_cliente.php";
         document.getElementById("rut2").value = '<?php echo $rut; ?>';
		  document.getElementById("id").value = '<?php echo $id; ?>';
         document.getElementById("boton_submit").childNodes[0].nodeValue="Guardar cambios";
          
      }
    }    
  });
</script>
