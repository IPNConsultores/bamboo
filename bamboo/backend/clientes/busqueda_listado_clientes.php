<?php
require_once "/home/gestio10/public_html/backend/config.php";
$resultado ='';
        mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
    $sql = "SELECT CONCAT(rut_sin_dv, \'-\',dv) as rut, apellido_materno, apellido_paterno, correo, direccion_laboral, direccion_personal, id, nombre_cliente, telefono
    FROM clientes";
  $resultado=mysqli_query($link, $sql);
  While($row=mysqli_fetch_object($resultado))
  {
    echo json_encode(array(
            "resultado" => "antiguo",
            "id" =>& $id,
            "nombre"=>& $nombre_cliente,
            "apellidop"=>& $apellido_paterno,
            "apellidom"=>& $apellido_materno,
            "correo_electronico" =>& $correo,
            "direccionl" =>& $direccion_laboral,
            "direccionp" =>& $direccion_personal,
            "telefono" =>& $telefono,
            "rut" =>& $rut
        ));
}


?>