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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/bamboo/images/bamboo.png">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!-- Bootstrap -->
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
</head>

<body>
    <!-- body code goes here -->
    <div class="container">
        <div class="card-header-tabs-p10" style="overflow:auto;  background-color: #536656;vertical-align: middle;">
            <div class="form-inline">
                <p><img href="/bamboo/images/logo_bamboo.png" width="100" class="img-fluid"
                        style="float: left;vertical-align: middle "></p>
                <p class="h2"
                    style="color:white; text-align: left;vertical-align: middle; font-family:'Varela Round', sans-serif;margin-left: 10px;">
                    &nbsp;Gestión Bamboo</p>
            </div>
        </div>
        <nav class="navbar navbar-expand navbar-light shadow p-1" style="background-color: #A5CCAB; OVERFLOW=AUTO">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span
                    class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active"> <a class="nav-link" type="button" href="/bamboo/index.php">Inicio <span
                                class="sr-only">(current)</span> </a> </li>
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Clientes </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" type="button" href="/bamboo/creacion_cliente.php">Creación</a>
                            <a class="dropdown-item" type="button" href="/bamboo/listado_clientes.php"
                                onclick="<?php $_SESSION["auxiliar"]=true;?>">Modificación</a> </div>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav mr-auto">
                <form class="form-inline">
                    <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" style="color:black"
                            data-toggle="dropdown">Bienvenido!, <?php echo htmlspecialchars($_SESSION["username"]); ?>
                            <Usuario>
                        </a>
                        <ul class="nav-item dropdown-menu">
                            <li><a href="/backend/login/registro.php"><i class="icon-cog"></i> Crear nuevo usuario</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="/backend/login/logout.php"><i class="icon-off"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </form>
                <form class="form-inline" method="POST" action="/bamboo/listado_clientes.php">
                    <input class="form-control" name="busqueda" type="text" placeholder="Buscar" aria-label="Buscar">
                    <button class="btn btn-outline-success " type="submit"
                        style="background-color:#536656;color:#A5CCAB ">Buscar</button>
                </form>
            </ul>
        </nav>
    </div>
    <br>
    <div class="needs-validation" novalidate>
        <form id="load" class="needs-validation" novalidate>
        </form>
    </div>
</body>

</html>