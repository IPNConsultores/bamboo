<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'asesori1_cesnar');
define('DB_PASSWORD', 'YvKC1ely)E^D');
define('DB_NAME', 'asesori1_bamboo');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: No se pudo conectar al servidor. " . mysqli_connect_error());
}
?>