<?php
$resultado =$codigo=$conta='';

require_once "/home/gestio10/public_html/backend/config.php";

    mysqli_set_charset($link, 'utf8');
    mysqli_select_db($link, 'gestio10_asesori1_bamboo');
    //$sql = "SELECT id FROM clientes WHERE CONTACT(rut_sin_dv, \'-\',dv) = ?";
$sql = "SELECT CONCAT(rut_sin_dv, '-',dv) as rut, concat(nombre_cliente ,' ', apellido_materno,' ', apellido_paterno) as nombre, correo, direccion_laboral, direccion_personal, id, telefono, fecha_ingreso, referido, grupo FROM clientes";
    $resultado=mysqli_query($link, $sql);
    $codigo='{
      "data": [';
    $conta=0;
  While($row=mysqli_fetch_object($resultado))
  {$conta=$conta+1;
    if ($conta==1){
      $codigo.= json_encode(array(
        "id" =>& $row->id,
        "nombre"=>& $row->nombre,
        "correo_electronico" =>& $row->correo,
        "direccionl" =>& $row->direccion_laboral,
        "direccionp" =>& $row->direccion_personal,
        "telefono" =>& $row->telefono,
        "fecingreso" =>& $row->fecha_ingreso,
        "referido" =>& $row->referido,
        "grupo" =>& $row->grupo,
        "rut" =>& $row->rut));
    } else {
    $codigo.= ', '.json_encode(array(
      "id" =>& $row->id,
      "nombre"=>& $row->nombre,
      "correo_electronico" =>& $row->correo,
      "direccionl" =>& $row->direccion_laboral,
      "direccionp" =>& $row->direccion_personal,
      "telefono" =>& $row->telefono,
      "fecingreso" =>& $row->fecha_ingreso,
      "referido" =>& $row->referido,
      "grupo" =>& $row->grupo,
      "rut" =>& $row->rut
    ));}
  }
  $codigo.=']}';
  echo $codigo;
?>