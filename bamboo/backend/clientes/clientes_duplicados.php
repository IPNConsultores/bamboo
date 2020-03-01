<?php
require_once "/home/gestio10/public_html/backend/config.php";
$resultado='';
$valor=$_REQUEST["rut"];
mysqli_set_charset( $link, 'utf8');
mysqli_select_db($link, 'gestio10_asesori1_bamboo');

$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
        
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    
    // Set parameters
    $param_username = estandariza_info($valor);
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        /* store result */
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) == 1){
            $resultado='1';
            //duplicado
        } else{
            $resultado='0'; 
            //éxito
        }
    } else{
            $resultado='3';
        //echo "Oops! Algo salió mal. Favor intentar más tarde.";
    }
}
mysqli_stmt_close($stmt);
echo $resultado;

?>