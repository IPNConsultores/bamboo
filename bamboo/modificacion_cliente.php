<?php
session_start();
require_once "/home/gestio10/public_html/backend/config.php";
$idcliente=$_GET["cliente"];
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');
$resultado=mysqli_query($link, 'SELECT * from clientes where id='.$idcliente.';');
While($row=mysqli_fetch_object($resultado))
    {
    //Mostramos los titulos de los articulos o lo que deseemos...
        $rut=$row->rut_sin_dv;
        $dv=$row->dv;
        $id=$row->id;
        $nombre=$row->nombre_cliente;
        $apellidop=$row->apellido_paterno;
        $apellidom=$row->apellido_materno;
        $telefono=$row->telefono;
        $direccionp=$row->direccion_personal;
        $direccionl=$row->direccion_laboral;
        $correo=$row->correo;
   }
function modificar(){
    mysqli_set_charset( $link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    mysqli_query($link, 'UPDATE clientes SET id=[value-1],nombre_cliente=[value-2],apellido_paterno=[value-3],apellido_materno=[value-4],rut_sin_dv=[value-5],dv=[value-6],telefono=[value-7],direccion_personal=[value-8],direccion_laboral=[value-9],correo=[value-10] WHERE id=id;');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creación de Cliente</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</head>


<body>
    <!-- body code goes here -->
    <div id="header"><?php include 'header2.php' ?></div>
    <div class="container">
        <p> Clientes / Creación <br>
        </p>
        <form action="/backend/clientes/modifica_cliente.php" class="needs-validation" method="POST" novalidate>
        <input type="hidden" id="idcliente" name="idcliente" value="<?php echo $id; ?>">
            <h5 class="form-row">&nbsp;Datos personales</h5>
            <br>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="Nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" required>
                    <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ApellidoP">Apellido Paterno</label>
                    <input type="text" class="form-control" name="apellidop" value="<?php echo $apellidop; ?>" required>
                    <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ApellidoM">Apellido Materno</label>
                    <input type="text" class="form-control" name="apellidom" value="<?php echo $apellidom; ?>" required>
                    <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-row">
                        <div class="col-md-8 mb-3">
                            <label for="RUT">RUT</label>
                            <input type="text" class="form-control" name="rut" placeholder="11111111" value="<?php echo $rut; ?>" required>
                            <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                        </div>
                        <div class="col-md-8 mb-3 col-xl-3">
                            <label for="RUT">&nbsp;</label>
                            <input type="text" class="form-control" name="dv" placeholder="K" value="<?php echo $dv; ?>" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustomUsername">E-mail</label>
                    <div class="input-group">
                        <div class="input-group-prepend"> <span class="input-group-text" id="mail">@</span> </div>
                        <input type="email" class="form-control" value="<?php echo $correo; ?>" name="correo_electronico" required>
                        <div class="invalid-feedback"> Campo en blanco o sin formato mail (aaa@bbb.xxx) </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustomUsername">Telefono</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="telefono" value="<?php echo $telefono; ?>" placeholder="569XXXXXX" required>
                        <div class="invalid-feedback">No puedes dejar este campo en blanco</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="Dirección">Dirección Particular</label>
                    <input type="text" class="form-control" value="<?php echo $direccionp; ?>" name="direccionp" required>
                    <div class="invalid-feedback"> No puedes dejar este campo en blanco </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustomUsername">Dirección Laboral</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?php echo $direccionl; ?>" name="direccionl" required>
                        <div class="invalid-feedback"> No puedes dejar este campo en blanco</div>
                    </div>
                </div>
            </div>

            <button class="btn" type="submit" style="background-color: #536656; color: white">Modificar</button>
        </form>
    </div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
</body>

</html>