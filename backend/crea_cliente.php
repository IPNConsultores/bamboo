<?php
//update listado_licitaciones as a left join (SELECT codigo_externo, max(fecha_creacion) as MAXFECHA FROM `listado_licitaciones` group by codigo_externo) as b on a.codigo_externo=b.codigo_externo set antigua=1 where a.fecha_creacion<>b.MAXFECHA
 //$dias=$argv[1];
$dbhost = 'localhost';
$dbname = 'asesori1_bamboo';
$dbuser = 'asesori1_cesnar';
$dbpass = 'YvKC1ely)E^D';
$st=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if ($st){
mysqli_set_charset( $st, 'utf8');
mysqli_select_db($st, $dbname);
$limpia = mysqli_query($st, 'select * from clientes;');
}
else{
echo "no conectado;\n";
}
?>