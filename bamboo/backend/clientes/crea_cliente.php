<?php
require_once "/home/gestio10/public_html/backend/config.php";
 $nombre=estandariza_info($_POST["nombre"]);
 $apellidop=estandariza_info($_POST["apellidop"]);
 $apellidom=estandariza_info($_POST["apellidom"]);
 $rut=estandariza_info($_POST["rut"]);
 $dv=estandariza_info($_POST["dv"]);
 $correo_electronico=estandariza_info($_POST["correo_electronico"]);
 $direccionp=estandariza_info($_POST["direccionp"]);
 $direccionl=estandariza_info($_POST["direccionl"]);
 $telefono=estandariza_info($_POST["telefono"]);
 $param_username =$error='';

mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');

$sql = "SELECT id FROM clientes WHERE rut_sin_dv = ?";
        
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    
    // Set parameters
    $param_username = estandariza_info($_POST["rut"]);
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        /* store result */
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) == 1){
            echo "El usuario ya esta utilizado.";
        } else{
          mysqli_query($link, 'insert into clientes(nombre_cliente, apellido_paterno, apellido_materno, rut_sin_dv, dv, direccion_personal, correo,direccion_laboral, telefono) values (\''.$nombre.'\', \''.$apellidop.'\', \''.$apellidom.'\', \''.$rut.'\', \''.$dv.'\', \''.$direccionp.'\', \''.$correo_electronico.'\', \''.$direccionl.'\', \''.$telefono.'\');');
            header("Location:http://gestionipn.cl/bamboo/index.php");
            
        }
    } else{
        echo "Oops! Algo salió mal. Favor intentar más tarde.";
    }
}
mysqli_stmt_close($stmt);

function estandariza_info($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>




