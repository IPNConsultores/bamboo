<?php
$resultado ='';
require_once "/home/gestio10/public_html/backend/config.php";

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
    $sql = "SELECT CONCAT(rut_sin_dv, \'-\',dv) as rut, apellido_materno, apellido_paterno, correo, direccion_laboral, direccion_personal, id, nombre_cliente, telefono FROM clientes";
    $resultado=mysqli_query($link, $sql);
  While($row=mysqli_fetch_object($resultado))
  {
    echo json_encode(array(
            "id" =>& $row["id"],
            "nombre"=>& $row["nombre_cliente"],
            "apellidop"=>& $row["apellido_paterno"],
            "apellidom"=>& $row["apellido_materno"],
            "correo_electronico" =>& $row["correo"],
            "direccionl" =>& $row["direccion_laboral"],
            "direccionp" =>& $row["direccion_personal"],
            "telefono" =>& $row["telefono"],
            "rut" =>& $row["rut"]
        ));
}


?>