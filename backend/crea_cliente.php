<?php
//update listado_licitaciones as a left join (SELECT codigo_externo, max(fecha_creacion) as MAXFECHA FROM listado_licitaciones group by codigo_externo) as b on a.codigo_externo=b.codigo_externo set antigua=1 where a.fecha_creacion<>b.MAXFECHA
 //$dias=$argv[1];
 $nombre=estandariza_info($_GET["nombre"]);
 $apellidop=estandariza_info($_GET["apellidop"]);
 $apellidom=estandariza_info($_GET["apellidom"]);
 $rut=estandariza_info($_GET["rut"]);
 $dv=estandariza_info($_GET["dv"]);
 $email=estandariza_info(_GET["email"]);
 $direccion=estandariza_info($_GET["direccion"]);
 //$telefono=estandariza_info($_GET["telefono"]);
$dbhost = 'localhost';
$dbname = 'asesori1_bamboo';
$dbuser = 'asesori1_cesnar';
$dbpass = 'YvKC1ely)E^D';
$st=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if ($st){
mysqli_set_charset( $st, 'utf8');
mysqli_select_db($st, $dbname);
mysqli_query($st, 'insert into clientes(nombre_cliente, apellido_paterno, apellido_materno, rut_sin_dv, dv, direccion_personal, correo) values 
(\''.$nombre.'\', \''.$apellidop.'\', \''.$apellidom.'\', \''.$rut.'\', \''.$dv.'\', \''.$direccion.'\', \''.$email.'\');');
echo "conectado al servidor;\n";
}
else{
echo "no conectado al servidor;\n";
}
function estandariza_info($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>


http://ipnconsultores.cl/bamboo/backend/crea_cliente.php?nombre=felipe&apellidop=abarca&apellidom=soto&rut=17029236&dv=7&email=fabarca212%40gmail.com&direccion=santa+isabel+1610