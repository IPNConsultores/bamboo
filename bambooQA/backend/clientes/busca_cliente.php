<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once "/home/gestio10/public_html/backend/config.php";
$busqueda=estandariza_info($_POST["buscacliente"]);
$numero=$trozos=0;
mysqli_set_charset( $link, 'utf8');

mysqli_select_db($link, 'gestio10_asesori1_bamboo_QA');
if ($busqueda<>''){
  //CUENTA EL NUMERO DE PALABRAS
  $trozos=explode(" ",$busqueda);
  $numero=count($trozos);
 if ($numero==1) {
  //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
  $resultado=mysqli_query($link, 'SELECT CONTACT(rut_sin_dv, \'-\',dv) as rut, concat_ws(\' \',nombre_cliente,  apellido_paterno,  apellido_materno) as nombre  FROM clientes WHERE  where nombre_cliente like \'%'.$busqueda.'%\' or apellido_paterno like \'%'.$busqueda.'%\' or rut_sin_dv like \'%'.$busqueda.'%\' or CONTACT(rut_sin_dv, \'-\',dv) like \'%'.$busqueda.'%\';');
 } elseif ($numero>1) {
 //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
 //busqueda de frases con mas de una palabra y un algoritmo especializado
 $resultado=mysqli_query($link, 'SELECT CONTACT(rut_sin_dv, \'-\',dv) as rut, concat_ws(\' \',nombre_cliente, apellido_paterno,  apellido_materno) as nombre , MATCH(nombre_cliente, apellido_paterno ,apellido_materno , rut_sin_dv) AGAINST ( \''.$busqueda.'\' ) AS Score FROM clientes WHERE MATCH(nombre_cliente, apellido_paterno ,apellido_materno , rut_sin_dv) AGAINST ( \''.$busqueda.'\' ) ORDER BY Score DESC LIMIT 50;');
}
}
While($row=mysqli_fetch_object($resultado))
{
   //Mostramos los titulos de los articulos o lo que deseemos...
  $rut=$row["rut"];
   $nombre=$row["nombre"];
   echo $rut." - ".$nombre."<br>";
}
mysqli_close($link);
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>