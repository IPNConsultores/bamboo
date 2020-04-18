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
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" />

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/7011384382.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<body>
<!-- body code goes here -->
<div id="header">
<?php include 'header2.php' ?>
</div>
<div class="container">
<p>Póliza / Creación<br>
</p>
<h5 class="form-row">&nbsp;Datos Póliza</h5>
<br>
<br>
<div class="form-check form-check-inline">
  <label class="form-check-label" >¿Es renovación de una póliza?:&nbsp;&nbsp;</label>
  <input class="form-check-input" type="radio" name="nueva" id="radio_no" value="nueva"
                    onclick="checkRadio(this.name)" checked="checked">
  <label class="form-check-label" for="inlineRadio1">No&nbsp;</label>
  <input class="form-check-input" type="radio" name="renovacion" id="radio_si" value="renovacion"
                    onclick="checkRadio(this.name)">
  <label class="form-check-label" for="inlineRadio2">Si&nbsp;&nbsp;</label>
  <button class="btn" id="busca_poliza" data-toggle="modal" data-target="#modal_poliza" style="background-color: #536656; color: white;display: none">Buscar Póliza</button>
  <div class="modal fade" id="modal_poliza" tabindex="-1" role="dialog" aria-labelledby="modal_text" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_text">Buscar Póliza a Renovar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class ="container-fluid">
            <table class="table" id="listado_polizas">
              <tr>
                <th>Póliza</th>
                <th>Compañia</th>
                <th>Ramo</th>
                <th>Nombre Asegurado</th>
                <th>Fecha fin</th>
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
    <input type="text" class="form-control" name="poliza_renovada" placeholder="Póliza Anterior" id ="poliza_renovada" style="display:none;">
  </div>
</div>
<br>
<br>
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne" style="background-color:whitesmoke">
      <h5 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#536656">Asegurado y Proponente</button>
      </h5>
    </div>
    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <div class="form-check form-check-inline">
          <label class="form-check-label" >¿Asegurado es el mismo que Proponente?:&nbsp;&nbsp;</label>
          <input class="form-check-input" type="radio" name="diferentes" id="radio2_no" value="diferentes"
                    onclick="checkRadio2(this.name)" checked="checked">
          <label class="form-check-label" for="inlineRadio1">No&nbsp;</label>
          <input class="form-check-input" type="radio" name="iguales" id="radio2_si" value="iguales"
                    onclick="checkRadio2(this.name)">
          <label class="form-check-label" for="inlineRadio2">Si&nbsp;&nbsp;</label>
          <button class="btn" id="busca_rut" data-toggle="modal" data-target="#modal_cliente" style="background-color: #536656; color: white;">Buscar RUT</button>
          <div class="modal fade" id="modal_cliente" tabindex="-1" role="dialog" aria-labelledby="modal_text_cliente" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modal_text_cliente">Buscar RUT</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                  <div class ="container-fluid">
                    <table class="table" id="listado_cliente">
                      <tr>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                      </tr>
                    </table>
                    <div id="botones_cliente"></div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p>Datos Proponente<br>
        <div class="form-row">
          <div class="form-row">
            <div class="col-md mb-3">
              <label for="RUT">RUT</label>
              <input type="text" class="form-control" id="rutprop" name="rutprop"
                                            placeholder="1111111-1" oninput="checkRut(this);copiadatos()"
                                            onchange="valida_rut_duplicado_prop();copiadatos()" onkeyup="copiadatos()" required>
              <div class="invalid-feedback">Dígito verificador no válido. Verifica rut
                ingresado</div>
            </div>
          </div>
          <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
            <label for="prop">&nbsp;</label>
            <br>
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="Nombre">Nombre</label>
              <input type="text" id="nombre_prop" class="form-control" name="nombre" oninput="copiadatos()" onkeyup="copiadatos()" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoP">Apellido Paterno</label>
              <input type="text" id="apellidop_prop" class="form-control" oninput="copiadatos()" name="apellidop" onkeyup="copiadatos()"
                                            required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoM">Apellido Materno</label>
              <input type="text" id="apellidom_prop" class="form-control" name="apellidom" oninput="copiadatos()" onkeyup="copiadatos()"
                                            required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
          </div>
        </div>
        <p>Datos Asegurado<br>
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
              <input type="text" id="apellidop_seg" class="form-control"
                                                name="apellidopaseg" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoM">Apellido Materno</label>
              <input type="text" id="apellidom_seg" class="form-control"
                                                name="apellidomaseg" required>
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
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse show"
                            data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"
                            style="color:#536656">Compañía, Vigencia, Materia y Deducible</button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <label for="compania"><b>Compañía</b></label>
        <br>
        <div class="form-row">
          <div class="form-inline">
            <select class="form-control" id="selcompania">
              <option>BCI Seguros</option>
              <option>Chilena Consolidada</option>
              <option>CHUBB</option>
              <option>Confuturo</option>
              <option>Consorcio</option>
              <option>Continental</option>
              <option>HDI Seguros</option>
              <option>Maphre</option>
              <option>Ohio National Financial Group</option>
              <option>Orsan</option>
              <option>Reale Seguros</option>
              <option>Renta Nacional</option>
              <option>Southbridge</option>
              <option>Sura</option>
              <option>Unnio</option>
            </select>
          </div>
        </div>
        <br>
        <label for="poliza"><b>Póliza</b></label>
        <br>
        <div class="form-row">
          <div class="col-md-2 mb-3">
            <label for="sel1">Ramo:&nbsp;</label>
            <select class="form-control" id="ramo">
              <option>VEH</option>
              <option>Hogar</option>
              <option>A. VIAJE</option>
              <option>RC</option>
              <option>INC</option>
              <option>APV</option>
              <option>D&O</option>
              <option>AP</option>
              <option>Vida</option>
              <option>Garantía</option>
            </select>
          </div>
          <div class="col-md-4 mb-3">
            <label for="Nombre">Vigencia Inicial</label>
            <div class="md-form">
              <input placeholder="Selected date" type="date" id="fechainicio"
                                        class="form-control">
            </div>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="Nombre">Vigencia Final</label>
            <div class="md-form">
              <input placeholder="Selected date" type="date" id="fechavenc" class="form-control">
            </div>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-4">
            <label for="poliza">Número de Poliza</label>
            <input type="text" class="form-control" name="poliza" required>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
          <div class="col-4">
            <label for="cobertura">Cobertura</label>
            <input type="text" class="form-control" name="cobertura">
          </div>
        </div>
        <br>
        <label for="materia"><b>Materia</b></label>
        <br>
        <div class="form-row">
          <div class="col">
            <label for="poliza">Materia Asegurada</label>
            <input type="text" class="form-control" name="materia" required>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
          <div class="col">
            <label for="poliza">Patente o Ubicación</label>
            <input type="text" class="form-control" name="materia" required>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
        </div>
        <br>
        <label for="materia"><b>Deducible, Primas y Montos</b></label>
        <br>
        <div class= "form-row; form-inline">
          <label for="moneda_prima">Moneda Prima</label>
          <div class="col-1">
            <select class="form-control" id="moneda_poliza">
              <option>UF</option>
              <option>USD</option>
              <option>CLP</option>
            </select>
          </div>
        </div>
        <br>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="deducible">Deducible</label>
            <input type="text" class="form-control" id="deducible" oninput = "concatenar(this.id)">
            <input type="text" class="form-control" name="deducible" oninput = "concatenar(this.name)">
          </div>
          <div class="col-md-4 mb-3">
            <label for="prima_afecta">Prima Afecta</label>
            <input type="text" class="form-control" id="prima_afecta" oninput = "concatenar(this.id)">
            <input type="text" class="form-control" name="prima_afecta" oninput = "concatenar(this.name)">
          </div>
          <div class="col-md-4 mb-3">
            <label for="prima_excenta">Prima Excenta</label>
            <input type="text" class="form-control" id="prima_excenta" oninput = "concatenar(this.id)">
            <input type="text" class="form-control" name="prima_excenta" oninput = "concatenar(this.name)">
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="prima_afecta">Prima Neta</label>
            <input type="text" class="form-control" id="prima_neta" oninput = "concatenar(this.id)">
          </div>
          <div class="col-md-4 mb-3">
            <label for="prima_afecta">Prima Bruta Anual</label>
            <input type="text" class="form-control" id="prima_bruta" oninput = "concatenar(this.id)">
          </div>
          <div class="col-md-4 mb-3">
            <label for="monto_aseg">Monto Asegurado</label>
            <input type="text" class="form-control" id="monto_aseg" oninput = "concatenar(this.id)">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
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
            <label for="monto_aseg">Número de Propuesta</label>
            <input type="text" class="form-control" name="monto_aseg">
          </div>
          <div class="col-md-4 mb-3">
            <label for="monto_aseg">Fecha Envío Propuesta</label>
            <div class="md-form">
              <input placeholder="Selected date" type="date" id="fechaprop" class="form-control">
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
              <input type="text" class="form-control" name="comision">
              <select class="form-control" id="moneda_prima">
                <option>UF</option>
                <option>USD</option>
                <option>CLP</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label>Porcentaje Comisión del Corredor</label>
            <input type="text" class="form-control" name="porcentaje">
          </div>
          <div class="col-md-4 mb-3">
            <label>Comisión Bruta a Pago</label>
            <input type="text" class="form-control" name="comisionbruta">
          </div>
          <div class="col-md-4 mb-3">
            <label>Comisión Neta a Pago</label>
            <input type="text" class="form-control" name="comisionneta">
          </div>
          <div class="col-md-4 mb-3">
            <label>Número de Boleta</label>
            <input type="text" class="form-control" name="boleta">
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
            <input type="text" class="form-control" name="comisionneg">
          </div>
          <div class="col-md-4 mb-3">
            <label for="comision">Boleta Comisión Negativa</label>
            <input type="text" class="form-control" name="boletaneg">
          </div>
        </div>
        <br>
        <label for="pago"><b>Pago</b></label>
        <br>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="formapago">Forma de Pago</label>
            <div class="form-row">
              <div class="col-4">
                <select class="form-control" id="modo_pago" onChange="modopago()">
                  <option>PAT</option>
                  <option>PAC</option>
                  <option>Cupon de Pago</option>
                </select>
              </div>
              &nbsp;
              <div class="col">
                <input type="text" class="form-control" id="cuotas" placeholder="Cantidad de Cuotas">
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="valorcuota">Valor Cuota</label>
            <input type="text" class="form-control" id="valorcuota" oninput="concatenar(this.id)">
          </div>
          <div class="col-md-4 mb-3">
            <label for="fechaprimer">Fecha Primera Cuota</label>
            <div class="md-form">
              <input placeholder="Selected date" type="date" id="fechaprimer"
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
                <select class="form-control" id="vendedor1" onChange="validavendedor()">
                  <option>Si</option>
                  <option>No</option>
                </select>
              </div>
              &nbsp;
              <div class="col">
                <input type="text" class="form-control" id="vendedor2" placeholder="Nombre Vendedor">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <br>
  <form action="" class="needs-validation" method="POST" novalidate>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
        </script>
<script src="/assets/js/jquery.redirect.js"></script>
<script src="/assets/js/validarRUT.js"></script>
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
       document.getElementById("busca_poliza").style.display = "block" ;
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
      

    } else if (name == "iguales") {
        document.getElementById("radio2_no").checked = false;
        document.getElementById("radio2_si").checked = true;
		document.getElementById("nombre_seg").disabled = "true";
        document.getElementById("rutaseg").disabled = "true";
		document.getElementById("apellidop_seg").disabled = "true";
		document.getElementById("apellidom_seg").disabled = "true";
    }
}

		function copiadatos() {
    if (document.getElementById("radio2_si").name == "iguales") {
        document.getElementById("rutaseg").value =  document.getElementById("rutprop").value;
        document.getElementById("nombre_seg").value =  document.getElementById("nombre_prop").value;
		document.getElementById("apellidop_seg").value = document.getElementById("apellidop_prop").value;
		document.getElementById("apellidom_seg").value = document.getElementById("apellidom_prop").value;
      
    } 
} 
		function concatenar(name){
			var  moneda = document.getElementById("moneda_poliza").value;
			var  texto = document.getElementById(name).value.replace(' ' + moneda, '');
			var final = texto + ' ' + moneda;

			document.getElementById(name).value= final;
		}
	
	function modopago(){
	if (document.getElementById("modo_pago").value == "PAT"){
		document.getElementById("cuotas").disabled = false;
		
	}
	else {
		document.getElementById("cuotas").disabled = true;
		
	}
	}
	
	function validavendedor(){ 
	if (document.getElementById("vendedor1").value=="Si"){
		document.getElementById("vendedor2").disabled = false;
	}
		
	else {
		document.getElementById("vendedor2").disabled = true;
		
	}
	}
	
		</script>
<script>

			
$('#modal_poliza').on('shown.bs.modal', function () {
$('#modal_text').trigger('focus')
})
		
		
</script>