<?php
// Initialize the session
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if ( !isset( $_SESSION[ "loggedin" ] ) || $_SESSION[ "loggedin" ] !== true ) {
    setcookie('URI',$_SERVER['REQUEST_URI'],time() + (180),"/");
    setcookie('DOMINIO',$_SERVER['HTTP_HOST'],time() + (180),"/");
header( "location: /backend/login/login.php" );
exit;
}
if ($_COOKIE['valida_arreglo']==1){
    //setcookie('valida_arreglo',"",time() - (10),"/");
    $arreglo=json_decode(html_entity_decode($_COOKIE['arreglo']),true);
    $arreglo=stripslashes($_COOKIE['arreglo']);
$cookie_url=$cookie_id=$cookie_acordeon='-';
    $codigo='{
      "data": [';
    if ($_COOKIE['historial']==null || $_COOKIE['historial']=="" || str_replace( "]}","",mb_substr($_COOKIE['historial'], 17))==""){
        setcookie('historial',$codigo.$arreglo.']}' ,time() + (60*30),"/"); 
        setcookie('arreglo',$codigo.$arreglo.']}' ,time() - (1),"/");
        //echo $codigo.$arreglo.']}';
    }
    else
    {
        $historial=mb_substr($_COOKIE['historial'], 17);
        $historial=str_replace( "]}","",$historial);
        $historial= stripslashes ($historial);
        $codigo.=' '.$historial.', '.$arreglo.']}';
        setcookie('historial',$codigo,time() + (60*30),"/");
        setcookie('arreglo',$codigo.$arreglo.']}' ,time() - (1),"/");
        //print_r(retrocede());
        //echo "<br>url: ->".$cookie_url."<-<br>";
    }
}
else
{
    setcookie('historial',"",time() - (10),"/");    
}
function retrocede()
{
    $historial=json_decode($_COOKIE['historial'],true);
    $contador=count($historial['data'])-1;
    $cookie_url=$historial['data'][$contador]['url'];
    $cookie_id=$historial['data'][$contador]['id'];
    $cookie_acordeon=$historial['data'][$contador]['acordeon'];
    unset($historial['data'][$contador]);
    setcookie('historial',json_encode($historial),time() + (180),"/");
   // echo $cookie_url;
    return stripslashes(json_encode(array($cookie_url,$cookie_id,$cookie_acordeon)));
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión IPN - Bamboo Seguros</title>
    <link rel="icon" href="/bambooQA/images/bamboo.png">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    
   
    <!-- body code goes here -->

         
      
        <div class="container" style="margin-right: auto; margin-left:auto; position:relative"  >
            

      
        <div class="card-header-tabs-p10" style="background-color:#536656;vertical-align: middle; padding:0px ;">
            <div class="form-inline">
                <div class="col-2">
                    <p><img src="/bambooQA/images/logo_bamboo.png" width="100" class="img-fluid"
                            style="float: left;vertical-align: middle "></p>
                </div>
                <div class="col-8">
                    <p class="h2"
                        style="color:white; text-align: left;vertical-align: middle; font-family:'Varela Round', sans-serif;margin-left: 10px;">
                        &nbsp;Gestión Bamboo</p>
                </div>
                <div class="col-2" style="color : white; font-size:80%">
                    <table id="ind_ec">
                        <tr>
                            <td width="100">Fecha :</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>UF:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Dólar:</td>
                            <td>-</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <nav class="navbar navbar-expand-lg navbar-light shadow p1" style="background-color: #A5CCAB">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span
                    class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active"> <a class="nav-link" href="/bambooQA/index.php">Inicio <span
                                class="sr-only">(current)</span></a> </li>
                    <li class="dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Clientes </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown"> <a class="dropdown-item"
                                type="button" href="/bambooQA/creacion_cliente.php">Creación</a>
                            <a class="dropdown-item" type="button" href="/bambooQA/listado_clientes.php"
                                onclick="<?php $_SESSION["auxiliar"]="header";?>">Listado de clientes</a> </div>
                    </li>
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Pólizas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/bambooQA/creacion_propuesta_poliza.php">Creación Propuesta </a>
                            <a class="dropdown-item" href="/bambooQA/listado_propuesta_polizas.php">Listado Propuesta </a>
                            <a class="dropdown-item" href="/bambooQA/listado_polizas.php">Listado de pólizas</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Endosos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            
                            <a class="dropdown-item" href="/bambooQA/creacion_poliza.php">Listado Propuesta Endosos</a>
                            <a class="dropdown-item" href="/bambooQA/listado_polizas.php">Listado de Endosos</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown4"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tareas</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/bambooQA/creacion_actividades.php">Creación</a>
                            <a class="dropdown-item" href="/bambooQA/listado_tareas.php">Listado de tareas</a>
                            <a class="dropdown-item" href="/bambooQA/listado_tareas_recurrentes.php">Listado de tareas
                                recurrentes</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Correos</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/bambooQA/solicitar_info.php">Ver Tipos de Correos</a>
                            <a class="dropdown-item" href="/bambooQA/creacion_template.php">Editar Templates</a>
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
                <form class="form-inline" action="/bambooQA/resumen2.php" method="POST">
                    <input class="form-control mr-sm-2" name="busqueda" type="text" placeholder="Buscar"
                        aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"
                        style="background-color:#536656;color:#A5CCAB"
                        onclick="<?php $_SESSION["auxiliar"]="buscador_header";?>">Buscar</button>
                </form>

            </div>
        </nav>
        <div>
            <div class ="row d-flex">
                <div class="col ">
     
    </div>
    <div class="col">
      
    </div>
  
                
            </div>
            
            
        </div>
    </div>
    
    <br>
    <div class="needs-validation" novalidate>
        <form id="load" class="needs-validation" novalidate>
        </form>
    </div>
    

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
    <script src="/assets/js/jquery.redirect.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
</body>

</html>
<script>
function formateo_numeros(x) {
    return x.toString().replace(".", ",").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
var request = new XMLHttpRequest()
request.open('GET', 'https://mindicador.cl/api', true)
request.onload = function() {
    // Begin accessing JSON data here
    var data = JSON.parse(this.response)
    if (request.status >= 200 && request.status < 400) {
        let date = new Date(data.fecha)
        let day = date.getDate()
        let month = date.getMonth() + 1
        let year = date.getFullYear()
        if (month < 10) {
            var fecha = `${day}/0${month}/${year}`
        } else {
            var fecha = `${day}/${month}/${year}`
        }
        document.getElementById('ind_ec').rows[0].cells[1].innerHTML = fecha;
        document.getElementById('ind_ec').rows[1].cells[1].innerHTML = "$" + formateo_numeros(data.uf.valor);
        document.getElementById('ind_ec').rows[2].cells[1].innerHTML = "$" + formateo_numeros(data.dolar.valor);
    } else {}
}
request.send()
function volveratras() {
    var funcion=JSON.parse('<?php echo retrocede();?>');
    var url=funcion[0];  
    var id=funcion[1]; 
    var acordeon=funcion[2]; 
    console.log(funcion);
   alert('url:' + url + '; id:' + id + '; acordeon:' + acordeon);
    Cookies.set('retrocede', '1', { expires: 1, path: '/' });
   $.redirect( url , {
                    'id': id,
                    'acordeon':acordeon
                }, 'post');
   // window.history.back();

}
</script>