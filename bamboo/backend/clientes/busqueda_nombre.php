
<?php
require_once "/home/gestio10/public_html/backend/config.php";
$resultado=$resultado1 =$busqueda= '';
    $busqueda=$_POST["rut"];

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
    $sql = "SELECT id, nombre_cliente, apellido_paterno, apellido_materno FROM clientes WHERE rut_sin_dv = ?";
    if ($stmt = mysqli_prepare($link, $sql))
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        // Set parameters
        $param_username = estandariza_info($busqueda);
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt))
        {
            

            // store result
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1)
            {

    mysqli_stmt_bind_result($stmt, $id, $nombre, $apellidop, $apellidom);
while (mysqli_stmt_fetch($stmt)) {
    echo json_encode(array(
 "resultado" => "antiguo",
            "id" =>& $id,
            "nombre"=>& $nombre,
            "apellidop"=>& $apellidop,
            "apellidom"=>& $apellidom
        ));
}
            }
            else
            {
                $resultado = 'valido';

    echo json_encode(array(
        "resultado"=>"nuevo",
        ));
            }
        }
        else
        {
$resultado = 'weeoe';
    echo json_encode(array(
        "resultado"=>"error",
        ));
            //echo "Oops! Algo salió mal. Favor intentar más tarde.";
        }
    }
    //mysqli_stmt_close($stmt);

function estandariza_info($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>