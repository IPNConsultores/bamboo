<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
</head>

<body>
    <!-- body code goes here -->
    <div class="container">
        <div class="card-header-tabs-p10" style="overflow:auto;  background-color: #536656;vertical-align: middle;">
            <div class="form-inline">
                <p><img src="http://www.bambooseguros.cl/img/logo-2.png" width="100" class="img-fluid" style="float: left;vertical-align: middle "></p>
                <p class="h2" style="color:white; text-align: left;vertical-align: middle; font-family:'Varela Round', sans-serif;margin-left: 10px;"> &nbsp;Gestión Bamboo</p>
            </div>
        </div>
        <nav class="navbar navbar-expand navbar-light shadow p-1" style="background-color: #A5CCAB; OVERFLOW=AUTO">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" type="button" href="index.php">Home
        <span class="sr-only">(current)</span> </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Clientes </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" type="button" href="creacion_cliente.php">Creación</a>
                            <a class="dropdown-item" type="button" href="listado_clientes.php">Modificación</a>
                        </div>
                    </li>

                    <form class="form-inline">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success " type="submit" style="background-color:#536656;color:#A5CCAB ">Search</button>
                    </form>
                </ul>
                <form class="form-inline">
                    <div class="pull-right">
                        <ul class="nav pull-right">
                            <li class="dropdown"><a href="#" class="dropdown-toggle" style="color:black" data-toggle="dropdown">Bienvenido!, <?php echo htmlspecialchars($_SESSION["username"]); ?> <Usuario></a>
                                <ul class="dropdown-menu">
                                    <li><a href="registro.php"><i class="icon-cog"></i> Crear nuevo usuario</a></li>
                                    <li class="divider"></li>
                                    <li><a href="backend/logout.php"><i class="icon-off"></i> Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </form>
                <div>
                </div>
        </nav>
        </div>
        <br>
        <div class="needs-validation" novalidate>
            <form id="load" class="needs-validation" novalidate>
            </form>
        </div>
</body>

</html>