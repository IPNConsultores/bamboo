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
            <div class="card">
                <div class="card-header" id="headingOne" style="background-color:whitesmoke">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne" style="color:#536656">Asegurado y
                            Proponente</button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <p>Datos Proponente<br>
                            <div class="form-row">
                                <div class="form-row">
                                    <div class="col-md mb-3">
                                        <label for="RUT">RUT</label>
                                        <input type="text" class="form-control" id="rutprop" name="rutprop"
                                            placeholder="1111111-1" oninput="checkRut(this)"
                                            onchange="valida_rut_duplicado_prop()" required>
                                        <div class="invalid-feedback">Dígito verificador no válido. Verifica rut
                                            ingresado</div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3 col-xl-3 col-lg-1 offset-lg-0">
                                    <label for="prop">&nbsp;</label>
                                    <br>
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"
                                        style="background-color:#536656;color:#A5CCAB;position:inherit">Buscar</button>
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
                                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"
                                            style="background-color:#536656;color:#A5CCAB;position:inherit">Buscar</button>
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
                                    <div class="form-row">
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
            <div class="card">
                <div class="card-header" id="headingTwo" style="background-color:whitesmoke">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
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
                            <div class="col">
                                <label for="polizaantigua">Póliza Renovada</label>
                                <input type="text" class="form-control" name="polizaantigua">
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
                        <div class="form-row">
                            <div class="col-md-4 mb-3;form-inline">
                                <label for="deducible">Deducible</label>
                                <input type="text" class="form-control" name="deducible">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="deducible">Prima Afecta</label>
                                <div class="form-inline">
                                    <input type="text" class="form-control" name="prima_afecta">
                                    <select class="form-control" id="moneda_prima">
                                        <option>UF</option>
                                        <option>USD</option>
                                        <option>CLP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="deducible">Prima Excenta</label>
                                <div class="form-inline">
                                    <input type="text" class="form-control" name="prima_afecta">
                                    <select class="form-control" id="moneda_prima">
                                        <option>UF</option>
                                        <option>USD</option>
                                        <option>CLP</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3; form-inline">
                                <label for="deducible">Prima total</label>
                                <div class="form-inline">
                                    <input type="text" class="form-control" name="prima_total">
                                    <select class="form-control" id="moneda_prima">
                                        <option>UF</option>
                                        <option>USD</option>
                                        <option>CLP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="deducible">Prima Bruta Anual</label>
                                <div class="form-inline">
                                    <input type="text" class="form-control" name="prima_afecta">
                                    <select class="form-control" id="moneda_prima">
                                        <option>UF</option>
                                        <option>USD</option>
                                        <option>CLP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="monto_aseg">Monto Asegurado</label>
                                <input type="text" class="form-control" name="monto_aseg">
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
                        <label for="endoso"><b>Endoso</b></label>
                        <br>
                        <div class="form-row">
                            <div class="form-inline">
                                <select class="form-control" id="moneda_prima">
                                    <option>Si</option>
                                    <option>No</option>
                                </select>
                                <div class="col">
                                    <input type="text" class="form-control" name="endoso">
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
                                <label for="comision">Comisión Negativa</label>
                                <input type="text" class="form-control" name="comisionneg">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="comision">Boleta Comisión Negativa</label>
                                <input type="text" class="form-control" name="boletaneg">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="fechadeposito">Fecha Depósito</label>
                                <div class="md-form">
                                    <input placeholder="Selected date" type="date" id="fechadeposito"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <br>
                        <label for="pago"><b>Pago</b></label>
                        <br>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="formapago">Forma de Pago</label>
                                <input type="text" class="form-control" name="formapago">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="valorcuota">Valor Cuota</label>
                                <div class="form-inline">
                                    <input type="text" class="form-control" name="valorcuota">
                                    <select class="form-control" id="moneda_prima">
                                        <option>UF</option>
                                        <option>USD</option>
                                        <option>CLP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="fechaprimer">Fecha Primer Deposito</label>
                                <div class="md-form">
                                    <input placeholder="Selected date" type="date" id="fechaprimer"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <br>
                        <label for="pago"><b>Referido</b></label>
                        <br>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">

                                <label>Vendedor:</label>
                                <div class="col-md-5">
                                    <select class="form-control" id="vendedor">
                                        <option>Si</option>
                                        <option>No</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="formapago">Referido</label>
                                <input type="text" class="form-control" name="referido">
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
        <script src="/bamboo/js/jquery.redirect.js"></script>
        <script src="/bamboo/js/validarRUT.js"></script>


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
            alert(response.nombre);
            console.log(response.rut);
            console.log(response.nombre);
            console.log(response.apellidop);
            console.log(response.apellidom);

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
            alert(response.nombre);
            console.log(response.rut);
            console.log(response.nombre);
            console.log(response.apellidop);
            console.log(response.apellidom);

        }

    });
}
</script>