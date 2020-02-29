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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

<body>
<!-- body code goes here -->
<div id="header">
<?php include 'header2.php' ?>
</div>
<div class="container">
  <p>Póliza / Creación<br>
  </p>
  <h5 class="form-row">&nbsp;Datos Póliza</h5>
  <div class="accordion" id="accordionExample">
    <div class="card" >
      <div class="card-header" id="headingOne" style="background-color:whitesmoke">
        <h5 class="mb-0">
          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#536656">Asegurado y Proponente</button>
        </h5>
      </div>
      <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body">
          <p>Datos Proponente<br>
          <div class="form-row">
            <div class="form-row">
              <div class="col-md mb-3">
                <label for="RUT">RUT</label>
                <input type="text" class="form-control" id="rutprop" name="rutprop" placeholder="1111111-1"
                            oninput="checkRut(this)" required>
                <script>
                            function valida_rut() {
                                
                                var dato = $('#rut').val();
                                /*
                                var r = confirm(
                                    "El rut que acabas de ingresar ya se encuentra en la base de datos. ¿Deseas ver la información asociada al rut?"
                                );
                                if (r == true) {
                                    $.redirect('/bamboo/listado_clientes.php', {
                                        'dato': dato
                                    }, 'post');
                                } else {
                                    location.href = "http://gestionipn.cl/bamboo/creacion_cliente.php";
                                }
                                */
                            }
                            </script>
                <div class="invalid-feedback">Dígito verificador no válido. Verifica rut ingresado</div>
              </div>
            </div>
            <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
              <label for="prop">&nbsp;</label>
              <br>
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="background-color:#536656;color:#A5CCAB;position:inherit">Buscar</button>
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="Nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="ApellidoP">Apellido Paterno</label>
                <input type="text" class="form-control" name="apellidop" required>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="ApellidoM">Apellido Materno</label>
                <input type="text" class="form-control" name="apellidom" required>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
              </div>
            </div>
          </div>
          <p>Datos Asegurado<br>
          <div class="form-row">
            <div class="form-row">
              <div class="col-md mb-3">
                <label for="RUT">RUT</label>
                <input type="text" class="form-control" id="rutaseg" name="rutaseg" placeholder="1111111-1"
                            oninput="checkRut(this)" required>
                <script>
                            function valida_rut() {
                                
                                var dato = $('#rut').val();
                                /*
                                var r = confirm(
                                    "El rut que acabas de ingresar ya se encuentra en la base de datos. ¿Deseas ver la información asociada al rut?"
                                );
                                if (r == true) {
                                    $.redirect('/bamboo/listado_clientes.php', {
                                        'dato': dato
                                    }, 'post');
                                } else {
                                    location.href = "http://gestionipn.cl/bamboo/creacion_cliente.php";
                                }
                                */
                            }
                            </script>
                <div class="invalid-feedback">Dígito verificador no válido. Verifica rut ingresado</div>
              </div>
            </div>
            <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
              <label for="prop">&nbsp;</label>
              <br>
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="background-color:#536656;color:#A5CCAB;position:inherit">Buscar</button>
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="Nombre">Nombre</label>
                <input type="text" class="form-control" name="nombreaseg" required>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="ApellidoP">Apellido Paterno</label>
                <input type="text" class="form-control" name="apellidopaseg" required>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="ApellidoM">Apellido Materno</label>
                <input type="text" class="form-control" name="apellidomaseg" required>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class ="form-row">
              <div class="col col-lg-12">
                <label for="Nombre">Grupo</label>
                <input type="text" class="form-control" name="grupo" required>
                <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card" >
      <div class="card-header" id="headingTwo" style="background-color:whitesmoke">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="color:#536656">Compañía, Vigencia y Materia</button>
        </h5>
      </div>
      <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
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
            <div class= "col-md-2 mb-3">
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
                <input placeholder="Selected date" type="date" id="fechainicio" class="form-control">
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
            <div class="col">
              <label for="polizaantigua">Póliza Renovada</label>
              <input type="text" class="form-control" name="polizaantigua" >
            </div>
            <div class="col">
              <label for="poliza">Número de Poliza</label>
              <input type="text" class="form-control" name="poliza" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col">
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
          <div  class= "form-row">
            <div class="col-md-4 mb-3;form-inline">
              <label for="deducible">Deducible</label>
              <input type="text" class="form-control" name="deducible">
            </div>
            <div class="col-md-4 mb-3">
              <label for="deducible">Prima Afecta</label>
				<div class="form-inline">
              <input type="text" class="form-control" name="prima_afecta" onkeyup="sumar(this.value);">
              <select class="form-control" id="moneda_prima">
                <option>UF</option>
                <option>USD</option>
                <option>CLP</option>
              </select>
			</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="deducible">Prima Excenta</label>
				<div class= "form-inline">
              <input type="text" class="form-control" name="prima_afecta" onkeyup="sumar(this.value);">
              <select class="form-control" id="moneda_prima">
                <option>UF</option>
                <option>USD</option>
                <option>CLP</option>
              </select>
			</div>
            </div>
          </div>
			<div  class= "form-row">
            
            <div class="col-md-4 mb-3; form-inline">
				
              <label for="deducible">Prima total</label>
			<div class= "form-inline">
              <input type="text" class="form-control" name="prima_total">
              <select class="form-control" id="moneda_prima">
                <option>UF</option>
                <option>USD</option>
                <option>CLP</option>
              </select>
			</div>
<script>function sumar (valor) {
    var total = 0;	
    valor = parseInt(valor); // Convertir el valor a un entero (número).
	
    total = document.getElementById('prima_total').innerHTML;
	
    // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
    total = (total == null || total == undefined || total == "") ? 0 : total;
	
    /* Esta es la suma. */
    total = (parseInt(total) + parseInt(valor));
	
    // Colocar el resultado de la suma en el control "span".
    document.getElementById('prima_total').innerHTML = total;
}
</script>
            </div>
            <div class="col-md-4 mb-3; form-inline">
              <label for="deducible">Prima Bruta Anual</label>
				<div class= "form-inline">
              <input type="text" class="form-control" name="prima_afecta">
              <select class="form-control" id="moneda_prima">
                <option>UF</option>
                <option>USD</option>
                <option>CLP</option>
              </select>
		     </div>
            </div>
          </div>
        </div>
        
        <!--
        <div class="form-row">
          <div class="col-md-4 mb-3 col-lg-3" style= "align:left">
            <label for="RUT" style= "align:left">RUT</label>
            <input type="text" class="form-control" name="rutprop" placeholder="11111111" required>
            <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
          </div>
          <div class="col-md-2 mb-3 col-xl-3">
            <label for="RUT">&nbsp;</label>
            <input type="text" class="form-control" name="dvprop" placeholder="K" required>
            <div class="invalid-feedback"></div>
          </div>
          <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
            <label for="prop">&nbsp;</label>
            <br>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="background-color:#536656;color:#A5CCAB;position:inherit">Buscar</button>
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="Nombre">Nombre</label>
              <input type="text" class="form-control" name="nombre" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoP">Apellido Paterno</label>
              <input type="text" class="form-control" name="apellidop" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="ApellidoM">Apellido Materno</label>
              <input type="text" class="form-control" name="apellidom" required>
              <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
            </div>
          </div>
        </div>
-->
      </div>
    </div>
  </div>
  <br>
  <form action="backend/clientes/crea_cliente.php" class="needs-validation" method="POST" novalidate>
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
<script src="/bamboo/js/jquery.redirect.js"></script>
<script src="/bamboo/js/validarRUT.js"></script>
</body>
</html>