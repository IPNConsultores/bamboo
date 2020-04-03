<?php
// Initialize the session
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

// Check if the user is logged in, if not then redirect him to login page
if ( !isset( $_SESSION[ "loggedin" ] ) || $_SESSION[ "loggedin" ] !== true ) {
  header( "location: /backend/login/login.php" );
  exit;
}
function valida_rut(){

}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bamboo Seguros</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>

<body>
    <!-- body code goes here -->
    <div class="container">
        <div class="card-header-tabs-p10" style="background-color:#536656;vertical-align: middle;">
            <div class="form-inline">
                <p><img src="http://www.bambooseguros.cl/img/logo-2.png" width="100" class="img-fluid"
                        style="float: left;vertical-align: middle "></p>
                <p class="h2"
                    style="color:white; text-align: left;vertical-align: middle; font-family:'Varela Round', sans-serif;margin-left: 10px;">
                    &nbsp;Gestión Bamboo</p>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light shadow p1" style="background-color: #A5CCAB">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span
                    class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active"> <a class="nav-link" href="/bamboo/index.php">Inicio <span
                                class="sr-only">(current)</span></a> </li>
                    <li class="dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Clientes </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown"> <a class="dropdown-item"
                                type="button" href="/bamboo/creacion_cliente.php">Creación</a>
                            <a class="dropdown-item" type="button" href="/bamboo/listado_clientes.php"
                                onclick="<?php $_SESSION["auxiliar"]="header";?>">Listado de clientes</a> </div>
                    </li>
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Pólizas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown"> <a class="dropdown-item"
                                href="/bamboo/creacion_poliza.php">Creación</a> <a class="dropdown-item" href="/bamboo/listado_polizas.php">Listado de pólizas</a> </div>
                    </li>
					<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3"
						role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Otros</a>
						<div class ="dropdown-menu" aria-labelledby="navbarDropdown"> 
							<a class="dropdown-item" href="/bamboo/creacion_actividades.php">Creación tareas</a>
							<a class="dropdown-item" href="#">Crear/Modificar template correos</a>						
						</div>				
					</li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?>
                                <Usuario>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown"> <a class="dropdown-item"
                                    href="/backend/login/registro.php"><i class="icon-cog"></i>Crear Nuevo usuario</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/backend/login/logout.php"><i class="icon-off"></i>Cerrar
                                    Sesión</a>
                            </div>
                        </li>
                    </ul>
                </form>
                    <form class="form-inline" action="/bamboo/listado_clientes.php" method="POST">
                        <input class="form-control mr-sm-2" name="busqueda" type="text" placeholder="Buscar"
                            aria-label="Buscar">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"
                            style="background-color:#536656;color:#A5CCAB" onclick="<?php $_SESSION["auxiliar"]="buscador_header";?>" >Buscar</button>
                    </form>
                
            </div>
        </nav>
    </div>
    <br>
    <div class="needs-validation" novalidate>
        <form id="load" class="needs-validation" novalidate>
        </form>
    </div>
    <script>
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--    <script src="js/jquery-3.3.1.min.js"></script>-->
    <!-- onclick="?php $_SESSION["auxiliar"]='buscador';?" -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap-4.3.1.js"></script>
-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</body>

</html>