<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'gestio10_bamboo');
define('DB_PASSWORD', 'Vz0f7Z1d$r6Z');
define('DB_NAME', 'gestio10_asesori1_bamboo');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: No se pudo conectar al servidor. " . mysqli_connect_error());
}
?>