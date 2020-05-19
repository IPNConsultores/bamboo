<?php
if ( !isset( $_SESSION ) ) {
  session_start();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Creación Clientes</title>
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
<?php include 'header2.php' ?>
</div>
<div class="container">
  <p>Clientes / Creación<br>
  </p>
  <form action="/bamboo/backend/clientes/crea_cliente.php" class="needs-validation" method="POST" novalidate>
    <h5 class="form-row">&nbsp;Datos personales</h5>
    <br>
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <label for="Nombre"> Nombre</label><label style= "color: darkred">*</label>
        
        <input type="text" class="form-control" name="nombre" required>
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="ApellidoP">Apellido Paterno</label>
        <label style= "color: darkred">*</label>
        <input type="text" class="form-control" name="apellidop" required>
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="ApellidoM">Apellido Materno</label>
        <label style= "color: darkred">*</label>
        <input type="text" class="form-control" name="apellidom" required>
        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="form-row">
          <div class="col-md-8 mb-3 col-lg-12">
            <label for="RUT">RUT</label>
            <label style= "color: darkred">*</label>
            <input type="text" class="form-control" id="rut" name="rut" placeholder="1111111-1"
                                oninput="checkRut(this)" onchange="valida_rut_duplicado()" required>
            <div class="invalid-feedback">Dígito verificador no válido. Verifica rut ingresado</div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustomUsername">E-mail</label>
        <label style= "color: darkred">*</label>
        <div class="input-group">
          <div class="input-group-prepend"><span class="input-group-text" id="mail">@</span></div>
          <input type="email" class="form-control" name="correo_electronico" required>
          <div class="invalid-feedback">Campo en blanco o sin formato mail (aaa@bbb.xxx)</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustomUsername">Telefono</label>
        <label style= "color: darkred">*</label>
        <div class="input-group">
          <input type="text" class="form-control" name="telefono" placeholder="56 9 XXXX XXXX" required>
          <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="Dirección">Dirección Principal</label>
                <input type="text" class="form-control" name="direccionp">
        
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustomUsername">Dirección Secundaria</label>
        <div class="input-group">
          <input type="text" class="form-control" name="direccionl">
          
        </div>
      </div>
      
        <div class="col-md-4 mb-3">
          <label for="referido">Referido</label>
          <input type="text" class="form-control" name="referido">
        </div>
        <div class="col-md-4 mb-3">
          <label for="grupo">Grupo</label>
          <input type="text" class="form-control" name="grupo">
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
    </div>
    <br>
    <hr>
    <button class="btn" type="submit" style="background-color: #536656; color: white">Registrar</button>
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

            $(container).append('<label id=label>Limite Alcanzado</label> ');
            $('#btAdd').attr('class', 'btn');
            $('#btAdd').attr('disabled', 'disabled');

        }
    });

    $('#btRemove').click(function() { // Elimina un elemento por click

        if (iCnt != 0) {
            iCnt = iCnt - 1;
            $('#btAdd').removeAttr('disabled');
            $('#registro' + iCnt).remove()
        }
        if (iCnt == 4) {
            $('#label').remove();
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
</script>